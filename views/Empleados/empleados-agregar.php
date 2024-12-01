<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Registro de Servicios</title>
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
  <link rel="stylesheet" href="../../assets/vendor/sweetalert2/sweetalert2.min.css">
  <script src="../../assets/vendor/sweetalert2/sweetalert2.min.js"></script>
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
  <?php include '../Partes/header.html'; ?>
  <?php include '../Partes/Sidebar.php'; ?>

  <main>
    <div class="container">
      <section
        class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 d-flex flex-column align-items-center justify-content-center">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Registrar Nuevo Empleado</h5>
                  </div>

                  <form class="row g-3 needs-validation" id="employeeForm" novalidate>

                    <!-- Primer Nombre -->
                    <div class="col-md-6">
                      <label for="firstName" class="form-label">Primer Nombre</label>
                      <input type="text" name="firstName" class="form-control" id="firstName"
                        required pattern="^[A-Za-z\s]{2,30}$">
                      <div class="invalid-feedback">Ingrese un nombre válido (solo letras, hasta
                        30 caracteres).</div>
                    </div>

                    <!-- Segundo Nombre -->
                    <div class="col-md-6">
                      <label for="secondName" class="form-label">Segundo Nombre</label>
                      <input type="text" name="secondName" class="form-control" id="secondName"
                        pattern="^[A-Za-z\s]{2,30}$">
                      <div class="invalid-feedback">Ingrese un nombre válido (solo letras, hasta
                        30 caracteres).</div>
                    </div>

                    <!-- Primer Apellido -->
                    <div class="col-md-6">
                      <label for="lastName1" class="form-label">Primer Apellido</label>
                      <input type="text" name="lastName1" class="form-control" id="lastName1"
                        required pattern="^[A-Za-z\s]{2,30}$">
                      <div class="invalid-feedback">Ingrese un apellido válido (solo letras, hasta
                        30 caracteres).</div>
                    </div>

                    <!-- Segundo Apellido -->
                    <div class="col-md-6">
                      <label for="lastName2" class="form-label">Segundo Apellido</label>
                      <input type="text" name="lastName2" class="form-control" id="lastName2"
                        pattern="^[A-Za-z\s]{2,30}$">
                      <div class="invalid-feedback">Ingrese un apellido válido (solo letras, hasta
                        30 caracteres).</div>
                    </div>

                    <!-- Cedula -->
                    <div class="col-md-6">
                      <label for="cedula" class="form-label">Cédula</label>
                      <input type="text" name="cedula" class="form-control" id="cedula" required
                        pattern="^[VE]{1}[0-9]{7,8}$">
                      <div class="invalid-feedback">Ingrese una cédula válida (ej. V12345678).
                      </div>
                    </div>

                    <!-- Género -->
                    <div class="col-md-6">
                      <label for="gender" class="form-label">Género</label>
                      <select class="form-select" name="gender" id="gender" required>
                        <option value="" selected disabled>Seleccione el género</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                        <option value="Otro">Otro</option>
                      </select>
                      <div class="invalid-feedback">Seleccione un género.</div>
                    </div>

                    <!-- Fecha de Nacimiento -->
                    <div class="col-md-6">
                      <label for="birthDate" class="form-label">Fecha de Nacimiento</label>
                      <input type="date" name="birthDate" class="form-control" id="birthDate"
                        required>
                      <div class="invalid-feedback">Seleccione una fecha válida.</div>
                    </div>

                    <!-- Correo Electrónico -->
                    <div class="col-md-6">
                      <label for="email" class="form-label">Correo Electrónico</label>
                      <input type="email" name="email" class="form-control" id="email" required>
                      <div class="invalid-feedback">Ingrese un correo electrónico válido.</div>
                    </div>

                    <!-- Teléfono Local -->
                    <div class="col-md-6">
                      <label for="phoneLocal" class="form-label">Teléfono Local</label>
                      <input type="text" name="phoneLocal" class="form-control" id="phoneLocal"
                        required pattern="^\d{11}$">
                      <div class="invalid-feedback">Ingrese un teléfono válido de 11 dígitos.
                      </div>
                    </div>

                    <!-- Teléfono Personal -->
                    <div class="col-md-6">
                      <label for="phonePersonal" class="form-label">Teléfono Personal</label>
                      <input type="text" name="phonePersonal" class="form-control"
                        id="phonePersonal" required pattern="^\d{11}$">
                      <div class="invalid-feedback">Ingrese un teléfono válido de 11 dígitos.
                      </div>
                    </div>

                    <!-- Teléfono Adicional (Opcional) -->
                    <div class="col-md-6">
                      <label for="phoneOptional" class="form-label">Teléfono Adicional</label>
                      <input type="text" name="phoneOptional" class="form-control"
                        id="phoneOptional" pattern="^\d{11}$">
                      <div class="invalid-feedback">Ingrese un teléfono válido de 11 dígitos
                        (opcional).</div>
                    </div>

                    <!-- Dirección -->
                    <div class="col-md-6">
                      <label for="municipio" class="form-label">Municipio</label>
                      <input type="text" name="municipio" class="form-control" id="municipio"
                        required pattern="^[A-Za-z\s]{2,50}$">
                      <div class="invalid-feedback">Ingrese un municipio válido.</div>
                    </div>

                    <div class="col-md-6">
                      <label for="parroquia" class="form-label">Parroquia</label>
                      <input type="text" name="parroquia" class="form-control" id="parroquia"
                        required pattern="^[A-Za-z\s]{2,50}$">
                      <div class="invalid-feedback">Ingrese una parroquia válida.</div>
                    </div>

                    <div class="col-md-6">
                      <label for="sector" class="form-label">Sector</label>
                      <input type="text" name="sector" class="form-control" id="sector" required
                        pattern="^[A-Za-z\s]{2,50}$">
                      <div class="invalid-feedback">Ingrese un sector válido.</div>
                    </div>

                    <div class="col-md-6">
                      <label for="avenue" class="form-label">Avenida</label>
                      <input type="text" name="avenue" class="form-control" id="avenue" required
                        pattern="^[A-Za-z\s]{2,50}$">
                      <div class="invalid-feedback">Ingrese una avenida válida.</div>
                    </div>

                    <div class="col-md-6">
                      <label for="addressDetail" class="form-label">Casa o Apartamento</label>
                      <input type="text" name="addressDetail" class="form-control"
                        id="addressDetail" required pattern="^[A-Za-z0-9\s]{2,100}$">
                      <div class="invalid-feedback">Ingrese una dirección válida.</div>
                    </div>

                    <!-- Rol -->
                    <div class="col-md-6">
                      <label for="role" class="form-label">Rol</label>
                      <select class="form-select" name="role" id="role" required>
                        <option value="" selected disabled>Seleccione el rol</option>
                        <option value="Mecánico">Mecánico</option>
                        <option value="Electricista">Electricista</option>
                        <option value="Transmisión">Transmisión</option>
                        <option value="Aire Acondicionado">Aire Acondicionado</option>
                        <option value="Ayudante">Ayudante</option>
                        <option value="Mensajero">Mensajero</option>
                        <option value="Limpieza">Limpieza</option>
                      </select>
                      <div class="invalid-feedback">Seleccione un rol.</div>
                    </div>

                    <!-- Experiencia Laboral -->
                    <div class="col-md-6">
                      <label for="workExperience" class="form-label">Experiencia Laboral</label>
                      <input type="text" name="workExperience" class="form-control"
                        id="workExperience" required pattern="^.{10,300}$">
                      <div class="invalid-feedback">Describa la experiencia laboral (mínimo 10
                        caracteres).</div>
                    </div>

                    <!-- Certificación -->
                    <div class="col-md-6">
                      <label for="certification" class="form-label">Certificación</label>
                      <input type="text" name="certification" class="form-control"
                        id="certification" required pattern="^.{5,100}$">
                      <div class="invalid-feedback">Ingrese una certificación válida (mínimo 5
                        caracteres).</div>
                    </div>

                    <!-- Habilidad Técnica -->
                    <div class="col-md-6">
                      <label for="technicalSkill" class="form-label">Habilidad Técnica</label>
                      <input type="text" name="technicalSkill" class="form-control"
                        id="technicalSkill" required pattern="^.{5,100}$">
                      <div class="invalid-feedback">Describa la habilidad técnica (mínimo 5
                        caracteres).</div>
                    </div>

                    <!-- Fecha de Ingreso -->
                    <div class="col-md-6">
                      <label for="entryDate" class="form-label">Fecha de Ingreso</label>
                      <input type="date" name="entryDate" class="form-control" id="entryDate"
                        required>
                      <div class="invalid-feedback">Seleccione una fecha de ingreso válida.</div>
                    </div>

                    <!-- Estado -->
                    <div class="col-md-6">
                      <label for="status" class="form-label">Estado</label>
                      <select class="form-select" name="status" id="status" required>
                        <option value="" selected disabled>Seleccione el estado</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                      </select>
                      <div class="invalid-feedback">Seleccione el estado.</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Registrar
                        Empleado</button>
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



</body>
<script>
  document.getElementById("employeeForm").addEventListener("submit", function(e) {
    e.preventDefault();

    if (this.checkValidity() === false) {
      e.stopPropagation();
      this.classList.add("was-validated");
      return;
    }

    // Simulate successful registration with SweetAlert
    Swal.fire({
      icon: "success",
      title: "Empleado registrado",
      text: "El registro se ha realizado exitosamente.",
      showConfirmButton: true,
      confirmButtonText: "Aceptar",
    }).then(() => {
      // Aquí podrías redirigir a otra página o limpiar el formulario si es necesario
      document.getElementById("employeeForm").reset();
    });
  });
</script>
