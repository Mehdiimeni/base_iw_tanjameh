// ajax script for Menu
$(document).on('change', '#PGender', function () {
    var Group_Name = $(this).val();
    if (Group_Name) {
        $.ajax({
            type: 'POST',
            url: '../ijson/MenuViewProducts.php',
            data: {'PGenderName': Group_Name},
            success: function (result) {
                $('#PCategory').html(result);

            }
        });
    }
});

// ajax script for Menu
$(document).on('change', '#PCategory', function () {
    var Group_Name = $(this).val();
    if (Group_Name) {
        $.ajax({
            type: 'POST',
            url: '../ijson/MenuViewProducts.php',
            data: {'PCategoryName': Group_Name},
            success: function (result) {
                $('#PGroup').html(result);

            }
        });
    }
});

// ajax script for Menu
$(document).on('change', '#PGroup', function () {
    var Group_Name = $(this).val();
    if (Group_Name) {
        $.ajax({
            type: 'POST',
            url: '../ijson/MenuViewProducts.php',
            data: {'PGroupName': Group_Name},
            success: function (result) {
                $('#PGroup2').html(result);

            }
        });
    }
});