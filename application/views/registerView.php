<h1>Register Page</h1>

<?php
if ($data['error'] != "") {
    echo sprintf('<br>
        <div class="alert alert-danger">
            <strong>Error!</strong> %s
        </div>', $data['error']);
} elseif ($data['success'] != "") {
    echo sprintf('<br>
        <div class="alert alert-success">
            <strong>Success!</strong>%s
        </div>', $data['success']);
}
?>
<br>
<form action="index.php?route=user/create" id="operation-form" method="post">
    <div id="username" class="col-md-3 col-sm-6 col-xs-12">
        <label>Username:</label>
        <input id="username-input" type="text" class="form-control" name="username">

        <label>Password:</label>
        <input id="pass-input" type="text" class="form-control" name="pass">

        <label>Confirm Password:</label>
        <input id="confirm-pass-input" type="text" class="form-control" name="confirm-pass">

        <label>Email:</label>
        <input id="email-input" type="text" class="form-control" name="email">
        <br>
        <input id="button-submit" type="submit" class="btn btn-primary" name="submit" value="Register" style="width: 30%">
    </div>
</form>

