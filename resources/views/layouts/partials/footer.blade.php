<footer class="w-full bg-[#14202A] text-white">
    <div class="max-w-screen-2xl mx-auto px-6 lg:px-12 py-14">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
            <!-- Brand -->
            <div class="lg:col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="NovaTM" class="w-10 h-10 object-contain">
                    <span class="text-xl font-bold text-white">NovaTM</span>
                </div>

                <p class="text-sm text-gray-300 leading-6 max-w-xs">
                    Plataforma de telemedicina veterinaria para consultas, historial clínico, recetas y atención de emergencia.
                </p>

                <div class="flex items-center gap-3 mt-6">
                    <a href="#" class="w-8 h-8 bg-cyan-500 hover:bg-cyan-600 text-white flex items-center justify-center rounded-sm transition">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="w-8 h-8 bg-cyan-500 hover:bg-cyan-600 text-white flex items-center justify-center rounded-sm transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-8 h-8 bg-cyan-500 hover:bg-cyan-600 text-white flex items-center justify-center rounded-sm transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-8 h-8 bg-cyan-500 hover:bg-cyan-600 text-white flex items-center justify-center rounded-sm transition">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            <!-- Navigation -->
            <div>
                <h3 class="text-lg font-bold mb-4">Navigation</h3>
                <div class="w-10 h-[3px] bg-orange-400 mb-5"></div>
                <ul class="space-y-3 text-sm text-gray-300">
                    <li><a href="#" class="hover:text-white transition">Mi Ganado</a></li>
                    <li><a href="#" class="hover:text-white transition">Consultas</a></li>
                    <li><a href="#" class="hover:text-white transition">Historial</a></li>
                    <li><a href="#" class="hover:text-white transition">Recetas</a></li>
                </ul>
            </div>

            <!-- Extras -->
            <div>
                <h3 class="text-lg font-bold mb-4">Extras</h3>
                <div class="w-10 h-[3px] bg-orange-400 mb-5"></div>
                <ul class="space-y-3 text-sm text-gray-300">
                    <li><a href="#" class="hover:text-white transition">Especialistas</a></li>
                    <li><a href="#" class="hover:text-white transition">Citas</a></li>
                    <li><a href="#" class="hover:text-white transition">Emergencias</a></li>
                    <li><a href="#" class="hover:text-white transition">Mensajes</a></li>
                </ul>
            </div>

            <!-- Information -->
            <div>
                <h3 class="text-lg font-bold mb-4">Information</h3>
                <div class="w-10 h-[3px] bg-orange-400 mb-5"></div>
                <ul class="space-y-3 text-sm text-gray-300">
                    <li><a href="#" class="hover:text-white transition">Certificados</a></li>
                    <li><a href="#" class="hover:text-white transition">Privacidad</a></li>
                    <li><a href="#" class="hover:text-white transition">Términos y condiciones</a></li>
                    <li><a href="#" class="hover:text-white transition">Contacto</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-lg font-bold mb-4">Get in Touch</h3>
                <div class="w-10 h-[3px] bg-orange-400 mb-5"></div>

                <ul class="space-y-4 text-sm text-gray-300">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt mt-1 text-white"></i>
                        <span>Av. Principal 123, Ciudad, País</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-phone-alt mt-1 text-white"></i>
                        <span>+1 (234) 567 89 00</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-envelope mt-1 text-white"></i>
                        <span>nova.tm@email.com</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-clock mt-1 text-white"></i>
                        <span>Lun - Sáb: 8 am - 6 pm</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-12 border-t border-white/15 pt-6 text-center text-sm text-gray-400">
            © {{ date('Y') }} NovaTM. Todos los derechos reservados.
        </div>
    </div>
</footer>