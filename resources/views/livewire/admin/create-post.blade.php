<div>
    @section('head')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endsection
    <div class="modal modal-lg fade" id="createPost" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createPost" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="bi bi-file-earmark-plus"></i> Crear Post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input wire:model.live.debounce.300ms="titulo" type="text" class="form-control @error('titulo') is-invalid @else is-valid @enderror" id="titulo" placeholder="Título del Post" maxlength="100">
                        <label for="title">Título del post</label>
                        <div class="d-flex">
                            <div class="w-100">
                                @error('titulo')
                                <span class="d-inline-flex alert alert-danger small p-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <span class="d-flex small text-secondary text-end ms-2 flex-shrink-1">{{ strlen($titulo) }}/100</span>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        Categorías <br>
                        <div wire:ignore class="mb-2">
                            <select wire:key="categories" wire:model="selectedCategories" class="categorySelect" aria-label="Seleccione un máximo de tres categorías" id="categories" style="width: 100%"; multiple>
                                <option></option>
                                @foreach($availableCategories as $category)
                                    @if(is_null($category->parentCategory))
                                        <optgroup label="{{ $category->name }}">
                                            <option value="{{$category->id}}">{{ $category->name }}</option>
                                            @else
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        </optgroup>
                                        @endif
                                        @endforeach
                                        </optgroup>
                            </select>
                        </div>
                        @error('selectedCategories') <span class="small pt-1 alert alert-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <textarea wire:model.live.debounce.400ms="description" class="form-control @error('description') is-invalid @else is-valid @enderror" id="description" placeholder="Descripción" minlength="50" maxlength="500" style="height: 100px"></textarea>
                        <label for="description">Texto breve</label>
                        <div class="d-flex">
                            <div class="w-100">
                                @error('description') <span class="alert alert-danger small p-1">{{ $message }}</span> @enderror
                            </div>
                            <span class="d-flex small text-secondary text-end ms-2 flex-shrink-1">{{ strlen($description) }}/500</span>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input wire:model="image" accept="image/png, image/jpeg" type="file" class="form-control  @error('image') is-invalid @else is-valid @enderror" id="image">
                        <label for="imagen">Imagen principal del post</label>
                        @error('image') <span class="small p-1 alert alert-danger">{{ $message }}</span> @enderror
                        @if(is_a($image, '\Illuminate\Http\UploadedFile'))
                            <img class="img-thumbnail w-25 h-auto mt-2" src="{{ $image->temporaryUrl() }}" />
                        @elseif ($post && $post->image)
                            <img class="img-thumbnail w-25 h-auto mt-2" src="{{ asset('storage/'.$post->image) }}" />
                        @endif
                        <div wire:loading wire:target="image">
                            <div class="spinner-border spinner-border-sm mt-2" role="status">
                            </div>
                            Subiendo imagen...
                        </div>
                    </div>
                    <div class="form-floating mb-3" wire:ignore>
                        Cuerpo del post
                        <textarea id="summernote" name="editordata" class="form-control" id="body" placeholder="Cuerpo del post" style="height: 100px">{{ $body }}</textarea>
                    </div>
                    @error('body')<span class="small p-1 alert alert-danger">{{ $message }}</span>@enderror
                    <div class="form-floating mb-3" wire:ignore>
                        Etiquetas <br>
                        <select wire:key="tags" wire:model="selectedTags" class="" aria-label="Etiquetas" id="tags" style="width: 100%;" multiple="multiple">
                            <option></option>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('selectedTags') <span class="small p-1 alert alert-danger">{{ $message }}</span> @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#postPreview" wire:click="createPost" @if(count($errors) > 0) disabled @endif >Vista Previa</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal modal-lg fade" id="postPreview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="postPreview" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Vista Previa - {{ $post?->titulo }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ $post?->description }}</p>
                    <strong>Categorías: </strong> @foreach($selectedCategories as $cat) {{ $availableCategories->firstWhere('id', $cat)->name }} @if(!$loop->last) ,  @endif @endforeach <br>
                    @if(isset($post->image))
                        <img src="{{ asset('storage/'.$post?->image) }}" class="img-fluid" /> <br>
                    @endif
                    {!! $post?->body !!} <br>
                    <strong>Etiquetas: </strong>
                    @if($post)
                        @foreach($post->tags as $tag)
                            <span class="badge text-bg-secondary">{{ $tag->name }}</span>
                        @endforeach
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#createPost">Editar</button>
                    <button type="button" class="btn btn-outline-light" wire:click="publicarPost">Publicar</button>
                </div>
            </div>
        </div>
    </div>

        @push('js')

            <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-es-ES.js"></script>
            <script>
                $(document).ready(function() {
                    $('#summernote').summernote({
                        placeholder: 'Cuerpo del post',
                        height: 450,
                        lang: "es-ES",
                        callbacks: {
                            onChange: function (contents, $editable) {
                            if($('#summernote').summernote('isEmpty')) {
                                @this.set('body', '');
                            }
                            else {
                                @this.set('body', contents);
                            }
                            }
                        }
                    });

                    document.getElementsByClassName("btn-codeview")[0].hidden = true;
                    document.getElementsByClassName("btn-fullscreen")[0].hidden = true;

                    var noteBar = $('.note-toolbar');
                    noteBar.find('[data-toggle]').each(function() {
                        $(this).attr('data-bs-toggle', $(this).attr('data-toggle')).removeAttr('data-toggle');
                    });


                    $('.categorySelect').select2({
                        dropdownParent: $('#createPost'),
                        placeholder:'Seleccione un máximo de tres categorías',
                        maximumSelectionLength: 3
                    });
                    $('#categories').on('change', function (e) {
                        @this.selectedCategories = $(this).val();
                        @this.dispatch('sc-changed');
                    });


                    $('#tags').select2({
                        dropdownParent: $('#createPost'),
                        placeholder: 'Seleccione las etiquetas del post',
                        width: "100%",
                        tags: true,
                        tokenSeparators: [',', ' '],
                        createTag: function (params) {
                            return {
                                id: params.term,
                                text: params.term,
                                newTag: true
                            }
                        }
                    }).on('select2:select', function (e) {
                    @this.dispatch('sc-changed');

                    var tagName = e.params.data.text;
                    var tagId = e.params.data.id;
                    if (tagId) {
                        @this.tagSelected(tagName);
                    @this.dispatch('sc-changed');
                    } else {
                        @this.set('selectedTags', $('#tags').val());
                    @this.dispatch('sc-changed');
                    }

                    }).on('select2:unselect', function (e) {
                    @this.dispatch('sc-changed');
                        @this.set('selectedTags', $('#tags').val());
                    });
                });


            </script>
        @endpush

        @push('css')
            <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

            <style>
                /* Restablecer estilos para todos los select2 */
                .select2-container {
                    color: #ffffff !important; /* Color de texto claro */
                    background-color: #262626 !important; /* Fondo oscuro */
                }

                /* Restablecer estilos para el texto de selección */
                .select2-selection__rendered {
                    color: #ffffff !important; /* Color de texto claro */
                    background-color: #262626 !important; /* Fondo oscuro */
                }

                /* Restablecer estilos para el marcador de posición */
                .select2-selection__placeholder {
                    color: #b0b0b0 !important; /* Color de texto de marcador de posición */
                }

                /* Restablecer estilos para la lista desplegable */
                .select2-dropdown {
                    background-color: #262626 !important; /* Fondo oscuro */
                    color: #ffffff !important; /* Color de texto claro */
                }

                /* Restablecer estilos para los resultados */
                .select2-results {
                    background-color: #262626 !important; /* Fondo oscuro */
                    color: #ffffff !important; /* Color de texto claro */
                }

                /* Restablecer estilos para la barra de búsqueda */
                .select2-search__field {
                    color: #ffffff !important; /* Color de texto claro */
                    background-color: #262626 !important; /* Fondo oscuro */
                }

                .select2-selection__choice {
                    color: #000000; /* Color del texto deseado */
                }

                .select2-results__option[aria-selected="true"] {
                    color: #000000; /* Color del texto deseado */
                }
            </style>
        @endpush
</div>
