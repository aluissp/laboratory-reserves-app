export default class EventForm {
  constructor() {
    this.form = this.getForm();
    this.modal = new bootstrap.Modal(document.getElementById('event-modal'));
    this.btn = document.getElementById('event-form-btn');
  }

  setValues({ dateStr, title }) {
    this.form.title.innerText = title;
    this.form.date.value = dateStr;
    this.modal.show();
  }

  getForm() {
    const title = document.getElementById('event-title');
    const name = document.getElementById('name');
    const assistants = document.getElementById('assistants');
    const description = document.getElementById('description');
    const date = document.getElementById('date');
    const startTime = document.getElementById('start-time');
    const endTime = document.getElementById('end-time');
    const lab = document.getElementById('lab-input');

    return {title, name, assistants, description, date, startTime, endTime, lab };
  }
}
