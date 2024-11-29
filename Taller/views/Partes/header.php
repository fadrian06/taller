<?php

use Jenssegers\Date\Date;

require_once __DIR__ . '/../../vendor/autoload.php';

const CLASES_ICONO = [
  'Repuesto bajo en stock' => 'bi bi-exclamation-circle text-warning',
  'Repuesto reabastecido' => 'bi bi-check-circle text-success',
  'Nuevo repuesto disponible' => 'bi bi-info-circle text-primary'
];

const PLANTILLA_MENSAJE_NOTIFICACION = [
  'Repuesto bajo en stock' => 'El repuesto "%s" está bajo de stock, considera reabastecer.',
  'Repuesto reabastecido' => 'El repuesto "%s" ha sido reabastecido.',
  'Nuevo repuesto disponible' => 'Se ha añadido un nuevo repuesto: "%s".'
];

$notificaciones = [
  [
    'tipo' => 'Repuesto bajo en stock',
    'repuesto' => 'Frenos',
    'fecha' => '2024-11-28 23:07:00'
  ],
  [
    'tipo' => 'Repuesto reabastecido',
    'repuesto' => 'Aceite de motor',
    'fecha' => '2024-11-28 22:48:00'
  ],
  [
    'tipo' => 'Nuevo repuesto disponible',
    'repuesto' => 'Filtros de aire',
    'fecha' => '2024-11-28 22:19:00'
  ]
];

date_default_timezone_set('America/Caracas');
Date::setLocale('es');

?>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="../dashboard/dashboard.php" class="logo d-flex align-items-center">
      <img src="../../assets/img/Logo.png" alt="Logo del Taller" />
    </a>
    <i class="bi bi-list toggle-sidebar-btn" id="toggleSidebar"></i>
  </div><!-- Fin Logo -->

  <div class="search-bar">
    <form class="search-form d-flex align-items-center" method="post" action="javascript:">
      <input type="search" name="query" placeholder="Buscar vehículo o repuesto" title="Ingrese palabra clave para buscar" />
      <button title="Buscar">
        <i class="bi bi-search"></i>
      </button>
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
            Tienes <?= count($notificaciones ?? []) ?> nuevas notificaciones
            <a href="#">
              <span class="badge rounded-pill bg-primary p-2 ms-2">Ver todas</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider" />
          </li>

          <?php foreach ($notificaciones as $notificacion): ?>
            <li class="notification-item">
              <i class="<?= CLASES_ICONO[$notificacion['tipo']] ?? '' ?>"></i>
              <div>
                <h4><?= $notificacion['tipo'] ?></h4>
                <p>
                  <?= sprintf(PLANTILLA_MENSAJE_NOTIFICACION[$notificacion['tipo']], $notificacion['repuesto']) ?>
                </p>
                <p><?= ucfirst((new Date($notificacion['fecha']))->ago()) ?></p>
              </div>
            </li>
            <li>
              <hr class="dropdown-divider" />
            </li>
          <?php endforeach ?>

          <li class="dropdown-footer">
            <a href="javascript:">Mostrar todas las notificaciones</a>
          </li>

        </ul><!-- Fin Elementos del Dropdown de Notificaciones -->

      </li><!-- Fin Nav de Notificaciones -->

      <li class="nav-item dropdown pe-3">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="../../assets/img/profile-img.jpg" alt="Perfil" class="rounded-circle" />
          <span class="d-none d-md-block dropdown-toggle ps-2">
            <?= "{$usuario['primerNombre']} {$usuario['primerApellido']}" ?>
          </span>
        </a><!-- Fin Icono de Imagen de Perfil -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6><?= $usuario['nombreUsuario'] ?></h6>
            <span><?= $usuario['nombreRol'] ?></span>
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
