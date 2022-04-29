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
                <div class="col-3">
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Admin Dashboard
                            <input type="hidden" id="userId" value="<?php echo $_GET['userid'] ?>" />
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive" id="myTable">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Usertype</th>
                                    <th scope="col">Firstname</th>
                                    <th scope="col">lastname</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!--<tr>
                                    <th scope="row" id="number"></th>
                                    <td id="usertype"></td>
                                    <td id="firstname"></td>
                                    <td id="lastname"></td>
                                    <td id="username"></td>
                                </tr>-->
                                </tbody>
                            </table>
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
        var settings = {
            "url": "http://localhost/eduhub/api/users/read.php?userid="+userId,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/json"
            },
        };

        $.ajax(settings).done(function (response) {
            console.log(response);
            for (var i=0;i<response['userdata'].length;i++){
                var row = $('<tr>' +
                                '<td>'+(i+1)+ '</td>' +
                                '<td>'+ response['userdata'][i]['usertype']+ '</td>' +
                                '<td>'+response['userdata'][i]['firstname']+'</td>' +
                                '<td>'+response['userdata'][i]['lastname']+'</td>'+
                                '<td>'+response['userdata'][i]['username']+'</td>'+
                                '<td>' +
                                    '<a href="updateuser.php?id=<?php echo"'+response['userdata'][i]['id']+'"?>"><button class="btn btn-success btn-sm">update</button></a><a href="deleteuser.php?id=<?php echo"'+response['userdata'][i]['id']+'"?>&adminid=<?php echo $_GET['userid']?>"><button class="btn btn-danger btn-sm">delete</button></a></td>'+
                            '<tr>');
                $('#myTable').append(row);
            }
        });
    })
</script>
</body>
</html>

