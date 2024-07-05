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
<div class="bg-white shadow-md rounded-lg px-8 my-8 flex w-[120vh] items-center">
    <!-- Formulario en dos columnas -->
    <form class="grid grid-cols-1 md:grid-cols-2 gap-4" action="{{ route('inventory.update', ['inventory' => $inventory->id]) }}" method="POST">
        @method('PUT')
        @csrf
        <!-- Columna 1 -->
        <div>
            <h1 class="text-2xl font-bold "><em>Editar Registro</em></h1>

            <!-- Codigo -->
            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="code">Código</label>
                <input id="code" name="code" value="{{ old('code', $inventory->code) }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Código">
                @error('code')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>

            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="clasifpgc">CLASIF PGC</label>
                <input placeholder="CLASIF PGC" min="99" id="clasifpgc" name="clasifpgc" value="{{ old('clasifpgc', $inventory->clasifpgc) }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number">
                @error('clasifpgc')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>

            <!-- Titulo del libro -->
            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Título del libro</label>
                <input id="title" name="title" value="{{ old('title', $inventory->title) }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Título">
                @error('title')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>


            <!-- Editorial -->
            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="editorial">Editorial</label>
                <input type="text" id="editorial" name="editorial" value="{{ old('editorial', $inventory->editorial ) }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Editorial">
                @error('editorial')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>

            <!-- Cantidad de libros -->
            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="amount">Cantidad</label>
                <input type="number" id="amount" name="amount" value="{{ old('amount', $inventory->amount) }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Cantidad">
                @error('amount')
                    <p class=" text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>
            <div class="mb-4 col-span-6 sm:col-span-3">
                <label class="block text-sm font-bold text-gray-700 mb-2">Categoría:</label>
                <select id="category" name="category" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                    <option selected disabled value="">Seleccione una categoría</option>
                    <option value="libro" {{ old('category', $inventory->category) == 'libro' ? 'selected' : '' }}>Libro</option>
                    <option value="tornos" {{ old('category', $inventory->category) == 'tornos' ? 'selected' : '' }}>Tornos</option>
                    <option value="cartilla" {{ old('category', $inventory->category) == 'cartilla' ? 'selected' : '' }}>Cartilla</option>
                    <option value="afiche" {{ old('category', $inventory->category) == 'afiche' ? 'selected' : '' }}>Afiche</option>
                    <option value="folleto" {{ old('category', $inventory->category) == 'folleto' ? 'selected' : '' }}>Folleto</option>
                    <option value="texto" {{ old('category', $inventory->category) == 'texto' ? 'selected' : '' }}>Texto</option>
                </select>

                @error('category')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>

            <!-- Botón de envío -->
            <div class="flex items-center w-full">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Editar Registro
                </button>
            </div>
        </div>
        <div>
            <div class="mb-4 col-span-6 sm:col-span-3">
                <!-- Autor del libro -->
                <div class="mb-3">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Autor del libro</label>
                    <input id="author" name="author" value="{{ old('author', $inventory->author) }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Título">
                    @error('author')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                    @enderror
                </div>

                <label for="area" class="block text-sm font-bold text-gray-700 mb-2">Área:</label>
                <select id="area" name="area" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                    <option selected disabled value="">Seleccione un área</option>
                    <option value="Arte" {{ old('area', $inventory->area) == 'arte' ? 'selected' : '' }}>Arte</option>
                    <option value="Aprendizaje" {{ old('area', $inventory->area) == 'Aprendizaje' ? 'selected' : '' }}>Aprendizaje</option>
                    <option value="Ciencia" {{ old('area', $inventory->area) == 'ciencia' ? 'selected' : '' }}>Ciencia</option>
                    <option value="Ciencias Sociales" {{ old('area', $inventory->area) == 'sociales' ? 'selected' : '' }}>Ciencias sociales</option>
                    <option value="Ciencias naturales" {{ old('area', $inventory->area) == 'Ciencianaturales' ? 'selected' : '' }}>Ciencias Naturales</option>
                    <option value="Ciencias de la computación" {{ old('area', $inventory->area) == 'CienciaComputer' ? 'selected' : '' }}>Ciencia de la Computación</option>
                    <option value="Ciencias de la salud" {{ old('area', $inventory->area) == 'Cienciasalud' ? 'selected' : '' }}>Ciencias de la Salud</option>
                    <option value="Educación en salud" {{ old('area', $inventory->area) == 'Educacionsalud' ? 'selected' : '' }}>Educación en Salud</option>
                    <option value="Economía Política" {{ old('area', $inventory->area) == 'EconomiaPolitica' ? 'selected' : '' }}>Economía Política</option>
                    <option value="Historia" {{ old('area', $inventory->area) == 'historia' ? 'selected' : '' }}>Historia</option>
                    <option value="Información" {{ old('area', $inventory->area) == 'informacion' ? 'selected' : '' }}>Información</option>
                    <option value="Información general" {{ old('area', $inventory->area) == 'Informaciongeneral' ? 'selected' : '' }}>Información General</option>
                    <option value="literatura" {{ old('area', $inventory->area) == 'literatura' ? 'selected' : '' }}>Literatura</option>
                    <option value="lenguas" {{ old('area', $inventory->area) == 'lenguas' ? 'selected' : '' }}>Lenguas</option>
                    <option value="Psicología" {{ old('area', $inventory->area) == 'psicologia' ? 'selected' : '' }}>Psicología</option>
                    <option value="Política" {{ old('area', $inventory->area) == 'politica' ? 'selected' : '' }}>Política</option>
                    <option value="Religion" {{ old('area', $inventory->area) == 'religion' ? 'selected' : '' }}>Religión</option>
                    <option value="Biblias" {{ old('area', $inventory->area) == 'Biblias' ? 'selected' : '' }}>Biblias</option>
                    <option value="Filosofía" {{ old('area', $inventory->area) == 'Filosofía' ? 'selected' : '' }}>Filosofía</option>
                    <option value="Ética y Valores" {{ old('area', $inventory->area) == 'ÉticaValores' ? 'selected' : '' }}>Ética y Valores</option>
                    <option value="Liderazgo" {{ old('area', $inventory->area) == 'Liderazgo' ? 'selected' : '' }}>Liderazgo</option>
                    <option value="Educación" {{ old('area', $inventory->area) == 'Educación' ? 'selected' : '' }}>Educación</option>
                    <option value="Cienciaspolíticas y económicas" {{ old('area', $inventory->area) == 'Cienciaspolíticaseconómicas' ? 'selected' : '' }}>Ciencias políticas y económicas</option>
                    <option value="Atlas universal" {{ old('area', $inventory->area) == 'Atlasuniversal' ? 'selected' : '' }}>Atlas universal</option>
                    <option value="Inglés" {{ old('area', $inventory->area) == 'Ingles' ? 'selected' : '' }}>Ingles</option>
                    <option value="Fichas de inglés" {{ old('area', $inventory->area) == 'Fichasingles' ? 'selected' : '' }}>Fichas de ingles</option>
                    <option value="Física matemática" {{ old('area', $inventory->area) == 'Físicamatemática' ? 'selected' : '' }}>Física matemática</option>
                    <option value="Matemáticas" {{ old('area', $inventory->area) == 'Matemáticas' ? 'selected' : '' }}>Matemáticas</option>
                    <option value="Diccionarios de español" {{ old('area', $inventory->area) == 'Diccionariosespañol' ? 'selected' : '' }}>Diccionarios español</option>
                    <option value="Diccionarios de inglés" {{ old('area', $inventory->area) == 'Diccionariosinglés' ? 'selected' : '' }}>Diccionarios inglés</option>
                    <option value="Química" {{ old('area', $inventory->area) == 'Química' ? 'selected' : '' }}>Química</option>
                    <option value="Ciencias naturales y biología" {{ old('area', $inventory->area) == 'Cienciasnaturalesbiología' ? 'selected' : '' }}>Ciencias naturales y biología</option>
                    <option value="Comportamiento y salud" {{ old('area', $inventory->area) == 'Comportamientosalud' ? 'selected' : '' }}>Comportamiento y salud</option>
                    <option value="Ecología" {{ old('area', $inventory->area) == 'Ecología' ? 'selected' : '' }}>Ecología</option>
                    <option value="Energía" {{ old('area', $inventory->area) == 'Energía' ? 'selected' : '' }}>Energía</option>
                    <option value="Medio ambiente" {{ old('area', $inventory->area) == 'medioambiente' ? 'selected' : '' }}>Medio ambiente</option>
                    <option value="Literatura moderna" {{ old('area', $inventory->area) == 'Literaturamoderna' ? 'selected' : '' }}>Literatura moderna</option>
                    <option value="Literatura antigua" {{ old('area', $inventory->area) == 'Literaturaantigua' ? 'selected' : '' }}>Literatura antigua</option>
                    <option value="Literatura infantil" {{ old('area', $inventory->area) == 'Literaturainfantil' ? 'selected' : '' }}>Literatura infantil</option>
                </select>
                @error('area')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>

            <!-- Estado del libro -->
            <div class="mb-4 col-span-6 sm:col-span-3">
                <label for="status" class="block text-sm font-bold text-gray-700 mb-2">Estado del libro:</label>
                <select id="status" name="status" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                    <option selected disabled value="">Seleccione su Estado</option>
                    <option value="well" {{ old('status', $inventory->status) == 'well' ? 'selected' : '' }}>Bueno</option>
                    <option value="regular" {{ old('status', $inventory->status) == 'regular' ? 'selected' : '' }}>Regular</option>
                    <option value="bad" {{ old('status', $inventory->status) == 'bad' ? 'selected' : '' }}>Malo</option>
                </select>
                @error('status')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>


            <div class="mb-3 col-span-6 sm:col-span-3">
                <label for="activite" class="block text-sm font-bold text-gray-700 mb-2">Proposito:</label>
                <select id="activite" name="activite" value="{{ old('activite') }}" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                    <option selected disabled value="">Seleccione su Actividad</option>
                    <option value="reference_material" {{ old('activite', $inventory->activite) == 'reference_material' ? 'selected' : '' }}>Material de referencia</option>
                    <option value="investigation" {{ old('activite', $inventory->activite) == 'investigation' ? 'selected' : '' }}>Investigación</option>
                    <option value="teaching" {{ old('activite', $inventory->activite) == 'teaching' ? 'selected' : '' }}>Enseñanza</option>
                    <option value="consultation" {{ old('activite', $inventory->activite) == 'consultation' ? 'selected' : '' }}>Consulta</option>
                    <option value="languagues" {{ old('activite', $inventory->activite) == 'languagues' ? 'selected' : '' }}>Idiomas</option>
                    <option value="reading" {{ old('activite', $inventory->activite) == 'reading' ? 'selected' : '' }}>Lectura</option>
                </select>
                @error('activite')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                @enderror
            </div>
            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="year">Editar año de donacion</label>
                <input type="number" id="year" name="year" value="{{ old('year', $inventory->year) }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Año de donación" min="2010" max="{{ date('Y') }}">
                @error('year')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Ingrese un año válido</span></p>
                @enderror
            </div>
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
