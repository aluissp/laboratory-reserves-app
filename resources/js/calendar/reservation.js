const { default: axios } = require('axios');
export default class Reservation {
  static async init() {
    try {
      const url = process.env.MIX_URL_SERVE;
      const response = await axios.get(`${url}/labs/all/filter`);
      return new Reservation(response.data.response);
    } catch (error) {
      return error;
    }
  }

  constructor(labs) {
    this.admin = process.env.MIX_ADMIN_ROLE_NAME;
    this.csrf = document.querySelector('meta[name="csrf-token"]').content;

    this.reserves = [{}];
    this.labs = labs;
  }

  getLabs() {
    return [...this.labs];
  }
}
