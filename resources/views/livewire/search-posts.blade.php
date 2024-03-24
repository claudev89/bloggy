<div>
    <form class="d-flex mb-1" role="search">
        <div class="input-group">
            <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
            <input wire:model.live.debounce.500ms="search"  class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
        </div>
    </form>
    @if(sizeof($posts) > 0)
        <div class="dropdown-menu d-block py-0 mt-0">
            @foreach($posts as $post)
                <div class="px-0 py-0 border-bottom">
                    <a href="{{ route('posts.show', $post) }}" style="text-decoration: none">
                        <div class="d-flex align-items-center me-auto btn btn-dark">
                            <div class="me-3">
                                <img src="{{ $post->image }}" width="64" height="48">
                            </div>
                            <div class="text-start">
                                <span class="text-truncate d-block" style="max-width: 27rem">
                                    {{ $post->titulo }}
                                </span>
                                <span class="text-truncate text-secondary small d-block" style="max-width: 27rem">
                                    {{ $post->description }}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
