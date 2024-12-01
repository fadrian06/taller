for (const form of document.querySelectorAll('.needs-validation')) {
  form.setAttribute('novalidate', true)

  form.addEventListener(
    'submit',
    event => {
      if (!form.checkValidity()) {
        for (const input of form.querySelectorAll('input, select, textarea')) {
          if (input.checkValidity()) {
            input.closest('.form-floating, .input-group').classList.remove('is-invalid')
          } else {
            input.closest('.form-floating, .input-group').classList.add('is-invalid')
          }
        }

        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    },
    false
  )
}
