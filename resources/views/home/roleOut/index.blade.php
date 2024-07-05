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
@section('content')

    <a href="{{ route('discards.table') }}"
        class="bg-[#95A5A6] top-[10%] right-[50%] hover:bg-gray-500 text-black hover:text-white p-2 rounded-full my-4" style="display:flex; justify-content:center; width:10rem">Generar tabla
    </a>

    <h1 class="my-3 text-2xl">Listados de Descartes</h1>

    <form action="{{ route('roleOut.index') }}" method="GET" class="flex items-center">
        <input type="search" name="search" class="bg-purple-white shadow rounded-l border-0 p-2" placeholder="Buscar">
        <button type="submit" class="bg-purple-white hover:bg-purple-200 text-purple-lighter font-bold py-2 px-4 rounded-r">
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

    

    <div class="flex flex-wrap justify-start">
        @foreach ($discardedBooks as $discardedBook)
            <div class="max-w-xs rounded overflow-hidden shadow-lg m-2 ">
                @if ($discardedBook->image)
                    <img class="w-full max-w-32 h-auto mx-auto" src="{{ asset($discardedBook->image) }}"
                        alt="{{ $discardedBook->title }}">
                @else
                    <img class="w-full max-w-32 h-auto mx-auto" src="/img/logo.png" alt="{{ $discardedBook->title }}">
                @endif

                <div class="px-4 py-2">
                    <div class="font-bold text-lg mb-1">Información del libro</div>
                    <p class="text-gray-700 text-sm">
                        <b>Codigo: </b>{{ $discardedBook->code }}
                    </p>
                    <p class="text-gray-700 text-sm">
                        <b>Titulo: </b>{{ $discardedBook->title }}
                    </p>
                    <p class="text-gray-700 text-sm">
                        <b>Autor: </b>{{ $discardedBook->author }}
                    </p>
                    <p class="text-gray-700 text-sm">
                        <b>Editorial: </b>{{ $discardedBook->editorial }}
                    </p>
                </div>
                <div class="flex justify-between items-center px-4 pt-2 pb-1">
                    <button
                        class="inline-block bg-gray-500 hover:bg-gray-600 rounded-full px-2 py-1 text-xs font-semibold text-white mr-1 mb-1 btn-show-info"
                        onclick="showModal('{{ $discardedBook->title }}',
                                    '{{ $discardedBook->author }}',
                                    '{{ $discardedBook->editorial }}',
                                    '{{ asset($discardedBook->image) }}',
                                    '{{ $discardedBook->code }}',
                                    '{{ $discardedBook->amount }}',
                                    '{{ $discardedBook->category }}',
                                    '{{ $discardedBook->area }}',
                                    '{{ $discardedBook->status }}',
                                    '{{ $discardedBook->clasifpgc }}',
                                    '{{ $discardedBook->activite }}',
                                    '{{ $discardedBook->year }}')">
                        Mas Info

                    </button>
                    <form id="delete-form-{{ $discardedBook->id }}"
                        action="{{ route('discard.destroy', $discardedBook->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-block bg-red-500 hover:bg-red-600 rounded-full px-2 py-1 text-xs font-semibold text-white mr-1 mb-1 form-delete"
                            data-id="{{ $discardedBook->id }}">Eliminar</button>
                    </form>
                    <form id="discard-form-{{ $discardedBook->id }}"
                        action="{{ route('restore.book', ['id' => $discardedBook->id]) }}" method="post">
                        @csrf
                        <button type="submit"
                            class="inline-block bg-green-500 hover:bg-green-600 rounded-full px-2 py-1 text-xs font-semibold text-white mr-1 mb-1 btn-show-confirm"
                            data-id="{{ $discardedBook->id }}">Restaurar</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex items-center justify-center" id="bookModal"
        style="display: none;">
        <div class="modal-dialog w-full md:w-1/2 lg:w-1/3 xl:w-1/3">
            <div class="modal-content border border-gray-900 bg-white rounded-lg shadow-lg">
                <div class="modal-header bg-gray-300 text-black border-b border-gray-900 py-4 px-6 rounded-t-lg">
                    <h5 class="modal-title text-2xl font-semibold" id="bookModalTitle"><em>Información completa del
                            libro</em></h5>
                    <!-- <button type="button" class="close text-black" onclick="hideModal()" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button> -->
                </div>
                <div class="modal-body p-6" id="bookModalBody">
                    <!-- Aquí se mostrará la información del libro -->
                </div>
                <div class="modal-footer bg-white py-4 px-6 rounded-b-lg">
                    <button type="button"
                        class="btn bg-gray-400 border border-gray-900 rounded-full hover:bg-gray-500  hover:text-white p-2 "
                        onclick="hideModal()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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


    <script>
        function showModal(title, author, editorial, image, code, amount, category, area, status, clasifpgc, activite,
            year) {
            var modalTitle = document.getElementById('bookModalTitle');
            var modalBody = document.getElementById('bookModalBody');

            modalTitle.textContent = 'Información completa del libro - ' + title;

            var defaultImage = '{{ asset('img/logo.png') }}';

            var modalContent = '<img class="w-full max-w-32 h-auto mx-auto" src="' + image + '" onerror="this.src=' + "'" +
                defaultImage + "'" + '" alt="' + title + '">';
            modalContent += '<em> <p><b>Codigo: </b>' + code + '</p> ';
            modalContent += '<p><b>Titulo: </b>' + title + '</p>';
            modalContent += '<p><b>Autor: </b>' + author + '</p>';
            modalContent += '<p><b>Editorial: </b>' + editorial + '</p>';
            modalContent += '<p><b>Cantidad: </b>' + amount + '</p>';
            modalContent += '<p><b>Categoria: </b>' + category + '</p>';
            modalContent += '<p><b>Area: </b>' + area + '</p>';
            modalContent += '<p><b>Estado: </b>' + getStatusText(status) + '</p>';
            modalContent += '<p><b>Clasificación: </b>' + clasifpgc + '</p>';
            modalContent += '<p><b>Propósito: </b>' + getActivityText(activite) + '</p>';
            modalContent += '<p><b>Año: </b>' + year + '</p>';

            modalBody.innerHTML = modalContent;

            document.getElementById('bookModal').style.display = 'flex';
        }

        function hideModal() {
            document.getElementById('bookModal').style.display = 'none';
        }

        function getStatusText(status) {
            switch (status) {
                case 'well':
                    return 'Bueno';
                case 'regular':
                    return 'Regular';
                case 'bad':
                    return 'Malo';
                default:
                    return status;
            }
        }

        function getActivityText(activity) {
            switch (activity) {
                case 'reference_material':
                    return 'Material de referencia';
                case 'investigation':
                    return 'Investigación';
                case 'teaching':
                    return 'Enseñanza';
                case 'consultation':
                    return 'Consulta';
                case 'languagues':
                    return 'Idiomas';
                case 'reading':
                    return 'Lectura';
                default:
                    return activity;
            }
        }
    </script>


    <script>
        $('.btn-show-confirm').click(function(e) {
            e.preventDefault();

            var id = $(this).data('id');

            Swal.fire({
                title: '¿Estás seguro de restaurar este libro?',
                text: '¡El libro será restaurado y visible nuevamente!',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, restaurar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#discard-form-' + id).submit(); // Corregir aquí
                }
            });
        });
    </script>
@endsection
