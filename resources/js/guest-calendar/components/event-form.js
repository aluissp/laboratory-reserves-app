export default class EventForm {
  constructor() {
    this.form = this.getForm();
    this.modal = new bootstrap.Modal(document.getElementById('event-modal'));
  }

  setValues(info) {
    for (const item in this.form) {
      if (item === 'error') continue;
      if (item === 'info') {
        this.form[item].classList.remove('d-none');
        const date = new Date(info.created_at).toLocaleString();
        this.form[
          item
        ].innerText = `Reservado por ${info.user.name} ${info.user.surname}.
        Reservado el ${date}.`;
        continue;
      }
      if (item === 'title') {
        this.form[item].innerText = info[item];
        continue;
      }
      if (item === 'lab_id') {
        this.form[item].value = `${info[item]} - ${info.lab.name}`;
        continue;
      }
      this.form[item].value = info[item];
    }
  }

  getForm() {
    const id = document.getElementById('id-reserve');
    const title = document.getElementById('event-title');
    const name = document.getElementById('name');
    const assistants = document.getElementById('assistants');
    const description = document.getElementById('description');
    const date = document.getElementById('date');
    const start_time = document.getElementById('start-time');
    const end_time = document.getElementById('end-time');
    const lab_id = document.getElementById('lab-input');
    const color = document.getElementById('color');
    const error = document.getElementById('fail-reserve');
    const info = document.getElementById('info-reserve');

    return {
      id,
      title,
      name,
      assistants,
      description,
      date,
      start_time,
      end_time,
      lab_id,
      color,
      error,
      info,
    };
  }

  uploadForm(info) {
    this.cleanForm();
    this.disableForm();

    if (info.type === 'new') {
      const { title, dateStr } = info;
      this.form.title.innerText = title;
      this.form.date.value = dateStr;
      this.modal.show();
    } else if (info.type === 'reload') {
      this.setValues(info);
      this.modal.show();
    }
  }

  cleanForm() {
    this.form.id.value = '';
    this.form.title.innerText = '';
    this.form.name.value = '';
    this.form.assistants.value = '';
    this.form.description.value = '';
    this.form.date.value = '';
    this.form.start_time.value = '07:00';
    this.form.end_time.value = '08:00';
    this.form.lab_id.value = '';
    this.form.color.value = '#2C3E50';
    this.form.error.innerText = '';
    this.form.info.innerText = '';

    this.form.error.classList.add('d-none');
    this.form.info.classList.add('d-none');

    for (const formInput in this.form) {
      this.form[formInput].classList.remove('is-invalid');
    }
  }
  disableForm() {
    for (const formInput in this.form) {
      this.form[formInput].setAttribute('disabled', '');
    }
  }

  getLabId(value) {
    return Number(value.split('-')[0]);
  }

  closeForm(type, message) {
    this.modal.hide();
    this.alert.show(type, message);
  }
}
