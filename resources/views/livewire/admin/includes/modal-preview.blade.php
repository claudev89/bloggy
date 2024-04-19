<div class="modal fade" id="postPreview_{{ $myPost->id }}" tabindex="-1" role="dialog" aria-labelledby="postPreview_{{ $myPost->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $myPost->titulo }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ $myPost->description }}</p>
                <img src="{{ $myPost->image }}" class="img-fluid">
                <p>{{ $myPost->body }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar vista previa</button>
                <a type="button" class="btn btn-primary" href="{{ route('posts.show', $myPost) }}" target="_blank">Ir al post</a>
            </div>
        </div>
    </div>
</div>
