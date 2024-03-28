<div>
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
                    <i class='far fa-fw fa-eye mr-2' wire:click="" style="cursor: pointer"></i>
                    <i class='far fa-fw fa-edit text-warning mr-2' wire:click="" style="cursor: pointer"></i>
                    <i class="far fa-fw fa-trash-alt text-danger" wire:click="" style="cursor: pointer"></i>
                </td>
            </tr>
        @empty
            "No tienes puclicaciones."
        @endforelse
    </table>
    <div wire:loading>
        Cargando...
    </div>
    {{ $myPosts->links() }}
</div>
