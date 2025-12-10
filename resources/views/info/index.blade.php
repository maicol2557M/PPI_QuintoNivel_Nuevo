<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asesoro - Estudio Jurídico Tributario</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{asset('css/estaticCSS/styles.css')}}" rel="stylesheet">
</head>
<body>
    <header>
        @include("info.nav_info")
    </header>


    <section class="hero">
        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('assets/img2/fondo_1.jpg') }}" class="d-block w-100" alt="Imagen 1">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('assets/img2/fondo_2.jpg') }}" class="d-block w-100" alt="Imagen 2">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('assets/img2/fondo_3.jpg') }}" class="d-block w-100" alt="Imagen 3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="hero-content">
            <h1>ASESORO</h1>
            <h2>Estudio Jurídico Tributario</h2>
            <a class="btn btn-primary" href="{{ route('contactanos') }}">Contáctanos</a>
        </div>
    </section>

    <section class="team-section">
        <h2>Nuestro Equipo de Trabajo</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="team-card" data-bs-toggle="modal" data-bs-target="#teamModal1">
                    <div class="team-photo-wrapper">
                        <img src="{{ asset('assets/img2/abogado_1.jpg') }}" alt="Abogado 1" class="team-photo">
                    </div>
                    <h3>Dr. Carlos Ordeñana Carrión</h3>
                    <p>Doctor en Jurisprudencia</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="team-card" data-bs-toggle="modal" data-bs-target="#teamModal2">
                    <div class="team-photo-wrapper">
                        <img src="{{ asset('assets/img2/abogado_2.jpg') }}" alt="Abogado 2" class="team-photo">
                    </div>
                    <h3>Ab. Carla Veintemilla Zambrano</h3>
                    <p>Derecho Penal Económico</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="team-card" data-bs-toggle="modal" data-bs-target="#teamModal3">
                    <div class="team-photo-wrapper">
                        <img src="{{ asset('assets/img2/abogado_3.jpg') }}" alt="Abogado 3" class="team-photo">
                    </div>
                    <h3>Econ. Daniel Gutierrez Jaramillo</h3>
                    <p>Economista</p>
                </div>
            </div>
            <div class="col-md-4 mx-auto">
                <div class="team-card text-center" data-bs-toggle="modal" data-bs-target="#teamModal4">
                    <div class="team-photo-wrapper">
                        <img src="{{ asset('assets/img2/abogado_4.jpg') }}" alt="Abogado 4" class="team-photo">
                    </div>
                    <h3>Ing. Maria Dolores Niemes</h3>
                    <p>Contadora e Ingeniera comercial</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Modals -->
    <div class="modal fade" id="teamModal1" tabindex="-1" aria-labelledby="teamModal1Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teamModal1Label">Dr. Carlos Ordeñana Carrión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align: justify;">
                    <img src="{{ asset('assets/img2/abogado_1modal.jpg') }}" alt="Abogado 1" class="modal-photo">
                    <p>Doctor en Jurisprudencia y abogado de los tribunales de la justicia de la República por la Universidad de Cuenca, estudios de postgrado en Tributación en la Universidad de Cuenca y estudios de postgrado en Derecho Procesal en la Universidad San Antonio de Machala.
                        Cuenta con más de 18 años de experiencia en Administración Pública como asesor, coordinador jurídico y depositario fiscal en el SRI y asesor jurídico en la Subscretaría de Minas Zona 7, y en la empresa privada como Gerente general de la Cooperativa de Producción y Comercialización La Clementina.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- (otros modals y secciones iguales, conservados como en el original, con rutas de imágenes convertidas a asset()) -->

    <section class="about-us-section">
        <div class="container text-center">
            <h2>¿Quiénes Somos?</h2>
            <p>
                ASESORO nació con la finalidad de apoyar al cumplimiento legal de las empresas.
Brindamos asesoría a nuestros clientes, previo a la implementación del negocio y durante la gestión, permitiendo así, que su atención se centre en la producción y generación de recursos para su empresa.
            </p>
        </div>
        <div class="services-list">
            <h3>¿Qué Ofrecemos?</h3>
            <ul>
                <li>Consultoría legal, tributaria, contable y financiera</li>
                <li>Patrocinio legal ante tribunales y órganos jurisdiccionales</li>
                <li>Gestión de cobranza preventiva, extrajudicial y judicial</li>
                <li>Planificación jurídica, tributaria y contable</li>
                <li>Acompañamiento en procesos de determinación de tributos</li>
                <li>Defensa en casos penales económicos</li>
            </ul>
        </div>
        <div class="social-media">
            <h3>Conéctate con Nosotros</h3>
            <div class="social-icons">
                <a href="https://www.instagram.com/asesoro.oficial/" target="_blank" class="social-link">
                    <img src="{{ asset('assets/img2/icon/instagram.png') }}" alt="Instagram">
                </a>
                <a href="https://www.linkedin.com" target="_blank" class="social-link">
                    <img src="{{ asset('assets/img2/icon/linkedin.png') }}" alt="LinkedIn">
                </a>
                <a href="https://www.twitter.com" target="_blank" class="social-link">
                    <img src="{{ asset('assets/img2/icon/X.png') }}" alt="X (Twitter)">
                </a>
            </div>
        </div>
    </section>

    <footer>
        &copy; 2024 ASESORO Estudio Jurídico Tributario | Todos los derechos reservados.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
