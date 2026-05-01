<nav class="w-full bg-white border-b border-gray-200 shadow-sm">
    <div class="w-full px-4 lg:px-8">
        <div class="flex items-center justify-between py-4">

            <!-- Left side: Logo + Usuario (si está autenticado) -->
            <div class="flex items-center gap-3 min-w-[220px]">
                <img src="{{ asset('images/logoNovaTM.png') }}" alt="NovaTM" class="w-14 h-14 object-contain">
                <div>
                    <span class="text-2xl font-bold tracking-tight block" style="color: #14202A; line-height: 1.2;">
                        NovaTM
                    </span>
                    <span class="text-xs text-gray-500" style="letter-spacing: 0.5px;">Telemedicina</span>
                </div>
                
                <!-- Nombre del usuario autenticado -->
                @auth
                    <div class="ml-6 pl-6 border-l-2 border-gray-300">
                        <span class="text-sm font-semibold" style="color: #14202A;">
                            {{ explode(' ', auth()->user()->nombre_completo)[0] }} 
                            {{ explode(' ', auth()->user()->nombre_completo)[1] ?? '' }}
                        </span>
                        <p class="text-xs text-gray-500">
                            @if(auth()->user()->rol === 'productor')
                                Productor
                            @elseif(auth()->user()->rol === 'veterinario')
                                Veterinario
                            @elseif(auth()->user()->rol === 'especialista')
                                Especialista
                            @endif
                        </p>
                    </div>
                @endauth
            </div>

            <!-- Center navigation -->
            <div class="hidden xl:flex items-center gap-6 text-sm font-semibold" style="color: #14202A;">
                <a href="{{ url('/') }}" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                    Mi Ganado <i class='fas fa-paw'></i>
                </a>
                <a href="#" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                    Consultas <i class="fa-solid fa-stethoscope"></i>
                </a>
                <a href="#" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                    Historial <i class='far fa-clipboard'></i>
                </a>
                <a href="#" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                    Recetas <i class="fa-solid fa-pills"></i>
                </a>
                <a href="#" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                    Mensajes <i class='far fa-comment'></i>
                </a>
                
                @auth
                    <a href="#" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                        Perfil <i class='fas fa-user-alt'></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                        Perfil <i class='fas fa-user-alt'></i>
                    </a>
                @endauth
                
                <a href="#footer" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                    Ayuda <i class="fa-solid fa-question"></i>
                </a>
            </div>

            <!-- Right side: Emergency + Logout (si está autenticado) -->
            <div class="flex items-center gap-3">
                @auth
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="text-sm font-semibold transition duration-300 px-3 py-2 rounded" style="color: #14202A;" onmouseover="this.style.color='#facc15'; this.style.backgroundColor='#f0f0f0'" onmouseout="this.style.color='#14202A'; this.style.backgroundColor='transparent'">
                            <i class='fas fa-sign-out-alt'></i> Salir
                        </button>
                    </form>
                @endauth
                
                <a href="#" class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold px-5 py-3 rounded-md transition">
                    <i class="fa fa-ambulance" aria-hidden="true"></i> Atención de emergencia
                </a>
            </div>
        </div>
    </div>
</nav>