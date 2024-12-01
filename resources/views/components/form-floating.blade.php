<label @class(['d-block', 'has-validation' => $attributes['required']])>
  <div class="form-floating">
    <input class="form-control" placeholder="" {{ $attributes }} />
    <label>{{ $label }}</label>
  </div>
  <div class="invalid-feedback">{{ $feedback }}</div>
</label>
