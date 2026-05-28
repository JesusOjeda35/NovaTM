<footer id="footer" class="w-full bg-[#14202A] text-white">
    <div class="max-w-screen-2xl mx-auto px-6 lg:px-12 py-14">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

            {{-- Marca --}}
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <img 
                        src="{{ asset('images/logoNovaTM.png') }}" 
                        alt="NovaTM" 
                        class="w-14 h-14 object-contain rounded-full"
                    >
                    <span class="text-xl font-bold text-white">NovaTM</span>
                </div>

                <p class="text-sm text-gray-300 leading-6 max-w-xs">
                    Plataforma de telemedicina veterinaria para ganado bovino, consultas, historial clínico, recetas y atención de emergencias.
                </p>

                <div class="flex items-center gap-4 mt-6">
                    <a href="#" class="w-11 h-11 rounded-full flex items-center justify-center bg-yellow-400 text-[#14202A] hover:bg-yellow-500 transition">
                        <i class="fab fa-facebook-f text-lg"></i>
                    </a>

                    <a href="#" class="w-11 h-11 rounded-full flex items-center justify-center bg-yellow-400 text-[#14202A] hover:bg-yellow-500 transition">
                        <i class="fab fa-instagram text-lg"></i>
                    </a>

                    <a href="#" class="w-11 h-11 rounded-full flex items-center justify-center bg-yellow-400 text-[#14202A] hover:bg-yellow-500 transition">
                        <i class="fab fa-whatsapp text-lg"></i>
                    </a>
                </div>
            </div>

            {{-- Navegación principal --}}
            <div>
                <h3 class="text-lg font-bold mb-4">Navegación</h3>
                <div class="w-10 h-[3px] mb-5 bg-yellow-400"></div>

                <ul class="space-y-3 text-sm text-gray-300">
                    <li>
                        <a href="{{ route('dashboard') }}" class="hover:text-yellow-400 transition">
                            Inicio
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('productor.animales') }}" class="hover:text-yellow-400 transition">
                            Mi Ganado
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('productor.consultas') }}" class="hover:text-yellow-400 transition">
                            Mis Consultas
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('historial.index') }}" class="hover:text-yellow-400 transition">
                            Historial Clínico
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('productor.recetas') }}" class="hover:text-yellow-400 transition">
                            Recetas Médicas
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Servicios --}}
            <div>
                <h3 class="text-lg font-bold mb-4">Servicios</h3>
                <div class="w-10 h-[3px] mb-5 bg-yellow-400"></div>

                <ul class="space-y-3 text-sm text-gray-300">
                    <li>
                        <a href="{{ route('profesionales.buscar') }}" class="hover:text-yellow-400 transition">
                            Buscar Especialistas
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('productor.mensajes') }}" class="hover:text-yellow-400 transition">
                            Mensajes
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('emergencia.publica') }}" class="hover:text-yellow-400 transition">
                            Emergencia
                        </a>
                    </li>

                    @auth
                        @if(auth()->user()->isProfesional())
                            <li>
                                <a href="{{ route('profesional.consultas') }}" class="hover:text-yellow-400 transition">
                                    Consultas del Profesional
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('profesional.recetas') }}" class="hover:text-yellow-400 transition">
                                    Recetas del Profesional
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>

            {{-- Contacto --}}
            <div>
                <h3 class="text-lg font-bold mb-4">Contacto</h3>
                <div class="w-10 h-[3px] mb-5 bg-yellow-400"></div>

                <ul class="space-y-4 text-sm text-gray-300">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt mt-1 text-yellow-400"></i>
                        <span>Colombia</span>
                    </li>

                    <li class="flex items-start gap-3">
                        <i class="fas fa-envelope mt-1 text-yellow-400"></i>
                        <span>nova.tm@email.com</span>
                    </li>

                    <li class="flex items-start gap-3">
                        <i class="fas fa-clock mt-1 text-yellow-400"></i>
                        <span>Atención virtual para productores y profesionales veterinarios</span>
                    </li>

                    <li class="flex items-start gap-3">
                        <i class="fas fa-shield-alt mt-1 text-yellow-400"></i>
                        <span>NovaTM Telemedicina Veterinaria</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-12 border-t border-white/15 pt-6 text-center text-sm text-gray-400">
            © {{ date('Y') }} NovaTM. Todos los derechos reservados.
        </div>
    </div>
</footer>