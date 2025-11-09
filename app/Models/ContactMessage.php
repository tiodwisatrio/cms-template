<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status',
        'admin_reply',
        'replied_at',
        'ip_address'
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    // Scopes
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    // Helper methods
    public function isNew()
    {
        return $this->status === 'new';
    }

    public function isRead()
    {
        return $this->status === 'read';
    }

    public function isReplied()
    {
        return $this->status === 'replied';
    }

    public function markAsRead()
    {
        $this->update(['status' => 'read']);
    }

    public function markAsReplied()
    {
        $this->update([
            'status' => 'replied',
            'replied_at' => now()
        ]);
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'new' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">New</span>',
            'read' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Read</span>',
            'replied' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Replied</span>',
        ];

        return $badges[$this->status] ?? '';
    }
}
