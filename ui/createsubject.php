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
                                Subject Form
                            </div>
                            <div class="card-body">
                                <form action="/createsubject.php" method="post" id="createsubject">
                                    <div class="mb-3">
                                        <label for="subjectname" class="form-label">Subject Name</label>
                                        <input type="text" class="form-control" name="subjectname" id="subjectname" required>
                                    </div>
                                    <div class="mb-3">
                                        <select class="form-select" aria-label="Default select example" name="isactive" id="classlist">
                                            <option selected>class</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <select class="form-select" aria-label="Default select example" name="isactive" id="teacherlist">
                                            <option selected>Teachers</option>
                                        </select>
                                    </div>
                                    <input type="submit" id="formSubmit" name="submit" class="btn btn-primary" value="Create Subject">
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
            $("#createsubject").submit(function(e){
                e.preventDefault()
                debugger;
                console.log(e)
                var settings = {
                    "url": "http://localhost/eduhub/api/subjects/create.php",
                    "method": "POST",
                    "timeout": 0,
                    "headers": {
                        "Content-Type": "application/json"
                    },
                    "data": JSON.stringify({
                        "subjectname": $("#subjectname").val(),
                        "classid": $("#classlist").val(),
                        "teacherid": $("#teacherlist").val()
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
            //var userId = $('#userId').val()
            var settings = {
                "url": "http://localhost/eduhub/api/classes/read.php",
                "method": "GET",
                "timeout": 0,
                "headers": {
                    "Content-Type": "application/json"
                },
            };

            $.ajax(settings).done(function (response) {
                console.log(response);
                for (var i=0;i<response['classdata'].length;i++){
                    var row = $('<option value="' + response['classdata'][i]['id'] + '">'+response['classdata'][i]['classname']+'</option>');
                    $('#classlist').append(row);
                }
            });
        })

        $(document).ready(function(){
            //var userId = $('#userId').val()
            var settings = {
                "url": "http://localhost/eduhub/api/users/getAllTeacher.php",
                "method": "GET",
                "timeout": 0,
                "headers": {
                    "Content-Type": "application/json"
                },
            };

            $.ajax(settings).done(function (response) {
                console.log(response);
                for (var i=0;i<response['teacherdata'].length;i++){
                    var row = $('<option value="' + response['teacherdata'][i]['id'] + '">'+response['teacherdata'][i]['username']+'</option>');
                    $('#teacherlist').append(row);
                }
            });
        })
    </script>
</body>
</html>

