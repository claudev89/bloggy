<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Post;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function show(Notification $notification, $postId)
    {
        $post = Post::findOrFail($postId);
        if($notification->read == 0) {
            $notification->update(['read' => 1]);
        }

        return to_route('posts.show', $post);
    }
}
