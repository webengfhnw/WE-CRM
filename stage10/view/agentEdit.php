<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 13.09.2017
 * Time: 21:48
 */
global $agent;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WE-CRM</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/navigation.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
<div class="container" style="display:flex;flex-direction:column;justify-content:center;">
    <div class="page-header">
        <h2 class="text-center"><strong>WE-CRM | Update</strong> your account. </h2></div>
    <form action="<?php echo $GLOBALS["ROOT_URL"]; ?>/agent/edit" method="post">
        <div class="form-group">
            <input class="form-control" type="text" name="name" placeholder="Name" value="<?php echo isset($this->agent) ? $this->agent->getName() : ''; ?>">
        </div>
        <div class="form-group">
            <input class="form-control" type="email" name="email" placeholder="Email" value="<?php echo isset($this->agent) ? $this->agent->getEmail() : ''; ?>">
        </div>
        <div class="form-group">
            <input class="form-control" type="password" name="password" placeholder="Password">
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block" type="submit">Update</button>
        </div>
    </form>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/script.js"></script>
</body>

</html>