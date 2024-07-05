@extends('layout.masterPage')

@section('content')

<section class="flex items-center justify-center bg-center bg-no-repeat bg-[url('{{ asset('img/library.jfif') }}')] bg-gray-600 bg-blend-multiply h-[80vh] overflow-hidden my-10">
    <div class="text-center ">
        <h1 class="text-white font-bold text-2xl">
            <em>Bienvenidos a la <span class="text-5xl text-[#3A8BC0]">Bliblioteca - Bethlemitas</span></em>
        </h1>
        <p id="typed-text" class="font-normal text-gray-100 px-[120px] p-5"></p>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var typed = new Typed('#typed-text', {
            strings: [
                "Esta aplicación está diseñada especialmente para una solución eficiente de recursos bibliográficos, facilitando la organización y acceso a la información de manera ágil y precisa"
            ],
            typeSpeed: 50,
            backSpeed: 15,
            backDelay: 2000,
            loop: true,
            
        });
    });
</script>
@endsection