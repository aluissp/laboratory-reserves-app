import Alert from './alert.js';
export default class EventForm {
  constructor() {
    this.form = this.getForm();
    this.alert = new Alert('calendar-alert');
    this.errorAlerts = this.getErrorAlerts();
    this.modal = new bootstrap.Modal(document.getElementById('event-modal'));
    this.btnCreate = document.getElementById('btn-new-form');
    this.btnEdit = document.getElementById('btn-edit-form');
    this.btnDelete = document.getElementById('btn-delete-form');
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

  getErrorAlerts() {
    const name = document.getElementById('error-name');
    const assistants = document.getElementById('error-assistants');
    const date = document.getElementById('error-date');
    const color = document.getElementById('error-color');
    const start_time = document.getElementById('error-start-time');
    const end_time = document.getElementById('error-end-time');
    const lab_id = document.getElementById('error-lab');

    return {
      name,
      assistants,
      date,
      start_time,
      end_time,
      lab_id,
      color,
    };
  }

  uploadForm(info) {
    this.cleanForm();

    if (info.type === 'new') {
      const { title, dateStr } = info;
      this.form.title.innerText = title;
      this.form.date.value = dateStr;
      this.btnCreate.classList.remove('d-none');
      this.modal.show();
    } else if (info.type === 'reload') {
      this.setValues(info);
      this.btnDelete.classList.remove('d-none');
      this.btnEdit.classList.remove('d-none');
      this.modal.show();
    }
  }

  cleanForm() {
    const buttons = [this.btnCreate, this.btnDelete, this.btnEdit];
    buttons.forEach((btn) => btn.classList.add('d-none'));

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

    for (const alert in this.errorAlerts) {
      this.errorAlerts[alert].classList.add('d-none');
    }
  }

  onCreateClick(callback) {
    this.btnCreate.onclick = () => {
      const data = {};
      for (const item in this.form) {
        if (item === 'id') continue;
        if (item === 'title') continue;
        if (item === 'error') continue;
        if (item === 'info') continue;
        if (item === 'lab_id') {
          data[item] = this.getLabId(this.form[item].value);
          continue;
        }
        if (item === 'start_time' || item === 'end_time') {
          data[item] = `${this.form[item].value}:00`;
          continue;
        }

        data[item] = this.form[item].value;
      }
      //console.log(data);
      callback(data);
    };
  }

  getLabId(value) {
    return Number(value.split('-')[0]);
  }

  setErrors(errors) {
    // console.log(errors);
    for (const element in this.form) {
      if (element === 'id') continue;
      if (element === 'title') continue;
      if (element === 'info') continue;
      if (element === 'error') continue;

      this.form[element].classList.remove('is-invalid');
      if (element === 'description') continue;

      this.errorAlerts[element].classList.add('d-none');
    }

    for (const error in errors) {
      this.form[error].classList.add('is-invalid');

      if (error === 'description') continue;

      this.errorAlerts[error].classList.remove('d-none');
      this.errorAlerts[error].children[0].innerText = errors[error][0];
    }
  }

  closeForm(type, message) {
    this.modal.hide();
    this.alert.show(type, message);
  }
}
