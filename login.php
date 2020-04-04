<?php
require "polices.php";
?>
<html>

<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>

<body>
  <div id="login">
    <h3 class="text-center text-white pt-5">Login Page</h3>
    <div class="container">
      <div id="login-row" class="row justify-content-center align-items-center">
        <div id="login-column" class="col-md-6">
          <div id="login-box" class="col-md-12">
            <form id="login-form" class="form">
              <h3 class="text-center text-info">Welcome using note system!</h3>
              <div class="form-group">
                <label for="username" class="text-info">Username:</label><br>
                <input type="text" name="user_name" id="username" class="form-control">
              </div>
              <div class="form-group">
                <label for="password" class="text-info">Password:</label><br>
                <input type="password" name="password" id="password" class="form-control">
              </div>
              <div class="form-group">
                <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                <input id="submitBtn" type="button" name="submit" class="btn btn-info btn-md" value="submit">
              </div>
              <div id="register-link" class="text-right">
                If you do not have account yet, please <a class="text-info" href="/assign2/create_user.php">register</a> firstly!</h3>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>    
  <script type="text/javascript">
    window.onload = function() {
      $("#submitBtn").click(function() { 
        $.post("login_handler.php", {
          user_name: $("#username").val(),
          password: $("#password").val()
          }, function(data, status) {
            let json_obj = JSON.parse(data);
            alert(json_obj.msg)
            if(json_obj.success == 1){
              window.location.href=("main.php");
            }
          });
      });

    }
  </script>
</body>

</html>

