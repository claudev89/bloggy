<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $like = Like::firstOrNew([
            'user_id' => $request->user_id,
            'likeable_type' => $request->likeable_type,
            'likeable_id' => $request->likeable_id
        ]);

        if(!$like->exists) {
            $like->save();
        }
    }

    public function destroy(Like $like)
    {
        $like->delete();
    }
}
