$(document).ready(function () {
    $('#example').DataTable();

    if (window.location.search) {
        history.replaceState(null, document.title, window.location.pathname);
    }

    $('.delete_user').on('click', function () {
        var data = $(this).closest('tr').find("input[type='hidden']").val();
        var encrypt_data = JSON.parse(atob(data));
        $(".user_id").val(encrypt_data.uid);
        $("#select_user").html(encrypt_data.name);
        $("#prev_photo").val(encrypt_data.photo);
    });


    $('.update_user').on('click', function () {
        var data = $(this).closest('tr').find("input[type='hidden']").val();
        var encrypt_data = JSON.parse(atob(data));
        $("#uid").val(encrypt_data.uid);
        $(".name").val(encrypt_data.name);
        $(".select_user").html(encrypt_data.name);
        $(".email").val(encrypt_data.email);
        $(".number").val(encrypt_data.number);
        $(".role").val(encrypt_data.role);
        $(".status").val(encrypt_data.status);
        $(".prev_photo").val(encrypt_data.photo);
        var img = `<img src="images/${encrypt_data.photo}" class="border h-100" width="100" alt="">`
        $("#img").html(img);
    });
});