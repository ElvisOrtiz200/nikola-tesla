@extends('dashboard')

@section('content')

<div class="w-auto h-[500px] md:h-[75%] lg:h-[75%] rounded border-dashed border-2 border-gray-300 overflow-auto">
    <header class="bg-white">
        <div class="mx-auto max-w-7xl px-2 sm:px-4 lg:divide-y lg:divide-teal-700 lg:px-8">
            <nav class="hidden lg:flex lg:space-x-8 lg:py-2" aria-label="Global">
                <!-- Listado de cursos dinámico -->
                @if($cursos->isEmpty())
                    <p class="text-gray-500">No hay cursos registrados para este estudiante.</p>
                @else
                    @foreach ($cursos as $curso)
                    <a href="{{ route('estudiantescursodetalle.show', $curso->acu_id) }}" 
                        class="text-cyan-500 bg-yellow-400 hover:bg-cyan-500 hover:text-yellow-400 inline-flex items-center rounded-md py-2 px-3 text-sm font-medium">
                         {{ $curso->acu_nombre }}
                     </a>
                    @endforeach
                @endif
            </nav>

            <div class="relative flex h-0 justify-between"></div>
        </div>

        <!-- Menú móvil -->
        <nav class="lg:hidden" aria-label="Global" id="mobile-menu">
            <div class="space-y-1 px-2 pb-3 pt-2">
                @if($cursos->isEmpty())
                    <p class="text-gray-500">No hay cursos registrados para este estudiante.</p>
                @else
                    @foreach ($cursos as $curso)
                        <a href="#" class="text-cyan-500 bg-yellow-400 hover:bg-cyan-500 hover:text-yellow-400 block rounded-md py-2 px-3 text-base font-medium">
                            {{ $curso->acu_nombre }}
                        </a>
                    @endforeach
                @endif
            </div>
        </nav>
    </header>

    <div class="px-5 py-5">
        <!-- Aquí colocamos el segundo yield para subcontenido -->
        @yield('subcontent')  
    </div>
</div>

@endsection
