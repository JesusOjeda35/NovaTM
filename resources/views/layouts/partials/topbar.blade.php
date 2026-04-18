<nav class="w-full bg-white border-b border-gray-200 shadow-sm">
    <div class="w-full px-4 lg:px-8">
        <div class="flex items-center justify-between py-4">

            <!-- Left side: Logo -->
            <div class="flex items-center gap-3 min-w-[220px]">
                <img src="{{ asset('images/logo.png') }}" alt="NovaTM" class="w-10 h-10 object-contain">
                <span class="text-2xl font-bold text-gray-700 tracking-tight">
                    NovaTM
                </span>
            </div>

            <!-- Center navigation -->
            <div class="hidden xl:flex items-center gap-6 text-sm font-semibold text-gray-700">
                <a href="{{ url('/') }}" class="hover:text-blue-700 transition">
                    Mi Ganado 🐄
                </a>
                <a href="#" class="hover:text-blue-700 transition">
                    Consultas 🩺
                </a>
                <a href="#" class="hover:text-blue-700 transition">
                    Historial 📋
                </a>
                <a href="#" class="hover:text-blue-700 transition">
                    Recetas 💊
                </a>
                <a href="#" class="hover:text-blue-700 transition">
                    Mensajes 💬
                </a>
                <a href="#" class="hover:text-blue-700 transition">
                    Perfil 👤
                </a>
                <a href="#" class="hover:text-blue-700 transition">
                    Ayuda ❓
                </a>
            </div>

            <!-- Right side: Emergency -->
            <div class="flex items-center gap-3">
                <a href="#" class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold px-5 py-3 rounded-md transition">
                    🚨 Atención de emergencia
                </a>
            </div>
        </div>
    </div>
</nav>