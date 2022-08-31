@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>Lista de reservas</h3>
    <div class="row mb-3">
      <label for="name"
        class="col-2 col-form-label text-md-start">{{ __('Buscar reserva') }}</label>

      <div class="col-md-5">
        <input id="search-name" type="text"
          placeholder="Ingresa el nombre de la reserva o la fecha en formato YYYY-mm-dd"
          class="form-control  form-control-user" name="name" autocomplete="name"
          autofocus>
      </div>
      {{-- <div class="col-md-2">
        <button class="btn btn-primary btn-user">
          {{ __('Buscar') }}
        </button>
      </div> --}}

    </div>

    {{-- <div id='major-list-view'> --}}

    <table class="table table-hover ">
      <thead>
        <tr>
          <th scope="col">#</i></th>
          <th scope="col">Nombre</th>
          <th scope="col">Asistentes</th>
          <th scope="col">Fecha</th>
          <th scope="col">Hora</th>
          <th scope="col">Reservado por</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody id="labs-list-view">
        @foreach ($reserves as $reserve)
          <tr>
            <th scope="row">{{ $reserve->id }}</th>
            <td>{{ $reserve->name }} </td>
            <td>{{ $reserve->assistants }}</td>
            <td>{{ $reserve->date }}</td>
            <td>{{ $reserve->start_time }} -
              {{ $reserve->end_time }}</td>
            <td>{{ $reserve->user->name }} {{ $reserve->user->surname }}</td>
            <td>
              <a href="{{ route('reservations.show', $reserve->id) }}"
                class="btn btn-secondary mb-0 me-2 p-1 px-2">
                <i class="fa-solid fa-eye"></i>
              </a>
              <button form="lab-destroy-{{ $reserve['id'] }}" type="submit"
                class="btn btn-danger mb-0 me-2 p-1 px-2">
                <i class="fa-solid fa-trash"></i>
              </button>

              <form id="lab-destroy-{{ $reserve['id'] }}"
                action="{{ route('reservation.delete', $reserve->id) }}"
                method="POST">
                @csrf
                @method('DELETE')
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection

{{-- <script src="{{ asset('js/admin/labs.js') }}" defer></script> --}}
