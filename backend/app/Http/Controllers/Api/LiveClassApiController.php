<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LiveClass;
use App\Models\Enrollment;
use App\Models\UserSession;

class LiveClassApiController extends Controller
{
    /**
     * Get active live classes for the authenticated student.
     */
    public function getActiveClasses(Request $request)
    {
        $user = $request->user();
        
        // Strict Device Check: Ensure the user's current token matches the active session
        $currentTokenId = $user->currentAccessToken()->id;
        $activeSession = UserSession::where('user_id', $user->id)
            ->where('is_active', true)
            ->first();
            
        if (!$activeSession || $activeSession->device_id != $currentTokenId) {
            return response()->json([
                'success' => false,
                'message' => 'Multiple device login detected or session invalid.',
            ], 403);
        }

        // Get batches the user is enrolled in
        $enrolledBatchIds = Enrollment::where('user_id', $user->id)
            ->where('status', 'active')
            ->pluck('batch_id');

        // Get active live classes for those batches
        $liveClasses = LiveClass::with(['course', 'subject'])
            ->whereIn('batch_id', $enrolledBatchIds)
            ->where('status', 'active')
            ->get();

        $formattedClasses = $liveClasses->map(function ($class) {
            return [
                'id' => $class->id,
                'title' => $class->title,
                'course' => optional($class->course)->name,
                'subject' => optional($class->subject)->name,
                'start_time' => $class->scheduled_at,
                // Stream key used to build the Playback URL on the client (e.g. HLS)
                'live_room_id' => $class->live_room_id, 
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedClasses
        ]);
    }
}
