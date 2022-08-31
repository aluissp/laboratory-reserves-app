const { default: axios } = require('axios');
export default class Reservation {
  static async init() {
    try {
      const url = process.env.MIX_URL_SERVE;
      const labs = await axios.get(`${url}/labs/all/filter`);
      const reserves = await axios.get(`${url}/reservations`);
      return new Reservation(labs.data.response, reserves.data.response);
    } catch (error) {
      console.log(error);
    }
  }

  constructor(labs, reserves) {
    this.admin = process.env.MIX_ADMIN_ROLE_NAME;
    this.url = process.env.MIX_URL_SERVE;

    this.reserves = reserves;
    this.labs = labs;
  }

  getLabs() {
    return [...this.labs];
  }

  getReserves() {
    return this.reserves.map((reserve) => ({ ...reserve }));
  }

  createNewReservation(data, callback) {
    const request = {
      method: 'post',
      url: `${this.url}/reservations`,
      data,
    };
    axios(request)
      .then((response) => {
        const { data } = response.data;
        this.reserves.push(data);
        callback(null, response.data);
      })
      .catch((error) => {
        callback(error.response.data.errors);
      });
  }

  editReservation(data, callback) {
    const request = {
      method: 'put',
      url: `${this.url}/reservations/${data.id}`,
      data,
    };
    axios(request)
      .then((response) => {
        const { data } = response.data;
        this.editReserve(data.id, data);
        callback(null, response.data);
      })
      .catch((error) => {
        if (error.response?.status == 403) callback({ status: 403 });

        callback(error.response?.data.errors);
      });
  }

  deleteReservation(data, callback) {
    const request = {
      method: 'delete',
      url: `${this.url}/reservations/${data.id}`,
    };
    axios(request)
      .then((response) => {
        const { data } = response.data;
        this.removeReserve(data.id);
        callback(null, response.data);
      })
      .catch((error) => {
        if (error.response?.status == 403) callback({ status: 403 });

        callback(error.response?.data.errors);
      });
  }

  findReserve(id) {
    return this.reserves.findIndex((reserve) => reserve.id == id);
  }

  getReserve(id) {
    const index = this.findReserve(id);
    return { ...this.reserves[index] };
  }

  removeReserve(id) {
    const index = this.findReserve(id);
    this.reserves.splice(index, 1);
  }

  editReserve(id, values) {
    const index = this.findReserve(id);
    Object.assign(this.reserves[index], values);
  }
}
