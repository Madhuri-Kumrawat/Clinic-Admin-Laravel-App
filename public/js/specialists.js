$(document).ready(function (e) {
    $('#tblSpecialist').DataTable({
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
            "url": APP_URL + "/admin/specialists_xhr",
            "type":"POST",
            "data": function (d) {
            	 d.specialistType = $('#specialistType').val();
            }
        },
        
    });
    $('#specialistType').on('change',function(e){
    	$('#tblSpecialist').DataTable().draw();
    });
    
    $(document).on('click', '#btnAddSpecialist',function (e) {
        $('#frmAddSpecialist').validate();
        if ($('#frmAddSpecialist').valid()) {
            var form_data = new FormData($('#frmAddSpecialist')[0]);
            $.ajax({
                url: APP_URL + "/admin/saveSpecialist",
                data: form_data,
                method: 'POST',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#btnAddSpecialist').button('loading');
                },
                success: function (r) {
                    var data = $.parseJSON(r);
                    if (data.success) {
                        $('#frmAddSpecialist')[0].reset();
                        $("#mdAddSpecialist").modal("hide");
                        $.NotificationApp.send("Done!", "The Specialist has been added successfully!", 'top-right', '#5ba035', 'success');
                        $('#tblSpecialist').DataTable().draw();
                    } else {
                        msg = 'Something Went Wrong!';
                        if (data.msg) {
                            msg = data.msg;
                        }
                        $.NotificationApp.send("Failed!", msg, 'top-right', '#bf441d', 'error', false);
                    }
                    $('#btnAddSpecialist').button('reset');
                }

            });
        }
    });
    $('#tblSpecialist').on('click', '.edit_specialist', function () {
        var specialistId = $(this).data('id');
        $.ajax({
            url: APP_URL + "/admin/specialist_detail?specialistId=" + specialistId,
            method: 'POST',
            success: function (d) {
                var x = JSON.parse(d);
                if (x.success == true) {
                    $('#specialistName').val(x.specialistInfo.name);                    
                    $('#specialist_type').val(x.specialistInfo.specialist_type);
                    if(x.specialistInfo.icon != ''){
                    	$('#preview').attr('src',APP_URL+'/'+x.specialistInfo.icon);
                    	$('#specialistImage').val(x.specialistInfo.icon);
                    	$('div.divPreview').show();
                    }
                    $('#specialistId').val(specialistId);
                    $('#mdAddSpecialist').modal('show');
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
    $('#tblSpecialist').on('click', '.remove_specialist', function () {
        var specialistId = $(this).data('id');
        Swal.fire({
          title: "Are you sure you want to delete this Specialist?",
          text: "You won't be able to revert this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        }).then(function (result) {
          if (result.value) {
              $.ajax({
                  url: APP_URL + "/admin/removeSpecialist?specialistId=" + specialistId,
                  method: 'POST',
                  success: function (d) {
                      var x = JSON.parse(d);
                      if (x.success == true) {
                          $('#tblSpecialist').DataTable().draw();
                          $.NotificationApp.send("Done!", "The Specialist has been deleted successfully!", 'top-right', '#5ba035', 'success');
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
    
    $(document).on('change',"#imageFile",function(){
        readURL(this);
    });
    $('#mdAddSpecialist').on('hide.bs.modal', function (e) {
        $('#frmAddSpecialist')[0].reset();
        $('#frmAddSpecialist #specialistId').val('');
        $('#btnAddSpecialist').button('reset');
        $('#preview').attr("src","");
        $('#specialistImage').val("");
        $('div.divPreview').hide();
    });
});
 function readURL(input){    	
	if (input.files && input.files[0]) {
		console.log('comin');
	    var reader = new FileReader();
	    
	    reader.onload = function(e) {
	      $('#preview').attr('src', e.target.result);
	    }
	    
	    reader.readAsDataURL(input.files[0]);
	    $('div.divPreview').show();
	  }else{
		  $('div.divPreview').hide();
	  }
    $('#specialistImage').val('');
 }