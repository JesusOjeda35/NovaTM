<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'NovaTM') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary-yellow: #facc15;
            --white: #FFFFFF;
            --dark-blue: #14202A;
            --light-gray: #f8f9fa;
            --text-dark: #1a1a1a;
            --text-light: #666;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: var(--light-gray); }

        /* HERO */
        .hero-carousel {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .carousel-slide {
            position: absolute;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .carousel-slide.active { opacity: 1; }

        .carousel-overlay {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(20, 32, 42, 0.4);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            width: 100%; height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-content h1 { color: var(--white); text-shadow: 2px 2px 4px rgba(20, 32, 42, 0.5); }
        .hero-content p { color: rgba(255, 255, 255, 0.95); text-shadow: 1px 1px 2px rgba(20, 32, 42, 0.5); }

        .btn-hero {
            background: linear-gradient(135deg, var(--primary-yellow) 0%, #f59e0b 100%);
            color: var(--dark-blue);
            border: none;
            font-weight: 700;
            padding: 14px 32px;
            border-radius: 50px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(250, 204, 21, 0.3);
        }

        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(250, 204, 21, 0.4);
            color: var(--dark-blue);
            text-decoration: none;
        }

        /* SECCIÓN POR QUÉ */
        .section-why {
            background: linear-gradient(135deg, var(--dark-blue) 0%, #1e2d3d 100%);
            color: var(--white);
        }

        /* FEATURE CARDS */
        .feature-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(250, 204, 21, 0.25);
            border-radius: 12px;
            padding: 24px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(250, 204, 21, 0.15) 0%, rgba(250, 204, 21, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
            border-radius: 12px;
        }

        .feature-card:hover::before { opacity: 1; }

        .feature-card:hover {
            transform: scale(1.05) translateY(-8px);
            background: rgba(255, 255, 255, 0.12);
            border-color: var(--primary-yellow);
            box-shadow: 0 12px 30px rgba(250, 204, 21, 0.2);
        }

        .feature-icon { font-size: 28px; min-width: 30px; transition: transform 0.4s; }
        .feature-card:hover .feature-icon { transform: scale(1.3) rotate(10deg); }
        .feature-text { font-size: 15px; line-height: 1.6; position: relative; z-index: 1; }

        /* SECCIÓN ARTÍCULOS */
        .section-articles { background: var(--light-gray); }

        /* ARTICLE CARDS */
        .article-card {
            background: var(--white);
            border-radius: 14px;
            overflow: hidden;
            transition: all 0.4s ease;
            cursor: pointer;
            box-shadow: 0 2px 12px rgba(20, 32, 42, 0.08);
            height: 100%;
            display: flex;
            flex-direction: column;
            border-top: 4px solid var(--primary-yellow);
        }

        .article-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 12px 30px rgba(20, 32, 42, 0.15);
        }

        .article-image { width: 100%; height: 240px; object-fit: cover; transition: transform 0.4s; }
        .article-card:hover .article-image { transform: scale(1.05); }

        .article-content { padding: 24px; display: flex; flex-direction: column; flex-grow: 1; }
        .article-title { font-size: 18px; font-weight: 700; color: var(--text-dark); margin-bottom: 12px; }
        .article-description { font-size: 14px; color: var(--text-light); margin-bottom: 16px; flex-grow: 1; }

        .article-button {
            background: linear-gradient(135deg, var(--primary-yellow) 0%, #f59e0b 100%);
            color: var(--dark-blue);
            border: none;
            padding: 10px 24px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s;
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
            align-self: flex-start;
        }

        .article-button:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(250, 204, 21, 0.3);
            color: var(--dark-blue);
        }

        /* PROCESS CARDS */
        .process-card { text-align: center; transition: all 0.4s; }
        .process-avatar {
            width: 140px; height: 140px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 20px;
            border: 4px solid var(--primary-yellow);
            transition: all 0.4s;
            cursor: pointer;
        }

        .process-card:hover .process-avatar {
            transform: scale(1.1);
            box-shadow: 0 0 30px rgba(250, 204, 21, 0.4);
        }

        .process-title { font-size: 18px; font-weight: 700; color: var(--white); margin-bottom: 12px; }
        .process-description { font-size: 14px; color: rgba(255, 255, 255, 0.9); line-height: 1.6; }

        /* CONTACTS */
        .contacts-section {
            position: relative;
            background-image: url('{{ asset('images/utencilios1.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: scroll;
            min-height: 450px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .contacts-overlay {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(20, 32, 42, 0.6);
        }

        .contacts-content {
            position: relative;
            z-index: 2;
            background: var(--white);
            border-radius: 16px;
            padding: 48px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 15px 50px rgba(20, 32, 42, 0.2);
            text-align: center;
            border-top: 6px solid var(--primary-yellow);
        }

        .contacts-title { color: var(--dark-blue); font-size: 36px; font-weight: 800; margin-bottom: 28px; }
        .contacts-schedule { color: var(--text-light); font-size: 13px; margin-bottom: 6px; font-weight: 600; letter-spacing: 0.5px; }
        .contacts-hours { color: var(--text-dark); font-size: 16px; font-weight: 700; margin-bottom: 20px; }
        .contacts-phone { color: var(--text-light); font-size: 14px; margin-bottom: 8px; }
        .contacts-phone-number { color: var(--primary-yellow); font-weight: 800; font-size: 22px; }

        /* MODAL */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(20, 32, 42, 0.95);
            z-index: 1000;
            animation: fadeIn 0.3s ease;
        }

        .modal-overlay.active { display: flex; align-items: center; justify-content: center; }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .modal-content {
            position: relative;
            width: 90%;
            max-width: 500px;
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(20, 32, 42, 0.3);
            animation: zoomIn 0.3s ease;
        }

        @keyframes zoomIn { from { transform: scale(0.8); opacity: 0; } to { transform: scale(1); opacity: 1; } }

        .modal-image { width: 100%; height: auto; max-height: 70vh; object-fit: contain; }

        .modal-close {
            position: absolute;
            top: 12px; right: 12px;
            background: var(--primary-yellow);
            color: var(--dark-blue);
            border: none;
            width: 40px; height: 40px;
            border-radius: 50%;
            font-size: 24px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 700;
        }

        .modal-close:hover { background: #f59e0b; transform: scale(1.1); }
    </style>
</head>
<body>
    @include('layouts.partials.topbar')

    <main>
        
        <!-- HERO -->
        <section class="hero-carousel" id="heroCarousel">
            <div class="carousel-slide active" style="background-image: url('{{ asset('images/vaca1.jpg') }}')"></div>
            <div class="carousel-slide" style="background-image: url('{{ asset('images/vaca2.jpg') }}')"></div>
            <div class="carousel-slide" style="background-image: url('{{ asset('images/vaca3.jpg') }}')"></div>
            <div class="carousel-slide" style="background-image: url('{{ asset('images/vaca4.jpg') }}')"></div>

            <div class="carousel-overlay"></div>

            <div class="hero-content">
                <div class="text-center text-white space-y-6 max-w-2xl px-6">
                    <h1 class="text-5xl md:text-6xl font-extrabold leading-tight">
                        Siempre<br>estamos<br>listos para<br>ayudar
                    </h1>
                    <p class="text-lg md:text-xl">
                        NovaTM brinda seguimiento, control y gestión para el cuidado de tus animales de manera rápida y eficiente.
                    </p>
                    <a href="#contacto" class="btn-hero inline-block px-8 py-4 rounded-full">
                        CONTÁCTENOS
                    </a>
                </div>
            </div>
        </section>

        <!-- POR QUÉ ELEGIMOS -->
        <section class="section-why py-16 lg:py-24 px-6 lg:px-12">
            <div class="max-w-7xl mx-auto">
                <div class="mb-16 text-center">
                    <p class="text-sm font-bold mb-3 opacity-90 lg:text-base" style="color: var(--primary-yellow);">POR QUÉ ELEGIRNOS</p>
                    <h2 class="text-3xl lg:text-5xl font-bold mb-4 leading-tight">
                        Animales siendo atendidos por veterinarios a distancia
                    </h2>
                    <p class="text-base lg:text-lg opacity-90">Incluso sin internet</p>
                </div>

                <div class="max-w-4xl mx-auto">
                    <h3 class="text-2xl font-bold mb-12 text-center">¿Cómo funciona?</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-white">
                        <div class="feature-card">
                            <div class="feature-icon">📋</div>
                            <p class="feature-text">Registro sencillo del animal (nombre, especie, síntoma) desde la finca, sin necesidad de conexión continua.</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">📸</div>
                            <p class="feature-text">Teleorientación envía fotos, videos o mensajes al veterinario; él responde cuando tenga señal.</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">📞</div>
                            <p class="feature-text">Teleconsulta en tiempo real por videollamada (si hay conectividad estable).</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">📊</div>
                            <p class="feature-text">Historia clínica electrónica automática con todo el historial de cada animal.</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">💊</div>
                            <p class="feature-text">Receta digital ajustada a normas del ICA, con firma del veterinario.</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">🏥</div>
                            <p class="feature-text">Derivación a atención presencial solo si el caso lo requiere, coordinando cita y lugar.</p>
                        </div>
                        <div class="feature-card md:col-span-2">
                            <div class="feature-icon">🔄</div>
                            <p class="feature-text">Sincronización offline-first: la app guarda los datos sin internet y los envía cuando vuelve la señal.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ARTÍCULOS -->
        <section class="section-articles py-16 lg:py-24 px-6 lg:px-12">
            <div class="max-w-7xl mx-auto">
                <div class="mb-16 text-center">
                    <p class="text-sm font-bold mb-2" style="color: var(--primary-yellow);">📰 NOTICIAS Y ARTÍCULOS</p>
                    <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 mb-4">
                        Todo lo que necesitas saber sobre telemedicina veterinaria
                    </h2>
                    <p class="text-base text-gray-600 max-w-2xl mx-auto">
                        Conoce cómo la atención remota transforma la salud animal
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="article-card">
                        <img src="{{ asset('images/rurales.jpg') }}" alt="Telemedicina rural" class="article-image">
                        <div class="article-content">
                            <h3 class="article-title">🌾 Telemedicina en zonas rurales</h3>
                            <p class="article-description">
                                Con NovaTM, el diseño offline-first y uso reducido de datos permiten que productores y veterinarios se comuniquen aunque la señal falle.
                            </p>
                            <a href="#" class="article-button">Leer más</a>
                        </div>
                    </div>
                    <div class="article-card">
                        <img src="{{ asset('images/telemedicinaatender.jpg') }}" alt="Alianzas" class="article-image">
                        <div class="article-content">
                            <h3 class="article-title">🤝 Creando alianzas veterinarias</h3>
                            <p class="article-description">
                                Teleorientación asincrónica que permite seguimiento sin estar en tiempo real, fortaleciendo confianza.
                            </p>
                            <a href="#" class="article-button">Leer más</a>
                        </div>
                    </div>
                    <div class="article-card">
                        <img src="{{ asset('images/beneficiotelemedicina.jpg') }}" alt="Bienestar" class="article-image">
                        <div class="article-content">
                            <h3 class="article-title">😌 Menos estrés, más acceso</h3>
                            <p class="article-description">
                                NovaTM evita traslado innecesario de animales y mejora su salud integral.
                            </p>
                            <a href="#" class="article-button">Leer más</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- PROCESO -->
        <section class="section-why py-16 lg:py-24 px-6 lg:px-12">
            <div class="max-w-7xl mx-auto">
                <div class="mb-16 text-center">
                    <p class="text-sm font-bold mb-3 opacity-90" style="color: var(--primary-yellow);">PROCESO DE TRABAJO</p>
                    <h2 class="text-3xl lg:text-5xl font-bold mb-4">¿Cómo trabajamos?</h2>
                    <p class="text-base opacity-90 max-w-2xl mx-auto">
                        NovaTM funciona como un equipo integrado
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="process-card">
                        <img src="{{ asset('images/veterinario1.jpg') }}" alt="Productor" class="process-avatar" onclick="openModal(this.src, this.alt)">
                        <h3 class="process-title">El Productor</h3>
                        <p class="process-description">Registra animales y recibe recomendaciones.</p>
                    </div>
                    <div class="process-card">
                        <img src="{{ asset('images/veterinario2.jpg') }}" alt="Veterinario" class="process-avatar" onclick="openModal(this.src, this.alt)">
                        <h3 class="process-title">El Veterinario</h3>
                        <p class="process-description">Evalúa casos y emite recetas.</p>
                    </div>
                    <div class="process-card">
                        <img src="{{ asset('images/veterinario3.jpg') }}" alt="Especialista" class="process-avatar" onclick="openModal(this.src, this.alt)">
                        <h3 class="process-title">El Especialista</h3>
                        <p class="process-description">Interviene en casos complejos.</p>
                    </div>
                    <div class="process-card">
                        <img src="{{ asset('images/veterinario4.jpg') }}" alt="Plataforma" class="process-avatar" onclick="openModal(this.src, this.alt)">
                        <h3 class="process-title">La Plataforma</h3>
                        <p class="process-description">Conecta a todos sin internet.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CONTACTOS -->
        <section class="contacts-section" id="contacto">
            <div class="contacts-overlay"></div>
            <div class="contacts-content">
                <h2 class="contacts-title">Contactos</h2>
                <div class="contacts-schedule">Lunes – Viernes</div>
                <div class="contacts-hours">8:00 AM – 8:00 PM</div>
                <div class="contacts-phone">Llámanos</div>
                <div class="contacts-phone-number">(111) 252 3366</div>
            </div>
        </section>

    </main>

    <!-- MODAL -->
    <div class="modal-overlay" id="imageModal" onclick="closeModal(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            <button class="modal-close" onclick="closeModal()">✕</button>
            <img id="modalImage" class="modal-image" src="" alt="">
        </div>
    </div>

    @include('layouts.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const totalSlides = slides.length;

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            slides[index].classList.add('active');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }

        setInterval(nextSlide, 5000);

        function openModal(src, alt) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = src;
            modalImage.alt = alt;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(event) {
            if (event && event.target.id !== 'imageModal') return;
            const modal = document.getElementById('imageModal');
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') closeModal();
        });
    </script>
</body>
</html>