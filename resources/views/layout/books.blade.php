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
        @yield('import-excel')
    </div>
    <div class="container mx-auto my-10">
        @yield('table')
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
                <input type="number" id="data-amount" value="" style="border: none; width: 50px; text-align: center" disabled>

                <label for="data-amount-donated" class="text-sm font-medium text-gray-500" >Cantidad libros donados:</label>
                <input type="number" id="data-amount-donated" value="" style="border: none; width: 50px; text-align: center" disabled>
                
                <div style="display: flex">
                    <div style="margin-right: 77px">
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
                    </div>
                    <div>
                        <label for="data-amount" class="block text-sm font-medium text-gray-500" style="padding-top: 10px;">Cantidad a descartar:</label>
                        <button type="button" onclick="buttonMenosDonated()" style="background: #f1f5e9; border: none; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 13H5v-2h14v2z"></path>
                            </svg>
                        </button>
                        <input type="number" id="amount_donated" name="amount_donated" style="border: 0.5px solid #c0c1c9; width: 50px; text-align: center" min="0" value="0">
                        <button type="button" onclick="buttonMasDonated()" style="background: #f1f5e9; border: none; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 13H13V19H11V13H5V11H11V5H13V11H19V13Z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Estado del libro -->
                <div class="mb-3 col-span-6 sm:col-span-3" style="margin-top: 20px">
                    <label for="book_status" class="block text-sm font-bold text-gray-700 mb-2">Estado del libro (Motivo):</label>
                    <select id="book_status" name="book_status" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Select a classification</option>
                        @foreach ($book_status as $status)
                            @if($status->id == 3)
                                <option value="{{ $status->id }}" {{ old('book_status') == $status->id ? 'selected' : '' }}>
                                    {{ $status->state }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

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
            const amount_book_donated = document.getElementById('amount_donated');
            let selectedForm = null;
    
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Obtener el título del libro y el formulario correspondiente
                    const title = this.getAttribute('data-title');
                    const amount = this.getAttribute('data-amount');
                    let amount_donated = this.getAttribute('data-amount-donated');
                    const id = this.getAttribute('data-id');
                    amount_descarted.max = amount - amount_donated;
                    if (amount_donated === null || isNaN(amount_donated) || amount_donated === '') {
                        amount_donated = 0;
                    }
                    amount_book_donated.max = amount_donated;

                    //Actualizar el valor bookId en el formulario
                    document.getElementById('bookId').value = id;

                    //Actualizar el action del formulario con el id correcto
                    const formAction = `{{ url('inventory') }}/${id}/descarted`;
                    document.getElementById('formDescarted').action = formAction;

                    //Actualizar el valor de la cantidad total
                    document.getElementById('data-amount').value = amount;
                    if (amount_donated === null || isNaN(amount_donated) || amount_donated === '')  {
                        amount_donated = 0;
                    }
                    
                    document.getElementById('data-amount-donated').value = amount_donated;
                    
                    // Mostrar el título en el modal
                    bookTitle.textContent = title;
    
                    // Mostrar el modal
                    modal.classList.remove('hidden');
                });
            });
    
            // Cerrar el modal al hacer clic en cancelar
            document.getElementById('cancel-button').addEventListener('click', function () {
                document.getElementById('amount_descarted').value = 0;
                document.getElementById('amount_donated').value = 0;
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
                timer: 3500,
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
            const maxAmountDonated = parseInt(document.getElementById('data-amount-donated').value, 10);
            let = maxAmountTotal = maxAmount - maxAmountDonated;
            
            // Obtener el valor actual y convertirlo a número
            let currentValue = parseInt(amountInput.value, 10);
            // Obtener el valor máximo de 'data-amount' del botón de descarte (suponiendo que lo almacenas en el botón)
            // Aumentar el valor en 1
            if (!isNaN(currentValue) &&  currentValue < maxAmountTotal) {
                amountInput.value = currentValue + 1;
            } else {
                amountInput.value = 0; // Si no hay valor, inicializa en 1
            }
        }
        //Botones de descarte de libros donados
        function buttonMenosDonated() {
            // Obtener el campo de entrada
            const amountInput = document.getElementById('amount_donated');
            // Obtener el valor actual y convertirlo a número
            let currentValue = parseInt(amountInput.value, 10);
            // Disminuir el valor en 1
            if (!isNaN(currentValue) && currentValue > 0) {
                amountInput.value = currentValue - 1;
            }
            
        }

        function buttonMasDonated() {
            // Obtener el campo de entrada
            const amountInput = document.getElementById('amount_donated');
            const maxAmount = parseInt(document.getElementById('data-amount-donated').value, 10);
            
            // Obtener el valor actual y convertirlo a número
            let currentValue = parseInt(amountInput.value, 10);
            // Obtener el valor máximo de 'data-amount' del botón de descarte (suponiendo que lo almacenas en el botón)
            // Aumentar el valor en 1
            if (!isNaN(currentValue) &&  currentValue < maxAmount) {
                amountInput.value = currentValue + 1;
            } else {
                amountInput.value = 0; // Si no hay valor, inicializa en 1
            }
        }
    </script>

    @endsection