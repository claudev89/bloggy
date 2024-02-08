@extends('layouts.app')

@section('content')
    @php($posts = \App\Models\Post::where('borrador', 0)->paginate(15))
    @foreach($posts as $post)
        <a href="{{ route('posts.show', $post) }}" style="text-decoration: none">
            <div class="card mb-2 mt-2">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ $post->image }}" class="img-fluid rounded-start" alt="{{ $post->titulo }}">
                    </div>
                    <div class="col-md-5" style="width: 66%;">
                        <div class="card-body">
                            <h4 class="card-title">{{ $post->titulo }}</h4>
                            <p class="card-text crop-text-3">{{ $post->description }}</p>
                            <p class="card-text"><small class="text-body-secondary">{{ date('d/m/Y', strtotime($post->created_at)) }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach

    {{ $posts->links() }}

@endsection

<style>
    .crop-text-3 {
        -webkit-line-clamp: 3;
        overflow : hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
    }
</style>
