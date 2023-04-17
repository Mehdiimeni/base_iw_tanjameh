// ajax script for Menu
$(document).on('change', '#NewMenuId', function () {
    var Menu_Id = $(this).val();
    if (Menu_Id) {
        $.ajax({
            type: 'get',
            url: '../ijson/NewMenuPanel.php',
            data: {'NewMenuId': Menu_Id},
            success: function (result) {
                $('#GroupIdKey').html(result);

            }
        });
    }
});

$(document).on('change', '#GroupIdKey', function () {
    var Menu2_Id = $(this).val();
    if (Menu2_Id) {
        $.ajax({
            type: 'get',
            url: '../ijson/NewMenuPanel.php',
            data: {'NewMenu2Id': Menu2_Id},
            success: function (result) {
                $('#NewMenu2Id').html(result);

            }
        });
    }
});

