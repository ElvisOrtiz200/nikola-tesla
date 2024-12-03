@extends('horario.index')

@section('subcontent')

<div class="container mx-auto mt-8">
    <!-- Verificamos si hay horarios disponibles -->
    @if(isset($horarios) && $horarios->isEmpty()) <!-- Si no hay horarios -->
        <div class="text-center text-red-500 font-semibold mb-4">
            No hay horarios registrados para este grado.
        </div>
    @elseif(isset($horarios) && $horarios->isNotEmpty())
        <h2 class="text-3xl font-semibold mb-6 text-center">Horario del Grado: {{ $horarios->first()->grado ?? 'Sin datos' }}</h2>

        @if (isset($mensaje))
            <div class="text-center text-red-500 font-semibold mb-4">
                {{ $mensaje }}
            </div>
        @else
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full table-auto text-left">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-lg font-semibold text-gray-600">Hora</th>
                            @foreach($dias as $dia)
                                <th class="px-6 py-4 text-lg font-semibold text-gray-600">{{ $dia->nombreDia }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($horas as $hora) <!-- Generamos las horas dinámicamente -->
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-6 py-4 text-gray-700">{{ $hora->nombreHora }}</td>

                                <!-- Llenamos las celdas de acuerdo a los días -->
                                @foreach($dias as $dia)
                                    <td class="px-6 py-4 text-gray-700">
                                        @php
                                            // Buscamos el curso correspondiente al día y hora
                                            $curso = $horarios->firstWhere(function ($horario) use ($hora, $dia) {
                                                return $horario->nombreHora == $hora->nombreHora && $horario->nombreDia == $dia->nombreDia;
                                            });
                                        @endphp

                                        @if ($curso)
                                            <span class="block text-gray-800">{{ $curso->acu_nombre }}</span>
                                        @else
                                            <span class="block text-gray-500">Sin curso</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @else
        <!-- Si no hay variable $horarios -->
        <div class="text-center text-red-500 font-semibold mb-4">
            No hay horarios registrados para este grado.
        </div>
    @endif
    
    <!-- Botón para regresar -->
    <div class="mt-4 text-center">
        <a href="{{ route('horario.listar') }}" class="text-blue-500 hover:underline">Regresar a la lista de grados</a>
    </div>
</div>
@endsection
    