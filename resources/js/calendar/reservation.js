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
    return [...this.reserves];
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
}
