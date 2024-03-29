<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class SearchPosts extends Component
{
    public $search = "";

    public function resetSearch ()
    {
        $this->reset();
    }

    public function render()
    {
        $results = [];

        if(strlen($this->search) >= 3) {
            $results = Post::where('titulo', 'like', '%'.$this->search.'%')->limit(10)->get();
        }
        return view('livewire.search-posts', ['posts' => $results]);
    }
}
