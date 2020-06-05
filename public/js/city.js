$(document).ready(function (e) {
    $('#tblCity').DataTable({
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
            "url": APP_URL + "/admin/city_xhr",
            "type":"POST",
            "data": function (d) {
                
            }
        },
        
    });
    $('#btnAddCity').on('click', function (e) {
        $('#frmAddCity').validate();
        if ($('#frmAddCity').valid()) {
            var d = $('#frmAddCity').serialize();
            $.ajax({
                url: APP_URL + "/admin/saveCity",
                data: d,
                method: 'POST',
                beforeSend: function () {
                    $('#btnAddCity').button('loading');
                },
                success: function (r) {
                    var data = $.parseJSON(r);
                    if (data.success) {
                        $('#frmAddCity')[0].reset();
                        $("#mdAddCity").modal("hide");
                        $.NotificationApp.send("Done!", "The City has been added successfully!", 'top-right', '#5ba035', 'success');
                        $('#tblCity').DataTable().draw();
                    } else {
                        msg = 'Something Went Wrong!';
                        if (data.msg) {
                            msg = data.msg;
                        }
                        $.NotificationApp.send("Failed!", msg, 'top-right', '#bf441d', 'error', false);
                    }
                    $('#btnAddCity').button('reset');
                }

            });
        }
    });
    $('#tblCity').on('click', '.edit_city', function () {
        var cityId = $(this).data('id');
        $.ajax({
            url: APP_URL + "/admin/city_detail?cityId=" + cityId,
            method: 'POST',
            success: function (d) {
                var x = JSON.parse(d);
                if (x.success == true) {
                    $('#cityName').val(x.cityInfo.name);                    
                    $('#cityId').val(cityId);
                    $('#mdAddCity').modal('show');
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
    });
    $('#tblCity').on('click', '.remove_city', function () {
    	var CityId = $(this).data('id');
          Swal.fire({
            title: "Are you sure you want to delete this City?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
          }).then(function (result) {
            if (result.value) {            	
              $.ajax({
                  url: APP_URL + "/admin/removeCity?cityId=" + CityId,
                  method: 'POST',
                  success: function (d) {
                      var x = JSON.parse(d);
                      if (x.success == true) {
                          $('#tblCity').DataTable().draw();
                          $.NotificationApp.send("Done!", "The City has been deleted successfully!", 'top-right', '#5ba035', 'success');
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
          });
        return false;
    });
    $('#mdAddCity').on('hide.bs.modal', function (e) {
        $('#frmAddCity')[0].reset();
        $('#frmAddCity #cityId').val('');
        $('#btnAddCity').button('reset');
    });
});