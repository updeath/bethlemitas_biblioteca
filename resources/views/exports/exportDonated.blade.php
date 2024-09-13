<table>
    <thead>
        <tr>
            <th class="py-3 px-4">ISBN</th>
            <th class="py-3 px-4">Clasif-PGC</th>
            <th class="py-3 px-4">Título</th>
            <th class="py-3 px-4">Autor</th>
            <th class="py-3 px-4">Editorial</th>
            <th class="py-3 px-4">Fecha de publicación</th>
            <th class="py-3 px-4">Estado del libro</th>
            <th class="py-3 px-4">Ubicación del libro</th>
            <th class="py-3 px-4">Actividad en la que se ocupa</th>
            <th class="py-3 px-4">Cantidad de libros donados</th>
        </tr>
    </thead>
    <tbody>
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