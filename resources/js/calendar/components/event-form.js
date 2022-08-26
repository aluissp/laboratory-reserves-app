export default class EventForm {
  constructor() {
    this.form = this.getForm();
    this.modal = new bootstrap.Modal(document.getElementById('event-modal'));
    this.btnCreate = document.getElementById('btn-new-form');
    this.btnEdit = document.getElementById('btn-edit-form');
    this.btnDelete = document.getElementById('btn-delete-form');
  }

  setValues() {}

  getForm() {
    const title = document.getElementById('event-title');
    const name = document.getElementById('name');
    const assistants = document.getElementById('assistants');
    const description = document.getElementById('description');
    const date = document.getElementById('date');
    const start_time = document.getElementById('start-time');
    const end_time = document.getElementById('end-time');
    const lab_id = document.getElementById('lab-input');
    const color = document.getElementById('color');

    return {
      title,
      name,
      assistants,
      description,
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
    }
  }

  cleanForm() {
    const buttons = [this.btnCreate, this.btnDelete, this.btnEdit];
    buttons.forEach((btn) => btn.classList.add('d-none'));

    this.form.title.innerText = '';
    this.form.name.value = '';
    this.form.assistants.value = '';
    this.form.description.value = '';
    this.form.date.value = '';
    this.form.start_time.value = '07:00:00';
    this.form.end_time.value = '08:00:00';
    this.form.lab_id.value = '';
    this.form.color.value = '#2C3E50';
  }

  onCreateClick(callback) {
    this.btnCreate.onclick = () => {
      const data = {};
      for (const item in this.form) {
        if (item === 'title') continue;
        if (item === 'lab') {
          data[item] = this.getLabId(this.form[item].value);
          continue;
        }
        data[item] = this.form[item].value;
      }

      callback(data);
    };
  }

  getLabId(value) {
    return Number(value.split('-')[0]);
  }
}
