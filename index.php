<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Youmi</title>

  <link href="assets/img/recursos/logotipos/favicon.png" rel="icon">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
  <div id="loader">
    <span id="loader-text"><img src="./assets/img/recursos/logotipos/logotipoblanco.png" class="palpitar"></span>
  </div>
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="index.php"><img src="assets\img\recursos\logotipos\logotipoblanco.png" alt=""> YOUMI</a></h1>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#home">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">Nosotros</a></li>
          <li><a class="nav-link scrollto" href="#services">Servicios</a></li>
          <li><a class="nav-link scrollto" href="#team">Conócenos</a></li>
          <li><a class="nav-link scrollto" href="#contact">Contacto</a></li>
          <li><a class="nav-link scrollto" href="./login.php">Inicia sesión</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>

    </div>
  </header>

  <section id="home">
    <div class="hero-container">
      <h3>Bienvenid@ a <strong>Youmi</strong></h3>
      <h1>¡CONÉCTATE CON PERSONAS NUEVAS!</h1>
      <h2>Explora perfiles interesantes, haz amistades y descubre conexiones auténticas en nuestra vibrante comunidad.</h2>
      <a href="./login.php" class="btn-get-started scrollto">¡EMPIEZA AHORA!</a>
    </div>
  </section>

  <main id="main">
    <section id="about" class="about">
      <div class="container">

        <div class="section-title">
          <h2>SOBRE NOSOTROS</h2>
          <h3>Descubre más <span>acerca de nosotros</span></h3>
          <p>En Youmi, nuestro objetivo es crear una plataforma que facilite la conexión humana y promueva relaciones auténticas.</p>
        </div>

        <div class="row content">
          <div class="col-lg-6">
            <p>
              Nuestra misión es fomentar la diversidad, la inclusión y el respeto en nuestra comunidad. Creemos en la importancia de explorar diferentes culturas, perspectivas y trasfondos para enriquecer nuestras vidas y expandir nuestros horizontes.
            </p>
            <ul>
              <li><i class="ri-check-double-line"></i> Conéctate con personas afines y descubre afinidades únicas.</li>
              <li><i class="ri-check-double-line"></i> Explora perfiles interesantes y haz amistades auténticas.</li>
              <li><i class="ri-check-double-line"></i> Amplía tu círculo social y establece relaciones sólidas.</li>
            </ul>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0">
            <p>
              Descubre una experiencia única para conocer gente nueva y construir relaciones significativas. En Youmi, nos enfocamos en crear conexiones auténticas que perduren en el tiempo. Nuestra plataforma te brinda la oportunidad de explorar perfiles interesantes y establecer amistades genuinas.
            </p>
            <a href="./login.php" class="btn-learn-more">¡ÚNETE!</a>
          </div>
        </div>

      </div>
    </section>
    <section id="services" class="services">
      <div class="container">

        <div class="section-title">
          <h2>Servicios</h2>
          <h3>Ofrecemos <span>Servicios increíbles</span> </h3>
          <p>En Youmi, nos esforzamos por brindarte una experiencia excepcional con nuestros servicios de calidad. Estamos aquí para hacer que tu experiencia de conocer gente sea aún mejor.</p>
        </div>

        <div class="row">
          <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-person-vcard"></i></div>
              <h4 class="title"><a href="">Perfil de usuario</a></h4>
              <p class="description">Crea tu perfil personalizado y destaca tus intereses y características únicas.</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-people"></i></div>
              <h4 class="title"><a href="">Exploración de perfiles</a></h4>
              <p class="description">Descubre perfiles interesantes y encuentra personas afines a tus gustos y preferencias.</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-chat-left-text"></i></div>
              <h4 class="title"><a href="">Chat y mensajería</a></h4>
              <p class="description">Conoce gente y mantén conversaciones a través de nuestra función de chat integrada.</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-controller"></i></div>
              <h4 class="title"><a href="">Juega y comparte</a></h4>
              <p class="description">Explora y aprende nuevos videojuegos, puedes conectar con la gente jugando y divirtiéndote.</p>
            </div>
          </div>

        </div>

      </div>
    </section>
    <section id="cta" class="cta">
      <div class="container">
        <div class="text-center">
          <h3>Únete a la diversión</h3>
          <p>Descubre una experiencia única para conocer a gamers como tú y sumérgete en el emocionante mundo de los videojuegos. ¡No te pierdas la oportunidad de conectarte con personas apasionadas por los juegos!</p>
          <a class="cta-btn" href="./login.php">Únete ahora</a>
        </div>
      </div>
    </section>
    <section id="team" class="team">
      <div class="container">
        <div class="section-title">
          <h2>Nuestro Equipo</h2>
          <h3>Conoce a nuestro <span>Equipo</span> de trabajo</h3>
          <p>En Youmi, nuestro equipo trabaja para brindarte una experiencia excepcional. Conéctate de forma segura y diviértete con otros amantes de los videojuegos</p>
        </div>

        <div class="row">

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member">
              <div class="member-img">
                <img src="assets/img/team/team-1.jpeg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Álvaro Fernández</h4>
                <span>Intento de programador</span>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member">
              <div class="member-img">
                <img src="assets/img/team/team-2.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Paula Cortés</h4>
                <span>Director Ejecutivo</span>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member">
              <div class="member-img">
                <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Pablo Mayenco</h4>
                <span>Gerente de Producto</span>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member">
              <div class="member-img">
                <img src="assets/img/team/team-4.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Jose Gallardo</h4>
                <span>Director de Marketing</span>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Team Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">

        <div class="section-title">
          <h2>Contacto</h2>
          <h3>Contáctanos</h3>
          <p>Si tienes alguna pregunta, sugerencia o simplemente quieres decir hola, estaremos encantados de escucharte.</p>
        </div>

        <div>
          <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12777.51246936276!2d-2.5829609!3d36.8094582!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd707109d61fa1df%3A0x2c9c97fcf2359d7!2sInstituto%20de%20Educaci%C3%B3n%20Secundaria%20Aguadulce!5e0!3m2!1ses!2ses!4v1684868712203!5m2!1ses!2ses" style="border:0; width: 100%; height: 270px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <div class="row mt-5">

          <div class="col-lg-4">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Ubicación:</h4>
                <p>Calle Alienígena, Aguadulce 333 </p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>pepitodelospalotes@gmail.com</p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Call:</h4>
                <p>+33 333 333 333</p>
              </div>

            </div>

          </div>

          <div class="col-lg-8 mt-5 mt-lg-0">

            <form role="form" class="php-email-form">
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Tu nombre" required>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Tu e-mail" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Asunto" required>
              </div>
              <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="5" placeholder="Mensaje" required></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Cargando...</div>
                <div class="error-message"></div>
                <div class="sent-message">Tu mensaje se ha enviado. ¡Gracias!</div>
              </div>
              <div class="text-center"><button type="submit">Enviar mensaje</button></div>
            </form>

          </div>

        </div>

      </div>
    </section>

  </main>

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-4 col-md-6 footer-contact">
            <h3>Sobre nosotros</h3>
            <p>
              Calle Falsa 123 <br>
              Springfield, SP 12345<br>
              Estados Unidos <br><br>
              <strong>Teléfono:</strong> +33 333 333 333<br>
              <strong>Email:</strong> pepitodelospalotes@gmail.com<br>
            </p>
          </div>

          <div class="col-lg-4 col-md-6 footer-links">
            <h4>Apartados de utilidad</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#home">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#about">Sobre nosotros</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#services">Servicios</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="./login.php">Inicio de sesión</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-links">
            <h4>Nuestros servicios</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#services">Perfil de usuario</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#services">Exploración de perfiles</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#services">Chat y mensajería</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#services">Juega y comparte</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="container d-md-flex py-4">

      <div class="me-md-auto text-center text-md-start">
        <div class="copyright">
          &copy; Copyright <strong><span>Álvaro Fernández</span></strong>. Todos los derechos reservados
        </div>
      </div>
      <div class="social-links text-center text-md-right pt-3 pt-md-0">
        <a href="https://twitter.com/" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="https://instagram.com" class="instagram"><i class="bx bxl-instagram"></i></a>
        <a href="https://www.linkedin.com/" class="linkedin"><i class="bx bxl-linkedin"></i></a>
      </div>
    </div>
  </footer>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="assets/js/main.js"></script>
  <script src="assets/js/header-scroll.js"></script>

</body>

<script src="./assets/js/loader.js"></script>

</html>