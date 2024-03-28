<th wire:click="setSortBy('{{ $columnName }}')"> {{ $name }}
    <button class="btn p-0">
        @if($sortBy !== $columnName) <i class='fa fa-fw fa-arrows-alt-v'></i>
        @elseif($sortDir == 'ASC') <i class='fa fa-fw fa-arrow-up'></i>
        @else <i class='fa fa-fw fa-arrow-down'></i>
        @endif
    </button>
</th>
