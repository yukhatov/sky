<h1>Login Page</h1>
<br>

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

<form action="index.php?route=user/login" id="operation-form" method="post">
    <div id="username" class="col-md-3 col-sm-6 col-xs-12">
        <label>Username:</label>
        <input id="username-input" type="text" class="form-control" name="username">

        <label>Password:</label>
        <input id="pass-input" type="text" class="form-control" name="pass">
        <br>
        <input id="button-submit" type="submit" class="btn btn-primary" name="submit" value="Login" style="width: 30%">
    </div>
</form>

