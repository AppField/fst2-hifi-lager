const notificationWrapper = $(`<div id="notificationWrapper" class="notification-wrapper"></div>`).appendTo('main');

$('#addAlert').on('click', () => {
    createNotifiction('asdfasdf', false);
});

const createNotifiction = (message, state) => {

    const newNotification = new Notification(message, state);

    newNotification.element.appendTo(notificationWrapper).addClass('bounce-in');
};


class Notification {

    constructor(message, state) {
        this.element = this.createNotification(message, state);
        this.createTimer();
    }

    createTimer() {
        setTimeout(() => {
            this.element.alert('close');
        }, 3000);
    }


    createNotification(message, state) {
        return $(`
      <div class="js-notification notification alert alert-${state ? 'success' : 'danger' } alert-dismissible fade show" role="alert">
            <span id="alertMessage">${message}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `)
    }
}

