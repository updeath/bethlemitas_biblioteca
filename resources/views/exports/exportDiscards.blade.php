<table>
    <thead>
        <tr>
            <th class="py-3 px-4">ISBN</th>
            <th class="py-3 px-4">Clasif-PGC</th>
            <th class="py-3 px-4">Título</th>
            <th class="py-3 px-4">Autor</th>
            <th class="py-3 px-4">Cantidad de libros descartados</th>
            <th class="py-3 px-4">Editorial</th>
            <th class="py-3 px-4">Fecha de publicación</th>
            <th class="py-3 px-4">Estado del libro(Motivo de descarte)</th>
            <th class="py-3 px-4">Actividad en la que se ocupa</th>
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
                <td class="py-3 px-4 border-gray-200" style="text-align: center">{{ $inventories->amount_descarted }}</td>
                <td class="py-3 px-3 border-gray-200" style="text-align: center">{{ $inventories->editorial->name_editorial }}</td>
                <td class="py-3 px-4 border-gray-200" style="text-align: center">{{ $inventories->publication_date }}</td>
                <td class="py-3 px-4 border-gray-200" style="text-align: center">{{ $inventories->estado_descarte->state }}</td>
                <td class="py-3 px-4 border-gray-200" style="text-align: center">{{ $inventories->actividad->activity_occupation }}</td>
            </tr>
        @endforeach
    </tbody>
</table>