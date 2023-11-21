  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
          </li>
          <h5 class="mt-2">HYBRID OFFICE SPACE</h5>
      </ul>




      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
          <!-- Messages Dropdown Menu -->
          <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="far fa-comments"></i>
                  <span class="badge badge-danger navbar-badge">
                      @if (session('nortification_count'))
                          {{ session('nortification_count') }}
                      @endif
                  </span>
              </a>


              @if (session('nortifications'))
                  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                      @foreach (session('nortifications') as $nortification)
                          <a href="#" class="dropdown-item">
                              <!-- Message Start -->




                              <p class="text-sm p-2">{!! $nortification->message !!}</p>



                              <!-- Message End -->
                          </a>
                      @endforeach
                  </div>
              @endif






          </li>

          <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="fa fa-user"></i>

              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">



                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <!-- Message Start -->
                      <div class="media">
                          <img src="img/avatar.png" alt="User Avatar" class="img-size-50 img-circle mr-3">
                          <div class="media-body">
                              <h3 class="dropdown-item-title">
                                  @if (Auth::user())
                                      {{ Auth::user()->name }}
                                  @endif
                                  <span class="float-right text-sm text-success"><i class="fa fa-circle"
                                          aria-hidden="true"></i></span>
                              </h3>

                              <p class="text-sm  text-success"><i class="far fa-clock mr-1"></i> online</p>
                          </div>
                      </div>
                      <!-- Message End -->
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item dropdown-footer btn text-danger" href="{{ route('logout') }}"> <i
                          class="fa fa-power-off" aria-hidden="true"></i> sign out</a>
              </div>
          </li>


      </ul>
  </nav>
  <!-- /.navbar -->


