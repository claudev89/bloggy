<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use App\Models\Tag;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use App\Models\Category;

class CreatePost extends ModalComponent
{
    use WithFileUploads;

    #[Validate()]
    public $selectedCategories = [];

    #[Validate()]
    public $selectedTags = [];
    public $availableCategories;

    #[Validate()]
    public $image;

    #[Validate()]
    public $titulo;

    #[Validate()]
    public $description;
    public $tags;

    #[Validate()]
    public $body;

    public $post;

    public function rules()
    {
        return [
            'selectedCategories' => ['required', ],
            'selectedTags' => ['required', ],
            'image' => ['required', 'image', 'max:8192'],
            'titulo' => ['required', 'max:100', Rule::unique('posts')->ignore($this->post), ],
            'description' => 'min:50|max:500|required',
            'body' => 'required',
        ];
    }

    public function messages()
    {
        return [
          //
        ];
    }


    public function mount()
    {
        $this->availableCategories = Category::all();
        $this->tags = Tag::all();
        $this->validate();
    }

    public function create()
    {
        if ($this->image) {
            $validated['image'] = $this->image->store('uploads', 'public');
        }
    }


    #[On('sc-changed')]
    public function validar()
    {
        $this->validate();
    }

    public function createPost()
    {
        $this->validate();
        if($this->post) {
            $this->post->update([
                'titulo' => $this->titulo,
                'description' => $this->description,
                'image' => $this->image->store('uploads', 'public'),
                'body' => $this->body,
            ]);
            // Eliminar categorías anteriores y agregar categorías nuevas
            $this->post->categories()->detach();
            $this->post->categories()->attach($this->selectedCategories);

            // Eliminar etiquetas anteriores y agregar etiquetas nuevas
            $this->post->tags()->detach();
            $this->post->tags()->attach($this->selectedTags);
        }
        else
        {
            $this->post = Post::create([
                    'titulo' => $this->titulo,
                    'description' => $this->description,
                    'image' => $this->image->store('uploads', 'public'),
                    'body' => $this->body,
                    'autor' => auth()->id(),
                    'borrador' => 1
                ]
            );
            // Agregar Categorías
            $this->post->categories()->attach($this->selectedCategories);
            // Agregar Etiquetas
            $this->post->tags()->attach($this->selectedTags);
        }
    }

    public function publicarPost()
    {
        $this->post->borrador = 0;
        $this->post->save();
        return redirect()->to('/');
    }



    public function render()
    {

        return view('livewire.admin.create-post', [
            'availableCategories' => $this->availableCategories,
        ]);
    }
}
