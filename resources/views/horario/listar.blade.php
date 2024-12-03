@extends('horario.index')


@section('subcontent')
<div class="container mx-auto mt-4">
    <h2 class="text-2xl font-semibold mb-4">Lista de Grados Académicos</h2>
    <table class="min-w-full bg-white">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2">Grado Académico</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grados as $grado)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $grado->nombre }}</td>
                    <td class="px-4 py-2">
                        <!-- Botón para expandir -->
                        <a href="{{ route('horario.showHorario', $grado->id_grado) }}" class="text-blue-500 hover:underline">Ver Horario</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
