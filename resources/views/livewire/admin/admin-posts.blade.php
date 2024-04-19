<div>

    @if(session('deleted'))
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('deleted') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <form class="mt-3" wire:submit.prevent>
        Buscar por título:
        <input wire:keydown.escape="resetSearch" wire:model.live.debounce.500ms="search" type="text" size="42">
    </form>
    <table class="table table-striped table-hover mt-3">
        <tr>
            @include('livewire.admin.includes.table-sortable-th', ['columnName' => 'titulo', 'name' => 'Título'])
            @include('livewire.admin.includes.table-sortable-th', ['columnName' => 'created_at', 'name' => 'Fecha'])
            @include('livewire.admin.includes.table-sortable-th', ['columnName' => 'borrador', 'name' => 'Tipo'])
            <th>Acciones</th>
        </tr>
        @forelse ($myPosts as $myPost)
            <tr id="{{ $myPost->id }}" wire:key="{{ $myPost->id }}">
                <td>{{ $myPost->titulo }}</td>
                <td>{{ $myPost->created_at->toFormattedDateString() }}</td>
                <td @class(['text-success' => $myPost->borrador ===0, 'text-warning' => $myPost->borrador === 1]) >
                    {!! $myPost->borrador === 0 ? "<i class='far fa-fw fa-file'></i> Publicación" : "<i class='far fa-fw fa-file-excel'></i> Borrador" !!}
                </td>
                <td>
                    <i class='far fa-fw fa-eye mr-2 ' data-twe-toggle="tooltip modal"  title="Vista Previa" data-toggle="modal" data-target="#postPreview_{{ $myPost->id }}" wire:click="" style="cursor: pointer"></i>
                    <i class='far fa-fw fa-edit text-warning mr-2' data-twe-toggle="tooltip" title="Editar" wire:click="" style="cursor: pointer"></i>
                    <i class="far fa-fw fa-trash-alt text-danger" data-twe-toggle="tooltip" title="Eliminar" wire:click="" data-toggle="modal" data-target="#deletePost-{{ $myPost->id }}" style="cursor: pointer"></i>

                    @include('livewire.admin.includes.modal-preview')

                    @include('livewire.admin.includes.modal-delete')

                </td>
            </tr>
        @empty
            "No tienes puclicaciones."
        @endforelse
    </table>
    <div wire:loading>
        <div class="spinner-border spinner-border-sm" role="status">
        </div> Cargando
    </div>

    {{ $myPosts->links() }}

    @script
   <script>
       // Initialization for ES Users
       import {
           Tooltip,
           initTWE,
       } from "tw-elements";

       initTWE({ Tooltip });

   </script>
    @endscript
</div>
