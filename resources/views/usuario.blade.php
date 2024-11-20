@extends('dashboard')

@section('content')

<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-4xl font-bold text-gray-800 mb-6">Mi Perfil</h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="flex flex-col md:flex-row">
            <!-- Sección de la izquierda (Icono y Nombre) -->
            <div class="bg-blue-600 w-full md:w-1/4 p-6 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 13.793A4 4 0 117.293 16h-.586a4 4 0 01-5.172-2.207L2 14.293l3.121-3.121zm1.414-1.414L12 2l5.465 10.379c.486.927.486 2.086 0 3.017l-5.465 5.465-5.465-5.465c-.927-.486-2.086-.486-3.017 0l-.121-.121z" />
                </svg>
            </div>

            <!-- Sección de la derecha (Detalles del perfil) -->
            <div class="w-full md:w-3/4 p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-semibold text-gray-800">Bienvenido, {{ $user->usu_login }}</h2>
                </div>
                <p class="text-gray-600 mt-2">Este es tu perfil personal donde puedes revisar tus datos de usuario.</p>

                <div class="mt-6">
                    <h3 class="text-xl font-semibold text-gray-700">Información Personal</h3>
                    <div class="mt-4 space-y-4">
                        <!-- Información del usuario -->
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.293 6.707a1 1 0 010 1.414l-4.586 4.586a1 1 0 01-1.414 0L7.707 9.707a1 1 0 111.414-1.414L12 10.172l3.293-3.293a1 1 0 011.414 0z" />
                            </svg>
                            <span class="text-gray-700 font-medium">Nombre de usuario:</span>
                            <span class="ml-2">{{ $user->usu_login }}</span>
                        </div>
                        
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12v4m0 0v4m0-4H8m8 0H8m0-4v4" />
                            </svg>
                            <span class="text-gray-700 font-medium">Correo electrónico:</span>
                            <span class="ml-2">{{ $user->correo }}</span>
                        </div>

                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12v4m0 0v4m0-4H8m8 0H8m0-4v4" />
                            </svg>
                            <span class="text-gray-700 font-medium">Rol:</span>
                            <span class="ml-2">{{ $user->nombre_rol }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
