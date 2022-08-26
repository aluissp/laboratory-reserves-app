@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="col-md-12">
      <div id="calendar">
      </div>
    </div>
  </div>


  <!-- Event Modal -->
  <div class="modal fade" id="event-modal" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="event-title"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="event-title">
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="event-form">
            <div class="row">
              <div class="mb-3 col-6">
                <label class="col-md-4 col-form-label">Nombre</label>
                <input id="name" type="text"
                  class="form-control form-control-user" name="name"
                  autocomplete="name" autofocus>
                <span class="invalid-feedback d-none" role="alert">
                  <strong></strong>
                </span>
              </div>
              <div class="mb-3 col-6">
                <label class="col-md-4 col-form-label">Asistentes</label>
                <input id="assistants" type="number"
                  class="form-control form-control-user" name="assistants">

                <span class="invalid-feedback d-none" role="alert">
                  <strong></strong>
                </span>
              </div>
            </div>

            <div class="row mb-3">
              <div class='px-3'>
                <div class="form-floating">
                  <textarea class="form-control" id="description" name="description"
                    style="height: 100px" placeholder="Escribe una descripción rapida."></textarea>
                  <label for="description">Descripción</label>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="mb-3 col-6">
                <label class="col-md-4 col-form-label">Fecha</label>
                <input id="date" type="date"
                  class="form-control form-control-user" name="date">
              </div>
              <div class="mb-3 col-6">
                <label class="col-form-label">Color</label>
                <input id="color" type="color"
                  class="form-control form-control-user" name="color"
                  value="#2C3E50">

                <span class="invalid-feedback d-none" role="alert">
                  <strong></strong>
                </span>

              </div>
            </div>
            <div class="row">
              <div class="mb-3 col-6">
                <label class="col-md-7 col-form-label">Hora
                  inicial</label>
                <input id="start-time" type="time"
                  class="form-control form-control-user" name="start-time"
                  value="07:00:00">

                <span class="invalid-feedback d-none" role="alert">
                  <strong></strong>
                </span>
              </div>
              <div class="mb-3 col-6">
                <label id="end-time" class="col-form-label">Hora final</label>
                <input type="time" class="form-control form-control-user"
                  name="end-time" value="08:00:00">

                <span class="invalid-feedback d-none" role="alert">
                  <strong></strong>
                </span>
              </div>
            </div>
            <div class="row mb-3 px-3">
              <label class="col-form-label">Eliga un laboratorio</label>
              <input id="lab-input" list="labs"
                class="form-control form-control-user" name="lab">
              <datalist id="labs">
                @foreach ($labs as $lab)
                  <option value="{{ $lab->id }} - {{ $lab->name }}">
                    {{ $lab->location }}
                  </option>
                @endforeach
              </datalist>
              <span class="invalid-feedback d-none" role="alert">
                <strong></strong>
              </span>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary"
            data-bs-dismiss="modal">Cerrar</button>
          <button id="btn-delete-form" type="button"
            class="btn btn-danger">Eliminar</button>
          <button id="btn-edit-form" type="button"
            class="btn btn-info">Guardar cambios</button>
          <button id='btn-new-form' type="button"
            class="btn btn-primary">Guardar reserva</button>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('js/calendar/main.js') }}" type="module" defer></script>
@endsection
