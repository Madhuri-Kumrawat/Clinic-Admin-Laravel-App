$(document).ready(function (e) {
    $('#tblProfile').DataTable({
        "language": {
            "paginate": {
                "previous": "<i class='fa fa-chevron-left'>",
                "next": "<i class='fa fa-chevron-right'>"
            },
            "processing": "Processing.... Please Wait.",
        },
        "processing": true,
        "serverSide": true,
        "order": [[1, "DESC"]],
        "ajax": {
            "url": APP_URL + "/admin/profile_xhr",
            "type": "POST",
            "data": function (d) {
                d.specialistType = $('#specialistType').val();
            }
        },
    });
    $('#specialistType').on('change', function (e) {
        $('#tblProfile').DataTable().draw();
    });

    function get_speciality(sType, selected) {
        var opt = "";
        $("#specialist_id option:gt(0)").remove();
        if (sType) {
            $.ajax({
                url: APP_URL + "/admin/get-specialist?specialist_type=" + sType,
                method: 'GET',
                success: function (d) {
                    var data = JSON.parse(d);
                    if (data) {
                        $.each(data.specialists, function () {
                            $("#specialist_id").append("<option value='" + this.id + "'>" + this.name + "</option>");
                        });
                        $("#specialist_id").val(selected);
                    }
                }
            });
        }
        return false;
    }

    $("#specialist_type").on("change", function () {
        get_speciality($(this).val());
    });

    $(document).on('click', '#btnAddProfile', function (e) {
        if ($('#frmAddProfile').valid()) {
            var form_data = new FormData($('#frmAddProfile')[0]);
            $.ajax({
                url: APP_URL + "/admin/save-profile",
                data: form_data,
                method: 'POST',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#btnAddProfile').button('loading');
                },
                success: function (r) {
                    var data = $.parseJSON(r);
                    if (data.success) {
                        $('#frmAddProfile')[0].reset();
                        $("#mdAddProfile").modal("hide");
                        $.NotificationApp.send("Done!", "The Profile has been added successfully!", 'top-right', '#5ba035', 'success');
                        $('#tblProfile').DataTable().draw();
                    } else {
                        msg = 'Something Went Wrong!';
                        if (data.msg) {
                            msg = data.msg;
                        }
                        $.NotificationApp.send("Failed!", msg, 'top-right', '#bf441d', 'error', false);
                    }
                    $('#btnAddProfile').button('reset');
                }

            });
        }
    });

    /*$('#tblProfile').on('click', '.edit_profile', function () {
        var profileId = $(this).data('id');
        $.ajax({
            url: APP_URL + "/admin/profile_detail?profileId=" + profileId,
            method: 'POST',
            success: function (d) {
                var x = JSON.parse(d);
                if (x.success == true) {
                    $('#specialist_type').val(x.profileInfo.specialist_type);
                    get_speciality(x.profileInfo.specialist_type, x.profileInfo.specialist_id)
                    $('#profileId').val(profileId);
                    $('#mdAddProfile').modal('show');
                } else {
                    msg = 'Something Went Wrong!';
                    if (x.msg) {
                        msg = x.msg;
                    }
                    $.NotificationApp.send("Failed!", msg, 'top-right', '#bf441d', 'error', false);
                }
            }
        });
        return false;
    });*/
    $('#tblProfile').on('click', '.remove_profile', function () {
        if (confirm('Are you sure you want to delete this Profile?')) {
            var profileId = $(this).data('id');
            $.ajax({
                url: APP_URL + "/admin/removeProfile?profileId=" + profileId,
                method: 'POST',
                success: function (d) {
                    var x = JSON.parse(d);
                    if (x.success == true) {
                        $('#tblProfile').DataTable().draw();
                        $.NotificationApp.send("Done!", "The Profile has been deleted successfully!", 'top-right', '#5ba035', 'success');
                    } else {
                        msg = 'Something Went Wrong!';
                        if (x.msg) {
                            msg = x.msg;
                        }
                        $.NotificationApp.send("Failed!", msg, 'top-right', '#bf441d', 'error', false);
                    }
                }
            });
        }
        return false;
    });
});