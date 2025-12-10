<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - ASESORO Estudio Jurídico Tributario</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{asset('css/estaticCSS/styles_nuestros.css')}}" rel="stylesheet">
</head>
<body>
    <header>
        @include("info.nav_info")
    </header>

    <section class="hero-services">
        <div class="container text-center">
            <h1>Servicios Especializados en Derecho Tributario</h1>
            <p>En ASESORO, ofrecemos soluciones personalizadas en derecho tributario, consultoría jurídica y defensa en casos penales. Conoce nuestros servicios.</p>
        </div>
    </section>

    <section class="services-list-section">
        <div class="container">
            <h2 class="text-center">Nuestros Servicios</h2>
            <div class="row g-4">
                <!-- Service 1 -->
                <div class="col-md-4">
                        <div class="service-card">
                        <img src="{{ asset('assets/img2/ase_tributario.jpeg') }}" class="d-block w-100" alt="Asesoría Tributaria">
                        <div class="service-info">
                            <h3>Consultoría legal, tributaria, contable y financiera</h3>
                            <p>Somos su aliado estratégico para la toma de decisiones en su negocio, brindamos asesoría preventiva y concurrente, en: contabilidad, tributos, finanzas, laboral, conforme al marco legal vigente. Ofrecemos planificación estratégica adaptada a la necesidad del cliente, facilitando procedimientos a su empresa a fin de mitigar riesgos.</p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#serviceModal1">Ver más</button>
                        </div>
                    </div>
                </div>
                <!-- Service 2 -->
                <div class="col-md-4">
                    <div class="service-card">
                        <img src="{{ asset('assets/img2/consul_juridica.webp') }}" class="d-block w-100" alt="Consultoría Empresarial">
                        <div class="service-info">
                            <h3>Patrocinio legal ante tribunales y órganos jurisdiccionales</h3>
                            <p>Nos encargamos de ejercer la defensa técnica en procesos administrativos y judiciales en materia: tributaria, penal económica, administrativa, constitucional, laboral, civil, minera, entre otras. Gestionamos trámites notariales y registrales.</p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#serviceModal2">Ver más</button>
                        </div>
                    </div>
                </div>
                <!-- Service 3 -->
                <div class="col-md-4">
                    <div class="service-card">
                        <img src="{{ asset('assets/img2/fiscal_estrategica.jpg') }}" class="d-block w-100" alt="Planeación Fiscal">
                        <div class="service-info">
                            <h3>Gestión de cobranza preventiva, extrajudicial y judicial</h3>
                            <p>Conocida la empresa y la relación comercial que ésta mantiene con sus clientes, procedemos a cobrar diligentemente al deudor, a través de acciones judiciales y extrajudiciales.</p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#serviceModal3">Ver más</button>
                        </div>
                    </div>
                </div>
                <!-- Service 4 -->
<div class="col-md-4">
    <div class="service-card">
        <img src="{{asset('assets/img2/asistencia_juridica.webp')}}" class="d-block w-100" alt="Planeación jurídica">
        <div class="service-info">
            <h3>Consultoría legal empresarial</h3>
            <p>Acompañamiento puntual y permanente desde el inicio y durante toda la gestión de su negocio. Nuestra propuesta de acciones lícitas le permitirá administrar e invertir los recursos económicos dentro del negocio, generando la correcta determinación de tributos.</p>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#serviceModal4">Ver más</button>
        </div>
    </div>
</div>

<!-- Service 5 -->
<div class="col-md-4">
    <div class="service-card">
        <img src="{{asset('assets/img2/acompañamiento_abogado.webp')}}" class="d-block w-100" alt="Acompañamiento en procesos">
        <div class="service-info">
            <h3>Acompañamiento en procesos de determinación de tributos</h3>
            <p>Te acompañamos en todas las etapas del proceso de control de parte de las administraciones tributarias, desde requerimientos de información, liquidaciones de impuestos, facilidades de pago, reclamos en vía administrativa y judicial.</p>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#serviceModal5">Ver más</button>
        </div>
    </div>
</div>

<!-- Service 6 -->
<div class="col-md-4">
    <div class="service-card">
        <img src="{{asset('assets/img2/defensa_casos.jpg')}}" class="d-block w-100" alt="Defensa casos">
        <div class="service-info">
            <h3>Defensa en casos penales económicos</h3>
            <p>Patrocinio legal en asuntos penales en materia económica por denuncias en casos de presunta defraudación tributaria.</p>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#serviceModal6">Ver más</button>
        </div>
    </div>
</div>
            </div>
        </div>
    </section>

    <section class="cta-section text-center">
        <div class="container">
            <h2>¿Listo para mejorar tu situación fiscal?</h2>
            <p>Contáctanos hoy mismo y encuentra soluciones adaptadas a tus necesidades.</p>
    <a class="btn btn-primary" href="{{ route('contactanos') }}">Contáctanos</a>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 ASESORO Estudio Jurídico Tributario | Todos los derechos reservados.</p>
    </footer>

