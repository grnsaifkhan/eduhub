<?php

?>

<!DOCTYPE html>
<html>
<?php include 'head.php'?>
<body>
<?php include 'navigation.php'?>

<div class="container-fluid">
    <div class="content">

        <div style="margin: 15px">
            <div class="row" >
                <div class="position-absolute top-50 start-50 translate-middle">
                    <div class="card">
                        <div class="card-header" id="alert">
                            Admin Login Form
                        </div>
                        <div class="card-body">
                            <form action="/adminlogin.php" method="post" id="login" class="col-lg-6 offset-lg-3 row justify-content-center">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" id="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" required>
                                </div>
                                <input type="submit" id="formSubmit" name="submit" class="btn btn-primary" value="Login">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $("#login").submit(function(e){
            e.preventDefault()
            debugger;
            console.log(e)
            var settings = {
                "url": "http://localhost/eduhub/api/users/login.php",
                "method": "POST",
                "timeout": 0,
                "headers": {
                    "Content-Type": "application/json"
                },
                "data": JSON.stringify({
                    "username": $("#username").val(),
                    "password": $("#password").val(),
                }),
            };


            $.ajax(settings).done(function (response) {
                window.location = '/eduhub/ui/adminprofile.php?userid='+response['userdata'][0]['id']
            });
        })
    })
</script>
</body>
</html>

