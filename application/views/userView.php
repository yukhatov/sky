<h2>User <?php echo $data['user']->getUsername(); ?> Settings</h2>
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
            <strong>Success!</strong> %s
        </div>', $data['success']);
}
?>
<br>
<form action="index.php?route=user/edit" id="operation-form" method="post">
    <div id="username" class="col-md-3 col-sm-6 col-xs-12">
        <input id="id-input" type="hidden" class="form-control" name="id" value=<?php echo $data['user']->getId(); ?>>

        <label>Email:</label>
        <input id="email-input" type="text" class="form-control" name="email" value=<?php echo $data['user']->getEmail(); ?>>
        <br>
        <input id="button-submit" type="submit" class="btn btn-primary" name="submit" value="Edit" style="width: 30%">
    </div>
</form>



