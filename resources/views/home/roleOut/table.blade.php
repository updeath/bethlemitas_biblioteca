@extends('layout.masterPage')

@section('content')
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
    <div class="flex justify-between items-center my-2">
    <div class="">
        <form action="{{ route('import.discard') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="excelFile" class="block text-gray-700 font-medium"><em>Adjunta el archivo Excel del inventario:</em></label>
            <input type="file" name="excelFile" id="excelFile"
                class="mt-1 px-3 py-2 border border-gray-300 rounded-lg  focus:ring-blue-500 focus:border-blue-500">
            
                <button type="submit"
                class="mt-2 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Importar</button>
        </form>
    </div>

    <div class="mt-6">
        <a href="{{route('export.discard')}}" class="bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-4 rounded-lg">
            <i class="fas fa-download mr-2"></i> Exportar excel
        </a>
    </div>

        <form action="{{ route('discards.table') }}" method="GET" class="flex items-center mt-5">
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
    </div>
    <div class="container mx-auto my-10">
        <h1 class="text-3xl font-semibold mb-6">Tabla Descartes</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4">Código</th>
                        <th class="py-3 px-4">Título</th>
                        <th class="py-3 px-4">Autor</th>
                        <th class="py-3 px-4">Editorial</th>
                        <th class="py-3 px-4">Cantidad</th>
                        <th class="py-3 px-4">Categoria</th>
                        <th class="py-3 px-4">Área</th>
                        <th class="py-3 px-4">Estado</th>
                        <th class="py-3 px-4">Clasif-pgc</th>
                        <th class="py-3 px-4">Actividad</th>
                        <th class="py-3 px-4">Año</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($discards as $discard)
                        <!-- Ejemplo de una fila -->
                        <tr class="transition-all hover:bg-gray-100">
                            <td class="py-3 px-4">{{ $discard->code }}</td>
                            <td class="py-3 px-4">{{ $discard->title }}</td>
                            <td class="py-3 px-4">{{ $discard->author }}</td>
                            <td class="py-3 px-4">{{ $discard->editorial }}</td>
                            <td class="py-3 px-4">{{ $discard->amount }}</td>
                            <td class="py-3 px-4">{{ $discard->category }}</td>
                            <td class="py-3 px-4">{{ $discard->area }}</td>
                            <td class="py-3 px-4">
                                @if ($discard->status == 'well')
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                        Bueno
                                    </span>
                                @elseif ($discard->status == 'regular')
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-green-700 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-100">
                                        Regular
                                    </span>
                                @elseif ($discard->status == 'bad')
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700">
                                        Malo
                                    </span>
                                @else
                                    {{ $discard->status }}
                                @endif
                            </td>
                            <td class="py-3 px-4">{{ $discard->clasifpgc }}</td>
                            <td class="py-3 px-4">
                                @if ($discard->activite == 'reference_material')
                                    <span>Material de Referencia</span>
                                @elseif ($discard->activite == 'investigation')
                                    <span>Invenstigacion</span>
                                @elseif ($discard->activite == 'teaching')
                                    <span>Enseñanza</span>
                                @elseif ($discard->activite == 'consultation')
                                    <span>Consultar</span>
                                @elseif ($discard->activite == 'languagues')
                                    <span>Lenguas</span>
                                @elseif ($discard->activite == 'languagues')
                                    <span>Lectura</span>
                                @else
                                    {{ $discard->activite }}
                                @endif
                            </td>
                            <td class="py-3 px-4">{{ $discard->year }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="bg-white px-4 py-3 border-t text-gray-900">
            {{ $discards->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('delete'))
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
                icon: 'error',
                title: '{{ session('delete') }}',
            });
        </script>
    @endif

    <script>
        // Agrega este script al final de tu archivo Blade
        document.addEventListener('DOMContentLoaded', function () {
            $('.form-delete').click(function (e) {
                e.preventDefault();

                var id = $(this).data('id');

                Swal.fire({
                    title: '¿Estás seguro de eliminar este registro?',
                    text: '¡No podrás revertir esto!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'red',
                    cancelButtonColor: 'gray',
                    confirmButtonText: 'Sí, eliminarlo',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete-form-' + id).submit();
                    }
                });
            });
        });
    </script>
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


    @if (session('error'))
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
                icon: 'error',
                title: '{{ session('error') }}',
            });
        </script>
    @endif
    @endsection
