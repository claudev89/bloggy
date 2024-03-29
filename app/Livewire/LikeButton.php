<?php

namespace App\Livewire;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use App\Models\Like;

class LikeButton extends Component
{
    #[Reactive]
    public $likeable;

    public $likeableType;
    public $liked = false;

    public $likeCount;

    public function mount($likeable)
    {
        $this->likeable = $likeable;
        $this->likeableType = $likeable->getMorphClass();
        $this->checkIfLiked();

    }


    public function like()
    {
        if ($this->liked) {
            $this->likeable->likes()->where('user_id', auth()->id())->firstOrFail()->delete();
            $this->liked = false;
        } else {
            $this->likeable->likes()->create(['user_id' => auth()->id()]);
            $this->liked = true;
        }
    }

    protected function checkIfLiked()
    {
        $this->liked = $this->likeable->likes()->where('user_id', auth()->id())->exists();
    }


    public function render()
    {
        $this->likeCount = $this->likeable->likes()->count();
        return view('livewire.like-button');
    }

}
