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
<div class="sm:overflow:hidden bg-white shadow-md rounded-lg px-8 my-8 flex items-center" style="width: 88%; padding: 5rem ">
    <!-- Formulario en dos columnas -->
    <form class="grid grid-cols-1 md:grid-cols-2 gap-4" action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data" style="width:100%">
        @csrf
        <!-- Columna 1 -->
        <div >
            <h1 class="text-2xl font-bold "><em>Crear Registro</em></h1>

            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="isbn">ISBN</label>
                <input id="isbn" name="isbn" value="{{ old('isbn') }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="ISBN">
                @error('isbn')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>

            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="clasifpgc">CLASIF PGC</label>
                <select id="clasifpgc" name="clasifpgc" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select a classification</option>
                    @foreach ($classifications as $classification)
                        <option value="{{ $classification->id }}" {{ old('clasifpgc') == $classification->id ? 'selected' : '' }}>
                            {{ $classification->clasifPGC }}
                        </option>
                    @endforeach
                </select>
                @error('clasifpgc')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>

            <!-- Titulo del libro -->
            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Título del libro</label>
                <input id="title" name="title" value="{{ old('title') }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Título">
                @error('title')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>


            <!-- Editorial -->
            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="editorial">Editorial</label>
                <select id="editorial" name="editorial" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select a classification</option>
                    @foreach ($editorials as $editorial)
                        <option value="{{ $editorial->id }}" {{ old('editorial') == $editorial->id ? 'selected' : '' }}>
                            {{ $editorial->name_editorial }}
                        </option>
                    @endforeach
                </select>
                @error('editorial')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>

            <!-- Cantidad de libros -->
            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="amount">Cantidad</label>
                <div class="container_input" style="display: flex">
                    <button type="button" onclick="buttonMenos()" style="background: #f1f5e9; border: none; cursor: pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 13H5v-2h14v2z"></path>
                        </svg>
                    </button>
                    <input type="number" id="amount" name="amount" value="{{ old('amount') }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Cantidad">
                    <button type="button" onclick="buttonMas()" style="background: #f1f5e9; border: none; cursor: pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 13H13V19H11V13H5V11H11V5H13V11H19V13Z"></path>
                        </svg>
                    </button>
                </div>
                @error('amount')
                    <p class=" text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>

            <!-- Autor del libro -->
            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="author">Autor del libro</label>
                <select id="author" name="author" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select a classification</option>
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}" {{ old('author') == $author->id ? 'selected' : '' }}>
                            {{ $author->name_author }}
                        </option>
                    @endforeach
                </select>
                @error('author')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>

        </div>
        <div class="sm:pl-3 pt-7" >
            <!-- Fecha de publicacion -->
            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="publication_date">Fecha de publicación</label>
                <input id="publication_date" name="publication_date" value="{{ old('publication_date') }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="date">
                @error('publication_date')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>

            <!-- Estado del libro -->
            <div class="mb-3 col-span-6 sm:col-span-3">
                <label for="book_status" class="block text-sm font-bold text-gray-700 mb-2">Estado del libro:</label>
                <select id="book_status" name="book_status" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select a classification</option>
                    @foreach ($book_status as $status)
                        <option value="{{ $status->id }}" {{ old('book_status') == $status->id ? 'selected' : '' }}>
                            {{ $status->state}}
                        </option>
                    @endforeach
                </select>
                @error('book_status')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>

            <!-- Actividad -->
            <div class="mb-3 col-span-6 sm:col-span-3">
                <label for="activite" class="block text-sm font-bold text-gray-700 mb-2">Actividad:</label>
                <select id="activite" name="activite" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select a classification</option>
                    @foreach ($activities as $activite)
                        <option value="{{ $activite->id }}" {{ old('activite') == $activite->id ? 'selected' : '' }}>
                            {{ $activite->activity_occupation}}
                        </option>
                    @endforeach
                </select>
                @error('activite')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>
            <!-- Ubicación -->
            <div class="mb-3 col-span-6 sm:col-span-3">
                <label for="location" class="block text-sm font-bold text-gray-700 mb-2">Ubicaión:</label>
                <select id="location" name="location" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select a classification</option>
                    @foreach ($book_location as $location)
                        <option value="{{ $location->id }}" {{ old('location') == $location->id ? 'selected' : '' }}>
                            {{ $location->location}}
                        </option>
                    @endforeach
                </select>
                @error('location')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>

            <div class="mb-3 col-span-6 sm:col-span-3">
                <label for="donado" class="block text-sm font-bold text-gray-700 mb-2">Donación:</label>
                <div class="container_input" style="display: flex">
                    <button type="button" onclick="buttonMenosDonados()" style="background: #f1f5e9; border: none; cursor: pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 13H5v-2h14v2z"></path>
                        </svg>
                    </button>
                    <input type="number" id="donado" name="donado" value="{{ old('donado') }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Cantidad donados">
                    <button type="button" onclick="buttonMasDonados()" style="background: #f1f5e9; border: none; cursor: pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 13H13V19H11V13H5V11H11V5H13V11H19V13Z"></path>
                        </svg>
                    </button>
                </div>
                @error('donado')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>
            
        </div>
        <!-- Botón de envío -->
        <div class="flex items-center w-full">
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Añadir Registro
            </button>
        </div>

    </form>
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
            const amountInput = document.getElementById('amount');
            // Obtener el valor actual y convertirlo a número
            let currentValue = parseInt(amountInput.value, 10);
            // Disminuir el valor en 1
            if (!isNaN(currentValue) && currentValue > 0) {
                amountInput.value = currentValue - 1;
            }
        }

        function buttonMas() {
            // Obtener el campo de entrada
            const amountInput = document.getElementById('amount');
            // Obtener el valor actual y convertirlo a número
            let currentValue = parseInt(amountInput.value, 10);
            // Aumentar el valor en 1
            if (!isNaN(currentValue)) {
                amountInput.value = currentValue + 1;
            } else {
                amountInput.value = 1; // Si no hay valor, inicializa en 1
            }
        }
         // ************************************************************************************
        function buttonMenosDonados() {
            // Obtener el campo de entrada
            const amountInput = document.getElementById('donado');
            // Obtener el valor actual y convertirlo a número
            let currentValue = parseInt(amountInput.value, 10);
            // Disminuir el valor en 1
            if (!isNaN(currentValue) && currentValue > 0) {
                amountInput.value = currentValue - 1;
            }
        }

        function buttonMasDonados() {
            // Obtener el campo de entrada
            const amountInput = document.getElementById('donado');
            // Obtener el valor actual y convertirlo a número
            let currentValue = parseInt(amountInput.value, 10);
            // Aumentar el valor en 1
            if (!isNaN(currentValue)) {
                amountInput.value = currentValue + 1;
            } else {
                amountInput.value = 1; // Si no hay valor, inicializa en 1
            }
        }
    </script>

@endsection
