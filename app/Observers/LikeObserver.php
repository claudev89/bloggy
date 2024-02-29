<?php

namespace App\Observers;

use App\Models\Like;
use App\Models\Notification;
use App\Models\Tag;

class LikeObserver
{
    /**
     * Handle the Like "created" event.
     */
    public function creating(Like $like): void
    {
        $existingNotification = Notification::where('user_id', $like->user_id)
                                            ->where('type', 'l')
                                            ->where('notifiable_type', $like->likeable_type)
                                            ->where('notifiable_id', $like->likeable_id)
                                            ->first();
        if(!$existingNotification){
            $notification = Notification::create([
                'user_id' => $like->user_id,
                'type' => 'l',
                'notifiable_type' => $like->likeable_type,
                'notifiable_id' => $like->likeable_id,
            ]);
            $like->notification_id = $notification->id;
        }
    }

    /**
     * Handle the Like "updated" event.
     */
    public function updated(Like $like): void
    {
        //
    }

    /**
     * Handle the Like "deleted" event.
     */
    public function deleting(Like $like): void
    {
        $notification = Notification::find($like->notification_id);
        if ($notification){
            $notification->delete();
        }
    }

    /**
     * Handle the Like "restored" event.
     */
    public function restored(Like $like): void
    {
        //
    }

    /**
     * Handle the Like "force deleted" event.
     */
    public function forceDeleted(Like $like): void
    {
        //
    }
}
