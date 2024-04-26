<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Arr;
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
            'selectedCategories' => 'Seleccione al menos una categoría y 3 como máximo.',
            'selectedTags' => 'Agregue etiquetas a su publicación',
            'image.required' => 'Suba una imagen de portada para su publicación',
            'image.image' => 'Seleccione un archivo de imagen válido',
            'image.max' => 'La imagen no puede sobrepasar los 8 MB',
            'titulo.required' => 'Escriba un título para su publicación',
            'titulo.max' => 'El título no puede sobrepasar los 100 caracteres de largo',
            'titulo.unique' => 'Ya existe una publicación con ese título',
            'description.required' => 'Escriba una descripción breve para su post (máximo 500 caracteres)',
            'description.min' => 'La descripción no puede contener menos de 50 caracteres',
            'description.max' => 'La descripción no puede ser de más de 500 caracteres de largo',
            'body.required' => 'Escriba el cuerpo de su publicación.',
        ];
    }

    public function mount()
    {
        $this->availableCategories = Category::all();
        $this->tags = Tag::all();
        if($this->post) {
            $this->selectedTags = $this->post->tags->pluck('id')->toArray();
        }

        $this->validate();
    }

    public function create()
    {
        if ($this->image) {
            $validated['image'] = $this->image->store('uploads', 'public');
        }
    }

    #[On('sc-changed')]
    public function validateCategoriesTags()
    {
        $this->validate();
    }

    public function tagSelected($tagName)
    {
        $tag = Tag::firstOrCreate(['name' => $tagName]);

        if (!in_array($tag->id, $this->selectedTags)) {
            $this->selectedTags[] = $tag->id;
        }
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
            $this->post->categories()->sync($this->selectedCategories);

            // Eliminar etiquetas anteriores y agregar etiquetas nuevas
            $this->post->tags()->sync($this->selectedTags);
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
            $this->post->tags()->sync($this->selectedTags);
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
