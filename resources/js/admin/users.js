const { default: axios } = require("axios");

document.addEventListener("DOMContentLoaded", function () {
    const buscador = document.querySelector("#search-name");
    if (!buscador) {
        return;
    }

    let consulta;
    const url = process.env.MIX_URL_SERVE;
    const viewList = document.getElementById("users-list-view");
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    const mandarPeticion = (consulta) => {
        axios
            .get(`${url}/users/${consulta}/filter`)
            .then((response) => {
                rederizar(response.data.response);
            })
            .catch((error) => {
                console.log(error);
            });
    };

    const consultar = (consulta) => {
        consulta = buscador.value;

        if (!consulta.length > 0) consulta = "all";

        carreras = mandarPeticion(consulta);
    };

    const rederizar = (data) => {
        if (data.length === 0) {
            viewList.innerHTML = `
            <tr>
              <th colspan="6">No se han encotrado registros.</th>
            </tr>
            `;
            return;
        }
        let html = "";
        for (const usuario of data) {
            html += `
            <tr>
              <th scope="row">${usuario.id}</th>
              <td>{{ $user->name }} {{ $user->surname }}</td>
              <td><a href="mailto:{{ $user->email }}"
                  class="text-info">{{ $user->email }}</a></td>
              <td>{{ $user->major?->name }}</td>
              <td>{{ $user->major?->name }}</td>
              <td>
                <a class="btn btn-secondary mb-0 me-2 p-1 px-2">
                  <x-icon icon="pencil" />
                </a>
                @if (!$user->hasRole(config('role.admin')))
                  <button form="rol-destroy-{{ $user['id'] }}" type="submit"
                    class="btn btn-danger mb-0 me-2 p-1 px-2">
                    <x-icon icon="trash" />
                  </button>
                @endif

                {{-- Eliminar rol --}}
                <form id="rol-destroy-{{ $user['id'] }}"
                  action="{{ route('users.destroy', $user->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                </form>
              </td>
            </tr>
            `;
        }
        viewList.innerHTML = html;
    };

    const padTo2Digits = (num) => {
        return num.toString().padStart(2, "0");
    };

    const formaterFecha = (date) => {
        return (
            [
                date.getFullYear(),
                padTo2Digits(date.getMonth() + 1),
                padTo2Digits(date.getDate()),
            ].join("-") +
            " " +
            [
                padTo2Digits(date.getHours()),
                padTo2Digits(date.getMinutes()),
                padTo2Digits(date.getSeconds()),
            ].join(":")
        );
    };

    buscador.oninput = () => consultar(consulta);
});
