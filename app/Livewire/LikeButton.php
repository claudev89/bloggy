<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Like;

class LikeButton extends Component
{
    public $likeableType;
    public $likeableId;
    public $likeCount;

    public function mount($likeableType, $likeableId)
    {
        $this->likeableType = $likeableType;
        $this->likeableId = $likeableId;
        $this->likeCount = Like::where('likeable_type', $this->likeableType)
            ->where('likeable_id', $this->likeableId)
            ->count();
    }

    public function toggleLike()
    {
        $user_id = auth()->id();

        $like = Like::where('user_id', $user_id)
        ->where('likeable_type', $this->likeableType)
        ->where('likeable_id', $this->likeableId)
        ->first();

        if($like) {
            $like->delete();
            $this->likeCount--;
        } else {
            Like::create([
                'user_id' => $user_id,
                'likeable_type' => $this->likeableType,
                'likeable_id' => $this->likeableId
            ]);
            $this->likeCount++;
        }
    }
    public function render()
    {
        return view('livewire.like-button');
    }
}
