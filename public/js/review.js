$(document).ready(function (e) {
    $('#tblReviews').DataTable({
        "language": {
            "paginate": {
                "previous": "<i class='fa fa-chevron-left'>",
                "next": "<i class='fa fa-chevron-right'>"
            },
            "processing": "Processing.... Please Wait.",
        },
        "processing": true,
        "serverSide": true,
        "order": [[4, "DESC"]],
        "ajax": {
            "url": APP_URL + "/admin/reviews_xhr",
            "type":"POST",
            "data": function (d) {
                
            }
        },
        
    });
    $('#tblReviews').on('click', '.remove_review', function () {
    	var reviewId = $(this).data('id');
          Swal.fire({
            title: "Are you sure you want to delete this Review?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
          }).then(function (result) {
            if (result.value) {            	
              $.ajax({
                  url: APP_URL + "/admin/removeReview?reviewId=" + reviewId,
                  method: 'POST',
                  success: function (d) {
                      var x = JSON.parse(d);
                      if (x.success == true) {
                          $('#tblReviews').DataTable().draw();
                          $.NotificationApp.send("Done!", "The Review has been removed successfully!", 'top-right', '#5ba035', 'success');
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
});