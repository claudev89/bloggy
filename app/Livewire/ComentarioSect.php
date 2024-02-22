<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Comentario;

class ComentarioSect extends Component
{
    public $post;
    public $comentario;

    public function addComment()
    {
        if(!empty($this->comentario)){
            $comentario = new Comentario();
            $comentario->post_id = $this->post->id;
            $comentario->autor = auth()->id();
            $comentario->cuerpo = $this->comentario;
            $comentario->save();

            $this->comentario = '';

            return redirect()->route('posts.show', $this->post);
        }
    }
    public function render()
    {
        return view('livewire.comentario');
    }
}
