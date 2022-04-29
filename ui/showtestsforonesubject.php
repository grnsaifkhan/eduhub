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
                            Test list
                            <input type="hidden" id="subjectId" value="<?php echo $_GET['subjectid'] ?>" />
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive" id="myTable">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Test Name</th>
                                    <th scope="col">Test date</th>
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
        var subjectId = $('#subjectId').val()
        var settings = {
            "url": "http://localhost/eduhub/api/teachers/readTestForOneSubject.php?subjectid="+subjectId,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/json"
            },
        };

        $.ajax(settings).done(function (response) {
            console.log(response);
            for (var i=0;i<response['testdataofonesubject'].length;i++){
                var row = $('<tr>' +
                    '<td>'+(i+1)+ '</td>' +
                    '<td>'+ response['testdataofonesubject'][i]['testname']+ '</td>' +
                    '<td>'+ response['testdataofonesubject'][i]['testdate']+ '</td>' +
                    '<td>' +
                    '<a href="updatetest.php?testid=<?php echo"'+response['testdataofonesubject'][i]['id']+'"?>"><button class="btn btn-warning btn-sm">Update Test</button></a><a href="showpupilgradewithsingletest.php?testid=<?php echo"'+response['testdataofonesubject'][i]['id']+'"?>"><button class="btn btn-primary btn-sm">Pupil With Test Grade</button></a><a href="createtestgrade.php?testid=<?php echo"'+response['testdataofonesubject'][i]['id']+'"?>"><button class="btn btn-success btn-sm">Add Test Grade</button></a><a href="removetest.php?testid=<?php echo"'+response['testdataofonesubject'][i]['id']+'"?>&subjectid=<?php echo $_GET['subjectid']?>"><button class="btn btn-danger btn-sm">Remove Test</button></a></td>'+
                    '<tr>');
                $('#myTable').append(row);
            }
        });
    })
</script>
</body>
</html>

