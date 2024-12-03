@extends('curso.index')


@section('subcontent')



<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Confirmar Eliminación</h1>

    <div class="bg-white p-6 rounded shadow">
        <p>¿Estás seguro de que deseas eliminar el curso <strong>{{ $curso->acu_nombre }}</strong>?</p>

        <div class="mt-4">
            <form action="{{ route('curso.destroy', $curso->acu_id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Eliminar</button>
                <a href="{{ route('curso.eliminar') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancelar</a>
            </form>
        </div>
    </div>
</div>


@endsection