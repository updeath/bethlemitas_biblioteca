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
                
                <form class="grid grid-cols-1 md:grid-cols-2 gap-4" action="{{ route('store.editorial') }}" method="POST" style="width: 100%; padding: 3rem 5rem 3rem 5rem">
                    @method('PUT')
                    @csrf
                    <div>
                        <h1 class="text-3xl font-semibold mb-6"><em>Añadir editorial</em></h1>
                        <!-- nombre de editorial -->
                        <div class="mb-3" >
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name_editorial">Nombre de editorial</label>
                            <input id="name_editorial" name="name_editorial" value="{{ old('name_editorial') }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Nombre de editorial">
                            @error('name_editorial')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">El nombre de la editorial ya se encuentra registrado o el campo esta vacío.</span></p>
                            @enderror
                        </div>
                        <div class="flex items-center w-full">
                            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Añadir Editorial
                            </button>
                        </div>
                    </div>

                    <div class="sm:pl-3 pt-7" >
                        <p><em>Verifique que el nombre de la editorial esté correctamente capitalizado con mayúscula inicial y que no contenga puntuación final.</em></p>
                    </div>
                </form>
            </div>

            <!-- Modal de editar editorial -->
            <div id="modal-edit-editorial" class="bg-white border-gray-300 rounded-lg shadow-md hidden" style="width: 100%; height: 42.6%; margin-top: 7px; padding: 0 15px 0 15px; ">
                <h1 class="text-2xl font-semibold mb-6" style=""><em>Editar editorial</em></h1>
                <br>
                <form class="grid grid-cols-1 md:grid-cols-2 gap-4 form-edit-editorial" method="POST" style="width: 100%;">
                    @method('PUT')
                    @csrf
                    <input type="hidden" id="editorialId" name="editorialId" value="">
                    <div>
                        <div class="mb-3">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_name_editorial">Nombre de editorial</label>
                            <input id="edit_name_editorial" name="edit_name_editorial" value="" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Nombre de editorial">
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
            <form action="{{ route('panel.editorial') }}" method="GET" class="flex items-center ">
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
                        <th class="py-3 px-7">Nombre de editorial</th>
                        <th class="py-3 px-4">Acciones</th>
                    </tr>
                </thead>
                <tbody style="text-align: left; vertical-align: middle;">
                    @foreach ($editorials as $editorial)
                        <tr class="transition-all hover:bg-gray-100">
                            <td class="py-3 px-4 border-gray-200" style="text-align: center">{{ $editorial->name_editorial }}</td>
                            <td class="py-3 px-4 border-gray-200" style="text-align: center">
                                <div class="py-1"></div>
                                <button type="button" class="inline-block bg-blue-500 hover:bg-blue-600 rounded-full px-2 py-1 font-semibold text-white mr-1 mb-1 edit-editorial" 
                                    data-id = "{{ $editorial->id }}"
                                    data-name = "{{ $editorial->name_editorial }}" >
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
            const editButton = document.querySelectorAll('.edit-editorial'); // Boton Editar de la tabla
            const modal = document.getElementById('modal-edit-editorial'); // Modal

            editButton.forEach(button => {
                button.addEventListener('click', function () {
                    const name = this.getAttribute('data-name');
                    const id = this.getAttribute('data-id');

                    // Actualizar los valores del formulario
                    document.getElementById('editorialId').value = id;
                    document.getElementById('edit_name_editorial').value = name;

                    // Actualizar el action del formulario
                    const formAction = `{{ url('panel') }}/${id}/editorial`;
                    document.querySelector('.form-edit-editorial').action = formAction;

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