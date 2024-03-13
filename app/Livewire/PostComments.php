<?php

namespace App\Livewire;

use App\Models\Comentario;
use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Rule;
use Livewire\Component;

class PostComments extends Component
{
    public Post $post;


    #[Rule('required|min:3|max:200')]
    public string $comment;

    #[Rule('required|min:3|max:200')]
    public string $replyBody;

    public $showReplyForm = null;

    public function postComment()
    {
        $this->validateOnly('comment');

        $this->post->comentarios()->create([
            'autor' => auth()->id(),
            'cuerpo' => $this->comment,


        ]);

        $this->reset('comment');
    }

    public function deleteComment(Comentario $commentToDelete)
    {
        $commentToDelete->delete();
    }

    #[Computed()]
    public function comments()
    {
        return $this?->post?->comentarios()->latest();
    }


    public function displayReplyForm($commentId)
    {
        $this->showReplyForm = $commentId;
    }

    public function replyToComment()
    {
        Comentario::create ([
            'autor' => auth()->id(),
            'cuerpo' => $this->replyBody,
            'respuestaA' => $this->showReplyForm,
            'post_id' => $this->post->id
        ]);

        $this->replyBody = '';
        $this->showReplyForm = null;
    }


    public function render()
    {
        return view('livewire.post-comments');
    }
}
