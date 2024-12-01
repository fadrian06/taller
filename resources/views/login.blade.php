<x-layouts.login>
  <section class="min-vh-100 d-flex align-items-center justify-content-center">
    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center">
      <picture class="py-4 logo">
        <img src="./assets/img/logo.png" class="me-auto" />
      </picture>

      <div class="card card-body">
        <div class="pt-4 pb-2">
          <h5 class="card-title text-center pb-0 fs-4">Datos de su cuenta</h5>
        </div>
        <form id="loginForm" class="row g-3 needs-validation">
          <div class="col-12">
            <x-form-floating
              name="username"
              required
              label="Usuario"
              feedback="Por favor, ingrese su nombre de usuario." />
          </div>
          <label class="col-12">
            <x-form-floating
              type="password"
              name="password"
              required
              feedback="Por favor, ingrese su contraseña."
              label="Contraseña"
            />
          </label>
          <button class="btn btn-primary">Iniciar sesión</button>
        </form>
      </div>
    </div>
  </section>
</x-layouts.login>

<script>
  const form = document.getElementById('loginForm')

  form.addEventListener('submit', event => {
    event.preventDefault() // Evita que el formulario se envíe de forma predeterminada

    const formData = new FormData(form)

    fetch('CRUD/Usuarios/Login.php', { // Ruta del archivo PHP
      method: 'POST',
      body: formData
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          Swal.fire({
            icon: 'success',
            title: '¡Bienvenido!',
            text: data.message,
            showConfirmButton: false,
            timer: 1500
          }).then(() => {
            window.location.href = 'views/dashboard/dashboard.php' // Redirección en caso de éxito
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: data.message,
          });
        }
      })
      .catch(error => {
        console.error('Error:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Hubo un problema al procesar tu solicitud.',
        })
      })
  })
</script>
