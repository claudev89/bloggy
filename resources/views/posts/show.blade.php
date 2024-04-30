@extends('layouts.app')

@section('content')

    <div class="d-flex">
        <h2 class="text-uppercase flex-grow-1" xmlns="http://www.w3.org/1999/html">{{ $post->titulo }}</h2>
        @if($isAuthor)
            <div class="dropdown">
                <a href="#" role="button" id="dropdownPost" data-bs-toggle="dropdown" aria-expanded="false" style="color: inherit">
                    <i class="bi bi-three-dots-vertical"></i>
                </a>

                <livewire:admin.create-post :post="$post" />

                <ul class="dropdown-menu" aria-labelledby="dropdownPost">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#createPost"><i class="bi bi-pencil-square"></i> Editar</a></li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#deletePost"><i class="bi bi-trash"></i> Eliminar</a></li>
                </ul>
            </div>

            <div class="modal fade" id="deletePost" tabindex="-1" aria-labelledby="deletePost" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar Post</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Está seguro que desea eliminar el post <b>{{ $post->titulo }}</b>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <form action="{{ route('post.destroy', $post) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @endif
    </div>

    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            @if( $post->categories->first()->parentCategory )
                <li class="breadcrumb-item">
                    <a href="{{ route('categories.show', $post->categories->first()->parent_category->name) }}">{{ $post->categories->first()->parent_category->name }}</a>
                </li>
            @endif
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('categories.show', $post->categories->first()->name) }}">{{$post->categories->first()->name }}</a> </li>
        </ol>
    </nav>

    <div class="text-secondary mb-3">
        Publicado el {{ date('d/m/Y', strtotime($post->created_at)) }} | Leído {{$post->views === 1 ? $post->views." vez": $post->views." veces" }}
    </div>

    <p>{{ $post->description }}</p>

    @if(Str::startsWith($post->image, 'http'))
        <img src="{{ $post->image }}" />
    @else
        <img src="{{ asset('storage/'.$post->image) }}" />
    @endif

    <p>{!! $post->body !!}</p>

    @if(count($post->tags) > 0)
        <strong>Etiquetas: </strong>
    @endif
    <div>
        @foreach($post->tags as $tag)
            <a href="{{ route('tag.show', $tag->name) }}"><span class="badge text-bg-secondary">{{ $tag->name }}</span></a>
        @endforeach
    </div>

    <livewire:PostComments :key="'comments-'.$post->id" :$post :comments="$post->comments"/>

@endsection

