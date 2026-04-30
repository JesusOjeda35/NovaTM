<nav class="w-full bg-white border-b border-gray-200 shadow-sm">
    <div class="w-full px-4 lg:px-8">
        <div class="flex items-center justify-between py-4">

            <!-- Left side: Logo -->
            <div class="flex items-center gap-3 min-w-[220px]">
                <img src="{{ asset('images/logo.png') }}" alt="NovaTM" class="w-10 h-10 object-contain">
                <span class="text-2xl font-bold tracking-tight" style="color: #14202A;">
                    NovaTM
                </span>
            </div>

            <!-- Center navigation -->
            <div class="hidden xl:flex items-center gap-6 text-sm font-semibold" style="color: #14202A;">
                <a href="{{ url('/') }}" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                    Mi Ganado 🐄
                </a>
                <a href="#" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                    Consultas 🩺
                </a>
                <a href="#" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                    Historial 📋
                </a>
                <a href="#" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                    Recetas 💊
                </a>
                <a href="#" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                    Mensajes 💬
                </a>
                <a href="#" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                    Perfil 👤
                </a>
                <a href="#" class="transition duration-300" style="color: #14202A;" onmouseover="this.style.color='#facc15'" onmouseout="this.style.color='#14202A'">
                    Ayuda ❓
                </a>
            </div>

            <!-- Right side: Emergency (SIN MODIFICAR - ROJO) -->
            <div class="flex items-center gap-3">
                <a href="#" class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold px-5 py-3 rounded-md transition">
                    🚨 Atención de emergencia
                </a>
            </div>
        </div>
    </div>
</nav>