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
    <div class="bg-white shadow-md rounded-lg my-[60px] p-5 flex w-3/4 items-center">
        <!-- Formulario en la parte izquierda -->
        <form class="w-full md:flex" action="{{ route('user.profileUpdate') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="w-full md:w-1/2 md:pr-4">
                <h1 class="text-2xl font-bold mb-4"><em>Ingresa los datos a modificar:</em></h1>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nombre">
                        <em>Nombre</em>
                    </label>
                        <input id="name" name="name" value="{{ auth()->user() ? auth()->user()->name : '' }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        type="text" placeholder="Nombre">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="apellido">
                        <em>Apellido</em>
                    </label>
                    <input id="last_name" name="last_name" value="{{ auth()->user() ? auth()->user()->last_name : '' }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        type="text" placeholder="Apellido">
                    @error('last_name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        <em>Correo electrónico</em>
                    </label>
                    <input id="email" name="email" value="{{ auth()->user() ? auth()->user()->email : '' }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        type="email" placeholder="Correo Electrónico">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        <em>Cambiar contraseña</em>
                    </label>

                    <input type="password" id="password" name="password"  value="{{ auth()->user() ? auth()->user()->password : '' }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="***********">
                        @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Incorrecto</span></p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="foto">
                        <em>Foto</em>
                    </label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        <em>Editar</em>
                    </button>
                </div>
            </div>


            <!-- Tarjeta en la parte derecha -->
            <div class="w-full md:w-1/2 p-3">
                <div class="text-center">
                    @if (auth()->user() ? auth()->user()->image : '')
                        <img name='image' id="image" src="{{ asset(auth()->user() ? auth()->user()->image : '') }}" alt="Foto del perfil"
                            class="rounded-full mx-auto mb-4">
                    @else
                        <img src="https://placekitten.com/200/200" alt="Foto de ejemplo" class="rounded-full mx-auto mb-4">
                    @endif
                </div>
                <div class="bg-gray-200 p-4 rounded">
                    <h2 class="text-xl font-bold mb-4"><em>Información Adicional</em></h2>
                    <em><p><b>Nombre Completo:  </b>{{auth()->user() ? auth()->user()->name : ''}} {{auth()->user() ? auth()->user()->last_name : ''}}</p></em>
                    
                    <em><p><b>email:  </b>{{auth()->user() ? auth()->user()->email : ''}}</p></em>
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
@endsection
