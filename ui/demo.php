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
                                Add test grade for single user
                                <input type="hidden" id="testId" value="<?php echo $_GET['testid'] ?>" />
                            </div>
                                    <form action="/demo.php" method="post" id="login" class="col-lg-6 offset-lg-3 row justify-content-center">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" name="username" id="username" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password" id="password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="file" class="form-label">File</label>
                                            <input type="file" class="form-control" name="file" id="file" required>
                                        </div>
                                        <input type="submit" id="formSubmit" name="submit" class="btn btn-primary" value="Login">
                                    </form>
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
            var testId = $('#testId').val()
            $("#createtestgrade").submit(function(e){
                e.preventDefault()
                debugger;
                console.log(e)
                var settings = {
                    "url": "http://localhost/eduhub/api/teachers/addSingleStudentGrade.php",
                    "method": "POST",
                    "timeout": 0,
                    "headers": {
                        "Content-Type": "application/json"
                    },
                    "data": JSON.stringify({
                        "testid": testId,
                        "studentusername": $("#stdUsername").val(),
                        "grade": $("#testGrade").val()
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
            var testId = $('#testId').val()
            var settings = {
                "url": "http://localhost/eduhub/api/teachers/getPupilWithSameClassUsingTestId.php?testid="+testId,
                "method": "GET",
                "timeout": 0,
                "headers": {
                    "Content-Type": "application/json"
                },
            };

            $.ajax(settings).done(function (response) {
                console.log(response);
                for (var i=0;i<response['pupilwithsameclass'].length;i++){
                    var row = $('<option value="' + response['pupilwithsameclass'][i]['studentusername'] + '">'+response['pupilwithsameclass'][i]['studentusername']+'</option>');
                    $('#stdUsername').append(row);
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


        $("#login").submit(function(e){
            var testId = $('#testId').val()
            e.preventDefault()
            debugger;
            console.log(e)
            var formData = new FormData();
            formData.append('file', $('#file')[0].files[0])
            formData.append('testid', 4)
            var settings = {
                "url": "http://localhost/eduhub/api/teachers/importAllStudentsTestGrade.php",
                "method": "POST",
                "timeout": 0,
                "contentType": false,
                "processData": false,
                "data": formData,
            };

            /*$.ajax(settings).done(function (response) {
                window.location = '/eduhub/ui/profile.php?userid='+response['userdata'][0]['id']
            });*/
        })
    </script>
</body>
</html>

