$(document).ready(function () {
    displayData();

    function displayData() {
        $.ajax({
            type: "POST",
            url: "display.php",
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            dataType: "html",   //expect html to be returned
            success: function (response) {
                $("#responsecontainer").html('');
                $("#responsecontainer").html(response);
                //alert(response);
            }
        });
    }


    function updateData(id, column_name, value) {
        $.ajax({
            url: "update.php",
            type: "POST",
            async: false,
            data: {
                id: id,
                column_name: column_name,
                value: value
            },
            success: function (data) {
                $('#alert_message').html('<div class="alert alert-success">' + data + '</div>');
                $('#responsecontainer').html('');
                $('#message').html(data);
                displayData();
            }
        });
        setTimeout(function() {
            $('#message').html('')
        }
        , 5000);
    }



    $(document).on('click', '#submit', function () {
        var itemId = $("#itemId").val();
        var name = $("#name").val();
        var description = $("#description").val();
        var price = $("#price").val();
        var availability = $("#availability").val();
        if (name != '' && description != '' && price != '' && availability != '') {

            $.ajax({
                url: "add.php",
                type: "POST",
                async: false,
                data: {
                    "done": 1,
                    "id": itemId,
                    "itemName": name,
                    "description": description,
                    "price": price,
                    "availability": availability
                },
                success: function (data) {
                    $("#itemId").val('');
                    $("#name").val('');
                    $("#description").val('');
                    $("#price").val('');
                    $("#availability").val('');
                    $('#responsecontainer').html('');
                    $('#message').html(data);
                    displayData();
                }
            });
            setTimeout(function() {
                    $('#message').html('')
                }
                , 5000);
        }
        else {
            alert("All fields are required");
        }
    });

    $(document).delegate('#delete', 'click', function () {
        var itemId = $(this).attr("data-id");
        if (confirm("Are you sure you want to delete this?")) {
            $.ajax({
                url: "delete.php",
                type: "POST",
                async: false,
                data: {
                    id: itemId
                },
                dataType: "text",
                success: function (data) {
                    $('#responsecontainer').html('');
                    $('#message').html(data);
                    displayData();
                }
            });
            setTimeout(function() {
                    $('#message').html('')
                }
                , 5000);
        }
    });

    $(document).on('blur', '.update', function () {
        var id = $(this).attr("data-id");
        var column_name = $(this).attr("data-column");
        var value = $(this).text();
        updateData(id, column_name, value);
    });
});
