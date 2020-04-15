<?php
require "polices.php";
if(! isset($_SESSION["user"])){
    header("Location: login.php");
}
?>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
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

    <header>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <!-- Slide One - Set the background image for this slide in the line below -->
                <div class="carousel-item active" style="background-image: url('pic/photo-1533134486753-c833f0ed4866.jfif')">
                    <div class="carousel-caption d-none d-md-block">
                        <h3 class="display-4">Mark those impressive moment</h3>
                        <p class="lead">Life is beautiful, isn't it?</p>
                    </div>
                </div>
                <!-- Slide Two - Set the background image for this slide in the line below -->
                <div class="carousel-item" style="background-image: url('pic/photo-1468657988500-aca2be09f4c6.jfif')">
                    <div class="carousel-caption d-none d-md-block">
                        <h3 class="display-4">Mark those impressive moment</h3>
                        <p class="lead">Life is beautiful, isn't it?</p>
                    </div>
                </div>
                <!-- Slide Three - Set the background image for this slide in the line below -->
                <div class="carousel-item" style="background-image: url('pic/photo-1490822061517-61b5e64bf21c.jfif')">
                    <div class="carousel-caption d-none d-md-block">
                        <h3 class="display-4">Mark those impressive moment</h3>
                        <p class="lead">Life is beautiful, isn't it?</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </header>

    <!-- Page Content -->
    <section class="py-5">
        <div class="container">
            <h1 class="font-weight-light">Hi, <?php echo $_SESSION['user']; ?>. Welcome back!</h1>
            <p class="lead">Always remember keep note for your life.</p>
            <form class="form-inline">
                <div class="form-group mb-2">
                    <label for="staticEmail2" class="sr-only">Search notes:</label>
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="Search notes:">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="s_key_input" class="sr-only">SearchKeyWords</label>
                    <input type="text" class="form-control" id="s_key_input" placeholder="E.g. yesterday..">
                </div>
                <button id="submitBtn" type="button" class="btn btn-primary mb-2">Search</button>
                <a class="btn btn-info mb-2" href="create_note.php" role="button">Create A New Note</a>
            </form>
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status" id="wait_animation_div">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div>
                <p class="lead" id="_placeholder"></p>
                <table id="note_table" style="display:none" class="table">
                    <thead class="thead-dark">
                        <th>No. </th>
                        <th>Note Title</th>
                        <th>State </th>
                        <th>To View it</th>
                        <th>Enable it to be search</th>
                    </thead>
                </table>
            </div>
        </div>
    </section>

    <!--
    <h1>Hi, <?php echo $_SESSION['user']; ?>! Welcome back!</h1>
        <form>
            Search notes:
            <input id="s_key_input" type="text" name="k">
            <input id="submitBtn" type="button" value="search" >
            <a href="create_note.php"><input type="button" value="create new note"></button></a>
        </form>
        <div>
            <p id="_placeholder"></p>
            <table id="note_table" style="display:none">
                <thead>
                    <th>No. </th>
                    <th>Note Title</th>
                    <th>State </th>
                    <th>To View it</th>
                    <th>Enable it to be search</th>
                </thead>
            </table>
        </div>
-->
</body>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    window.onload = function() {
        $("#wait_animation_div").show();
        $.ajax({
            type: 'GET',
            url: 'main_handler.php',
            data: {},
            success: function(data) {
                let json_obj = JSON.parse(data);
                if (json_obj.success == 1) {
                    $("#_placeholder").hide()
                    $("#note_table").show()
                    var note_list = json_obj.data;
                    for (index = 0; index < note_list.length; index++) {
                        var $row = $("<tr>", {
                            class: ""
                        }).prop('id', 'table-row');
                        $row.append($("<td>").html(index+1));
                        $row.append($("<td>").html(note_list[index].title));
                        $row.append($("<td>").html(note_list[index].state));
                        $row.append($('<td><a href="' + note_list[index].link + '">View it</a></td>'));

                        if (0 == note_list[index].is_enabled_search) {
                            // $row.append($('<td>Not yet,<button>Enable it</button></td>'));    
                            // $row.append($('<td>Not yet, <a href="main_handler.php?note_id=' + note_list[index].note_id + '">Enable it</a></td>'));
                            $row.append($('<td>Not yet, <a href="#' + note_list[index].note_id + '" name="enableSearchLink">Enable it</a></td>'));
                        } else {
                            $row.append($("<td>").html('have been enabled'));
                        }
                        $row.appendTo($('#note_table'));
                    }
                    $('a[name=enableSearchLink]').on("click", function() {
                        var href_txt = $(this).attr('href');
                        var td_e = $(this).parent();
                        note_id = href_txt.substring(1, href_txt.length);
                        $.get("main_handler.php", {
                            note_id: note_id
                        }, function(data, status) {
                            let json_obj = JSON.parse(data);
                            if (json_obj.success == 1) {
                                alert("enable operation succeed!!")
                                td_e.html('have been enabled')
                            } else {
                                alert(json_obj.msg)
                            }
                            // alert("Data: " + data + "\nStatus: " + status);
                        });
                    });

                } else {
                    $("#_placeholder").html(json_obj.msg);
                }
            },
            error: function(data) {
                alert("Failed to create note!! Bad request! ");
                window.location.href = ("main.php");
            }
        });
        $("#wait_animation_div").hide();
        $("#submitBtn").click(function() {
            $("#wait_animation_div").show();
            $.ajax({
                type: 'GET',
                url: 'main_handler.php',
                data: {
                    k: $("#s_key_input").val(),
                },
                success: function(data) {
                    let json_obj = JSON.parse(data);
                    if (json_obj.success == 1) {
                        $("#_placeholder").hide()
                        $("#note_table").show()
                        // var thead = $("#note_table:first-child")
                        $("#note_table>tr").html('');
                        var note_list = json_obj.data;
                        for (index = 0; index < note_list.length; index++) {
                            var $row = $("<tr>", {
                                class: ""
                            }).prop('id', 'table-row');
                            $row.append($("<td scope=\"row\">").html(index+1));
                            $row.append($("<td>").html(note_list[index].title));
                            $row.append($("<td>").html(note_list[index].state));
                            $row.append($('<td><a href="' + note_list[index].link + '">View it</a></td>'));
                            $row.append($("<td>").html('have been enabled'));
                            $row.appendTo($('#note_table'));
                        }

                    } else {
                        $("#note_table").hide()
                        $("#_placeholder").show()
                        $("#_placeholder").html(json_obj.msg);
                    }
                },
                error: function(data) {
                    alert("Failed to create note!! Bad request! ");
                }
            });
            $("#wait_animation_div").hide();
        });
    }
</script>

</html>