  <!-- Footer -->
  <footer>
      <div class="container-fluid">
          <img src="{{ asset('template/home') }}/assets/img/logo_footer.png" alt="logo" class="footer__logo">
          <div class="row">
              <div class="col-lg-3 mb-4">
                  <h4 class="footer__title">
                      Kontak Kami
                  </h4>
                  <ul class="footer__list">
                      <li>Jalan BJ Habibie</li>
                      <li>berita@bonebolangokab.go.id</li>
                  </ul>
              </div>
              <div class="col-lg-3 mb-4">
                  <h4 class="footer__title">
                      Statistik Web
                  </h4>
                  <ul class="footer__list">
                      <li>Total Pengunjung : {{ $totalVisitor }}</li>
                      <li>Hari ini : {{ $totalVisitorToday }}</li>
                      <li>Kemarin : {{ $totalVisitorYesterday }}</li>
                  </ul>
              </div>
              <div class="col-lg-6 mb-4">
                  <iframe
                      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15958.548948956477!2d123.13410925000001!3d0.5458856499999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x327ed46cdaacf3ab%3A0x8133b59f38e828ba!2sKantor%20Bupati%20Bone%20Bolango!5e0!3m2!1sid!2sid!4v1656488644835!5m2!1sid!2sid"
                      width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                      referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
          </div>
          <hr style="color: white;">
          <div class="row mt-3 py-3">
              <div class="col-lg-6">
                  Copyrights © 2022 - <span><a href="https://kominfo.bonebolangokab.go.id" target="_blank"
                          style="color: #8A99F0;text-decoration:none">Dinas
                          Komunikasi dan Informatika
                          Bone
                          Bolango</a> </span>,
                  <p>All Rights Reserved.</p>
              </div>
              <div class="col-lg-5">
                  <div class="footer__icon d-none d-lg-block">
                      <i class="fab fa-facebook fa-2x"></i>
                      <i class="fab fa-twitter fa-2x"></i>
                      <i class="fab fa-instagram fa-2x"></i>
                  </div>
              </div>
          </div>
      </div>
  </footer>
  <!-- End Footer -->

  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>

  <!-- Main JS -->
  <script src="{{ asset('template/home') }}/assets/js/main.js"></script>

  @production
      <!-- Google tag (gtag.js) -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=G-0NBE0YLBE3"></script>
      <script>
          window.dataLayer = window.dataLayer || [];

          function gtag() {
              dataLayer.push(arguments);
          }
          gtag('js', new Date());

          gtag('config', 'G-0NBE0YLBE3');
      </script>
  @endproduction

  <!-- Custom Script -->
  @stack('js')

  </body>

  </html>
