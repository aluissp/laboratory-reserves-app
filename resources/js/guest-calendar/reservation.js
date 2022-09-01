const { default: axios } = require('axios');
export default class Reservation {
  static async init() {
    try {
      const url = process.env.MIX_URL_SERVE;
      const reserves = await axios.get(`${url}/guest-show `);
      return new Reservation(reserves.data.response);
    } catch (error) {
      console.log(error);
    }
  }

  constructor(reserves) {
    this.admin = process.env.MIX_ADMIN_ROLE_NAME;
    this.url = process.env.MIX_URL_SERVE;

    this.reserves = reserves;
  }

  getReserves() {
    return this.reserves.map((reserve) => ({ ...reserve }));
  }

  getReserve(id) {
    const index = this.findReserve(id);
    return { ...this.reserves[index] };
  }
  
  findReserve(id) {
    return this.reserves.findIndex((reserve) => reserve.id == id);
  }
}
