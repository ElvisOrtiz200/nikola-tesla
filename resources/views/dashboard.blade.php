<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

     <title>Panel de Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<!-- component -->
<div class="w-full h-full">
    <dh-component>
        <div class="flex flex-no-wrap">
            <!-- Sidebar starts -->
            <!-- Remove class [ hidden ] and replace [ sm:flex ] with [ flex ] -->
            <!--- more free and premium Tailwind CSS components at https://tailwinduikit.com/ --->
            <div style="min-height: 716px" class="w-64 absolute sm:relative bg-gray-800 shadow md:h-full flex-col justify-between hidden sm:flex">
                <div class="px-8">
                    <div class="h-16 w-full flex items-center">
                        <img viewBox="0 0 54 40" class="h-12 mr-2" fill="none" src="/img/logo_tesla.png" alt="Logo Escuela" />
                        <span class="text-surface-900 dark:text-surface-0 font-medium text-lg leading-normal text-white">NIKOLA TESLA</span>
                    </div>

                    @if ($idrol === 11)
                    <!-- Contenedor de botones con efecto de deslizamiento -->
                        <!-- Botón 1 (Roles) -->
                        <li class="flex w-full justify-between text-gray-300 hover:text-yellow-400 cursor-pointer items-center mb-6 mt-11">
                            <a href="{{route('docentesCursosVistas.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-6">Mis cursos</span>
                            </a>
                        </li>   
                        
                    @endif



                    @if ($idrol === 17)
                    <!-- Contenedor de botones con efecto de deslizamiento -->
                        <!-- Botón 1 (Roles) -->
                        <li class="flex w-full justify-between text-gray-300 hover:text-yellow-400 cursor-pointer items-center mb-6 mt-11">
                            <a href="{{route('estudiantesCursosVistas.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-6">Mis cursos</span>
                            </a>
                        </li>   
                        
                        <li class="flex w-full justify-between text-gray-300 hover:text-yellow-400 cursor-pointer items-center mb-6 mt-11">
                            <a href="{{route('estudiantesHorarioVistas.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-6">Horario</span>
                            </a>
                        </li>   
                    @endif

                    @if ($idrol === 14)

                    <button id="toggleButton" class="bg-gray-600 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded mb-4 flex items-center">
                        <span><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/1A1A1A/groups.png" alt="groups"/></span>
                        <span>Gestión de Usuarios</span>
                        <svg id="arrowIcon" xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5 transition-transform transform rotate-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.292 7.707a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                
                    <!-- Contenedor de botones con efecto de deslizamiento -->
                    <ul id="buttonList" class="hidden transition-all duration-300 ease-in-out overflow-hidden max-h-0">
                        <!-- Botón 1 (Roles) -->
                        <li class="flex w-full justify-between text-gray-300 hover:text-yellow-400 cursor-pointer items-center mb-6">
                            <a href="{{ route('rol.index') }}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-6">Roles</span>
                            </a>
                        </li>
                
                        <!-- Botón 2 (Usuarios) -->
                        <li class=" flex w-full justify-between text-gray-400 hover:text-yellow-400 cursor-pointer items-center mb-6 ">
                            <a href="{{ route('usuario.index') }}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>

                                <span class="text-sm ml-6">Usuarios</span>
                            </a>
                        </li>
                    </ul>

                    @endif

                    @if ($idrol === 14)

                    <button id="toggleButton2" class="bg-gray-600 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded mb-4 flex items-center">
                        <span><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/1A1A1A/groups.png" alt="groups"/></span>
                        <span>Gestión Académica</span>
                        <svg id="arrowIcon2" xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5 transition-transform transform rotate-0" viewBox="0 0 20 20" fill="currentColor2">
                            <path fill-rule="evenodd" d="M5.292 7.707a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                
                    <!-- Contenedor de botones con efecto de deslizamiento -->
                    <ul id="buttonList2" class="hidden transition-all duration-300 ease-in-out overflow-hidden max-h-0">
                        <!-- Botón 1 (Roles) -->

                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('estudiante-curso.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Asignar estudiantes a grado</span>
                            </a>
                        </li>
                        
                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('curso-docente.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Asignar docentes a cursos</span>
                            </a>
                        </li>
                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('curso.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Cursos</span>
                            </a>
                        </li>
                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('bimestre.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Bimestres</span>
                            </a>
                        </li>
                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('nivel.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Nivel Educativo</span>
                            </a>
                        </li>
                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('grado.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Grado Educativo</span>
                            </a>
                        </li>
                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('aula.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Aula Educativo</span>
                            </a>
                        </li>

                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('horario.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Horarios</span>
                            </a>
                        </li>
                       
                     

                    </ul>

                    @endif





                    @if ($idrol === 14)

                    <button id="toggleButton3" class="bg-gray-600 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded mb-4 flex items-center">
                        <span><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/1A1A1A/groups.png" alt="groups"/></span>
                        <span>Gestión de Personal</span>
                        <svg id="arrowIcon3" xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5 transition-transform transform rotate-0" viewBox="0 0 20 20" fill="currentColor2">
                            <path fill-rule="evenodd" d="M5.292 7.707a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                
                    <!-- Contenedor de botones con efecto de deslizamiento -->
                    <ul id="buttonList3" class="hidden transition-all duration-300 ease-in-out overflow-hidden max-h-0">
                        <!-- Botón 1 (Roles) -->
                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('recursoshh.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Recursos Humanos</span>
                            </a>
                        </li>
                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('docente.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Docentes</span>
                            </a>
                        </li>
                        
                    </ul>
                    @endif



                    @if ($idrol === 14)

                    <button id="toggleButton4" class="bg-gray-600 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded mb-4 flex items-center">
                        <span><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/1A1A1A/groups.png" alt="groups"/></span>
                        <span>Gestión de Estudiantes</span>
                        <svg id="arrowIcon4" xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5 transition-transform transform rotate-0" viewBox="0 0 20 20" fill="currentColor4">
                            <path fill-rule="evenodd" d="M5.292 7.707a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                
                    <!-- Contenedor de botones con efecto de deslizamiento -->
                    <ul id="buttonList4" class="hidden transition-all duration-300 ease-in-out overflow-hidden max-h-0">
                        <!-- Botón 1 (Roles) -->
                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('estudiante.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Estudiantes</span>
                            </a>
                        </li>
                       
                        
                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('apoderado.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white" >
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Apoderados</span>
                            </a>
                        </li>
                        
                    </ul>


                    @endif






                   

                </div>

            </div>

            <button aria-label="toggle sidebar" id="openSideBar" class="md:hidden h-10 w-10 bg-gray-800 fixed left-0 mt-16 mr-2 flex items-center shadow rounded-tr rounded-br justify-center cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 rounded focus:ring-gray-800" onclick="sidebarHandler(true)">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-adjustments" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <circle cx="6" cy="10" r="2" />
                    <line x1="6" y1="4" x2="6" y2="8" />
                    <line x1="6" y1="12" x2="6" y2="20" />
                    <circle cx="12" cy="16" r="2" />
                    <line x1="12" y1="4" x2="12" y2="14" />
                    <line x1="12" y1="18" x2="12" y2="20" />
                    <circle cx="18" cy="7" r="2" />
                    <line x1="18" y1="4" x2="18" y2="5" />
                    <line x1="18" y1="9" x2="18" y2="20" />
                </svg>
            </button>
            
            <div class="w-64 hidden z-40 absolute bg-gray-800 shadow md:h-full flex-col justify-between sm:hidden transition duration-150 ease-in-out" id="mobile-nav" >
                
                <button aria-label="Close sidebar" id="closeSideBar" class=" h-10 w-10 bg-gray-800 absolute right-0 mt-16 -mr-10 flex items-center shadow rounded-tr rounded-br justify-center cursor-pointer text-white" onclick="sidebarHandler(false)">
                    <svg  xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
                <div class="px-8">
                    <div class="h-16 w-full flex items-center">
                        <img viewBox="0 0 54 40" class="h-12 mr-2" fill="none" src="/img/logo_tesla.png" alt="Logo Escuela" />
                        <span class="text-surface-900 dark:text-surface-0 font-medium text-lg leading-normal text-white">NIKOLA TESLA</span>
                    </div>



                    @if ($idrol === 14)

                    <button id="toggleButton5" class="bg-gray-600 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded mb-4 flex items-center">
                        <span><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/1A1A1A/groups.png" alt="groups"/></span>
                        <span>Gestión de Usuarios</span>
                        <svg id="arrowIcon5" xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5 transition-transform transform rotate-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.292 7.707a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                
                    <!-- Contenedor de botones con efecto de deslizamiento -->
                    <ul id="buttonList5" class="hidden transition-all duration-300 ease-in-out overflow-hidden max-h-0">
                        <!-- Botón 1 (Roles) -->
                        <li class="flex w-full justify-between text-gray-300 hover:text-yellow-400 cursor-pointer items-center mb-6">
                            <a href="{{ route('rol.index') }}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-6">Roles</span>
                            </a>
                        </li>
                
                        <!-- Botón 2 (Usuarios) -->
                        <li class=" flex w-full justify-between text-gray-400 hover:text-yellow-400 cursor-pointer items-center mb-6 ">
                            <a href="{{ route('usuario.index') }}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>

                                <span class="text-sm ml-6">Usuarios</span>
                            </a>
                        </li>
                    </ul>



                    @endif


                    @if ($idrol === 14)

                    <button id="toggleButton6" class="bg-gray-600 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded mb-4 flex items-center">
                        <span><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/1A1A1A/groups.png" alt="groups"/></span>
                        <span>Gestión Académica</span>
                        <svg id="arrowIcon6" xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5 transition-transform transform rotate-0" viewBox="0 0 20 20" fill="currentColor2">
                            <path fill-rule="evenodd" d="M5.292 7.707a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                
                    <!-- Contenedor de botones con efecto de deslizamiento -->
                    <ul id="buttonList6" class="hidden transition-all duration-300 ease-in-out overflow-hidden max-h-0">
                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('curso-docente.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Asignar docentes a cursos</span>
                            </a>
                        </li>
                        <!-- Botón 1 (Roles) -->
                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('curso.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Cursos</span>
                            </a>
                        </li>
                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('bimestre.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Bimestres</span>
                            </a>
                        </li>
                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('nivel.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Nivel Educativo</span>
                            </a>
                        </li>
                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('grado.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Grado Educativo</span>
                            </a>
                        </li>
                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('aula.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Aula Educativo</span>
                            </a>
                        </li>
                       
                     

                    </ul>
                    @endif







                    @if ($idrol === 14)
                    <button id="toggleButton7" class="bg-gray-600 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded mb-4 flex items-center">
                        <span><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/1A1A1A/groups.png" alt="groups"/></span>
                        <span>Gestión de Personal</span>
                        <svg id="arrowIcon7" xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5 transition-transform transform rotate-0" viewBox="0 0 20 20" fill="currentColor2">
                            <path fill-rule="evenodd" d="M5.292 7.707a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                
                    <!-- Contenedor de botones con efecto de deslizamiento -->
                    <ul id="buttonList7" class="hidden transition-all duration-300 ease-in-out overflow-hidden max-h-0">
                        <!-- Botón 1 (Roles) -->
                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('recursoshh.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Recursos Humanos</span>
                            </a>
                        </li>
                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('docente.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Docentes</span>
                            </a>
                        </li>
                        
                    </ul>


                    @endif

                    @if ($idrol === 14)

                    <button id="toggleButton8" class="bg-gray-600 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded mb-4 flex items-center">
                        <span><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/1A1A1A/groups.png" alt="groups"/></span>
                        <span>Gestión de Estudiantes</span>
                        <svg id="arrowIcon8" xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5 transition-transform transform rotate-0" viewBox="0 0 20 20" fill="currentColor4">
                            <path fill-rule="evenodd" d="M5.292 7.707a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                
                    <!-- Contenedor de botones con efecto de deslizamiento -->
                    <ul id="buttonList8" class="hidden transition-all duration-300 ease-in-out overflow-hidden max-h-0">
                        <!-- Botón 1 (Roles) -->
                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('estudiante.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Estudiantes</span>
                            </a>
                        </li>
                       
                        
                        <li class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                            <a href="{{route('apoderado.index')}}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white" >
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-compass" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"></path>
                                    <polyline points="8 16 10 10 16 8 14 14 8 16"></polyline>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                                <span class="text-sm ml-2">Apoderados</span>
                            </a>
                        </li>
                        
                    </ul>

                    @endif                   
                    <div class="flex justify-center mt-48 mb-4 w-full">
                        <div class="relative">
                            <div class="text-gray-300 absolute ml-4 inset-0 m-auto w-4 h-4">

                            </div>

                        </div>
                    </div>
                </div>
                <div class="px-8 border-t border-gray-700">
                </div>
            </div>
            <!-- Sidebar ends -->
            <!-- Remove class [ h-64 ] when adding a card block -->

            <div class="container mx-auto pt-10 md:w-4/5 w-11/12 px-6">
                <nav x-data="{ isOpen: false }" class="relative bg-white shadow dark:bg-gray-800 ">
                    <div class="container px-6 py-4 mx-auto md:flex md:justify-between md:items-center">
                        <div class="flex items-center justify-between">
                            
                            <!-- Mobile menu button -->
                           
                        </div>
                        
                        <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
                        <div x-cloak :class="[isOpen ? 'translate-x-0 opacity-100 ' : 'opacity-0 -translate-x-full']" class="absolute inset-x-0 z-20 w-full px-6 py-1 transition-all duration-300 ease-in-out bg-white dark:bg-gray-800 md:mt-0 md:p-0 md:top-0 md:relative md:bg-transparent md:w-auto md:opacity-100 md:translate-x-0 md:flex md:items-center ">
                            <div class="flex flex-row mx-6 ">
                                
                                <form  action="{{ route('logout') }}" method="POST" class="mr-5">
                                    @csrf
                                    <button class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-lg transition duration-300 ease-in-out" type="submit">Cerrar Sesión</button>
                                </form>

                                <form id="myForm" action="{{ route('me') }}" method="POST">
                                    @csrf
                                    <button class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg transition duration-300 ease-in-out" type="submit">Mi perfil</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </nav>
                <div class="mt-10">
               @yield('content')
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Configura el input de fecha de inicio
                flatpickr("#datepicker-range-start", {
                    dateFormat: "Y-m-d",  // Día-Mes-Año
                    locale: "es",         // Idioma español
                    allowInput: true      // Para permitir escribir la fecha también
                });
        
                // Configura el input de fecha de fin
                flatpickr("#datepicker-range-end", {
                    dateFormat: "Y-m-d",  // Día-Mes-Año
                    locale: "es",         // Idioma español
                    allowInput: true      // Para permitir escribir la fecha también
                });

                flatpickr("#datepicker-individiual", {
                    dateFormat: "Y-m-d",  // Día-Mes-Año
                    locale: "es",         // Idioma español
                    allowInput: true      // Para permitir escribir la fecha también
                });
            });

            document.getElementById('openSideBar').addEventListener('click', function() {
            sidebarHandler(true);
});

document.getElementById('closeSideBar').addEventListener('click', function() {
    sidebarHandler(false);
});

        </script>

<script>
    const toggleButton = document.getElementById('toggleButton');
    const buttonList = document.getElementById('buttonList');
    const arrowIcon = document.getElementById('arrowIcon');
    toggleButton.addEventListener('click', () => {
        // Alternar visibilidad de los botones
        if (buttonList.classList.contains('hidden')) {
            buttonList.classList.remove('hidden');
            buttonList.classList.add('block');
            buttonList.style.maxHeight = buttonList.scrollHeight + 'px';  // Expandir lista
            arrowIcon.classList.add('rotate-180');  // Rotar la flecha hacia arriba
        } else {
            buttonList.style.maxHeight = '0px';  // Colapsar lista
            arrowIcon.classList.remove('rotate-180');  // Rotar la flecha hacia abajo
            setTimeout(() => {
                buttonList.classList.add('hidden');
            }, 300);  // Mantener efecto de animación antes de ocultar completamente
        }
    });
</script>

<script>
    const toggleButton2 = document.getElementById('toggleButton2');
    const buttonList2 = document.getElementById('buttonList2');
    const arrowIcon2 = document.getElementById('arrowIcon2');
    toggleButton2.addEventListener('click', () => {
        // Alternar visibilidad de los botones
        if (buttonList2.classList.contains('hidden')) {
            buttonList2.classList.remove('hidden');
            buttonList2.classList.add('block');
            buttonList2.style.maxHeight = buttonList2.scrollHeight + 'px';  // Expandir lista
            arrowIcon2.classList.add('rotate-180');  // Rotar la flecha hacia arriba
        } else {
            buttonList2.style.maxHeight = '0px';  // Colapsar lista
            arrowIcon2.classList.remove('rotate-180');  // Rotar la flecha hacia abajo
            setTimeout(() => {
                buttonList2.classList.add('hidden');
            }, 300);  // Mantener efecto de animación antes de ocultar completamente
        }
    });
</script>

    
<script>
    const toggleButton3 = document.getElementById('toggleButton3');
    const buttonList3 = document.getElementById('buttonList3');
    const arrowIcon3 = document.getElementById('arrowIcon3');
    toggleButton3.addEventListener('click', () => {
        // Alternar visibilidad de los botones
        if (buttonList3.classList.contains('hidden')) {
            buttonList3.classList.remove('hidden');
            buttonList3.classList.add('block');
            buttonList3.style.maxHeight = buttonList3.scrollHeight + 'px';  // Expandir lista
            arrowIcon3.classList.add('rotate-180');  // Rotar la flecha hacia arriba
        } else {
            buttonList3.style.maxHeight = '0px';  // Colapsar lista
            arrowIcon3.classList.remove('rotate-180');  // Rotar la flecha hacia abajo
            setTimeout(() => {
                buttonList3.classList.add('hidden');
            }, 300);  // Mantener efecto de animación antes de ocultar completamente
        }
    });
</script>

<script>
    const toggleButton5 = document.getElementById('toggleButton5');
    const buttonList5 = document.getElementById('buttonList5');
    const arrowIcon5 = document.getElementById('arrowIcon5');
    toggleButton5.addEventListener('click', () => {
        // Alternar visibilidad de los botones
        if (buttonList5.classList.contains('hidden')) {
            buttonList5.classList.remove('hidden');
            buttonList5.classList.add('block');
            buttonList5.style.maxHeight = buttonList5.scrollHeight + 'px';  // Expandir lista
            arrowIcon5.classList.add('rotate-180');  // Rotar la flecha hacia arriba
        } else {
            buttonList5.style.maxHeight = '0px';  // Colapsar lista
            arrowIcon5.classList.remove('rotate-180');  // Rotar la flecha hacia abajo
            setTimeout(() => {
                buttonList5.classList.add('hidden');
            }, 300);  // Mantener efecto de animación antes de ocultar completamente
        }
    });
</script>


<script>
    const toggleButton6 = document.getElementById('toggleButton6');
    const buttonList6 = document.getElementById('buttonList6');
    const arrowIcon6 = document.getElementById('arrowIcon6');
    toggleButton6.addEventListener('click', () => {
        // Alternar visibilidad de los botones
        if (buttonList6.classList.contains('hidden')) {
            buttonList6.classList.remove('hidden');
            buttonList6.classList.add('block');
            buttonList6.style.maxHeight = buttonList6.scrollHeight + 'px';  // Expandir lista
            arrowIcon6.classList.add('rotate-180');  // Rotar la flecha hacia arriba
        } else {
            buttonList6.style.maxHeight = '0px';  // Colapsar lista
            arrowIcon6.classList.remove('rotate-180');  // Rotar la flecha hacia abajo
            setTimeout(() => {
                buttonList6.classList.add('hidden');
            }, 300);  // Mantener efecto de animación antes de ocultar completamente
        }
    });
</script>


<script>
    const toggleButton7 = document.getElementById('toggleButton7');
    const buttonList7 = document.getElementById('buttonList7');
    const arrowIcon7 = document.getElementById('arrowIcon7');
    toggleButton7.addEventListener('click', () => {
        // Alternar visibilidad de los botones
        if (buttonList7.classList.contains('hidden')) {
            buttonList7.classList.remove('hidden');
            buttonList7.classList.add('block');
            buttonList7.style.maxHeight = buttonList7.scrollHeight + 'px';  // Expandir lista
            arrowIcon7.classList.add('rotate-180');  // Rotar la flecha hacia arriba
        } else {
            buttonList7.style.maxHeight = '0px';  // Colapsar lista
            arrowIcon7.classList.remove('rotate-180');  // Rotar la flecha hacia abajo
            setTimeout(() => {
                buttonList7.classList.add('hidden');
            }, 300);  // Mantener efecto de animación antes de ocultar completamente
        }
    });
</script>


<script>
    const toggleButton8 = document.getElementById('toggleButton8');
    const buttonList8 = document.getElementById('buttonList8');
    const arrowIcon8 = document.getElementById('arrowIcon8');
    toggleButton8.addEventListener('click', () => {
        // Alternar visibilidad de los botones
        if (buttonList8.classList.contains('hidden')) {
            buttonList8.classList.remove('hidden');
            buttonList8.classList.add('block');
            buttonList8.style.maxHeight = buttonList8.scrollHeight + 'px';  // Expandir lista
            arrowIcon8.classList.add('rotate-180');  // Rotar la flecha hacia arriba
        } else {
            buttonList8.style.maxHeight = '0px';  // Colapsar lista
            arrowIcon8.classList.remove('rotate-180');  // Rotar la flecha hacia abajo
            setTimeout(() => {
                buttonList8.classList.add('hidden');
            }, 300);  // Mantener efecto de animación antes de ocultar completamente
        }
    });
</script>

<script>
    function sidebarHandler(isOpen) {
    const sidebar = document.getElementById("mobile-nav");

    if (isOpen) {
        // Mostrar el sidebar
        sidebar.classList.remove("hidden");
    } else {
        // Ocultar el sidebar
        sidebar.classList.add("hidden");
    }
}
</script>


 
<script>
    const toggleButton4 = document.getElementById('toggleButton4');
    const buttonList4 = document.getElementById('buttonList4');
    const arrowIcon4 = document.getElementById('arrowIcon4');
    toggleButton4.addEventListener('click', () => {
        // Alternar visibilidad de los botones
        if (buttonList4.classList.contains('hidden')) {
            buttonList4.classList.remove('hidden');
            buttonList4.classList.add('block');
            buttonList4.style.maxHeight = buttonList4.scrollHeight + 'px';  // Expandir lista
            arrowIcon4.classList.add('rotate-180');  // Rotar la flecha hacia arriba
        } else {
            buttonList4.style.maxHeight = '0px';  // Colapsar lista
            arrowIcon4.classList.remove('rotate-180');  // Rotar la flecha hacia abajo
            setTimeout(() => {
                buttonList4.classList.add('hidden');
            }, 300);  // Mantener efecto de animación antes de ocultar completamente
        }
    });
</script>


    </dh-component>
</div>
</body>
</html>