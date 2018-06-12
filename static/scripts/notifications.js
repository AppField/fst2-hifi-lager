const notificationWrapper = $(`<div id="notificationWrapper" class="notification-wrapper"></div>`).appendTo('main');


const createNotifiction = (message, state) => {

    const newNotification = $(notification(message, state));

    newNotification.appendTo(notificationWrapper).addClass('bounce-in');

    setTimeout(() => {
        $($('#notificationWrapper .notification')[0]).alert('close');

    }, 3000);

};


function notification(message, state) {
    return `
      <div class="js-notification notification alert alert-${state ? 'success' : 'danger' } alert-dismissible fade show" role="alert">
            <span id="alertMessage">${message}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `
};