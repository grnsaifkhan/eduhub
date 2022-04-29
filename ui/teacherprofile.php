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
                            Teacher Profile Information
                            <input type="hidden" id="userId" value="<?php echo $_GET['userid'] ?>" />

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
                            Subject Management
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive" id="myTable">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Subject name</th>
                                    <th scope="col">Classname</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>

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
        var teacherId = $('#userId').val()
        var settings = {
            "url": "http://localhost/eduhub/api/users/readSingleUser.php?userid="+teacherId,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/json"
            },
        };

        $.ajax(settings).done(function (response) {
            console.log(response);
            $("#firstname").text(response['singleuserid'][0]['firstname'])
            $("#lastname").text(response['singleuserid'][0]['lastname'])
            $("#usertype").text(response['singleuserid'][0]['usertype'])
            console.log(response);
        });
    })


    //for subjectlist and info
    $(document).ready(function(){
        var teacherId = $('#userId').val()
        var settings = {
            "url": "http://localhost/eduhub/api/subjects/getSubjectWithTeacherAndClassForOneTeacher.php?teacherid="+teacherId,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/json"
            },
        };

        $.ajax(settings).done(function (response) {
            console.log(response);
            for (var i=0;i<response['subjectinfoforoneteacher'].length;i++){
                var row = $('<tr>' +
                    '<td>'+(i+1)+ '</td>' +
                    '<td>'+ response['subjectinfoforoneteacher'][i]['subjectname']+ '</td>' +
                    '<td>'+ response['subjectinfoforoneteacher'][i]['classname']+ '</td>' +
                    '<td >' +
                    '<a href="assignedpupilinsubject.php?subjectid=<?php echo"'+response['subjectinfoforoneteacher'][i]['subjectid']+'"?>"><button class="btn btn-success btn-sm">Pupil Average Grade</button></a><a href="createtest.php?subjectid=<?php echo"'+response['subjectinfoforoneteacher'][i]['subjectid']+'"?>&teacherid=<?php echo $_GET['userid']?>"><button class="btn btn-primary btn-sm">Add Test</button></a><a href="showtestsforonesubject.php?subjectid=<?php echo"'+response['subjectinfoforoneteacher'][i]['subjectid']+'"?>"><button class="btn btn-warning btn-sm">Show Test</button></a></td>'+
                    '<tr>');
                $('#myTable').append(row);
            }
        });
    })
</script>
</body>
</html>

