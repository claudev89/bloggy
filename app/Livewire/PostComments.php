<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Rule;
use Livewire\Component;

class PostComments extends Component
{
    public Post $post;


    #[Rule('required|min:3|max:200')]
    public string $comment;

    public function postComment()
    {
        $this->validateOnly('comment');

        $this->post->comentarios()->create([
            'autor' => auth()->id(),
            'cuerpo' => $this->comment,


        ]);

        $this->reset('comment');
    }

    #[Computed()]
    public function comments()
    {
        return $this?->post?->comentarios()->latest();
    }

    public function render()
    {
        return view('livewire.post-comments');
    }
}
