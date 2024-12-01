<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Registro de Vehículo</title>

  <!-- Favicons -->
  <link href="../../assets/img/favicon.png" rel="icon">
  <link href="../../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../../assets/css/style.css" rel="stylesheet">

  <!-- Vendor JS Files -->
  <script src="../../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../../assets/vendor/quill/quill.js"></script>
  <script src="../../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../../assets/js/main.js"></script>
</head>
</head>

<body>
  <?php include '../Partes/header.html'; ?>
  <?php include '../Partes/Sidebar.php'; ?>
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 d-flex flex-column align-items-center justify-content-center">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Registrar Nuevo Vehículo</h5>
                  </div>

                  <form class="row g-3 needs-validation" id="vehicleForm" novalidate>
                    <!-- Identificación del Cliente -->
                    <div class="col-md-12">
                      <label for="clientID" class="form-label">Identificación del Cliente</label>
                      <input type="text" name="clientID" class="form-control" id="clientID" required pattern="^\d{5,10}$">
                      <div class="invalid-feedback">Ingrese la cédula de un cliente válido.</div>
                    </div>

                    <!-- Marca -->
                    <div class="col-md-6">
                      <label for="brand" class="form-label">Marca</label>
                      <input type="text" name="brand" class="form-control" id="brand" required pattern="^[A-Za-z\s]{2,30}$">
                      <div class="invalid-feedback">Ingrese una marca válida.</div>
                    </div>

                    <!-- Modelo -->
                    <div class="col-md-6">
                      <label for="model" class="form-label">Modelo</label>
                      <input type="text" name="model" class="form-control" id="model" required pattern="^[A-Za-z0-9\s-]{2,30}$">
                      <div class="invalid-feedback">Ingrese un modelo válido.</div>
                    </div>

                    <!-- Año -->
                    <div class="col-md-6">
                      <label for="year" class="form-label">Año</label>
                      <input type="text" name="year" class="form-control" id="year" required pattern="^\d{4}$">
                      <div class="invalid-feedback">Ingrese un año válido.</div>
                    </div>

                    <!-- Placa -->
                    <div class="col-md-6">
                      <label for="plate" class="form-label">Placa</label>
                      <input type="text" name="plate" class="form-control" id="plate" required pattern="^[A-Z0-9]{6,8}$">
                      <div class="invalid-feedback">Ingrese una placa válida.</div>
                    </div>

                    <!-- Tipo de Combustible -->
                    <div class="col-md-12">
                      <label for="fuelType" class="form-label">Tipo de Combustible</label>
                      <select class="form-select" name="fuelType" id="fuelType" required>
                        <option value="" selected disabled>Seleccione un tipo de combustible</option>
                        <option value="Gasolina">Gasolina</option>
                        <option value="Diesel">Diésel</option>
                        <option value="Eléctrico">Eléctrico</option>
                      </select>
                      <div class="invalid-feedback">Seleccione un tipo de combustible.</div>
                    </div>

                    <!-- Clave (Llave) -->
                    <div class="col-md-12">
                      <label for="key" class="form-label">Clave (Llave)</label>
                      <input type="text" name="key" class="form-control" id="key" pattern="^[A-Za-z0-9@!#\$%\^\&\*\(\)_\-]{4,20}$">
                      <div class="invalid-feedback">Ingrese una clave válida (4-20 caracteres, letras, números o caracteres especiales).</div>
                    </div>

                    <!-- Botón de registro -->
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Registrar Vehículo</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>
  <?php include '../Partes/footer.php' ?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('vehicleForm');

      // Validación de campos al introducir datos
      form.querySelectorAll('input, select').forEach(field => {
        field.addEventListener('input', () => {
          field.setCustomValidity('');
          if (!field.checkValidity()) {
            field.classList.add('is-invalid');
          } else {
            field.classList.remove('is-invalid');
          }
        });
      });

      // Validación al enviar el formulario
      form.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Validar el formulario completo
        if (!form.checkValidity()) {
          Swal.fire({
            icon: 'error',
            title: 'Formulario incompleto',
            text: 'Por favor complete correctamente todos los campos.',
          });
          return;
        }

        // Procesamiento del registro con fetch
        try {
          const formData = new FormData(form);

          // Mostrar indicador de carga
          Swal.fire({
            title: 'Procesando',
            text: 'Por favor espere...',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });

          const response = await fetch('registro_vehiculo.php', {
            method: 'POST',
            body: formData
          });

          const result = await response.json();

          if (result.success) {
            Swal.fire({
              icon: 'success',
              title: 'Vehículo registrado',
              text: 'El vehículo ha sido registrado exitosamente.',
            }).then(() => {
              form.reset(); // Limpiar el formulario después del registro exitoso
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: result.mensaje || 'Error al registrar vehículo'
            });
          }
        } catch (error) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un error al procesar la solicitud'
          });
        }
      });
    });
  </script>




</body>

</html>
