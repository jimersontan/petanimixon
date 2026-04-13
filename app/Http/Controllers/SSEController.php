<?php

namespace App\Http\Controllers;

use App\Models\SupportMessage;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SSEController extends Controller
{
    /**
     * SSE stream for user-side events (notifications + chat).
     */
    public function userStream(Request $request)
    {
        $userId = Auth::id();

        $response = new StreamedResponse(function () use ($userId) {
            // Release session lock so other concurrent requests don't hang
            session_write_close();
            
            // Disable output buffering
            if (ob_get_level()) ob_end_clean();

            $lastNotifCheck = now();
            $lastChatCheck = now();
            $iterations = 0;
            
            // On PHP's built-in server (artisan serve), block for max 1 iteration 
            // since it's single-threaded and would block CSS/JS from loading.
            $maxIterations = php_sapi_name() === 'cli-server' ? 1 : 150; 

            while ($iterations < $maxIterations) {
                if (connection_aborted()) break;

                // 1. Check for new notifications
                $unreadNotifs = UserNotification::where('user_id', $userId)
                    ->where('read', false)
                    ->count();

                $newNotifs = UserNotification::where('user_id', $userId)
                    ->where('created_at', '>', $lastNotifCheck)
                    ->orderByDesc('created_at')
                    ->limit(3)
                    ->get();

                echo "event: notification_count\n";
                echo "data: " . json_encode(['unread_count' => $unreadNotifs]) . "\n\n";

                if ($newNotifs->count() > 0) {
                    foreach ($newNotifs as $n) {
                        echo "event: new_notification\n";
                        echo "data: " . json_encode([
                            'id' => $n->id,
                            'title' => $n->title,
                            'message' => $n->message,
                            'icon' => $n->icon,
                            'type' => $n->type,
                            'created_at' => $n->created_at->toISOString(),
                        ]) . "\n\n";
                    }
                    $lastNotifCheck = now();
                }

                // 2. Check for new chat messages from admin
                $unreadChat = SupportMessage::unreadCountForUser($userId);
                $newChatMsgs = SupportMessage::where('user_id', $userId)
                    ->where('sender_type', 'admin')
                    ->where('created_at', '>', $lastChatCheck)
                    ->orderBy('created_at', 'asc')
                    ->get();

                echo "event: chat_count\n";
                echo "data: " . json_encode(['unread_count' => $unreadChat]) . "\n\n";

                if ($newChatMsgs->count() > 0) {
                    foreach ($newChatMsgs as $cm) {
                        echo "event: new_chat_message\n";
                        echo "data: " . json_encode([
                            'id' => $cm->id,
                            'message' => $cm->message,
                            'image_path' => $cm->image_path,
                            'sender_type' => 'admin',
                            'created_at' => $cm->created_at->toISOString(),
                        ]) . "\n\n";
                    }
                    $lastChatCheck = now();
                }

                // 3. Check if admin is typing
                $adminTyping = cache()->get('chat_typing_admin_' . $userId, false);
                echo "event: admin_typing\n";
                echo "data: " . json_encode(['typing' => (bool) $adminTyping]) . "\n\n";

                @ob_flush();
                @flush();

                $iterations++;
                if ($iterations < $maxIterations) {
                    sleep(2);
                }
            }

            // Send reconnect hint
            echo "event: reconnect\n";
            echo "data: {}\n\n";
            @ob_flush();
            @flush();
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('X-Accel-Buffering', 'no');

        return $response;
    }

    /**
     * SSE stream for admin-side events (notifications + chat).
     */
    public function adminStream(Request $request)
    {
        $adminId = Auth::id();

        $response = new StreamedResponse(function () use ($adminId) {
            // Release session lock
            session_write_close();
            
            if (ob_get_level()) ob_end_clean();

            $lastNotifCheck = now();
            $lastChatCheck = now();
            $iterations = 0;
            
            // On built-in server, avoid blocking single thread
            $maxIterations = php_sapi_name() === 'cli-server' ? 1 : 150;

            while ($iterations < $maxIterations) {
                if (connection_aborted()) break;

                // 1. Notification count
                $unreadNotifs = UserNotification::where('user_id', $adminId)
                    ->where('read', false)
                    ->count();

                echo "event: notification_count\n";
                echo "data: " . json_encode(['unread_count' => $unreadNotifs]) . "\n\n";

                // 2. New notifications
                $newNotifs = UserNotification::where('user_id', $adminId)
                    ->where('created_at', '>', $lastNotifCheck)
                    ->orderByDesc('created_at')
                    ->limit(3)
                    ->get();

                if ($newNotifs->count() > 0) {
                    foreach ($newNotifs as $n) {
                        echo "event: new_notification\n";
                        echo "data: " . json_encode([
                            'id' => $n->id,
                            'title' => $n->title,
                            'message' => $n->message,
                            'icon' => $n->icon,
                        ]) . "\n\n";
                    }
                    $lastNotifCheck = now();
                }

                // 3. Chat unread count for admin
                $chatUnread = SupportMessage::unreadCountForAdmin();
                echo "event: chat_count\n";
                echo "data: " . json_encode(['unread_count' => $chatUnread]) . "\n\n";

                // 4. New chat messages from users
                $newUserMsgs = SupportMessage::where('sender_type', 'user')
                    ->where('created_at', '>', $lastChatCheck)
                    ->orderBy('created_at', 'asc')
                    ->limit(5)
                    ->with('user:id,first_name,last_name')
                    ->get();

                if ($newUserMsgs->count() > 0) {
                    foreach ($newUserMsgs as $cm) {
                        echo "event: new_chat_message\n";
                        echo "data: " . json_encode([
                            'id' => $cm->id,
                            'user_id' => $cm->user_id,
                            'user_name' => $cm->user ? ($cm->user->first_name . ' ' . ($cm->user->last_name ?? '')) : 'User',
                            'message' => $cm->message,
                            'image_path' => $cm->image_path,
                            'sender_type' => 'user',
                            'created_at' => $cm->created_at->toISOString(),
                        ]) . "\n\n";
                    }
                    $lastChatCheck = now();
                }

                @ob_flush();
                @flush();

                $iterations++;
                if ($iterations < $maxIterations) {
                    sleep(2);
                }
            }

            echo "event: reconnect\n";
            echo "data: {}\n\n";
            @ob_flush();
            @flush();
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('X-Accel-Buffering', 'no');

        return $response;
    }
}
