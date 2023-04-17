// ajax script for Menu
$(document).on('change', '#PGender', function () {
    var Group_IdKey = $(this).val();
    if (Group_IdKey) {
        $.ajax({
            type: 'GET',
            url: '../ijson/MenuView.php',
            data: {'PGenderIdKey': Group_IdKey},
            success: function (result) {
                $('#PCategory').html(result);

            }
        });
    } else {
        $('#PCategory').html('<option value=""></option>');
        $('#PGroup').html('<option value=""></option>');
    }
});

// ajax script for Menu
$(document).on('change', '#PCategory', function () {
    var Group_IdKey = $(this).val();
    if (Group_IdKey) {
        $.ajax({
            type: 'GET',
            url: '../ijson/MenuView.php',
            data: {'PCategoryIdKey': Group_IdKey},
            success: function (result) {
                $('#PGroup').html(result);

            }
        });
    } else {
        $('#PGroup').html('<option value=""></option>');

    }
});