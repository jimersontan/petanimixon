<?php

namespace App\Http\Controllers;

use App\Models\SupportMessage;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportChatController extends Controller
{
    /**
     * User sends a message (text and/or image).
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        if (!$request->message && !$request->hasFile('image')) {
            return response()->json(['error' => 'Please provide a message or image.'], 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('support-chat', 'public');
        }

        $msg = SupportMessage::create([
            'user_id' => Auth::id(),
            'sender_type' => 'user',
            'message' => $request->message,
            'image_path' => $imagePath,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => $msg->fresh(),
        ]);
    }

    /**
     * User gets their chat messages.
     */
    public function getMessages(Request $request)
    {
        $messages = SupportMessage::where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark admin messages as read
        SupportMessage::where('user_id', Auth::id())
            ->where('sender_type', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json(['messages' => $messages]);
    }

    /**
     * User gets unread count (admin messages they haven't read).
     */
    public function getUnreadCount()
    {
        $count = SupportMessage::unreadCountForUser(Auth::id());
        return response()->json(['unread_count' => $count]);
    }

    /**
     * User sends typing indicator.
     */
    public function sendTyping()
    {
        // Store in cache for 3 seconds
        cache()->put('chat_typing_user_' . Auth::id(), true, 3);
        return response()->json(['status' => 'ok']);
    }

    // ── Admin Methods ──

    /**
     * Admin: Get list of all conversations.
     */
    public function adminGetConversations()
    {
        $conversations = SupportMessage::getConversationList();

        $result = $conversations->map(function ($conv) {
            $lastMsg = SupportMessage::where('user_id', $conv->user_id)
                ->orderByDesc('created_at')
                ->first();

            return [
                'user_id' => $conv->user_id,
                'user_name' => $conv->user ? (($conv->user->first_name ?? '') . ' ' . ($conv->user->last_name ?? '')) : 'Unknown',
                'user_email' => $conv->user->email ?? '',
                'last_message' => $lastMsg ? ($lastMsg->message ?? '[Image]') : '',
                'last_message_at' => $conv->last_message_at,
                'unread_count' => (int) $conv->unread_count,
            ];
        });

        $totalUnread = SupportMessage::unreadCountForAdmin();

        return response()->json([
            'conversations' => $result,
            'total_unread' => $totalUnread,
        ]);
    }

    /**
     * Admin: Get messages for a specific user.
     */
    public function adminGetMessages($userId)
    {
        $messages = SupportMessage::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark user messages as read
        SupportMessage::where('user_id', $userId)
            ->where('sender_type', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        // Check if user is typing
        $isTyping = cache()->get('chat_typing_user_' . $userId, false);

        return response()->json([
            'messages' => $messages,
            'is_typing' => $isTyping,
        ]);
    }

    /**
     * Admin: Reply to a user.
     */
    public function adminSendReply(Request $request, $userId)
    {
        $request->validate([
            'message' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        if (!$request->message && !$request->hasFile('image')) {
            return response()->json(['error' => 'Please provide a message or image.'], 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('support-chat', 'public');
        }

        $msg = SupportMessage::create([
            'user_id' => $userId,
            'sender_type' => 'admin',
            'message' => $request->message,
            'image_path' => $imagePath,
        ]);

        // Notify the user
        UserNotification::createNotification(
            $userId,
            'support',
            '💬 New Support Reply',
            $request->message ? substr($request->message, 0, 100) : 'Sent you an image',
            '💬',
            '#ea580c'
        );

        return response()->json([
            'status' => 'success',
            'message' => $msg->fresh(),
        ]);
    }

    /**
     * Admin: Send typing indicator.
     */
    public function adminSendTyping($userId)
    {
        cache()->put('chat_typing_admin_' . $userId, true, 3);
        return response()->json(['status' => 'ok']);
    }

    /**
     * Admin: Get total unread chat count.
     */
    public function adminUnreadCount()
    {
        return response()->json([
            'unread_count' => SupportMessage::unreadCountForAdmin(),
        ]);
    }
}
