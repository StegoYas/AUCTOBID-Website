<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get user's notifications
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        
        $query = $user->notifications()->orderBy('created_at', 'desc');

        // Filter unread only
        if ($request->boolean('unread_only')) {
            $query->unread();
        }

        $notifications = $query->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $notifications->through(fn($notif) => [
                'id' => $notif->id,
                'title' => $notif->title,
                'message' => $notif->message,
                'type' => $notif->type,
                'reference_type' => $notif->reference_type,
                'reference_id' => $notif->reference_id,
                'is_read' => $notif->is_read,
                'read_at' => $notif->read_at?->toIso8601String(),
                'created_at' => $notif->created_at->toIso8601String(),
            ]),
            'meta' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'per_page' => $notifications->perPage(),
                'total' => $notifications->total(),
                'unread_count' => $user->notifications()->unread()->count(),
            ],
        ]);
    }

    /**
     * Get unread count
     */
    public function unreadCount(Request $request): JsonResponse
    {
        $count = $request->user()->notifications()->unread()->count();

        return response()->json([
            'success' => true,
            'data' => [
                'unread_count' => $count,
            ],
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Request $request, Notification $notification): JsonResponse
    {
        // Check if notification belongs to user
        if ($notification->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found.',
            ], 404);
        }

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read.',
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        $request->user()->notifications()->unread()->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read.',
        ]);
    }

    /**
     * Delete notification
     */
    public function destroy(Request $request, Notification $notification): JsonResponse
    {
        // Check if notification belongs to user
        if ($notification->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found.',
            ], 404);
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted.',
        ]);
    }
}
