const { default: axios } = require("axios");

document.addEventListener("DOMContentLoaded", function () {
    const buscador = document.querySelector("#search-name");
    if (!buscador) {
        return;
    }

    let consulta;
    const url = process.env.MIX_URL_SERVE;
    const admin = process.env.MIX_ADMIN_ROLE_NAME;
    const viewList = document.getElementById("users-list-view");
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    const mandarPeticion = (consulta) => {
        axios
            .get(`${url}/users/${consulta}/filter`)
            .then((response) => {
                // console.log(response.data.response);
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
        let deleteBtn = "";
        for (const usuario of data) {
            if (usuario.roles[0]?.name !== admin) {
                deleteBtn = `
                <button form="rol-destroy-${usuario.id}" type="submit"
                class="btn btn-danger mb-0 me-2 p-1 px-2">
                    <svg class="bi flex-shrink-0" width="16" height="16" role="img" aria-label="Info:">
                        <use xlink:href="#trash" />
                    </svg>
                </button>
                `;
            }
            html += `
            <tr>
              <th scope="row">${usuario.id}</th>
              <td>${usuario.name} ${usuario.surname}</td>
              <td><a href="mailto:${usuario.email}"
                  class="text-info">${usuario.email}</a></td>
              <td>${usuario.roles[0]?.name}</td>
              <td>${usuario.major?.name ? usuario.major?.name : ""}</td>
              <td>
                <a href="${url}/users/${usuario.id}/edit"
                  class="btn btn-secondary mb-0 me-2 p-1 px-2">
                  <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                      <symbol id="pencil" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                      </symbol>

                      <symbol id="trash" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </symbol>
                    </svg>
                    <svg class="bi flex-shrink-0" width="16" height="16" role="img" aria-label="Info:">
                      <use xlink:href="#pencil" />
                    </svg>
                  </div>
                </a>
                ${deleteBtn}
                <form id="rol-destroy-${usuario.id}"
                  action="${url}/users/${usuario.id}" method="POST">
                  <input type="hidden" name="_token" value="${csrf}">
                  <input type="hidden" name="_method" value="DELETE">
                </form>
              </td>
            </tr>
            `;
        }
        viewList.innerHTML = html;
    };

    buscador.oninput = () => consultar(consulta);
});
