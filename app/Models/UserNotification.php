<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'title', 'message', 'icon', 'color',
        'data', 'related_id', 'related_type', 'read', 'read_at'
    ];

    protected $casts = [
        'data' => 'json',
        'read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Get the user that owns the notification
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->update([
            'read' => true,
            'read_at' => now()
        ]);
    }

    /**
     * Get unread notifications count for user
     */
    public static function getUnreadCount($userId)
    {
        return self::where('user_id', $userId)->where('read', false)->count();
    }

    /**
     * Create a notification
     */
    public static function createNotification($userId, $type, $title, $message, $icon = '🔔', $color = '#ea580c', $relatedId = null, $relatedType = null, $data = null)
    {
        return self::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'icon' => $icon,
            'color' => $color,
            'related_id' => $relatedId,
            'related_type' => $relatedType,
            'data' => $data,
        ]);
    }
}

