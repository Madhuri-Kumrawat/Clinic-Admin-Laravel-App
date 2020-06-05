$(document).ready(function (e) {
    $('#tblNotification').DataTable({
        "language": {
            "paginate": {
                "previous": "<i class='fa fa-chevron-left'>",
                "next": "<i class='fa fa-chevron-right'>"
            },
            "processing": "Processing.... Please Wait.",
        },
        "processing": true,
        "serverSide": true,
        "order": [[0, "DESC"]],
        "ajax": {
            "url": APP_URL + "/admin/notification_xhr",
            "type": "POST"
        },
    });

    $('#btnSendNotification').on('click', function (e) {
        $('#frmSendNotification').validate();
        if ($('#frmSendNotification').valid()) {
            var d = $('#frmSendNotification').serialize();
            $.ajax({
                url: APP_URL + "/admin/send-notification-message",
                data: d,
                method: 'POST',
                beforeSend: function () {
                    $('#btnSendNotification').button('loading');
                },
                success: function (r) {
                    var data = $.parseJSON(r);
                    if (data.success) {
                        $('#frmSendNotification')[0].reset();
                        $("#mdSendNotification").modal("hide");
                        $.NotificationApp.send("Done!", "Notification sent Successfully!", 'top-right', '#5ba035', 'success');
                        $('#tblNotification').DataTable().draw();
                    } else {
                        msg = 'Something Went Wrong!';
                        if (data.msg) {
                            msg = data.msg;
                        }
                        $.NotificationApp.send("Failed!", msg, 'top-right', '#bf441d', 'error', false);
                    }
                    $('#btnSendNotification').button('reset');
                }

            });
        }
    });
    $('#mdSendNotification').on('hide.bs.modal', function (e) {
        $('#frmSendNotification')[0].reset();
        $('#btnSendNotification').button('reset');
    });
});