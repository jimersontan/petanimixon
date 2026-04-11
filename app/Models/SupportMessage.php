<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sender_type',
        'message',
        'image_path',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Get the user (customer) this message belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark the message as read.
     */
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    /**
     * Get unread count for a user (messages from admin that user hasn't read).
     */
    public static function unreadCountForUser($userId)
    {
        return self::where('user_id', $userId)
            ->where('sender_type', 'admin')
            ->where('is_read', false)
            ->count();
    }

    /**
     * Get unread count for admin (messages from all users that admin hasn't read).
     */
    public static function unreadCountForAdmin()
    {
        return self::where('sender_type', 'user')
            ->where('is_read', false)
            ->count();
    }

    /**
     * Get list of users with conversations (for admin panel).
     */
    public static function getConversationList()
    {
        return self::select('user_id')
            ->selectRaw('MAX(created_at) as last_message_at')
            ->selectRaw('SUM(CASE WHEN sender_type = "user" AND is_read = 0 THEN 1 ELSE 0 END) as unread_count')
            ->groupBy('user_id')
            ->orderByDesc('last_message_at')
            ->with('user:id,first_name,last_name,email')
            ->get();
    }
}
