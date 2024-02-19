<div>
    <i class="bi {{ $liked ? 'bi-heart-fill text-danger' : 'bi-heart' }}" @auth() wire:click="like" style="cursor: pointer" @endauth ></i><br>
    @if($likeCount > 0)
        {{ $likeCount }}
    @endif
</div>
