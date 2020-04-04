<?php
require "polices.php";
?>
<html>

<head>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/create_note.css">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="main.php">Note System</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="main.php">Home
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="create_user.php">Registry</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="create_note.php">Create New Note</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="card border-0 shadow my-5">
            <div class="card-body p-5">
                <!-- 解锁框 -->
                <div class="form-group" id="decode_div" style="display:none">

                    <p class="lead">Ensure you have input a right key that we can resume the note normally!</p>
                    <label class="sr-only" for="key">Key for Decode: </label>
                    <form class="form-inline">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">#</div>
                            </div>
                            <input type="password" class="form-control" id="key" maxlength="16" name="encrypt_key">
                        </div>
                        <button id="submit_btn" type="button" class="btn btn-primary mb-2">Decode</button>
                    </form>
                </div>

                <!-- 文章内容渲染 -->
                <!-- <div id="decode_div" style="display:none">
                    <label for="key">Key for decode:</label><br>
                    <input id="key" type="password" />
                    <input id="submit_btn" type="button" value="Decode" />
                </div> -->

                <label id='title' class="display-4" for="title"></label>
                <hr>
                <div class="card">
                    <div class="card-body" id="content"></div>
                </div>
                <!-- <div  style="border:dashed"></div> -->
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
        window.onload = function() {
            $.ajax({
                type: 'POST',
                url: 'view_handler.php',
                data: {
                    note_id: "<?php if (!isset($_GET['note_id']) || is_null($_GET['note_id'])) {echo '';} else {echo $_GET['note_id'];} ?>",
                },
                success: function(data) {
                    console.log(data);
                    let json_obj = JSON.parse(data);
                    if (json_obj.success == 1) {
                        if (json_obj.is_private == 1) {
                            alert("this note has been encoded and you need to enter the right key to decode it.")
                            $("#title").html(json_obj.title)
                            var $new_p = $("<p>", {
                                style: "overflow-wrap: break-word"
                            }).prop('id', 'encrypted_p');
                            $new_p.text(json_obj.content)
                            $new_p.appendTo($('#content'));
                            $("#decode_div").show();
                        } else {
                            $("#decode_div").hide();
                            $("#title").html(json_obj.title)
                            $("#content").html(json_obj.content)
                        }
                    } else {
                        alert(json_obj.msg);
                        window.location.href = ("main.php");
                    }
                },
                error: function(data) {
                    alert("Failed to create note!! Bad request! ");
                    window.location.href = ("main.php");
                }
            });

            $("#submit_btn").click(function() {
                $.ajax({
                    type: 'POST',
                    url: 'view_handler.php',
                    data: {
                        key: $("#key").val(),
                        note_id: "<?php if (!isset($_GET['note_id']) || is_null($_GET['note_id'])) {echo '';} else {echo $_GET['note_id'];} ?>",
                    },
                    success: function(data) {
                        let json_obj = JSON.parse(data);
                        if (json_obj.success == 1) {
                            $("#content").html(json_obj.content)
                            $("#decode_div").hide();
                        } else {
                            alert(json_obj.msg);
                        }
                    },
                    error: function(data) {
                        alert("Failed to create note!! Bad request! ");
                    }
                });
            });
        }
    </script>
</body>

</html>