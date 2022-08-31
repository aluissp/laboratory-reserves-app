const { default: axios } = require('axios');

document.addEventListener('DOMContentLoaded', function () {
  const buscador = document.querySelector('#search-name');
  if (!buscador) {
    return;
  }

  let consulta;
  const url = process.env.MIX_URL_SERVE;
  const admin = process.env.MIX_ADMIN_ROLE_NAME;
  const viewList = document.getElementById('reserves-list-view');
  const csrf = document.querySelector('meta[name="csrf-token"]').content;

  const mandarPeticion = (consulta) => {
    axios
      .get(`${url}/reservations/${consulta}/filter`)
      .then((response) => {
        rederizar(response.data.response);
      })
      .catch((error) => {
        console.log(error);
      });
  };

  const consultar = (consulta) => {
    consulta = buscador.value;

    if (!consulta.length > 0) consulta = 'all';

    mandarPeticion(consulta);
  };

  const rederizar = (data) => {
    if (data.length === 0) {
      viewList.innerHTML = `
            <tr>
              <th colspan="7">No se han encotrado registros.</th>
            </tr>
            `;
      return;
    }
    let html = '';
    for (const reserve of data) {
      html += `
            <tr>
              <th scope="row">${reserve.id}</th>
              <td>${reserve.name}</td>
              <td>${reserve.assistants}</td>
              <td>${reserve.date}</td>
              <td>${reserve.start_time} - ${reserve.end_time}</td>
              <td>${reserve.user.name} ${reserve.user.surname} </td>
              <td>
              <a href="${url}/reservations/${reserve.id}"
                class="btn btn-secondary mb-0 me-2 p-1 px-2">
                <i class="fa-solid fa-eye"></i>
              </a>
              <button form="reserve-destroy-${reserve.id}" type="submit"
                class="btn btn-danger mb-0 me-2 p-1 px-2">
                <i class="fa-solid fa-trash"></i>
              </button>

                <form id="reserve-destroy-${reserve.id}"
                  action="${url}/reservations/${reserve.id}/delete" method="POST">
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
