@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="col-md-12">
      <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="success" fill="currentColor" viewBox="0 0 16 16">
          <path
            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </symbol>
        <symbol id="info" fill="currentColor" viewBox="0 0 16 16">
          <path
            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
        <symbol id="warning" fill="currentColor" viewBox="0 0 16 16">
          <path
            d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
      </svg>

      <div id="calendar-alert" class="alert d-flex align-items-center d-none"
        role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24"
          role="img" aria-label="Info:">
          <use xlink:href="" />
        </svg>
        <div>
        </div>
      </div>

      {{-- Calendar --}}
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
              <div class='px-2'>
                <div id="fail-reserve" class="alert alert-danger m-0 d-none">
                </div>
              </div>
              <div class="mb-3 col-6">
                <label class="col-md-4 col-form-label">Nombre</label>
                <input id="name" type="text"
                  class="form-control form-control-user" name="name"
                  autocomplete="name" autofocus>
                <span id="error-name" class="invalid-feedback d-none"
                  role="alert">
                  <strong></strong>
                </span>
              </div>
              <div class="mb-3 col-6">
                <label class="col-md-4 col-form-label">Asistentes</label>
                <input id="assistants" type="number"
                  class="form-control form-control-user" name="assistants">

                <span id="error-assistants" class="invalid-feedback d-none"
                  role="alert">
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

                <span id="error-date" class="invalid-feedback d-none"
                  role="alert">
                  <strong></strong>
                </span>
              </div>
              <div class="mb-3 col-6">
                <label class="col-form-label">Color</label>
                <input id="color" type="color"
                  class="form-control form-control-user" name="color"
                  value="#2C3E50">

                <span id="error-color" class="invalid-feedback d-none"
                  role="alert">
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
                  value="07:00">

                <span id="error-start-time" class="invalid-feedback d-none"
                  role="alert">
                  <strong></strong>
                </span>
              </div>
              <div class="mb-3 col-6">
                <label class="col-form-label">Hora final</label>
                <input id="end-time" type="time"
                  class="form-control form-control-user" name="end-time"
                  value="08:00">

                <span id="error-end-time" class="invalid-feedback d-none"
                  role="alert">
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
              <span id="error-lab" class="invalid-feedback d-none"
                role="alert">
                <strong></strong>
              </span>
              <div id='info-reserve' class='alert alert-light mt-4 d-none'>
              </div>
            </div>

            <input id="id-reserve" type="hidden">
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
