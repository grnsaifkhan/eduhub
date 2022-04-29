
<html>
<body>
<div class="card-header">
    <input type="hidden" id="userId" value="<?php echo $_GET['id']; ?>" />
    <input type="hidden" id="adminId" value="<?php echo $_GET['adminid']; ?>" />

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        var adminId = $('#adminId').val()
        var userId = $('#userId').val()
        var settings = {
            "url": "http://localhost/eduhub/api/users/delete.php?id="+userId,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/json"
            },
        };

        $.ajax(settings).done(function (response) {
            console.log(response);
            alert(response['message'])
            // response['userdata'][0]['message']
            window.location = '/eduhub/ui/userlist.php?userid='+adminId
        });
    })
</script>
</body>
</html>
