<div>
    <button wire:click="toggleLike">
        {{ $likesCount }} {{ $likesCount === 1 ? 'Like': 'Likes' }}
    </button>
</div>
