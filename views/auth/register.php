<?php
require_once "../../config/ManejoUsuario.php"
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Registro de Usuario</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../../assets/img/favicon.png" rel="icon">
  <link href="../../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

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
  <link href="../../assets/css/Mystyle.css" rel="stylesheet">

  <!-- SweetAlert -->
  <link rel="stylesheet" href="../../assets/css/sweetalert2.min.css">
  <script src="../../assets/js/sweetalert2.min.js"></script>
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

<body>
  <?php include '../Partes/header.php'; ?>
  <?php include '../Partes/Sidebar.php'; ?>
  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a class="logo d-flex align-items-center w-auto">
                  <img src="../../assets/img/logo.png" alt="" class="login-logo">
                </a>
              </div>

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Registrar Nuevo Usuario</h5>
                  </div>

                  <form class="row g-3 needs-validation" id="userForm" novalidate>
                    <!-- Primer nombre -->
                    <div class="col-md-6">
                      <label for="firstName" class="form-label">Primer Nombre</label>
                      <input type="text" name="firstName" class="form-control" id="firstName" required
                        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ]{2,30}$">
                      <div class="invalid-feedback">Por favor ingrese un nombre válido.</div>
                    </div>

                    <!-- Segundo nombre -->
                    <div class="col-md-6">
                      <label for="secondName" class="form-label">Segundo Nombre</label>
                      <input type="text" name="secondName" class="form-control" id="secondName"
                        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ]{2,30}$">
                    </div>

                    <!-- Primer apellido -->
                    <div class="col-md-6">
                      <label for="firstSurname" class="form-label">Primer Apellido</label>
                      <input type="text" name="firstSurname" class="form-control" id="firstSurname" required
                        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ]{2,30}$">
                      <div class="invalid-feedback">Por favor ingrese un apellido válido.</div>
                    </div>

                    <!-- Segundo apellido -->
                    <div class="col-md-6">
                      <label for="secondSurname" class="form-label">Segundo Apellido</label>
                      <input type="text" name="secondSurname" class="form-control" id="secondSurname"
                        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ]{2,30}$">
                    </div>

                    <!-- Cédula -->
                    <div class="col-md-6">
                      <label for="cedula" class="form-label">Cédula</label>
                      <input type="text" name="cedula" class="form-control" id="cedula" pattern="^[V|E]-\d{5,8}$"
                        required>
                      <div class="invalid-feedback">Por favor ingrese una cédula válida (V-12345678 o E-12345678).</div>
                    </div>

                    <!-- Teléfono -->
                    <div class="col-md-6">
                      <label for="phone" class="form-label">Teléfono</label>
                      <input type="text" name="phone" class="form-control" id="phone" required pattern="^\d{11}$">
                      <div class="invalid-feedback">Por favor ingrese un número de teléfono válido de 11 dígitos.</div>
                    </div>

                    <!-- Correo -->
                    <div class="col-md-12">
                      <label for="email" class="form-label">Correo Electrónico</label>
                      <input type="email" name="email" class="form-control" id="email" required
                        pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
                      <div class="invalid-feedback">Por favor ingrese un correo electrónico válido.</div>
                    </div>

                    <!-- Nombre de usuario -->
                    <div class="col-md-12">
                      <label for="username" class="form-label">Nombre de Usuario</label>
                      <input type="text" name="username" class="form-control" id="username" required
                        pattern="^[a-zA-Z0-9_]{4,20}$">
                      <div class="invalid-feedback">Por favor ingrese un nombre de usuario válido.</div>
                    </div>

                    <!-- Contraseña -->
                    <div class="col-md-6">
                      <label for="password" class="form-label">Contraseña</label>
                      <input type="password" name="password" class="form-control" id="password" required
                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$">
                      <div class="invalid-feedback">La contraseña debe tener al menos una letra mayúscula, una
                        minúscula, un número y un carácter especial.</div>
                    </div>

                    <!-- Confirmar contraseña -->
                    <div class="col-md-6">
                      <label for="confirmPassword" class="form-label">Confirmar Contraseña</label>
                      <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" required>
                      <div class="invalid-feedback">Por favor confirme su contraseña.</div>
                    </div>

                    <!-- Rol del usuario -->
                    <div class="col-md-12">
                      <label for="role" class="form-label">Rol</label>
                      <select class="form-select" name="role" id="role" required>
                        <option value="" selected disabled>Seleccione un rol</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Secretaría">Secretaría</option>
                      </select>
                      <div class="invalid-feedback">Por favor seleccione un rol.</div>
                    </div>

                    <!-- Botón de registro -->
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Registrar</button>
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



  <!-- SweetAlert y Validación -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const form = document.getElementById('userForm');
      const passwordField = document.getElementById('password');
      const confirmPasswordField = document.getElementById('confirmPassword');
      const cedulaField = document.getElementById('cedula');

      // Expresión regular para validar cédula
      const cedulaRegex = /^[V|E]-\d{5,8}$/;

      // Función para validar que las contraseñas coincidan
      function validatePasswords() {
        if (passwordField.value !== confirmPasswordField.value) {
          confirmPasswordField.setCustomValidity("Las contraseñas no coinciden");
          confirmPasswordField.classList.add('is-invalid');
          return false;
        } else {
          confirmPasswordField.setCustomValidity("");
          confirmPasswordField.classList.remove('is-invalid');
          return true;
        }
      }

      // Validación de cada campo con el evento "input"
      form.querySelectorAll('input, select').forEach(field => {
        field.addEventListener('input', () => {
          field.setCustomValidity('');
          if (!field.checkValidity()) {
            field.classList.add('is-invalid');
          } else {
            field.classList.remove('is-invalid');
          }

          // Validar el campo de cédula
          if (field === cedulaField) {
            if (!cedulaRegex.test(cedulaField.value)) {
              cedulaField.setCustomValidity('Por favor ingrese una cédula válida (V-12345678 o E-12345678).');
              cedulaField.classList.add('is-invalid');
            } else {
              cedulaField.setCustomValidity('');
              cedulaField.classList.remove('is-invalid');
            }
          }
        });
      });

      // Validar contraseñas cuando cambien
      passwordField.addEventListener('input', validatePasswords);
      confirmPasswordField.addEventListener('input', validatePasswords);

      // Validación al enviar el formulario
      form.addEventListener('submit', async function (e) {
        e.preventDefault();

        // Validar coincidencia de contraseñas
        if (!validatePasswords()) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Las contraseñas no coinciden.',
          });
          return;
        }

        // Validar cédula antes de enviar el formulario
        if (!cedulaRegex.test(cedulaField.value)) {
          cedulaField.setCustomValidity('Por favor ingrese una cédula válida (V-12345678 o E-12345678).');
          cedulaField.classList.add('is-invalid');
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor ingrese una cédula válida siguiendo la estructura: (V-12345678 o E-12345678).',
          });
          return;
        }

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

          const response = await fetch('../../CRUD/Usuarios/RegistroUsuario.php', {
            method: 'POST',
            body: formData
          });

          const result = await response.json();

          if (result.success) {
            Swal.fire({
              icon: 'success',
              title: 'Usuario registrado',
              text: 'El usuario ha sido registrado exitosamente.',
            }).then(() => {
              form.reset(); // Limpiar el formulario después del registro exitoso
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: result.mensaje || (Array.isArray(result.errores) ? result.errores.join('\n') : 'Error al registrar usuario')
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