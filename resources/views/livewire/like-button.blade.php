<div>
    <i wire:loading.delay.remove class="bi {{ $liked ? 'bi-heart-fill text-danger' : 'bi-heart' }}" @auth() wire.loading.attr="disabled" wire:click="like" style="cursor: pointer" @endauth ></i>
    <div wire:loading.delay class="spinner-border spinner-border-sm" role="status"></div><br>
@if($likeCount > 0)
        <span class="small">{{ $likeCount }}</span>
    @endif
</div>
