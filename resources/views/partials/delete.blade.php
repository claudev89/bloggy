@if(auth()->id() === $objeto->autor)
    <button type="button" class="btn p-0 ms-1" data-bs-toggle="modal" data-bs-target="#deleteComment-{{ $objeto->id }}">
        <i class="bi bi-trash"></i>
    </button>

    <div class="modal fade" id="deleteComment-{{ $objeto->id }}" tabindex="-1" aria-labelledby="deleteComment-{{ $objeto->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar {{ $type }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro que deseas eliminar {{ $type == "comentario" ? "el ": "la " }} {{ $type }}: <br>
                    "<b>{{ $objeto->cuerpo }}</b>" ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('comentario.destroy', $objeto) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endif
