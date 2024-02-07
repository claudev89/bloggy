<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tag;

class TagAutocomplete extends Component
{
    public $query;
    public function render()
    {
        $tags = Tag::where('name', 'like', '%' .$this->query. '%')->get();
        return view('livewire.tag-autocomplete', ['tags' => $tags]);
    }
}
