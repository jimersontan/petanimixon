<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get unread notifications count for the authenticated user.
     */
    public function getUnreadCount()
    {
        $user = Auth::user();
        $unreadCount = UserNotification::where('user_id', $user->id)
            ->where('read', false)
            ->count();

        return response()->json(['unread_count' => $unreadCount]);
    }

    /**
     * Get all notifications for logged-in user (with pagination)
     */
    public function getNotifications(Request $request)
    {
        $user = Auth::user();
        $limit = (int) $request->query('limit', 20);
        $unreadOnly = filter_var($request->query('unread_only', false), FILTER_VALIDATE_BOOLEAN);

        $query = UserNotification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        $filter = $request->query('filter');
        if ($filter && $filter !== 'all') {
            $query->where('type', $filter);
        }

        if ($unreadOnly) {
            $query->where('read', false);
        }

        $notifications = $query->paginate($limit);
        $notifications->getCollection()->transform(function (UserNotification $notification) use ($user) {
            $notification->action_url = $notification->resolveActionUrlFor($user);
            $notification->action_label = $notification->resolveActionLabelFor($user);
            $notification->type_label = $notification->type_label;

            return $notification;
        });

        return response()->json($notifications);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        $notification = UserNotification::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error'], 404);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        UserNotification::where('user_id', $user->id)
            ->where('read', false)
            ->update([
                'read' => true,
                'read_at' => now()
            ]);

        return response()->json(['status' => 'success']);
    }

    /**
     * Delete a notification
     */
    public function delete($id)
    {
        $user = Auth::user();
        $notification = UserNotification::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($notification) {
            $notification->delete();
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error'], 404);
    }
}
