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
            <form action="{{ route('import.inventory') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="excelFile" class="block text-gray-700 font-medium"><em>Adjunta el archivo Excel del inventario:</em></label>
                <input type="file" name="excelFile" id="excelFile"
                    class="mt-1 px-3 py-2 border border-gray-300 rounded-lg  focus:ring-blue-500 focus:border-blue-500">

                    <button type="submit"
                    class="mt-2 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Importar</button>
            </form>
        </div>
        

            <div class="mt-5">
                <a href="{{route('export.inventory')}}" class="bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-4 rounded-lg">
                    <i class="fas fa-download mr-2"></i> Exportar excel
                </a>
            </div>

        <form action="{{ route('inventory.index') }}" method="GET" class="flex items-center mt-5">
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
        <h1 class="text-3xl font-semibold mb-6">Tabla Registros de Inventario</h1>
        <div class="overflow-x-auto">
            <table class="bg-white border border-gray-300 rounded-lg overflow-hidden" style="width: 105%">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4">Clasif PGC</th>
                        <th class="py-3 px-4">Título</th>
                        <th class="py-3 px-4">Autor</th>
                        <th class="py-3 px-4">Cantidad</th>
                        <th class="py-3 px-4">Editorial</th>
                        <th class="py-3 px-4">Fecha de publicación</th>
                        <th class="py-3 px-4">Estado</th>
                        <th class="py-3 px-4">Ubicación</th>
                        <th class="py-3 px-4">Actividad en la que se ocupa</th>
                        <th class="py-3 px-4">Donado</th>
                        <th class="py-3 px-4">Acciones</th>
                    </tr>
                </thead>
                <tbody style="text-align: left; vertical-align: middle;">
                    @foreach ($inventory as $inventories)
                        <!-- Ejemplo de una fila -->
                        <tr class="transition-all hover:bg-gray-100">
                            <td class="py-3 px-4 border-gray-200">{{ $inventories->classification->clasifPGC}}</td>
                            <td class="py-3 px-4 border-gray-200">{{ $inventories->title }}</td>
                            <td class="py-3 px-4 border-gray-200">{{ $inventories->author->name_author }}</td>
                            <td class="py-3 px-4 border-gray-200">{{ $inventories->amount }}</td>
                            <td class="py-3 px-3 border-gray-200">{{ $inventories->editorial->name_editorial }}</td>
                            <td class="py-3 px-4 border-gray-200">{{ $inventories->publication_date }}</td>
                            <td class="py-3 px-4 border-gray-200">{{ $inventories->estado->state }}</td>
                            <td class="py-3 px-4 border-gray-200">{{ $inventories->ubicacion->location }}</td>
                            <td class="py-3 px-4 border-gray-200">{{ $inventories->actividad->activity_occupation }}</td>
                            <td class="py-3 px-4 border-gray-200">@if($inventories->donated == 1) Si @elseif($inventories->donated == 2) No @endif</td>
                            <td class="py-3 px-4 border-gray-200">
                                <a href="{{ route('inventory.edit', ['inventory' => $inventories->id]) }}"
                                    class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold px-2 py-1 rounded-full transition duration-300">
                                    Editar
                                </a>
                                <div class="py-1"></div>
                                <button type="button" class="inline-block bg-red-500 hover:bg-red-600 rounded-full px-2 py-1 font-semibold text-white mr-1 mb-1 descarte_book" 
                                    data-id="{{ $inventories->id }}" 
                                    data-amount="{{ $inventories->amount }}"
                                    data-title="{{ $inventories->title }}">
                                    Descartar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="bg-white px-4 py-3 border-t text-gray-900">
            {{ $inventory->links() }}
        </div>
    </div>

    <!-- Modal de Descarte -->
     <div id="descarte-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4">Descartar libro</h2>
            <p>Titulo del libro: <span id="book-title" class="font-semibold"></span></p>
            <form id="formDescarted" method="POST">
                @csrf
                <input type="hidden" id="bookId" name="bookId" value="">
                <br>
                <label for="data-amount" class="text-sm font-medium text-gray-500" >Cantidad de ejemplares:</label>
                <input type="number" id="data-amount" value="" style="border: none; width: 30px; text-align: center" disabled>
                
                <label for="data-amount" class="block text-sm font-medium text-gray-500" style="padding-top: 10px;">Cantidad a descartar:</label>
                <button type="button" onclick="buttonMenos()" style="background: #f1f5e9; border: none; cursor: pointer;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13H5v-2h14v2z"></path>
                    </svg>
                </button>
                <input type="number" id="amount_descarted" name="amount_descarted" style="border: 0.5px solid #c0c1c9; width: 50px; text-align: center" min="0" value="0">
                <button type="button" onclick="buttonMas()" style="background: #f1f5e9; border: none; cursor: pointer;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13H13V19H11V13H5V11H11V5H13V11H19V13Z"></path>
                    </svg>
                </button>

                <div class="flex justify-end mt-4">
                <button id="cancel-button" type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded-lg mr-2">Cancelar</button>
                <button id="confirm-delete-button" type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-lg">Descartar</button>
            </div>
            </form>
            
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Obtener todos los botones de eliminar
            const deleteButtons = document.querySelectorAll('.descarte_book');
            const modal = document.getElementById('descarte-modal');
            const bookTitle = document.getElementById('book-title');
            const confirmDeleteButton = document.getElementById('confirm-delete-button');
            const amount_descarted = document.getElementById('amount_descarted');
            let selectedForm = null;
    
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Obtener el título del libro y el formulario correspondiente
                    const title = this.getAttribute('data-title');
                    const amount = this.getAttribute('data-amount');
                    const id = this.getAttribute('data-id');
                    amount_descarted.max = amount;

                    //Actualizar el valor bookId en el formulario
                    document.getElementById('bookId').value = id;

                    //Actualizar el action del formulario con el id correcto
                    const formAction = `{{ url('inventory') }}/${id}/descarted`;
                    document.getElementById('formDescarted').action = formAction;

                    //Actualizar el valor de la cantidad total
                    document.getElementById('data-amount').value = amount;
                    
                    // Mostrar el título en el modal
                    bookTitle.textContent = title;
    
                    // Mostrar el modal
                    modal.classList.remove('hidden');
                });
            });
    
            // Cerrar el modal al hacer clic en cancelar
            document.getElementById('cancel-button').addEventListener('click', function () {
                document.getElementById('amount_descarted').value = 0;
                modal.classList.add('hidden');
            });

        });
    </script>

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
                timer: 2500,
                timerProgressBar: true,
            });
            Toast.fire({
                icon: 'info',
                title: '{{ session('info') }}',
            });
        </script>
    @endif

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

    <script>
        function buttonMenos() {
            // Obtener el campo de entrada
            const amountInput = document.getElementById('amount_descarted');
            // Obtener el valor actual y convertirlo a número
            let currentValue = parseInt(amountInput.value, 10);
            // Disminuir el valor en 1
            if (!isNaN(currentValue) && currentValue > 0) {
                amountInput.value = currentValue - 1;
            }
            
        }

        function buttonMas() {
            // Obtener el campo de entrada
            const amountInput = document.getElementById('amount_descarted');
            const maxAmount = parseInt(document.getElementById('data-amount').value, 10);
            
            // Obtener el valor actual y convertirlo a número
            let currentValue = parseInt(amountInput.value, 10);
            // Obtener el valor máximo de 'data-amount' del botón de descarte (suponiendo que lo almacenas en el botón)
            // Aumentar el valor en 1
            if (!isNaN(currentValue) &&  currentValue < maxAmount) {
                amountInput.value = currentValue + 1;
            } else {
                amountInput.value = 1; // Si no hay valor, inicializa en 1
            }
        }
    </script>

    @endsection