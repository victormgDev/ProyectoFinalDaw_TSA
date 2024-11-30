<?php
include 'templates/head.php';
?>
    <div class="container-fluid my-5" aria-label="Contenedor preguntas frecuentes">
        <h2 class="text-center mb-4">Preguntas Frecuentes (FAQ)</h2>
        <div class="row justify-content-center">
            <div class="col-7">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item mb-1">
                        <h2 class="accordion-header" id="headFaq1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="false" aria-controls="faq1" aria-label="Primera pregunta Que es esta aplicacion?">
                                ¿Qué es esta aplicación?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse " aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
                            <div class="accordion-body" aria-label="Respuesta primera pregunta">
                                Es una plataforma que te permite consultar rutas aéreas en tiempo real, buscar información detallada sobre aviones y explorar una enciclopedia completa de aeronaves.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mb-1">
                        <h2 class="accordion-header" id="headFaq2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2" aria-label="Segunda pregunta Necesito registrarme?">
                                ¿Necesito registrarme para usar la aplicación?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#faqAccordion">
                            <div class="accordion-body" aria-label="Respuesta segunda pregunta">
                                No es necesario registrarse para explorar la enciclopedia, pero para interactuar con el mapa de rutas en tiempo real y añadir aviones o modificar alguno, si es obligatorio crear una cuenta e iniciar sesion.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mb-1">
                        <h2 class="accordion-header" id="headFaq3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3" aria-label="Tercera pregunta que informacion existe?">
                                ¿Qué información puedo encontrar sobre un avión?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#faqAccordion">
                            <div class="accordion-body" aria-label="Respuesta tercera pregunta">
                                Detalles como capacidad, alcance, velocidad máxima, fabricante, y una breve descripción histórica del modelo.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mb-1">
                        <h2 class="accordion-header" id="headFaq4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4" aria-label="Cuarta pregunta Cambio de configuracion">
                                ¿Cómo cambio la configuración de mi cuenta?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" data-bs-parent="#faqAccordion">
                            <div class="accordion-body" aria-label="Respuesta cuarta pregunta">
                                Inicia sesión y dirígete a la sección "Mi Perfil" para actualizar tus datos personales o cambiar la contraseña.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mb-1">
                        <h2 class="accordion-header" id="headFaq5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5" aria-expanded="false" aria-controls="faq5" aria-label="Quinta pregunta Compatibilidad">
                                ¿Que navegadores son compatibles?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" aria-labelledby="faqHeading5" data-bs-parent="#faqAccordion" aria-label="Respuesta compatibilidad">
                            <div class="accordion-body">
                                Opera, Google Chorme, Microsoft Edge, Mozilla Firefox
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
include 'templates/footer.php';
?>