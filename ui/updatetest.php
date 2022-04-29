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
                                Update Test
                                <input type="hidden" id="testId" value="<?php echo $_GET['testid'] ?>" />
                            </div>
                            <div class="card-body">
                                <form action="/updatetest.php" method="post" id="update">
                                    <div class="mb-3">
                                        <label for="exampleInputText" class="form-label">Test Name</label>
                                        <input type="text" class="form-control" name="testname" value="" id="testname" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputText" class="form-label">Test Date</label>
                                        <input type="date" class="form-control" name="testdate" value="" id="testdate" required>
                                    </div>
                                    <input type="submit" id="formSubmit" name="submit" class="btn btn-primary" value="Update Test">
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
            var testId = $('#testId').val()
            $("#update").submit(function(e){
                e.preventDefault()
                debugger;
                console.log(e)
                var settings = {
                    "url": "http://localhost/eduhub/api/teachers/updateTest.php",
                    "method": "PUT",
                    "timeout": 0,
                    "headers": {
                        "Content-Type": "application/json"
                    },
                    "data": JSON.stringify({
                        "testname": $("#testname").val(),
                        "testdate": $("#testdate").val(),
                        "id": testId
                    }),
                };

                $.ajax(settings).done(function (response) {
                    console.log(response);
                    alert(response['message'])
                    // response['userdata'][0]['message']
                });
            })
        })

        //get subject name
        $(document).ready(function(){
            var testid = $('#testId').val()
            var settings = {
                "url": "http://localhost/eduhub/api/teachers/readTestWithTestId.php?testid="+testid,
                "method": "GET",
                "timeout": 0,
                "headers": {
                    "Content-Type": "application/json"
                },
            };

            $.ajax(settings).done(function (response) {
                console.log(response);
                //$("#subjectname").text(response['subjectdata'][0]['subjectname'])
                $("#testname").val(response['testdata'][0]['testname']);
                $("#testdate").val(response['testdata'][0]['testdate']);
                console.log(response);
            });
        })
    </script>
</body>
</html>

