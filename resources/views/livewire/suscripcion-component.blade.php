<div>
    <div class="row justify-content-center">
        <div wire:loading wire:target="crearSuscripcion">
            <div class="d-flex justify-content-center mb-3">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 justify-content-center">
            @if(session()->has('suscripcionRealizada'))
                <div class="alert alert-success" role="alert">
                    {{ session('suscripcionRealizada') }}
                </div>
            @endif
            @error('correo')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
                <form wire:submit.prevent="" class="d-flex" role="suscribe">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="correo@example.com" aria-label="correo"
                           aria-describedby="button-addon2" wire:model="correo" id="correo" name="correo" required>
                    <button class="btn btn-outline-light" type="submit" id="button-addon2"
                            wire:click="crearSuscripcion">Suscribirse
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
