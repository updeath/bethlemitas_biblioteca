@extends('layout.masterPage')

@section ('content')
    <div class="bg-white shadow-md rounded-lg my-8 flex w-[120vh] items-center" style="width: 50%" >
        <!-- Formulario en dos columnas -->
        
        <form class="grid grid-cols-1 md:grid-cols-2 gap-4" action="" method="POST" style="width: 100%; padding: 3rem 5rem 3rem 5rem">
            @method('PUT')
            @csrf
            <div>
                <h1 class="text-3xl font-semibold mb-6"><em>Añadir autor</em></h1>

                <!-- Titulo del libro -->
                <div class="mb-3" >
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Nombre de editorial</label>
                    <input id="name_editorial" name="name_editorial" value="{{ old('name_editorial') }}" class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Nombre de editorial">
                    @error('name_editorial')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">La editorial ya se encuentra registrada</span></p>
                    @enderror
                </div>
                <div class="flex items-center w-full">
                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Añadir Autor
                    </button>
                </div>
            </div>

            <div class="sm:pl-3 pt-7" >
                <p><em>Asegúrate de que el nombre de la editorial esté correctamente capitalizado, con la primera letra en mayúscula, y que no termine con un punto ni ningún otro carácter adicional.</em></p>
            </div>
            
        </form>
    </div>

    
@endsection