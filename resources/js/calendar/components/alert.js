export default class Alert {
  constructor(alertId) {
    this.alert = document.getElementById(alertId);
    this.icon = this.alert.children[0].children[0];
    this.message = this.alert.children[1];
    this.btnClose = this.alert.children[2];
  }

  show(type, message) {
    this.alert.classList.remove('d-none');
    this.alert.classList.add(`alert-${type}`);

    this.icon.setAttribute('xlink:href', `#${type}`);
    this.message.innerText = message;

    return new Promise(() => {
      setTimeout(() => {
        this.hide(type);
      }, 4000);
    });
  }

  hide(type) {
    this.alert.classList.add('d-none');
    this.alert.classList.remove(`alert-${type}`);
    this.message.innerText = '';
    this.icon.setAttribute('xlink:href', '');
    this.btnClose.click();
  }
}
