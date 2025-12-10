<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Informativo - ASESORO Estudio Jurídico Tributario</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{asset('css/estaticCSS/styless_blog.css')}}" rel="stylesheet">
</head>
<body>
    <header>
        @include("info.nav_info")
    </header>

    <!-- Hero Section -->
    <section class="hero-blog">
        <div class="container">
            <h1>Blog Informativo</h1>
            <p>Lee nuestras últimas actualizaciones, noticias y consejos sobre el ámbito jurídico tributario.</p>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="about-us">
        <div class="container">
            <h2>Sobre ASESORO</h2>
            <p>En ASESORO Estudio Jurídico Tributario, nos especializamos en ofrecer soluciones legales integrales en el ámbito tributario, asesorando a empresas y particulares para asegurar el cumplimiento normativo y optimizar su carga fiscal.</p>
        </div>
    </section>

    <!-- Blog Section -->
<section class="blog-section">
    <div class="container">
        <h2>Últimas publicaciones</h2>
        <div class="blog-posts">
            <!-- Post 1 -->
            <div class="blog-post">
                <img src="{{ asset('assets/img2/optimizar_impuestos.jpg') }}" alt="Post 1">
                <h3>¿Cómo optimizar tus impuestos en tiempos de incertidumbre económica?</h3>
                <p>En este artículo exploramos las mejores estrategias para gestionar tus impuestos durante periodos de crisis económica. Desde la planificación fiscal hasta la optimización de deducciones, te ofrecemos consejos prácticos para reducir tu carga tributaria sin comprometer tu cumplimiento fiscal.</p>
            </div>

            <!-- Post 2 -->
            <div class="blog-post">
                <img src="{{ asset('assets/img2/pequenas_empresas.jpg') }}" alt="Post 2">
                <h3>Impacto de la reforma tributaria en las pequeñas empresas</h3>
                <p>La reciente reforma tributaria ha afectado a muchas pequeñas empresas. En este post analizamos cómo estos cambios impactan las operaciones diarias de los pequeños empresarios y qué medidas pueden tomar para adaptarse a las nuevas regulaciones fiscales sin comprometer su crecimiento.</p>
            </div>

            <!-- Post 3 -->
            <div class="blog-post">
                <img src="{{ asset('assets/img2/transparencia_sector.jpg') }}" alt="Post 3">
                <h3>La importancia de la transparencia fiscal en el sector corporativo</h3>
                <p>La transparencia fiscal es un tema crucial en el mundo corporativo. Este artículo aborda la importancia de una política fiscal clara y abierta para fortalecer la confianza de los inversores, mejorar la reputación de la empresa y asegurar el cumplimiento de la normativa tributaria.</p>
            </div>
        </div>
    </div>
</section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="container">
            <h2>Testimonios</h2>
            <div class="testimonial">
                <p>"Gracias a ASESORO, pudimos resolver un conflicto tributario de forma rápida y eficaz. ¡Recomiendo sus servicios ampliamente!"</p>
                <p>- Juan Pérez, Cliente</p>
            </div>
            <div class="testimonial">
                <p>"El equipo de ASESORO nos brindó un excelente asesoramiento fiscal, lo que nos permitió mejorar nuestra rentabilidad fiscal. Profesionales de confianza."</p>
                <p>- Laura Martínez, Cliente Corporativo</p>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter">
        <div class="container">
            <h2>Suscríbete a nuestro blog</h2>
            <p>Recibe las últimas novedades y consejos directamente en tu correo.</p>
            <form id="subscribeForm">
                <input type="email" placeholder="Ingresa tu email" required>
                <button type="submit">Suscribirse</button>
            </form>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="subscribeModal" tabindex="-1" aria-labelledby="subscribeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subscribeModalLabel">¡Te has suscrito correctamente!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¡Gracias por suscribirte a nuestro blog! Estás listo para recibir las últimas noticias y actualizaciones.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action Section -->
    <section class="cta">
        <div class="container">
            <h2>¿Necesitas asesoría legal?</h2>
            <p>Haz clic en el botón para consultar con nosotros directamente.</p>
            <a href="{{ route('contactanos') }}" class="btn-cta">Consultar con Nosotros</a>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 ASESORO Estudio Jurídico Tributario | Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Modal script
        document.getElementById("subscribeForm").addEventListener("submit", function(event) {
            event.preventDefault();
            var myModal = new bootstrap.Modal(document.getElementById('subscribeModal'));
            myModal.show();
        });
    </script>
</body>
</html>
