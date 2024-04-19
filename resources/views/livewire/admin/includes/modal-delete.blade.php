<div class="modal fade" id="deletePost-{{ $myPost->id }}" tabindex="-1" aria-labelledby="deletePost-{{ $myPost->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Está seguro que desea eliminar el post <b>{{ $myPost->titulo }}</b>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" wire:click="deletePost({{ $myPost }})" data-dismiss="modal">Eliminar</button>
            </div>
        </div>
    </div>
</div>
