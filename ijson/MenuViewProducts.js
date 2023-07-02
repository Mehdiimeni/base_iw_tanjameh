// ajax script for Menuurl_group
$(document).on('change', '#url_gender', function () {
    var gender_val = $(this).val();
    if (gender_val) {
        $.ajax({
            type: 'POST',
            url: '../ijson/MenuViewProducts.php',
            data: {'url_gender': gender_val},
            success: function (result) {
                $('#url_category').html(result);

            }
        });
    }
});

// ajax script for Menu
$(document).on('change', '#url_category', function () {
    var category_val = $(this).val();
    if (category_val) {
        $.ajax({
            type: 'POST',
            url: '../ijson/MenuViewProducts.php',
            data: {'url_category': category_val},
            success: function (result) {
                $('#url_group').html(result);

            }
        });
    }
});

// ajax script for Menu
$(document).on('change', '#url_group', function () {
    var group_val = $(this).val();
    if (group_val) {
        $.ajax({
            type: 'POST',
            url: '../ijson/MenuViewProducts.php',
            data: {'url_group': gender_val},
            success: function (result) {
                $('#url_group2').html(result);

            }
        });
    }
});