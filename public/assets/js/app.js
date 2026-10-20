const alertTypes = ['success', 'danger', 'warning']
const alertContainer = document.getElementById('alertContainer')

const showAlert = (message, type) => {
    const wrapper = document.createElement('div')
    const alertType = alertTypes.includes(type) ? type : 'warning';

    wrapper.innerHTML = [
        `<div class="alert alert-${alertType} alert-dismissible fade show" role="alert">`,
        `   <div>${message}</div>`,
        '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
        '</div>'
    ].join('')

    alertContainer.append(wrapper)
    setTimeout(() => {
        const bsAlert = bootstrap.Alert.getOrCreateInstance(wrapper);
        bsAlert.close();
  }, 2000);
}