<div class="modal fade" id="serviceModal1" tabindex="-1" aria-labelledby="serviceModal1Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceModal1Label">Asesoría en Derecho Tributario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{asset('assets/img2/ase_tributario.jpeg')}}" alt="Asesoría Tributaria">
                <p>Para realizar el proceso de asesoría tributaria, por favor, ingresa los siguientes datos:</p>
                <form id="formService1">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="company" class="form-label">Nombre de la Empresa</label>
                        <input type="text" class="form-control" id="company" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción del Caso</label>
                        <textarea class="form-control" id="description" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar Requisitos</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="serviceModal2" tabindex="-1" aria-labelledby="serviceModal2Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceModal2Label">Consultoría Jurídica Empresarial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{asset('assets/img2/consul_juridica.webp')}}" alt="Consultoría Empresarial">
                <p>Para comenzar el proceso de consultoría jurídica empresarial, por favor, llena los siguientes campos:</p>
                <!-- Formulario para los requisitos -->
                <form id="formService2">
                    <div class="mb-3">
                        <label for="name2" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="name2" required>
                    </div>
                    <div class="mb-3">
                        <label for="email2" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email2" required>
                    </div>
                    <div class="mb-3">
                        <label for="company2" class="form-label">Nombre de la Empresa</label>
                        <input type="text" class="form-control" id="company2" required>
                    </div>
                    <div class="mb-3">
                        <label for="caseDescription2" class="form-label">Descripción del Caso</label>
                        <textarea class="form-control" id="caseDescription2" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar Requisitos</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="serviceModal3" tabindex="-1" aria-labelledby="serviceModal3Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceModal3Label">Planeación Fiscal Estratégica</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{asset('assets/img2/fiscal_estrategica.jpg')}}" alt="Planeación Fiscal">
                <p>Para solicitar una planeación fiscal estratégica, por favor, llena los siguientes datos:</p>
                <form id="formService3">
                    <div class="mb-3">
                        <label for="name3" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="name3" required>
                    </div>
                    <div class="mb-3">
                        <label for="email3" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email3" required>
                    </div>
                    <div class="mb-3">
                        <label for="company3" class="form-label">Nombre de la Empresa</label>
                        <input type="text" class="form-control" id="company3" required>
                    </div>
                    <div class="mb-3">
                        <label for="fiscalDescription3" class="form-label">Descripción de la Necesidad Fiscal</label>
                        <textarea class="form-control" id="fiscalDescription3" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar Requisitos</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="serviceModal4" tabindex="-1" aria-labelledby="serviceModal4Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceModal4Label">Consultoría Legal Empresarial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                <img src="{{ asset('assets/img2/asistencia_juridica.webp') }}" alt="Planeación jurídica">
                <p>Para comenzar el proceso de consultoría legal empresarial, por favor, llena los siguientes campos:</p>
                <form id="formService4">
                    <div class="mb-3">
                        <label for="name4" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="name4" required>
                    </div>
                    <div class="mb-3">
                        <label for="email4" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email4" required>
                    </div>
                    <div class="mb-3">
                        <label for="company4" class="form-label">Nombre de la Empresa</label>
                        <input type="text" class="form-control" id="company4" required>
                    </div>
                    <div class="mb-3">
                        <label for="legalDescription4" class="form-label">Descripción del Caso</label>
                        <textarea class="form-control" id="legalDescription4" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar Requisitos</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="serviceModal5" tabindex="-1" aria-labelledby="serviceModal5Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceModal5Label">Acompañamiento en Procesos de Determinación de Tributos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{asset('assets/img2/acompañamiento_abogado.webp')}}" alt="Acompañamiento en procesos">
                <p>Para solicitar nuestro acompañamiento en procesos de determinación de tributos, por favor, completa el siguiente formulario:</p>
                <form id="formService5">
                    <div class="mb-3">
                        <label for="name5" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="name5" required>
                    </div>
                    <div class="mb-3">
                        <label for="email5" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email5" required>
                    </div>
                    <div class="mb-3">
                        <label for="company5" class="form-label">Nombre de la Empresa</label>
                        <input type="text" class="form-control" id="company5" required>
                    </div>
                    <div class="mb-3">
                        <label for="processDescription5" class="form-label">Descripción del Proceso</label>
                        <textarea class="form-control" id="processDescription5" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar Requisitos</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="serviceModal6" tabindex="-1" aria-labelledby="serviceModal6Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceModal6Label">Defensa en Casos Penales Económicos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{asset('assets/img2/defensa_casos.jpg')}}" alt="Defensa casos">
                <p>Para solicitar nuestra defensa en casos penales económicos, por favor, llena el siguiente formulario:</p>
                <form id="formService6">
                    <div class="mb-3">
                        <label for="name6" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="name6" required>
                    </div>
                    <div class="mb-3">
                        <label for="email6" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email6" required>
                    </div>
                    <div class="mb-3">
                        <label for="caseDescription6" class="form-label">Descripción del Caso</label>
                        <textarea class="form-control" id="caseDescription6" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar Requisitos</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById('formService1').addEventListener('submit', function(event) {
        event.preventDefault(); // Evitar el envío del formulario
        alert('Los requisitos para el servicio han sido enviados.');
        // Aquí puedes agregar el código para enviar el formulario o hacer cualquier otra acción
    });

    document.getElementById('formService2').addEventListener('submit', function(event) {
        event.preventDefault();
        alert('Los requisitos para el servicio han sido enviados.');
    });

    document.getElementById('formService3').addEventListener('submit', function(event) {
        event.preventDefault();
        alert('Los requisitos para el servicio han sido enviados.');
    });
    </script>
</body>
</html>
