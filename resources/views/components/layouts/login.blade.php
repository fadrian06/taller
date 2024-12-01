<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />

  <title>Inicio de sesión ― ServiMotors</title>

  <base href="{{ str_replace('index.php', '', $_SERVER['SCRIPT_NAME']) }}" />

  <!-- Favicons -->
  <link rel="icon" href="./assets/img/favicon.png" />

  <!-- Google Fonts -->
  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" />

  <!-- Vendor CSS Files -->
  <link
    rel="stylesheet"
    href="./assets/vendor/bootstrap/css/bootstrap.min.css" />
  <link
    rel="stylesheet"
    href="./assets/vendor/bootstrap-icons/bootstrap-icons.css" />
  <link rel="stylesheet" href="./assets/vendor/boxicons/css/boxicons.min.css" />
  <link rel="stylesheet" href="./assets/vendor/quill/quill.snow.css" />
  <link rel="stylesheet" href="./assets/vendor/quill/quill.bubble.css" />
  <link rel="stylesheet" href="./assets/vendor/remixicon/remixicon.css" />
  <link rel="stylesheet" href="./assets/vendor/simple-datatables/style.css" />

  <!-- Template Main CSS File -->
  <link rel="stylesheet" href="./assets/css/style.css" />

  <!-- SweetAlert -->
  <link rel="stylesheet" href="assets/css/sweetalert2.min.css">
</head>

<body class="container">
  {{ $slot }}
  <x-go-top />

  <!-- Vendor JS Files -->
  <script src="./assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/vendor/chart.js/chart.umd.js"></script>
  <script src="./assets/vendor/echarts/echarts.min.js"></script>
  <script src="./assets/vendor/quill/quill.js"></script>
  <script src="./assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="./assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="./assets/vendor/php-email-form/validate.js"></script>

  <script src="assets/js/sweetalert2.min.js"></script>

  <!-- Template Main JS File -->
  <script src="./assets/js/main.js"></script>
  <script src="./assets/js/enable-validations.js"></script>
  @stack('scripts')
</body>

</html>
