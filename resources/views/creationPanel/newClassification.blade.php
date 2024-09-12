@extends('layout.masterPage')
<style>
    .colored-toast.swal2-icon-success {
        background-color: #a5dc86 !important;
    }

    .colored-toast.swal2-icon-error {
        background-color: #f27474 !important;
    }

    .colored-toast.swal2-icon-warning {
        background-color: #f8bb86 !important;
    }

    .colored-toast.swal2-icon-info {
        background-color: #3fc3ee !important;
    }

    .colored-toast.swal2-icon-question {
        background-color: #87adbd !important;
    }

    .colored-toast .swal2-title {
        color: white;
    }

    .colored-toast .swal2-close {
        color: white;
    }

    .colored-toast .swal2-html-container {
        color: white;
    }
</style>

@section ('content')
    <div style="display: flex">
        <div style="width: 50%;">
            <div class="bg-white shadow-md rounded-lg  flex w-[120vh] items-center" style="width: 100%;" >
                <!-- Formulario en dos columnas -->
                
                <form class="grid grid-cols-1 md:grid-cols-2 gap-4" action="{{ route('store.classification') }}" method="POST" style="width: 100%; padding: 3rem 5rem 3rem 5rem">
                    @method('PUT')
                    @csrf
                    <div>
                        <h1 class="text-3xl font-semibold mb-6"><em>Añadir clasificación</em></h1>

                        <!-- codigo de clasificacion -->
                        <div class="mb-3" >
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="code_classification">Código de Clasificación</label>
                            <input id="code_classification" name="code_classification" value="{{ old('code_classification') }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" placeholder="Código PGC">
                            @error('code_classification')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">El código PGC ya se encuentra registrado o el campo está vacío</span></p>
                            @enderror
                        </div>

                        <!-- nombre de clasificacion -->
                        <div class="mb-3" >
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name_classification">Nombre de Clasificación</label>
                            <input id="name_classification" name="name_classification" value="{{ old('name_classification') }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Nombre de clasificación">
                            @error('name_classification')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Campo vacío</span></p>
                            @enderror
                        </div>
                        <div class="flex items-center w-full">
                            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Añadir Clasificación
                            </button>
                        </div>
                    </div>

                    <div class="sm:pl-3 pt-7" >
                        <p><em>Verifica que el código PGC sea correcto y que el nombre asociado sea el adecuado. Asegúrate de que el nombre tenga mayúscula inicial y no finalice con un punto ni ningún otro carácter adicional.</em></p>
                    </div>
                </form>
            </div>

            <!-- Modal de editar clasificacion -->
            <div id="modal-edit-classification" class="bg-white border-gray-300 rounded-lg shadow-md hidden" style="width: 100%; height: 42.6%; margin-top: 7px; padding: 0 15px 0 15px; ">
                <h1 class="text-2xl font-semibold mb-6" style=""><em>Editar clasificación</em></h1>
                <br>
                <form class="grid grid-cols-1 md:grid-cols-2 gap-4 form-edit-classification" method="POST" style="width: 100%;">
                    @method('PUT')
                    @csrf
                    <input type="hidden" id="classificationId" name="classificationId" value="">
                    <div>
                        <div class="mb-3">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_code_classificationn">Código de clasificación</label>
                            <input id="edit_code_classification" name="edit_code_classification" value="" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" placeholder="Código de clasificación">
                        </div>
                    </div>
                    <div>
                        <div class="mb-3">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_name_classification">Nombre de clasificación</label>
                            <input id="edit_name_classification" name="edit_name_classification" value="" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Nombre de clasificación">
                        </div>
                    </div>

                    <!-- Botón de envío -->
                    <div class="flex justify-end mt-4">
                        <div class="flex items-center ">
                            <button id="finish-edit" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-lg mr-2" type="submit">
                                Editar
                            </button>
                        </div>
                        <div class="flex items-center w-full">
                            <button id="cancel-button" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded-lg mr-2" type="button">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div style="margin-left: 10px; width: 50%; height: 720px; overflow: auto;">
            <form action="{{ route('panel.classification') }}" method="GET" class="flex items-center ">
                <input type="search" name="search" class="bg-purple-white shadow rounded-l border-0 p-2"
                    placeholder="Buscar">
                <button type="submit"
                    class="bg-purple-white hover:bg-purple-200 text-purple-lighter font-bold py-2 px-4 rounded-r">
                    <svg version="1.1" class="h-4 text-dark" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 52.966 52.966"
                        style="enable-background:new 0 0 52.966 52.966;" xml:space="preserve">
                        <path d="M51.704,51.273L36.845,35.82c3.79-3.801,6.138-9.041,6.138-14.82c0-11.58-9.42-21-21-21s-21,9.42-21,21s9.42,21,21,21
                                    c5.083,0,9.748-1.817,13.384-4.832l14.895,15.491c0.196,0.205,0.458,0.307,0.721,0.307c0.25,0,0.499-0.093,0.693-0.279
                                    C52.074,52.304,52.086,51.671,51.704,51.273z M21.983,40c-10.477,0-19-8.523-19-19s8.523-19,19-19s19,8.523,19,19
                                    S32.459,40,21.983,40z" />
                    </svg>
                </button>
            </form>
            <table class="bg-white border border-gray-300 rounded-lg overflow-hidden" style="width: 100%">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-1">Código PGC</th>
                        <th class="py-3 px-7">Nombre clasificación</th>
                        <th class="py-3 px-4">Acciones</th>
                    </tr>
                </thead>
                <tbody style="text-align: left; vertical-align: middle;">
                    @foreach ($classifications as $classification)
                        <tr class="transition-all hover:bg-gray-100">
                            <td class="py-3 px-4 border-gray-200" style="text-align: center">{{ $classification->clasifPGC }}</td>
                            <td class="py-3 px-4 border-gray-200" style="text-align: center">{{ $classification->name_classification }}</td>
                            <td class="py-3 px-4 border-gray-200" style="text-align: center">
                                <div class="py-1"></div>
                                <button type="button" class="inline-block bg-blue-500 hover:bg-blue-600 rounded-full px-2 py-1 font-semibold text-white mr-1 mb-1 edit-classification" 
                                    data-id = "{{ $classification->id }}"
                                    data-code = "{{ $classification->clasifPGC }}"
                                    data-name = "{{ $classification->name_classification }}" >
                                    Editar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    
    @if (session('success'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                iconColor: 'white',
                customClass: {
                    popup: 'colored-toast',
                },
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
            });
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}',
            });
        </script>
    @endif

    @if (session('info'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                iconColor: 'white',
                customClass: {
                    popup: 'colored-toast',
                },
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,
            });
            Toast.fire({
                icon: 'info',
                title: '{{ session('info') }}',
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Obtener todos los botones de edición
            const editButton = document.querySelectorAll('.edit-classification'); // Boton Editar de la tabla
            const modal = document.getElementById('modal-edit-classification'); // Modal

            editButton.forEach(button => {
                button.addEventListener('click', function () {
                    const code = this.getAttribute('data-code');
                    const name = this.getAttribute('data-name');
                    const id = this.getAttribute('data-id');

                    // Actualizar los valores del formulario
                    document.getElementById('classificationId').value = id;
                    document.getElementById('edit_code_classification').value = code;
                    document.getElementById('edit_name_classification').value = name;

                    // Actualizar el action del formulario
                    const formAction = `{{ url('panel') }}/${id}/classification`;
                    document.querySelector('.form-edit-classification').action = formAction;

                    // Mostrar el modal
                    modal.classList.remove('hidden');
                });

                // Cerrar el modal al hacer clic en cancelar
                document.getElementById('cancel-button').addEventListener('click', function () {
                    modal.classList.add('hidden');
                });
            });
        });

    </script>
    
@endsection