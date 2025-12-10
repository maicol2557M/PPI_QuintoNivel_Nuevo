<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros - ASESORO Estudio Jurídico Tributario</title>
    <link href="{{asset('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap')}}" rel="stylesheet">
    <link href="{{asset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/estaticCSS/styles_nosotros.css')}}" rel="stylesheet">
</head>
<body>
    <header>
        @include("info.nav_info")
    </header>

    <!-- Hero Section -->
    <section class="hero-about">
        <div class="container">
            <h1>Sobre Nosotros</h1>
            <p>Conoce nuestra historia, misión y visión de ASESORO Estudio Jurídico Tributario.</p>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <h2>Nuestra historia, misión y visión</h2>
            <div class="section-content" style="text-align: justify;" >
                <!-- History Section -->
                <div>
                    <h3>Historia</h3>
                    <p>ASESORO nació con la finalidad de apoyar al cumplimiento legal de las empresas. Brindamos asesoría a nuestros clientes, previo a la implementación del negocio y durante la gestión, permitiendo así, que su atención se centre en la producción y generación de recursos para su empresa. Nuestros socios mantienen una destacada trayectoria a nivel de asesoría tributaria empresarial.</p>
                    <img src="{{ asset('assets/img2/logo asesoro mediano.webp') }}" alt="Historia" class="img-fluid mt-3">
                </div>
                <!-- Mission Section -->
                <div>
                    <h3>Misión</h3>
                    <p>Ofrecer asistencia jurídica judicial y extrajudicial, brindando seguridad y confianza a través de soluciones integrales y adecuadas a las necesidades de cada cliente.</p>
                    <img src="{{ asset('assets/img2/mision_asesoro.jpg') }}" alt="Misión" class="img-fluid mt-3">
                </div>
                <!-- Vision Section -->
                <div>
                    <h3>Visión</h3>
                    <p>Ser un estudio jurídico líder en la prestación de Servicios Jurídicos, consolidando su crecimiento con experiencia y eficiencia profesional, ofreciendo un servicio integral de calidad en asesoría y consultoría legal, con resultados ágiles y eficientes, cumpliendo siempre con las expectativas de nuestros clientes, en base a valores y principios fundamentales.</p>
                    <img src="{{ asset('assets/img2/vision_asesoro.jpg') }}" alt="Visión" class="img-fluid mt-3">
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <h2>Preguntas Frecuentes</h2>
            <div class="faq-item">
                <h3>¿Qué servicios ofrece ASESORO?</h3>
                <p>Ofrecemos asesoría jurídica y tributaria, planificación fiscal, defensa legal y consultoría empresarial personalizada para empresas y particulares.</p>
            </div>
            <div class="faq-item">
                <h3>¿Cómo puedo contactar a ASESORO?</h3>
                <p>Puede contactarnos a través de nuestro formulario en la página "Contáctanos" o llamándonos directamente a nuestro número de atención. WhatsApp +593 98 936 2522</p>
            </div>
            <div class="faq-item">
                <h3>¿Dónde se encuentran ubicados?</h3>
                <p>Nuestra oficina principal está ubicada en la Ciudad de Machala, Ecuador. También ofrecemos servicios virtuales para clientes en todo el país. Nos Ubicamos en Ayacucho entre 25 de Junio y Rocafuerte.</p>
            </div>
        </div>
    </section>


    <section class="map-section">
        <div class="container">
            <h2>Ubicación</h2>
                <p>En la Ciudad de Machala, Ayacucho entre 25 de Junio y Rocafuerte, Edificio Veintemilla Segundo Piso.</p>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1184.2623739986!2d-79.96087038031185!3d-3.258500555885565!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x90330e59d7571303%3A0xad08c0e640483ae3!2sAyacucho%201619%2C%20Machala!5e0!3m2!1ses-419!2sec!4v1736816850739!5m2!1ses-419!2sec" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 ASESORO Estudio Jurídico Tributario | Todos los derechos reservados.</p>
    </footer>

    <script src="{{asset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script>
        document.querySelectorAll('.faq-item h3').forEach(item => {
            item.addEventListener('click', () => {
                const parent = item.parentElement;
                parent.classList.toggle('active');
            });
        });
    </script>
</body>
</html>
