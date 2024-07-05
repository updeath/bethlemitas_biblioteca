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
<div class="bg-white shadow-md rounded-lg px-8 my-8 flex sm:w-[120vh] items-center">
    <!-- Formulario en dos columnas -->
    <form class="grid grid-cols-1 md:grid-cols-2 gap-4" action="{{ route('donations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Columna 1 -->
        <div>
            <h1 class="text-2xl font-bold "><em>Crear una Donación</em></h1>

            <!-- Codigo -->
            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="code">Código</label>
                <input id="code" name="code" value="{{ old('code') }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Código">
                @error('code')
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

            <!-- Autor del libro -->
            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="author">Autor del libro</label>
                <input id="author" name="author" value="{{ old('author') }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Autor">
                @error('author')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>

            <!-- Editorial -->
            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="editorial">Editorial</label>
                <input type="text" id="editorial" name="editorial" value="{{ old('editorial') }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Editorial">
                @error('editorial')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>

            <!-- Cantidad de libros -->
            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="amount">Cantidad de libros</label>
                <input type="number" id="amount" name="amount" value="{{ old('amount') }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Cantidad">
                @error('amount')
                    <p class=" text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>
        </div>

        <!-- Columna 2 -->
        <div class="sm:pl-10  pt-7">
            <div class="mb-3 col-span-6 sm:col-span-3">
                <label class="block text-sm font-bold text-gray-700 mb-2">Categoría:</label>
                <select id="category" name="category" value="{{ old('category') }}" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                    <option selected disabled value="">Seleccione una categoría</option>
                    <option value="libro" {{ old('category') == 'libro' ? 'selected' : '' }}>Libro</option>
                    <option value="tornos" {{ old('category') == 'tornos' ? 'selected' : '' }}>Tornos</option>
                    <option value="cartilla" {{ old('category') == 'cartilla' ? 'selected' : '' }}>Cartilla</option>
                    <option value="afiche" {{ old('category') == 'afiche' ? 'selected' : '' }}>Afiche</option>
                    <option value="folleto" {{ old('category') == 'folleto' ? 'selected' : '' }}>Folleto</option>
                    <option value="texto" {{ old('category') == 'texto' ? 'selected' : '' }}>Texto</option>
                </select>

                @error('category')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>

            <!-- Area -->
            <div class="mb-3 col-span-6 sm:col-span-3">
                <label for="area" class="block text-sm font-bold text-gray-700 mb-2">Área:</label>
                <select id="area" name="area" value="{{ old('area') }}" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                    <option selected disabled value="">Seleccione un área</option>
                    <option value="arte" {{ old('area') == 'arte' ? 'selected' : '' }}>Arte</option>
                    <option value="Atlasuniversal" {{ old('area') == 'Atlasuniversal' ? 'selected' : '' }}>Atlas universal</option>
                    <option value="Aprendizaje" {{ old('area') == 'Aprendizaje' ? 'selected' : '' }}>Aprendizaje</option>
                    <option value="Biblias" {{ old('area') == 'Biblias' ? 'selected' : '' }}>Biblias</option>
                    <option value="ciencia" {{ old('area') == 'ciencia' ? 'selected' : '' }}>Ciencia</option>
                    <option value="sociales" {{ old('area') == 'sociales' ? 'selected' : '' }}>Ciencias sociales</option>
                    <option value="Cienciaspolíticaseconómicas" {{ old('area') == 'Cienciaspolíticaseconómicas' ? 'selected' : '' }}>Ciencias políticas y económicas</option>
                    <option value="Ciencianaturales" {{ old('area') == 'Ciencianaturales' ? 'selected' : '' }}>Ciencias Naturales</option>
                    <option value="CienciaComputer" {{ old('area') == 'CienciaComputer' ? 'selected' : '' }}>Ciencia de la Computación</option>
                    <option value="Cienciasalud" {{ old('area') == 'Cienciasalud' ? 'selected' : '' }}>Ciencias de la Salud</option>
                    <option value="Cienciasnaturalesbiología" {{ old('area') == 'Cienciasnaturalesbiología' ? 'selected' : '' }}>Ciencias naturales y biología</option>
                    <option value="Comportamientosalud" {{ old('area') == 'Comportamientosalud' ? 'selected' : '' }}>Comportamiento y salud</option>
                    <option value="Diccionariosinglés" {{ old('area') == 'Diccionariosinglés' ? 'selected' : '' }}>Diccionarios inglés</option>
                    <option value="Diccionariosespañol" {{ old('area') == 'Diccionariosespañol' ? 'selected' : '' }}>Diccionarios español</option>
                    <option value="Educacionsalud" {{ old('area') == 'Educacionsalud' ? 'selected' : '' }}>Educación en Salud</option>
                    <option value="EconomiaPolitica" {{ old('area') == 'EconomiaPolitica' ? 'selected' : '' }}>Economía Política</option>
                    <option value="ÉticaValores" {{ old('area') == 'ÉticaValores' ? 'selected' : '' }}>Ética y Valores</option>
                    <option value="Educación" {{ old('area') == 'Educación' ? 'selected' : '' }}>Educación</option>
                    <option value="Ecología" {{ old('area') == 'Ecología' ? 'selected' : '' }}>Ecología</option>
                    <option value="Energía" {{ old('area') == 'Energía' ? 'selected' : '' }}>Energía</option>
                    <option value="Fichasingles" {{ old('area') == 'Fichasingles' ? 'selected' : '' }}>Fichas de ingles</option>
                    <option value="Físicamatemática" {{ old('area') == 'Físicamatemática' ? 'selected' : '' }}>Física matemática</option>
                    <option value="historia" {{ old('area') == 'historia' ? 'selected' : '' }}>Historia</option>
                    <option value="Ingles" {{ old('area') == 'Ingles' ? 'selected' : '' }}>Ingles</option>
                    <option value="informacion" {{ old('area') == 'informacion' ? 'selected' : '' }}>Información</option>
                    <option value="Informaciongeneral" {{ old('area') == 'Informaciongeneral' ? 'selected' : '' }}>Información General</option>
                    <option value="literatura" {{ old('area') == 'literatura' ? 'selected' : '' }}>Literatura</option>
                    <option value="lenguas" {{ old('area') == 'lenguas' ? 'selected' : '' }}>Lenguas</option>
                    <option value="Liderazgo" {{ old('area') == 'Liderazgo' ? 'selected' : '' }}>Liderazgo</option>
                    <option value="Literaturamoderna" {{ old('area') == 'Literaturamoderna' ? 'selected' : '' }}>Literatura moderna</option>
                    <option value="Literaturaantigua" {{ old('area') == 'Literaturaantigua' ? 'selected' : '' }}>Literatura antigua</option>
                    <option value="Literaturainfantil" {{ old('area') == 'Literaturainfantil' ? 'selected' : '' }}>Literatura infantil</option> 
                    <option value="Matemáticas" {{ old('area') == 'Matemáticas' ? 'selected' : '' }}>Matemáticas</option>
                    <option value="medioambiente" {{ old('area') == 'medioambiente' ? 'selected' : '' }}>Medio ambiente</option>
                    <option value="psicologia" {{ old('area') == 'psicologia' ? 'selected' : '' }}>Psicología</option>
                    <option value="politica" {{ old('area') == 'politica' ? 'selected' : '' }}>Política</option>
                    <option value="Química" {{ old('area') == 'Química' ? 'selected' : '' }}>Química</option>
                    <option value="religion" {{ old('area') == 'religion' ? 'selected' : '' }}>Religión</option>     
                    
                </select>
                @error('area')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>

            <!-- Estado del libro -->
            <div class="mb-3 col-span-6 sm:col-span-3">
                <label for="status" class="block text-sm font-bold text-gray-700 mb-2">Estado del libro:</label>
                <select id="status" name="status" value="{{ old('status') }}" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                    <option selected disabled value="">Seleccione su Estado</option>
                    <option value="well" {{ old('status') == 'well' ? 'selected' : '' }}>Bueno</option>
                    <option value="regular" {{ old('status') == 'regular' ? 'selected' : '' }}>Regular</option>
                    <option value="bad" {{ old('status') == 'bad' ? 'selected' : '' }}>Malo</option>
                </select>
                @error('status')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>

            <!-- Clasificacion del libro -->
            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="classification mb-2">Clasificación del libro</label>
                <input type="text" id="classification" name="classification" value="{{ old('classification') }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Clasificación">
                @error('classification')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>

            <!-- Año de la donación del libro -->
            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="year">Año de la donación del libro</label>
                <input type="number" id="year" name="year" value="{{ old('year') }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Año de donación" min="2010" max="{{ date('Y') }}">
                @error('year')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Ingrese un año válido</span></p>
                @enderror
            </div>

            <!-- Imagen del libro -->
            <div class="">
                <label class="block text-gray-700 text-sm font-bold" for="image">Imagen del libro</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>

        </div>

        <!-- Botón de envío -->
        <div class="flex justify-center ">
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Añadir a la tabla de Donaciones
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

@endsection
