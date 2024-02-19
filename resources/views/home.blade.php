@php( $users = \App\Models\User::count() )
@php( $posts = \App\Models\Post::where('borrador', 0)->count() )
@php( $activesSubscriptions = \App\Models\Suscripcion::whereDoesnthave('token')->count() )

@extends('adminlte::page')

@section('title', config('app.name').' - Dashboard')
@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <x-adminlte-small-box title="{{ $posts }}" text="Posts publicados" icon="fas fa-file text-dark"
                                                  theme="teal" url="#" url-text="Ver posts"/>
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-small-box title="{{ $users }}" text="Usuarios activos" icon="fas fa-user text-dark"
                                                  theme="teal" url="#" url-text="Ver usuarios"/>
                        </div><div class="col-md-4">
                            <x-adminlte-small-box title="{{ $activesSubscriptions }}" text="Susctipciones activas" icon="fas fa-newspaper text-dark"
                                                  theme="teal" url="#" url-text="Ver suscripciones"/>
                        </div>
                    </div>



                    @push('js')
                        <script>

                            $(document).ready(function() {

                                let sBox = new _AdminLTE_SmallBox('sbUpdatable');

                                let updateBox = () =>
                                {
                                    // Stop loading animation.
                                    sBox.toggleLoading();

                                    // Update data.
                                    let rep = Math.floor(1000 * Math.random());
                                    let idx = rep < 100 ? 0 : (rep > 500 ? 2 : 1);
                                    let text = 'Reputation - ' + ['Basic', 'Silver', 'Gold'][idx];
                                    let icon = 'fas fa-medal ' + ['text-primary', 'text-light', 'text-warning'][idx];
                                    let url = ['url1', 'url2', 'url3'][idx];

                                    let data = {text, title: rep, icon, url};
                                    sBox.update(data);
                                };

                                let startUpdateProcedure = () =>
                                {
                                    // Simulate loading procedure.
                                    sBox.toggleLoading();

                                    // Wait and update the data.
                                    setTimeout(updateBox, 2000);
                                };

                                setInterval(startUpdateProcedure, 10000);
                            })

                        </script>
                    @endpush

            </div>
        </div>
    </div>
@stop
