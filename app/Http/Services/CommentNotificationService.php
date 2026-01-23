<?php

namespace App\Http\Services;

use App\Models\ComponentContent;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentNotificationService
{
    public static function getUnreadNotifications()
    {
        $userId = Auth::id();

        if (!$userId) return collect();

        return ComponentContent::whereHas('comments', function ($q) use ($userId) {
            $q->where(function ($query) use ($userId) {
                // Belum pernah baca sama sekali
                $query->whereDoesntHave('contents.commentReads', function ($qr) use ($userId) {
                    $qr->where('user_id', $userId);
                })
                // Atau sudah baca tapi ada yang lebih baru
                ->orWhereHas('contents.commentReads', function ($qr) use ($userId) {
                    $qr->where('user_id', $userId)
                       ->whereColumn('content_comments.created_at', '>', 'comment_reads.last_read_at');
                });
            });
        })
        ->withCount(['comments as unread_comments_count' => function ($q) use ($userId) {
            $q->whereDoesntHave('contents.commentReads', function ($qr) use ($userId) {
                $qr->where('user_id', $userId);
            })
            ->orWhereHas('contents.commentReads', function ($qr) use ($userId) {
                $qr->where('user_id', $userId)
                   ->whereColumn('content_comments.created_at', '>', 'comment_reads.last_read_at');
            });
        }])
        ->with(['detail.component.subdomain.domain'])
        ->get();
    }

    /**
     * Menghitung total angka notifikasi (jumlah total komentar yang belum dibaca)
     */
    public static function totalUnreadCount()
    {
        $notifications = self::getUnreadNotifications();
        return $notifications->sum('unread_comments_count');
    }

}
