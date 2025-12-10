<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="{{ asset('assets/img2/logo asesoro mediano.webp') }}" alt="Logo" style="height: 50px; margin-right: 10px;">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="#navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav text-center">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('home') }}">
                                <i class="fas fa-home me-2"></i>Inicio
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('servicios') }}">
                                <i class="fa-solid fa-screwdriver-wrench me-2"></i>Nuestros Servicios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('sobre_nosotros') }}">
                                <i class="fa-solid fa-address-card me-2"></i>Sobre Nosotros
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('blog') }}">
                                <i class="fa-solid fa-blog me-2"></i>Blog Informativo
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contactanos') }}">
                                <i class="fa-solid fa-address-book me-2"></i>Contáctanos
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="d-flex ms-lg-auto">
                    <a href="{{ route('login') }}" class="btn btn-warning btn-lg px-4 py-2 fw-bold text-dark shadow-sm">
                        <i class="fa-solid fa-sign-in-alt me-2"></i>Acceder
                    </a>
                </div>
                </div>
        </nav>
