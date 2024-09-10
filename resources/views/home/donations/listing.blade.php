@extends ('layout.books')

@section('import-excel')
    <form action="{{ route('listing.donated') }}" method="GET" class="flex items-center mt-5">
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
@endsection

@section('table')
    <h1 class="text-3xl font-semibold mb-6">Tabla de libros donados</h1>
    <div class="overflow-x-auto">
        <table class="bg-white border border-gray-300 rounded-lg overflow-hidden" style="width: 105%">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4">ISBN</th>
                    <th class="py-3 px-4">Clasif PGC</th>
                    <th class="py-3 px-4">Título</th>
                    <th class="py-3 px-4">Autor</th>
                    <th class="py-3 px-4">Editorial</th>
                    <th class="py-3 px-4">Fecha de publicación</th>
                    <th class="py-3 px-4">Estado</th>
                    <th class="py-3 px-4">Ubicación</th>
                    <th class="py-3 px-4">Actividad en la que se ocupa</th>
                    <th class="py-3 px-4">Donado</th>
                </tr>
            </thead>
            <tbody style="text-align: left; vertical-align: middle;">
                @foreach ($inventory as $inventories)
                    <!-- Ejemplo de una fila -->
                    <tr class="transition-all hover:bg-gray-100">
                        <td class="py-3 px-4 border-gray-200" style="text-align: center">{{ $inventories->ISBN}}</td>
                        <td class="py-3 px-4 border-gray-200" style="text-align: center">{{ $inventories->classification->clasifPGC}}</td>
                        <td class="py-3 px-4 border-gray-200" style="text-align: center">{{ $inventories->title }}</td>
                        <td class="py-3 px-4 border-gray-200" style="text-align: center">{{ $inventories->author->name_author }}</td>
                        <td class="py-3 px-3 border-gray-200" style="text-align: center">{{ $inventories->editorial->name_editorial }}</td>
                        <td class="py-3 px-4 border-gray-200" style="text-align: center">{{ $inventories->publication_date }}</td>
                        <td class="py-3 px-4 border-gray-200" style="text-align: center">{{ $inventories->estado->state }}</td>
                        <td class="py-3 px-4 border-gray-200" style="text-align: center">{{ $inventories->ubicacion->location }}</td>
                        <td class="py-3 px-4 border-gray-200" style="text-align: center">{{ $inventories->actividad->activity_occupation }}</td>
                        <td class="py-3 px-4 border-gray-200" style="text-align: center">@if($inventories->amount_donated > 0) {{$inventories->amount_donated}} @elseif($inventories->donated == null || $inventories->donated <= 0 ) Ninguno @endif</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection