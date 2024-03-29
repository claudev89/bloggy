<div>
    @if(session()->has('success'))
        <div class=" alert alert-success" role="alert">{{ session('success') }}</div>
    @endif
    <form wire:submit.prevent="submit" class="mt-4 mb-4 needs-validation" method="post" action="{{ route('contacto.store') }}" novalidate>
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" wire:model.live.debounce.200ms="name" class="form-control @error('name') is-invalid @enderror is-valid" {{ $errors->has('name') ? '' : 'is-valid' }} value="{{ old('name') }}" id="name" placeholder="Juan Pérez" required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" wire:model.live.debounce.200ms="email" class="form-control @error('email') is-invalid @enderror is-valid" {{ $errors->has('email') ? '' : 'is-valid' }} value="{{ old('email') }}" id="name" placeholder="hola@example.com" required>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="emailHelp" class="form-text">No compartiremos tu dirección de correo electrónico con nadie.</div>
        </div>
        <div class="mb-3">
            <label for="messageContent" class="form-label">Mensaje</label>
            <textarea wire:model.live.debounce.200ms="messageContent" class="form-control @error('messageContent') is-invalid @enderror is-valid" {{ $errors->has('messageContent') ? '' : 'is-valid' }} id="messageContent"  rows="8"></textarea>
            @error('messageContent')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-outline-light" wire:click.prevent="submit" wire:loading.attr="disabled">
            <span wire:loading.remove>Enviar</span>
            <span wire:loading wire:target="submit">
                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                <span role="status">Enviando...</span>
            </span>
        </button>

    </form>

</div>
