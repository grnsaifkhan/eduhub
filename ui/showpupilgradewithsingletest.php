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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Test Grade List | Test Name : <span style="color: blueviolet" id="testName"></span>
                            <input type="hidden" id="testId" value="<?php echo $_GET['testid'] ?>" />
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive" id="myTable">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Grade</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>

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
        var testId = $('#testId').val()
        var settings = {
            "url": "http://localhost/eduhub/api/teachers/readSingleTestGrade.php?testid="+testId,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/json"
            },
        };

        $.ajax(settings).done(function (response) {
            console.log(response);
            $("#testName").text(response['singletestdata'][0]['testname'])
            for (var i=0;i<response['singletestdata'].length;i++){
                var row = $('<tr>' +
                    '<td>'+(i+1)+ '</td>' +
                    '<td>'+ response['singletestdata'][i]['firstname']+" "+response['singletestdata'][i]['lastname']+ '</td>' +
                    '<td>'+ response['singletestdata'][i]['grade']+ '</td>' +
                    '<td>' +
                    '<a href="updatetestgrade.php?testid=<?php echo"'+response['singletestdata'][i]['testid']+'"?>&studentusername=<?php echo"'+response['singletestdata'][i]['studentusername']+'"?>"><button class="btn btn-warning btn-sm">Update Test Grade</button></a></td>'+
                    '<tr>');
                $('#myTable').append(row);
            }
        });
    })
</script>
</body>
</html>

