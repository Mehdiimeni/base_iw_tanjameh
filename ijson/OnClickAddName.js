// ajax script for On Click Behaver



$(document).ready(function(){
    $(".name-main").on('change', function postinput(){
        var name_main = $(this).val(); // this.value
        var idkey_main = $(this).attr('id');
        $.ajax({
            url: '../ijson/OnClickAddName.php',
            data: { mainname: name_main , mainidkey : idkey_main },
            type: 'get'
        }).done(function(responseData) {
            console.log('Done: ', responseData);
        }).fail(function() {
            console.log('Failed');
        });
    });
});

$(document).ready(function(){
    $(".name-sub").on('change', function postinput(){
        var name_sub = $(this).val(); // this.value
        var idkey_sub = $(this).attr('id');
        $.ajax({
            url: '../ijson/OnClickAddName.php',
            data: { subname: name_sub , subidkey : idkey_sub },
            type: 'get'
        }).done(function(responseData) {
            console.log('Done: ', responseData);
        }).fail(function() {
            console.log('Failed');
        });
    });
});

$(document).ready(function(){
    $(".name-sub2").on('change', function postinput(){
        var name_sub2 = $(this).val(); // this.value
        var idkey_sub2 = $(this).attr('id');
        $.ajax({
            url: '../ijson/OnClickAddName.php',
            data: { sub2name: name_sub2 , sub2idkey : idkey_sub2 },
            type: 'get'
        }).done(function(responseData) {
            console.log('Done: ', responseData);
        }).fail(function() {
            console.log('Failed');
        });
    });
});

$(document).ready(function(){
    $(".name-sub4").on('change', function postinput(){
        var name_sub4 = $(this).val(); // this.value
        var idkey_sub4 = $(this).attr('id');
        $.ajax({
            url: '../ijson/OnClickAddName.php',
            data: { sub4name: name_sub4 , sub4idkey : idkey_sub4 },
            type: 'get'
        }).done(function(responseData) {
            console.log('Done: ', responseData);
        }).fail(function() {
            console.log('Failed');
        });
    });
});
