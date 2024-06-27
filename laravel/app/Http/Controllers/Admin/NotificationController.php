<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function listNotification()
    {
        try {
            $notifications = $this->notificationService->listNotification();

            return response()->json(['notifications' => $notifications], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function readNotification($id)
    {
        try {
            $notification = $this->notificationService->readNotification($id);

            if ($notification) {
                return response()->json(['notification' => $notification], Response::HTTP_OK);
            } else {
                return response()->json(['error' => 'Notification not found'], Response::HTTP_NOT_FOUND);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function countUnreadNotifications()
    {
        $count = $this->notificationService->countUnreadNotifications();
        return response()->json(['count' => $count], Response::HTTP_OK);
    }
}
