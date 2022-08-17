const { default: axios } = require("axios");

document.addEventListener("DOMContentLoaded", function () {
    const buscador = document.querySelector("#search-name");
    if (!buscador) {
        return;
    }

    let consulta;
    const url = process.env.MIX_URL_SERVE;
    const viewList = document.getElementById("major-list-view");
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    const mandarPeticion = (consulta) => {
        axios
            .get(`${url}/majors/${consulta}/filter`)
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
            <div class="d-flex justify-content-between bg-light mb-3 rounded px-4 py-2">
              <div class="text-center">
                <p>No se encontró coincidencias.</p>
              </div>
            </div>
            `;
            return;
        }
        let html = "";
        for (const carrera of data) {
            html += `
            <form method="POST" action="${url}/majors/${carrera.id}"
              class="d-flex justify-content-between bg-light mb-3 rounded px-4 py-2">

                <input type="hidden" name="_token" value="${csrf}">
                <input type="hidden" name="_method" value="PUT">

              <div class="d-flex align-items-center">
                <p class="me-2 mb-0 fw-bold">
                  <input name="name-update" class="form-control-plaintext fw-bold"
                    value="${carrera.name}">
                </p>
                <p class="me-2 mb-0 d-none d-md-block">
                  Creado el: ${formaterFecha(new Date(carrera.created_at))}
                </p>
                <p class="me-2 mb-0 d-none d-md-block">
                  Actualizado el: ${formaterFecha(
                      new Date(carrera.updated_at)
                  )} </p>
                </p>


              </div>
              <div class="d-flex  align-items-center">
                <button type="submit" class="btn btn-secondary mb-0 me-2 p-1 px-2">
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
                </button>
                <button form="major-destroy-${carrera.id}" type="submit"
                  class="btn btn-danger mb-0 me-2 p-1 px-2">
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
                      <use xlink:href="#trash" />
                    </svg>
                  </div>
                </button>
              </div>
            </form>

            <form id="major-destroy-${carrera.id}"
              action="${url}/majors/${carrera.id}" method="POST">
              <input type="hidden" name="_token" value="${csrf}">
              <input type="hidden" name="_method" value="DELETE">
            </form>
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
