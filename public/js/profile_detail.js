$(function () {
    $('[data-mask]').inputmask();

    //Initialize Select2 Elements
    $('#city').select2();

    $("#specialist_type").on("change", function () {
        get_speciality($(this).val());
    });
    $("#specialist_type").trigger("change");
    
    $(document).on('change', "#imageFile", function () {
        readURL(this);
    });

    //Timepicker
    $('#start_office_hours').datetimepicker({
        format: 'HH:mm'
    });
    $('#end_office_hours').datetimepicker({
        format: 'HH:mm'
    });


    $('#googleMap').locationpicker({
        location:
                {
                    latitude: 46.15242437752303,
                    longitude: 2.7470703125
                },
        radius: 300,
        inputBinding:
                {
                    latitudeInput: $('#lat'),
                    longitudeInput: $('#lon'),
                    radiusInput: $('#radius'),
                  //  locationNameInput: $('#address')
                },
        enableAutocomplete: true
    });
});
function get_speciality(sType) {
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
                    	var selected=($("#specialist_id").attr("data-selected-value")==this.id)?' selected ':'';
                        $("#specialist_id").append("<option value='" + this.id + "' "+selected+" >" + this.name + "</option>");
                    });
                }
            }
        });
    }
    return false;
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
        $('div.divPreview').show();
    } else {
        $('div.divPreview').hide();
    }
    $('#specialistImage').val('');
}