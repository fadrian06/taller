<?php

require_once '../../config/ManejoUsuario.php';

// Incluir el archivo con la clase Database
require_once '../../config/Database.php';

// Crear una instancia de la clase Database
$database = new Database;
$conn = $database->getConnection();

// Consulta para obtener los datos de los clientes
$sql = "
  SELECT
    c.cedula AS 'Cédula',
    c.primerNombre AS 'Primer Nombre',
    c.segundoNombre AS 'Segundo Nombre',
    c.primerApellido AS 'Primer Apellido',
    c.segundoApellido AS 'Segundo Apellido',
    t.telefonoPersonal AS 'Teléfono Personal',
    t.telefonoFijo AS 'Teléfono Fijo',
    t.telefonoOpcional AS 'Teléfono Opcional',
    CONCAT(ca.detalleCasaApartamento, ', ', cl.nombreCalle, ', ', av.nombreAvenida, ', ', p.nombreParroquia, ', ', m.nombreMunicipio, ', ', e.nombreEstado) AS 'Dirección'
  FROM Clientes c
  JOIN Telefonos t ON c.cedula = t.cedulaCliente
  JOIN Direcciones d ON c.cedula = d.cedulaCliente
  JOIN CasasApartamentos ca ON d.casaApartamentoId = ca.casaApartamentoId
  JOIN Calles cl ON ca.calleId = cl.calleId
  JOIN Avenidas av ON cl.avenidaId = av.avenidaId
  JOIN Parroquias p ON av.parroquiaId = p.parroquiaId
  JOIN Municipios m ON p.municipioId = m.municipioId
  JOIN Estados e ON m.estadoId = e.estadoId
";

// Ejecutar la consulta y mostrar los datos en la tabla
$stmt = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />

  <title>Registro de Clientes</title>

  <!-- Favicons -->
  <link rel="icon" href="../../assets/img/favicon.png" />

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet" />

  <!-- Vendor CSS Files -->
  <link
    rel="stylesheet"
    href="../../assets/vendor/bootstrap/css/bootstrap.min.css" />
  <link
    rel="stylesheet"
    href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" />
  <link
    rel="stylesheet"
    href="../../assets/vendor/boxicons/css/boxicons.min.css" />
  <link rel="stylesheet" href="../../assets/vendor/quill/quill.snow.css" />
  <link rel="stylesheet" href="../../assets/vendor/quill/quill.bubble.css" />
  <link rel="stylesheet" href="../../assets/vendor/remixicon/remixicon.css" />
  <link
    rel="stylesheet"
    href="../../assets/vendor/simple-datatables/style.css" />

  <!-- Template Main CSS File -->
  <link rel="stylesheet" href="../../assets/css/style.css" />
  <link rel="stylesheet" href="../../assets/css/Mystyle.css" />

  <!-- SweetAlert -->
  <link rel="stylesheet" href="../../assets/vendor/sweetalert2/sweetalert2.min.css" />
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

  <!-- DataTables CSS -->
  <link
    rel="stylesheet"
    href="../../assets/vendor/simple-datatables/jquery.dataTables.min.css" />
  <link
    rel="stylesheet"
    href="../../assets/vendor/simple-datatables/responsive.dataTables.min.css" />

  <!-- JavaScript de jQuery y Bootstrap -->
  <script src="../../assets/vendor/simple-datatables/jquery-3.6.0.min.js"></script>

  <!-- DataTables JS -->
  <script src="../../assets/vendor/simple-datatables/jquery.dataTables.min.js"></script>
  <script src="../../assets/vendor/simple-datatables/dataTables.responsive.min.js"></script>
</head>

