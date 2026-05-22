<nav class="w-full bg-white border-b border-gray-200 shadow-sm">
    <div class="w-full px-4 lg:px-8">
        <div class="flex items-center justify-between py-4">

            <!-- Left side: Logo + User (si está autenticado) -->
            <div class="flex items-center gap-3 min-w-[220px]">
                <a href="{{ route('home') }}" style="text-decoration: none; display: flex; align-items: center; gap: 12px; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                    <img src="{{ asset('images/logoNovaTM.png') }}" alt="NovaTM" class="w-14 h-14 object-contain">
                    <div>
                        <span class="text-2xl font-bold tracking-tight block" style="color: #14202A; line-height: 1.2;">
                            NovaTM
                        </span>
                        <span class="text-xs text-gray-500" style="letter-spacing: 0.5px;">Telemedicina</span>
                    </div>
                </a>
                
                <!-- Nombre del User autenticado -->
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
                @auth
                    <a href="{{ route('productor.animales') }}" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                        Mi Ganado <i class='fas fa-paw'></i>
                    </a>

                    @if(auth()->user()->isProfesional())
                        <!-- Para veterinarios y especialistas -->
                        <a href="{{ route('profesional.consultas') }}" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                            Consultas <i class="fa-solid fa-stethoscope"></i>
                        </a>
                    @else
                        <!-- Para productores -->
                        <a href="{{ route('profesionales.buscar') }}" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                            Consultas <i class="fa-solid fa-stethoscope"></i>
                        </a>
                    @endif

                    <a href="{{ route('profesional.historiales') }}" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                        Historial <i class='far fa-clipboard'></i>
                    </a>

                    @if(auth()->user()->isProfesional())
                        <a href="{{ route('profesional.recetas') }}" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                            Recetas <i class="fa-solid fa-pills"></i>
                        </a>
                    @else
                        <a href="{{ route('productor.recetas') }}" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                            Recetas <i class="fa-solid fa-pills"></i>
                        </a>
                    @endif

                    <a href="{{ route('productor.mensajes') }}" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                        Mensajes <i class='far fa-comment'></i>
                    </a>

                    <a href="{{ route('dashboard') }}" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                        Perfil <i class='fas fa-user-alt'></i>
                    </a>

                    <a href="#footer" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                        Ayuda <i class="fa-solid fa-question"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                        Perfil <i class='fas fa-user-alt'></i>
                    </a>
                    <a href="#footer" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                        Ayuda <i class="fa-solid fa-question"></i>
                    </a>
                @endauth
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