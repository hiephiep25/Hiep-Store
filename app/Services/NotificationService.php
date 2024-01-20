<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Response\ApiResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Friend;

class NotificationService
{
    public function listNotification()
    {
        $userId = auth()->id();

        $notifications = Notification::with(['receiver', 'sender'])->where('receiver_id', $userId)->orderBy('created_at', 'desc')->get();

        return $notifications;
    }

    public function readNotification($notificationId)
    {
        $notification = Notification::with(['receiver', 'sender'])->where('id', $notificationId)
            ->first();

        if ($notification) {
            $notification->update(['is_read' => true]);
            return $notification;
        }

        return null;
    }

    public function createNotification($receiverId, $type)
    {
        $userId = auth()->id();

        $content = $this->getNotificationContent($type);

        if($userId != $receiverId) {

            $notification = Notification::create([
                'sender_id' => $userId,
                'receiver_id' => $receiverId,
                'type' => $type,
                'content' => $content,
                'is_read' => false,
            ]);

            return $notification;
        }

        return ;
    }

    private function getNotificationContent($type)
    {
        switch ($type) {
            case 'approve-document':
                return 'đã chấp nhận tài liệu nhập hàng';
            case 'deny-document':
                return 'đã từ chối tài liệu nhập hàng';
            case 'create-document':
                return 'đã cung cấp tài liệu nhập hàng';
            case 'create-offline-order':
                return 'đã tạo đơn hàng tại quầy';
            default:
                return '';
        }
    }

    public function countUnreadNotifications()
    {
        $userId = auth()->id();

        $unreadCount = Notification::where('receiver_id', $userId)
            ->where('is_read', false)
            ->count();
        return $unreadCount;
    }
}
