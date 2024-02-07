<div>
    <input wire:model="query" type="text" placeholder="Escribe una etiqueta">

    @if(count($tags) > 0)
        <ul>
            @foreach($tags as $tag)
                <li wire:click="$emit('tagSelected', '{{ $tag->name  }}">{{ $tag->name }} ({{ $tag->posts_count }})</li>
            @endforeach
        </ul>
    @endif
</div>
