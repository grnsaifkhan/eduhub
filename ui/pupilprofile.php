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
                    <div class="card">
                        <div class="card-header">
                            Pupil Profile Information
                            <input type="hidden" id="stdUsername" value="<?php echo $_GET['studentusername'] ?>" />

                        </div>
                        <div class="card-body">
                            <p>
                                First Name:  <span id="firstname">

                            </span>
                            </p>

                            <p>
                                Last Name: <span id="lastname">

                            </span>
                            </p>

                            <p>
                                Usertype: <span id="usertype">

                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="card">
                        <div class="card-header">
                            Subject info
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Activity</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td style="color: #007bff">Current subjects details</td>
                                    <td>
                                        <a href="currentsubjectwithavggradeofonepupil.php?studentusername=<?php echo $_GET['studentusername']?>"><button class="btn btn-success btn-sm">Show</button></a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td style="color: #007bff">Archived subject details</td>
                                    <td>
                                        <a href="archivedsubjectwithavggradeofonepupil.php?studentusername=<?php echo $_GET['studentusername']?>"><button class="btn btn-success btn-sm">Show</button></a>
                                    </td>
                                </tr>
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
        var stdUsername = $('#stdUsername').val()
        var settings = {
            "url": "http://localhost/eduhub/api/users/readSinglePupil.php?studentusername="+stdUsername,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/json"
            },
        };

        $.ajax(settings).done(function (response) {
            console.log(response);
            $("#firstname").text(response['singlestudentwithusername'][0]['firstname'])
            $("#lastname").text(response['singlestudentwithusername'][0]['lastname'])
            $("#usertype").text(response['singlestudentwithusername'][0]['usertype'])
            console.log(response);
        });
    })
</script>
</body>
</html>

