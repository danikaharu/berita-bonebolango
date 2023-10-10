  <!--Main Navigation-->
  <header id="navbar_top">
      <!-- Jumbotron -->
      <div class="p-3 text-center bg-white border-bottom">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-md-6 d-flex justify-content-center justify-content-md-start mb-3 mb-md-0">
                      <a href="{{ route('home') }}">
                          <img src="{{ asset('template/home') }}/assets/img/logo_berita.svg" />
                      </a>
                  </div>

                  <div class="col-md-6 d-flex justify-content-center justify-content-md-end align-items-center">
                      <div class="d-flex d-none d-md-block">
                          <span class="header__text">Tentang</span>
                          <span class="header__text">Kontak</span>
                          <span style="margin-left: 0.6rem;margin-right:0.6rem;"><i class="fab fa-facebook"></i></span>
                          <span style="margin-left: 0.6rem;margin-right:0.6rem;"><i class="fab fa-twitter"></i></span>
                          <span style="margin-left: 0.6rem;margin-right:0.6rem;"><i class="fab fa-instagram"></i></span>
                          <span class="header__text">{{ Carbon\Carbon::today()->isoFormat('dddd, D MMMM Y') }}</span>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- Jumbotron -->

      <nav class="navbar navbar-expand-lg navbar-custom">
          <div class="container-fluid">
              <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                  aria-label="Toggle navigation">
                  <span class="toggler-icon top-bar"></span>
                  <span class="toggler-icon middle-bar"></span>
                  <span class="toggler-icon bottom-bar"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100">
                      <li class="nav-item {{ request()->is('/') ? ' active' : '' }}" style="margin-left: 0">
                          <a class="nav-link" href="{{ route('home') }}">BERANDA</a>
                      </li>
                      <li class="nav-item {{ request()->is('berita*') ? ' active' : '' }} dropdown">
                          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                              data-bs-toggle="dropdown" aria-expanded="false">
                              INDEKS
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                              @foreach ($categories as $category)
                                  <li><a class="dropdown-item"
                                          href="{{ route('detailCategory', $category->slug) }}">{{ $category->title }}</a>
                                  </li>
                              @endforeach
                          </ul>
                      </li>
                      <li class="nav-item {{ request()->is('siaran-pers*') ? ' active' : '' }}">
                          <a class="nav-link" href="{{ route('pressRelease') }}">SIARAN PERS</a>
                      </li>
                      <li class="nav-item {{ request()->is('kategori/drpd') ? ' active' : '' }}">
                          <a class="nav-link" href="{{ route('detailCategory', $dprd->slug) }}">DPRD</a>
                      </li>
                      <li class="nav-item {{ request()->is('kategori/bumd') ? ' active' : '' }}">
                          <a class="nav-link" href="{{ route('detailCategory', $bumd->slug) }}">BUMD</a>
                      </li>
                      <li class="nav-item {{ request()->is('potret') ? ' active' : '' }}">
                          <a class="nav-link" href="{{ route('gallery') }}">POTRET BONEBOL</a>
                      </li>
                      <li class="nav-item" style="margin-right: 0">
                          <a class="nav-link" href="#" onclick="openSearch()"><i class="fas fa-search"></i></a>
                      </li>
                  </ul>
              </div>
          </div>

          <!-- Search -->
          <div id="myOverlay" class="overlay">
              <span class="closebtn" onclick="closeSearch()" title="Close Overlay">x</span>
              <div class="overlay-content">
                  <form action="{{ route('search') }}" method="GET">
                      @csrf
                      <input type="text" placeholder="Cari berita disini.." name="search">
                  </form>
              </div>
          </div>
          <!-- End Search -->
      </nav>

  </header>
  <!--Main Navigation-->
