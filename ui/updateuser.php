<?php

?>

<!DOCTYPE html>
<html>
<?php include 'head.php'?>
<body>
<?php include 'navigation.php'?>

<div class="container-fluid">

    <div class="content">
        <div class="container-fluid">

            <div style="margin: 15px">
                <div class="row center" >
                    <div class="">
                        <div class="card">
                            <div class="card-header">
                                User Form
                                <input type="hidden" id="userId" value="<?php echo $_GET['id'] ?>" />
                            </div>
                            <div class="card-body">
                                <form action="/updateuser.php" method="post" id="update">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">Username: <span style="color: #1B5DD1" id="userName"></span></label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">Firstname</label>
                                        <input type="text" class="form-control" name="firstname" id="firstname" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">Lastname</label>
                                        <input type="text" class="form-control" name="lastname" id="lastname" required>
                                    </div>
                                    <input type="submit" id="formSubmit" name="submit" class="btn btn-primary" value="Update">
                                </form>
                                <div>
                               <span id="print">

                               </span>
                                </div>
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
            var userId = $('#userId').val()

            $("#update").submit(function(e){
                e.preventDefault()
                debugger;
                console.log(e)
                var settings = {
                    "url": "http://localhost/eduhub/api/users/update.php",
                    "method": "PUT",
                    "timeout": 0,
                    "headers": {
                        "Content-Type": "application/json"
                    },
                    "data": JSON.stringify({
                        "firstname": $("#firstname").val(),
                        "lastname": $("#lastname").val(),
                        "id": userId
                    }),
                };

                $.ajax(settings).done(function (response) {
                    console.log(response);
                    alert(response['message'])
                    // response['userdata'][0]['message']
                });
            })
        })

        $(document).ready(function(){
            var userId = $('#userId').val()
            var settings = {
                "url": "http://localhost/eduhub/api/users/readSingleUser.php?userid="+userId,
                "method": "GET",
                "timeout": 0,
                "headers": {
                    "Content-Type": "application/json"
                },
            };

            $.ajax(settings).done(function (response) {
                console.log(response);
                $("#userName").text(response['singleuserid'][0]['username'])
                $("#firstname").val(response['singleuserid'][0]['firstname']);
                $("#lastname").val(response['singleuserid'][0]['lastname']);
                console.log(response);
            });
        })
    </script>
</body>
</html>