<body>
  <?php include '../Partes/header.php' ?>
  <?php include '../Partes/Sidebar.php' ?>

  <main id="main" class="main">
    <div class="container py-5 d-flex justify-content-center align-items-center">
      <!-- Botón para abrir la ventana de registro -->
      <button class="btn btn-primary" id="registerClientButton">
        Registrar Cliente
      </button>
    </div>

    <div class="container py-5">
      <h2 class="text-center mb-4">Clientes Registrados</h2>
      <div class="table-responsive">
        <table
          id="clientesTable"
          class="table table-striped dt-responsive nowrap">
          <thead class="table-dark">
            <tr>
              <th>Cédula</th>
              <th>Primer Nombre</th>
              <th>Segundo Nombre</th>
              <th>Primer Apellido</th>
              <th>Segundo Apellido</th>
              <th>Teléfono Personal</th>
              <th>Teléfono Fijo</th>
              <th>Teléfono Opcional</th>
              <th>Dirección</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
              <tr>
                <td><?= $row['Cédula'] ?></td>
                <td><?= $row['Primer Nombre'] ?></td>
                <td><?= $row['Segundo Nombre'] ?></td>
                <td><?= $row['Primer Apellido'] ?></td>
                <td><?= $row['Segundo Apellido'] ?></td>
                <td><?= $row['Teléfono Personal'] ?></td>
                <td><?= $row['Teléfono Fijo'] ?></td>
                <td><?= $row['Teléfono Opcional'] ?></td>
                <td><?= $row['Dirección'] ?></td>
                <td>
                  <button
                    class="btn btn-warning btn-sm"
                    onclick="editClient('<?= $row['Cédula'] ?>')">
                    Modificar
                  </button>
                  <button
                    class="btn btn-danger btn-sm"
                    onclick="deleteClient('<?= $row['Cédula'] ?>')">
                    Eliminar
                  </button>
                </td>
              </tr>
            <?php endwhile ?>
          </tbody>
        </table>
      </div>
    </div>

    <script>
      $(document).ready(() => {
        $('#clientesTable').DataTable({
          responsive: true,
          language: {
            url: '../../assets/vendor/simple-datatables/es-ES.json'
          }
        })
      })

      // Función para editar cliente
      function editClient(cedula) {
        // Redirigir a una página de edición (esto es un ejemplo, personaliza según tu aplicación)
        window.location.href = `editar_cliente.php?cedula=${cedula}`
      }

      // Función para eliminar cliente
      function deleteClient(cedula) {
        Swal.fire({
          title: '¿Estás seguro?',
          text: "¡Esta acción eliminará todos los datos asociados con este cliente!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar'
        }).then(result => {
          if (result.isConfirmed) {
            $.ajax({
              url: '../../CRUD/Clientes/eliminar_cliente.php',
              method: 'POST',
              data: {
                cedula: cedula
              },
              dataType: 'json',
              success(response) {
                if (response.success) {
                  Swal.fire({
                    icon: 'success',
                    title: '¡Eliminado!',
                    text: '¡Cliente eliminado exitosamente!',
                    showConfirmButton: true
                  }).then(() => {
                    // Recargar la tabla sin recargar la página
                    $('#clientesTable').DataTable().ajax.reload()
                    // Si prefieres recargar la página completa, usa:
                    location.reload()
                  })
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.mensaje || 'Hubo un error al eliminar el cliente'
                  })
                }
              },
              error() {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Hubo un problema de conexión al intentar eliminar el cliente'
                })
              }
            })
          }
        })
      }
    </script>
    <!-- Modal para editar cliente -->
    <div class="modal fade" id="editClientModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editClientModalLabel">
              Editar Cliente
            </h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="editClientForm" class="row g-3 needs-validation" novalidate>
              <!-- Sección de Datos Personales -->
              <h6 class="mb-3 fw-bold fs-4">Datos Personales</h6>

              <!-- Primer Nombre -->
              <div class="col-md-6">
                <label for="editFirstName" class="form-label">
                  Primer Nombre
                </label>
                <input
                  name="firstName"
                  id="editFirstName"
                  class="form-control"
                  required
                  pattern="[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{1,29}" />
                <div class="invalid-feedback">
                  Por favor, ingrese un nombre válido con la primera letra en
                  mayúscula.
                </div>
              </div>

              <!-- Segundo Nombre -->
              <div class="col-md-6">
                <label for="editSecondName" class="form-label">
                  Segundo Nombre
                </label>
                <input
                  name="secondName"
                  id="editSecondName"
                  class="form-control"
                  pattern="[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{1,29}" />
                <div class="invalid-feedback">
                  Por favor, ingrese un nombre válido con la primera letra en
                  mayúscula.
                </div>
              </div>

              <!-- Primer Apellido -->
              <div class="col-md-6">
                <label for="editFirstSurname" class="form-label">
                  Primer Apellido
                </label>
                <input
                  name="firstSurname"
                  id="editFirstSurname"
                  class="form-control"
                  required
                  pattern="[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{1,29}" />
                <div class="invalid-feedback">
                  Por favor, ingrese un apellido válido con la primera letra
                  en mayúscula.
                </div>
              </div>

              <!-- Segundo Apellido -->
              <div class="col-md-6">
                <label for="editSecondSurname" class="form-label">
                  Segundo Apellido
                </label>
                <input
                  name="secondSurname"
                  id="editSecondSurname"
                  class="form-control"
                  pattern="[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{1,29}" />
                <div class="invalid-feedback">
                  Por favor, ingrese un apellido válido con la primera letra
                  en mayúscula.
                </div>
              </div>

              <!-- Cédula -->
              <div class="col-md-6">
                <label for="cedula" class="form-label">
                  Cédula de Identidad
                </label>
                <input
                  name="cedula"
                  id="editcedula"
                  class="form-control"
                  required
                  pattern="[VE]-\d{6,8}" />
                <div class="invalid-feedback">
                  Formato válido: V-123456 o E-123456.
                </div>
              </div>

              <!-- Teléfonos -->
              <div class="col-md-4">
                <label for="editPersonalPhone" class="form-label">
                  Teléfono Personal
                </label>
                <input
                  name="personalPhone"
                  id="editPersonalPhone"
                  class="form-control"
                  required
                  pattern="\d{11}" />
                <div class="invalid-feedback">Debe tener 11 dígitos.</div>
              </div>

              <div class="col-md-4">
                <label for="editLandlinePhone" class="form-label">
                  Teléfono Fijo
                </label>
                <input
                  name="landlinePhone"
                  id="editLandlinePhone"
                  class="form-control"
                  pattern="\d{11}" />
                <div class="invalid-feedback">Debe tener 11 dígitos.</div>
              </div>

              <div class="col-md-4">
                <label for="editOptionalPhone" class="form-label">
                  Teléfono Opcional
                </label>
                <input
                  name="optionalPhone"
                  id="editOptionalPhone"
                  class="form-control"
                  pattern="\d{11}" />
                <div class="invalid-feedback">Debe tener 11 dígitos.</div>
              </div>

              <!-- Dirección -->
              <h6 class="mb-3 fw-bold fs-4">Dirección Personal</h6>

              <div class="col-md-6">
                <label for="editState" class="form-label">Estado</label>
                <input
                  name="state"
                  id="editState"
                  class="form-control"
                  required
                  pattern="[A-ZÁÉÍÓÚ][a-záéíóúñ\s]*" />
                <div class="invalid-feedback">
                  Ingrese un estado válido (primera letra mayúscula).
                </div>
              </div>

              <div class="col-md-6">
                <label for="editMunicipality" class="form-label">
                  Municipio
                </label>
                <input
                  name="municipality"
                  id="editMunicipality"
                  class="form-control"
                  required
                  pattern="[A-ZÁÉÍÓÚ][a-záéíóúñ\s]*" />
                <div class="invalid-feedback">
                  Ingrese un municipio válido (primera letra mayúscula).
                </div>
              </div>

              <div class="col-md-6">
                <label for="editParish" class="form-label">Parroquia</label>
                <input
                  name="parish"
                  id="editParish"
                  class="form-control"
                  required
                  pattern="[A-ZÁÉÍÓÚ][a-záéíóúñ\s]*">
                <div class="invalid-feedback">
                  Ingrese una parroquia válida (primera letra mayúscula).
                </div>
              </div>

              <div class="col-md-6">
                <label for="editAvenue" class="form-label">Avenida</label>
                <input
                  name="avenue"
                  id="editAvenue"
                  class="form-control"
                  required
                  pattern="[A-ZÁÉÍÓÚ][a-záéíóúñ0-9\s\-]{1,49}">
                <div class="invalid-feedback">
                  Ingrese una avenida válida (letras, números, guiones).
                </div>
              </div>

              <div class="col-md-6">
                <label for="editStreet" class="form-label">Calle</label>
                <input
                  name="street"
                  id="editStreet"
                  class="form-control"
                  required
                  pattern="[A-ZÁÉÍÓÚ][a-záéíóúñ0-9\s\-]{1,49}" />
                <div class="invalid-feedback">
                  Ingrese una calle válida (letras, números, guiones).
                </div>
              </div>

              <div class="col-md-6">
                <label for="editHouseOrApartment" class="form-label">
                  Casa o Apartamento
                </label>
                <input
                  name="houseOrApartment"
                  id="editHouseOrApartment"
                  class="form-control"
                  required
                  pattern="[A-ZÁÉÍÓÚ][a-záéíóúñ0-9\s#\-]{1,49}">
                <div class="invalid-feedback">
                  Ingrese una dirección válida (letras, números, guiones, #).
                </div>
              </div>

              <!-- Botón para guardar cambios -->
              <div class="col-12">
                <button class="btn btn-success w-100">Guardar Cambios</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script>
      function editClient(cedula) {
        const modal = new bootstrap.Modal(document.getElementById('editClientModal'))
        modal.show()

        // Realizar una solicitud AJAX para obtener los datos del cliente
        fetch(`../../CRUD/Clientes/obtener_cliente.php?cedula=${cedula}`)
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Llenar los campos del formulario con los datos obtenidos
              document.getElementById('editFirstName').value = data.cliente.primerNombre
              document.getElementById('editSecondName').value = data.cliente.segundoNombre || ''
              document.getElementById('editFirstSurname').value = data.cliente.primerApellido
              document.getElementById('editSecondSurname').value = data.cliente.segundoApellido || ''
              document.getElementById('editcedula').value = `V-${data.cliente.cedula}`
              document.getElementById('editPersonalPhone').value = data.cliente.telefonoPersonal
              document.getElementById('editLandlinePhone').value = data.cliente.telefonoFijo || ''
              document.getElementById('editOptionalPhone').value = data.cliente.telefonoOpcional || ''
              document.getElementById('editState').value = data.cliente.estado
              document.getElementById('editMunicipality').value = data.cliente.municipio
              document.getElementById('editParish').value = data.cliente.parroquia
              document.getElementById('editAvenue').value = data.cliente.avenida
              document.getElementById('editStreet').value = data.cliente.calle
              document.getElementById('editHouseOrApartment').value = data.cliente.casaApartamento
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'No se pudieron cargar los datos del cliente',
              });
            }
          })
          .catch(error => {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Ocurrió un error al obtener los datos del cliente',
            });
            console.error('Error:', error);
          });
      }

      document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('editClientForm');

        // Validación en cada input
        form.querySelectorAll('input, select').forEach(field => {
          field.addEventListener('input', () => {
            field.setCustomValidity('')

            if (!field.checkValidity()) {
              field.classList.add('is-invalid')
            } else {
              field.classList.remove('is-invalid')
            }
          })
        })

        form.addEventListener('submit', async e => {
          e.preventDefault();

          if (!form.checkValidity()) {
            return Swal.fire({
              icon: 'error',
              title: 'Formulario incompleto',
              text: 'Por favor complete correctamente todos los campos.',
            })
          }

          try {
            const formData = new FormData(form)

            Swal.fire({
              title: 'Procesando',
              text: 'Por favor espere...',
              allowOutsideClick: false,
              didOpen() {
                Swal.showLoading()
              }
            })

            const response = await fetch('../../CRUD/Clientes/editar_cliente.php', {
              method: 'POST',
              body: formData
            })

            const result = await response.json()

            if (result.success) {
              Swal.fire({
                icon: 'success',
                title: 'Cliente actualizado',
                text: 'Los datos del cliente se actualizaron correctamente.',
              }).then(() => {
                form.reset()
                modal.hide()
              })
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: result.mensaje || 'Error al actualizar cliente',
              })
            }
          } catch (error) {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Ocurrió un error al procesar la solicitud',
            })
          }
        })
      })
    </script>

    <!-- Modal para registrar Clientes -->
    <div class="modal fade" id="registerClientModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="registerClientModalLabel">
              Registrar Nuevo Cliente
            </h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="clientForm" class="row g-3 needs-validation" novalidate>
              <!-- Sección de Datos Personales -->
              <h6 class="mb-3 fw-bold fs-4">Datos Personales</h6>

              <!-- Primer Nombre -->
              <div class="col-md-6">
                <label for="firstName" class="form-label">Primer Nombre</label>
                <input
                  name="firstName"
                  id="firstName"
                  class="form-control"
                  required
                  pattern="[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{1,29}">
                <div class="invalid-feedback">
                  Por favor, ingrese un nombre válido con la primera letra en
                  mayúscula.
                </div>
              </div>

              <!-- Segundo Nombre -->
              <div class="col-md-6">
                <label for="secondName" class="form-label">Segundo Nombre</label>
                <input type="text" name="secondName" id="secondName" class="form-control"
                  pattern="^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{1,29}$">
                <div class="invalid-feedback">Por favor, ingrese un nombre válido con la primera letra en mayúscula.</div>
              </div>

              <!-- Primer Apellido -->
              <div class="col-md-6">
                <label for="firstSurname" class="form-label">Primer Apellido</label>
                <input type="text" name="firstSurname" id="firstSurname" class="form-control" required
                  pattern="^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{1,29}$">
                <div class="invalid-feedback">Por favor, ingrese un apellido válido con la primera letra en mayúscula.
                </div>
              </div>

              <!-- Segundo Apellido -->
              <div class="col-md-6">
                <label for="secondSurname" class="form-label">Segundo Apellido</label>
                <input type="text" name="secondSurname" id="secondSurname" class="form-control"
                  pattern="^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{1,29}$">
                <div class="invalid-feedback">Por favor, ingrese un apellido válido con la primera letra en mayúscula.
                </div>
              </div>

              <!-- Cédula -->
              <div class="col-md-6">
                <label for="cedula" class="form-label">Cédula de Identidad</label>
                <input type="text" name="cedula" id="cedula" class="form-control" required pattern="^[VE]-\d{6,8}$">
                <div class="invalid-feedback">Formato válido: V-123456 o E-123456.</div>
              </div>

              <!-- Teléfonos -->
              <div class="col-md-4">
                <label for="personalPhone" class="form-label">
                  Teléfono Personal
                </label>
                <input
                  type="tel"
                  name="personalPhone"
                  id="personalPhone"
                  class="form-control"
                  required
                  pattern="(\+(\d{1,3}|\d{1}-\d{1,3}){1} \d{1,3}-\d{7,}|\d{11}){1}" />
                <div class="invalid-feedback">
                  Debe ser local (ej. 04241234567) o internacional
                  (ej. +58 416-1231234).
                </div>
              </div>

              <div class="col-md-4">
                <label for="landlinePhone" class="form-label">
                  Teléfono Fijo
                </label>
                <input
                  type="tel"
                  name="landlinePhone"
                  id="landlinePhone"
                  class="form-control"
                  pattern="(\+(\d{1,3}|\d{1}-\d{1,3}){1} \d{1,3}-\d{7,}|\d{11}){1}" />
                <div class="invalid-feedback">
                  Debe ser local (ej. 04241234567) o internacional
                  (ej. +58 416-1231234).
                </div>
              </div>

              <div class="col-md-4">
                <label for="optionalPhone" class="form-label">
                  Teléfono Opcional
                </label>
                <input
                  type="tel"
                  name="optionalPhone"
                  id="optionalPhone"
                  class="form-control"
                  pattern="(\+(\d{1,3}|\d{1}-\d{1,3}){1} \d{1,3}-\d{7,}|\d{11}){1}" />
                <div class="invalid-feedback">
                  Debe ser local (ej. 04241234567) o internacional
                  (ej. +58 416-1231234).
                </div>
              </div>

              <h6 class="mb-3 fw-bold fs-4">Dirección Personal</h6>

              <!-- Dirección -->
              <div class="col-md-3">
                <label for="state" class="form-label">Estado</label>
                <select name="state" id="state" class="form-select" required>
                  <option value=""></option>
                </select>
                <div class="invalid-feedback">
                  Por favor, ingrese un estado válido (solo letras y espacios,
                  2 a 50 caracteres, y la primera letra debe ser mayúscula).
                </div>
              </div>

              <div class="col-md-3">
                <label for="municipality" class="form-label">Municipio</label>
                <select
                  name="municipality"
                  id="municipality"
                  class="form-select"
                  required>
                  <option value=""></option>
                </select>
                <div class="invalid-feedback">
                  Por favor, ingrese un municipio válido (solo letras y
                  espacios, 2 a 50 caracteres, y la primera letra debe ser
                  mayúscula).
                </div>
              </div>

              <div class="col-md-3">
                <label for="parish" class="form-label">Parroquia</label>
                <select name="parish" id="parish" class="form-select" required>
                  <option value=""></option>
                </select>
                <div class="invalid-feedback">Por favor, ingrese una parroquia válida (solo letras y espacios, 2 a 50
                  caracteres, y la primera letra debe ser mayúscula).</div>
              </div>

              <!-- Avenida -->
              <div class="col-md-3">
                <label for="avenue" class="form-label">Avenida</label>
                <input
                  list="avenue-list"
                  name="avenue"
                  id="avenue"
                  class="form-control"
                  required
                  pattern="[A-ZÁÉÍÓÚ][a-záéíóúñ0-9\s\-]{1,49}" />
                <datalist id="avenue-list"></datalist>
                <div class="invalid-feedback">
                  Por favor, ingrese una avenida válida (letras, números,
                  guiones y espacios, 2 a 50 caracteres, y la primera letra
                  debe ser mayúscula).
                </div>
              </div>

              <!-- Calle -->
              <div class="col-md-6">
                <label for="street" class="form-label">Calle</label>
                <input
                  list="street-list"
                  name="street"
                  id="street"
                  class="form-control"
                  required
                  pattern="[A-ZÁÉÍÓÚ][a-záéíóúñ0-9\s\-]{1,49}" />
                <datalist id="street-list"></datalist>
                <div class="invalid-feedback">
                  Por favor, ingrese una calle válida (letras, números, guiones
                  y espacios, 2 a 50 caracteres, y la primera letra debe ser
                  mayúscula).
                </div>
              </div>

              <div class="col-md-6">
                <label for="housingType" class="form-label">
                  Tipo de vivienda
                </label>
                <select
                  name="housingType"
                  id="housingType"
                  required
                  class="form-select">
                  <option value=""></option>
                  <option>Casa</option>
                  <option>Apartamento</option>
                  <option>Quinta</option>
                  <option>Rancho</option>
                  <option>Finca</option>
                  <option>Parcela</option>
                </select>
              </div>

              <!-- Número de vivienda -->
              <div class="col-md-6">
                <label for="housingNumber" class="form-label">
                  Número de vivienda
                </label>
                <input
                  name="housingNumber"
                  id="housingNumber"
                  class="form-control"
                  required
                  pattern="[A-ZÁÉÍÓÚ][a-záéíóúñ0-9\s#\-]{1,49}">
                <div class="invalid-feedback">
                  Por favor, ingrese un número de vivienda válido
                  (letras, números, guiones, # y espacios, 2 a 50 caracteres
                  y la primera letra debe ser mayúscula).
                </div>
              </div>

              <!-- Botón para enviar el formulario -->
              <div class="col-12">
                <button class="btn btn-primary w-100">Registrar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script>
      document.getElementById('registerClientButton').addEventListener('click', () => {
        const modal = new bootstrap.Modal(document.getElementById('registerClientModal'));
        modal.show();
      });

      document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('clientForm');

        // Validación en cada input
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

        // Manejo de validación al enviar el formulario
        form.addEventListener('submit', async e => {
          e.preventDefault()

          if (!form.checkValidity()) {
            return Swal.fire({
              icon: 'error',
              title: 'Formulario incompleto',
              text: 'Por favor complete correctamente todos los campos.',
            })
          }

          try {
            const formData = new FormData(form)

            let response = await fetch(`../../api.php?id_estado=${form.state.value}`)
            const estado = await response.json()
            response = await fetch(`../../api.php?id_municipio=${form.municipality.value}`)
            const municipio = await response.json()
            response = await fetch(`../../api.php?id_parroquia=${form.parish.value}`)
            const parroquia = await response.json()

            function soloInicialMayuscula(string = '') {
              const letters = string.toLowerCase().split('')
              letters[0] = letters[0].toUpperCase()

              return letters.join('')
            }

            formData.set('state', soloInicialMayuscula(estado.nombre))
            formData.set('municipality', soloInicialMayuscula(municipio.nombre))
            formData.set('parish', soloInicialMayuscula(parroquia.nombre))

            Swal.fire({
              title: 'Procesando',
              text: 'Por favor espere...',
              allowOutsideClick: false,
              didOpen: () => {
                Swal.showLoading()
              }
            })

            response = await fetch('../../CRUD/Clientes/registro_cliente.php', {
              method: 'POST',
              body: formData
            })

            const result = await response.json()

            if (result.success) {
              Swal.fire({
                icon: 'success',
                title: 'Cliente registrado',
                text: 'El cliente ha sido registrado exitosamente.',
              }).then(() => {
                form.reset()
              })
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: result.mensaje || 'Error al registrar cliente',
              })
            }
          } catch (error) {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Ocurrió un error al procesar la solicitud',
            })
          }
        })
      })
    </script>

    <script>
      const $formNuevoCliente = document.querySelector('#clientForm')
      const $selectEstado = $formNuevoCliente.state
      const $selectMunicipio = $formNuevoCliente.municipality
      const $selectParroquia = $formNuevoCliente.parish
      const $listAvenidas = $formNuevoCliente.querySelector('#avenue-list')
      const $inputAvenida = $formNuevoCliente.avenue
      const $listCalles = $formNuevoCliente.querySelector('#street-list')
      const $inputCalle = $formNuevoCliente.street

      fetch('../../api.php?estados')
        .then(response => response.json())
        .then(estados => {
          $selectEstado.innerHTML = '<option value=""></option>'

          for (const inicial in estados) {
            $selectEstado.innerHTML += `
              <optgroup label="${inicial}">
                ${estados[inicial].map(estado => `
                  <option value="${estado.id}">${estado.nombre}</option>
                `)}
              </optgroup>
            `
          }
        })

      $selectEstado.addEventListener('change', () => {
        if (!$selectEstado.value) {
          return
        }

        fetch(`../../api.php?municipios&id_estado=${$selectEstado.value}`)
          .then(response => response.json())
          .then(municipios => {
            $selectMunicipio.innerHTML = '<option value=""></option>'

            for (const inicial in municipios) {
              $selectMunicipio.innerHTML += `
                <optgroup label="${inicial}">
                  ${municipios[inicial].map(municipio => `
                    <option value="${municipio.id}">${municipio.nombre}</option>
                  `)}
                </optgroup>
              `
            }
          })
      })

      $selectMunicipio.addEventListener('change', () => {
        if (!$selectMunicipio.value) {
          return
        }

        fetch(`../../api.php?parroquias&id_municipio=${$selectMunicipio.value}`)
          .then(response => response.json())
          .then(parroquias => {
            $selectParroquia.innerHTML = '<option value=""></option>'

            for (const inicial in parroquias) {
              $selectParroquia.innerHTML += `
                <optgroup label="${inicial}">
                  ${parroquias[inicial].map(parroquia => `
                    <option value="${parroquia.id}">${parroquia.nombre}</option>
                  `)}
                </optgroup>
              `
            }
          })
      })

      $selectParroquia.addEventListener('change', () => {
        if (!$selectParroquia.value) {
          return
        }

        fetch(`../../api.php?avenidas&id_parroquia=${$selectParroquia.value}`)
          .then(response => response.json())
          .then(avenidas => {
            $listAvenidas.innerHTML = '<option value="Sin nombre" />'

            for (const avenida of avenidas) {
              $listAvenidas.innerHTML += `
                <option value="${avenida.nombre} - ${avenida.id}" />
              `
            }
          })
      })

      $inputAvenida.addEventListener('change', () => {
        if (!$inputAvenida.value) {
          return
        }

        const [, idAvenida = ''] = $inputAvenida.value.split(/\s?-\s?/)

        fetch(`../../api.php?calles&id_avenida=${idAvenida}&id_parroquia=${$selectParroquia.value}`)
          .then(response => response.json())
          .then(calles => {
            $listCalles.innerHTML = '<option value="Sin nombre" />'

            for (const calle of calles) {
              let nombre = calle.nombre.toLowerCase().split('')
              nombre[0] = nombre[0].toUpperCase()
              nombre = nombre.join('')

              $listCalles.innerHTML += `
                <option value="${nombre} - ${calle.id}" />
              `
            }
          })
      })
    </script>
  </main>
  <?php include '../Partes/footer.php' ?>

  <!-- Template Main JS File -->
  <script src="../../assets/js/main.js"></script>
</body>
