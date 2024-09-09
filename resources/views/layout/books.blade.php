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