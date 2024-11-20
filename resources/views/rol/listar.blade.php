@extends('rol.index')


@section('subcontent')
<form action="{{ route('rol.showListar') }}" method="GET" id="searchForm">
  <div class="flex items-center px-3.5 py-2 text-gray-400 group hover:ring-1 hover:ring-gray-300 focus-within:!ring-2 ring-inset focus-within:!ring-teal-500 rounded-md">
      <svg class="mr-2 h-5 w-5 stroke-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
      </svg>
      <input
          class="block w-full appearance-none bg-transparent text-base text-gray-700 placeholder:text-gray-400 focus:outline-none sm:text-sm sm:leading-6"
          placeholder="Buscar por nombre de rol"
          name="search"
          oninput="this.form.submit()"
          aria-label="Search components"
          value="{{ request()->query('search') }}"
          style="caret-color: rgb(107, 114, 128)"
      />
  </div>
</form>

<div class="flex flex-col">
    <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
      <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <table class="min-w-full">
            <thead class="bg-white border-b">
              <tr>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                  #
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                  Nombre del rol
                </th>
                
               
              </tr>
            </thead>
            <tbody>
              @if($roles->isEmpty())
            <tr>
                <td colspan="3" class="text-center text-gray-500">No hay coincidencias</td>
            </tr>
        @else
              @foreach ($roles as $rol)
              <tr class="bg-white border-b">
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $rol->idrol }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $rol->nombre_rol }}
                </td>
               
              </tr>
              @endforeach
              @endif
            </tbody>
          </table>
          <div class="mt-4">
            {{ $roles->links() }} <!-- Esto genera los enlaces de paginación -->
        </div>
        </div>
      </div>
    </div>
  </div>
  
@endsection