<!-- ======= Header ======= -->

<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="../dashboard/dashboard.php" class="logo d-flex align-items-center">
      <img src="../../assets/img/Logo.png" alt="Logo del Taller">
    </a>
    <i class="bi bi-list toggle-sidebar-btn" id="toggleSidebar"></i>
  </div><!-- Fin Logo -->

  <div class="search-bar">
    <form class="search-form d-flex align-items-center" method="POST" action="#">
      <input type="text" name="query" placeholder="Buscar vehículo o repuesto" title="Ingrese palabra clave para buscar">
      <button type="submit" title="Buscar"><i class="bi bi-search"></i></button>
    </form>
  </div><!-- Fin Barra de Búsqueda -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

      <li class="nav-item d-block d-lg-none">
        <a class="nav-link nav-icon search-bar-toggle" href="#">
          <i class="bi bi-search"></i>
        </a>
      </li><!-- Fin Icono de Búsqueda-->

      <li class="nav-item dropdown">

        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-bell"></i>
          <span class="badge bg-primary badge-number">3</span>
        </a><!-- Fin Icono de Notificaciones -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
          <li class="dropdown-header">
            Tienes 3 nuevas notificaciones
            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">Ver todas</span></a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="notification-item">
            <i class="bi bi-exclamation-circle text-warning"></i>
            <div>
              <h4>Repuesto bajo de stock</h4>
              <p>El repuesto "Frenos" está bajo de stock, considera reabastecer.</p>
              <p>10 min. atrás</p>
            </div>
          </li>

          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="notification-item">
            <i class="bi bi-check-circle text-success"></i>
            <div>
              <h4>Repuesto reabastecido</h4>
              <p>El repuesto "Aceite de motor" ha sido reabastecido.</p>
              <p>30 min. atrás</p>
            </div>
          </li>

          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="notification-item">
            <i class="bi bi-info-circle text-primary"></i>
            <div>
              <h4>Nuevo repuesto disponible</h4>
              <p>Se ha añadido un nuevo repuesto: "Filtros de aire".</p>
              <p>1 hr. atrás</p>
            </div>
          </li>

          <li>
            <hr class="dropdown-divider">
          </li>
          <li class="dropdown-footer">
            <a href="#">Mostrar todas las notificaciones</a>
          </li>

        </ul><!-- Fin Elementos del Dropdown de Notificaciones -->

      </li><!-- Fin Nav de Notificaciones -->

      <li class="nav-item dropdown pe-3">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="../../assets/img/profile-img.jpg" alt="Perfil" class="rounded-circle">
          <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $usuario['primerNombre'] . ' ' . $usuario['primerApellido'];?></span>
        </a><!-- Fin Icono de Imagen de Perfil -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
              <h6><?php echo $usuario['nombreUsuario']; ?></h6>
              <span><?php echo $usuario['nombreRol']; ?></span>
          </li>
          <li>
              <hr class="dropdown-divider">
          </li>
      
          <li>
              <a class="dropdown-item d-flex align-items-center" href="views/dashboard/users-profile.php">
                  <i class="bi bi-person"></i>
                  <span>Mi Perfil</span>
              </a>
          </li>
          <li>
              <hr class="dropdown-divider">
          </li>
      
          <li>
              <a class="dropdown-item d-flex align-items-center" href="views/dashboard/users-profile.php">
                  <i class="bi bi-gear"></i>
                  <span>Configuración de Cuenta</span>
              </a>
          </li>
          <li>
              <hr class="dropdown-divider">
          </li>
      
          <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                  <i class="bi bi-question-circle"></i>
                  <span>¿Necesitas Ayuda?</span>
              </a>
          </li>
          <li>
              <hr class="dropdown-divider">
          </li>
      
          <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                  <i class="bi bi-box-arrow-right"></i>
                  <span>Cerrar Sesión</span>
              </a>
          </li>
      
      </ul><!-- Fin Elementos del Dropdown de Perfil -->
      </li><!-- Fin Nav de Perfil -->

    </ul>
  </nav><!-- Fin Navegación de Iconos -->

</header><!-- Fin Header -->
