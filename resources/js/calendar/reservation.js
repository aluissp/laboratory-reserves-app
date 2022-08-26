const { default: axios } = require('axios');
export default class Reservation {
  static async init() {
    try {
      const url = process.env.MIX_URL_SERVE;
      const response = await axios.get(`${url}/labs/all/filter`);
      return new Reservation(response.data.response);
    } catch (error) {
      console.log(error);
    }
  }

  constructor(labs) {
    this.admin = process.env.MIX_ADMIN_ROLE_NAME;
    this.url = process.env.MIX_URL_SERVE;

    this.reserves = [{}];
    this.labs = labs;
  }

  getLabs() {
    return [...this.labs];
  }

  createNewReservation(data, callback) {
    const request = {
      method: 'post',
      url: `${this.url}/reservations`,
      data,
    };
    console.log(request);
    axios(request)
      .then((response) => {
        console.log(response.data);
        callback('ok');
      })
      .catch(function (error) {
        console.error(error);
      });
  }
}
