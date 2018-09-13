<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 13.09.2017
 * Time: 21:48
 */
use domain\Agent;
use validator\AgentValidator;

isset($this->agent) ? $agent = $this->agent : $agent = new Agent();
isset($this->agentValidator) ? $agentValidator = $this->agentValidator : $agentValidator = new AgentValidator()
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($this->pageTitle) ? $this->pageTitle : "WE-CRM"; ?></title>
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
        <h2 class="text-center"><?php echo isset($this->pageHeading) ? $this->pageHeading : "<strong>WE-CRM | Create</strong> your account. "; ?></h2></div>
    <form action="<?php echo $GLOBALS["ROOT_URL"]; ?><?php echo isset($this->pageFormAction) ? $this->pageFormAction : "/register"; ?>" method="post">
        <div class="form-group <?php echo $agentValidator->isNameError() ? "has-error" : ""; ?>">
            <input class="form-control" type="text" name="name" placeholder="Name" value="<?php echo $agent->getName() ?>">
            <p class="help-block"><?php echo $agentValidator->getNameError() ?></p>
        </div>
        <div class="form-group <?php echo $agentValidator->isEmailError() ? "has-error" : ""; ?>">
            <input class="form-control" type="email" name="email" placeholder="Email" value="<?php echo $agent->getEmail() ?>">
            <p class="help-block"><?php echo $agentValidator->getEmailError() ?></p>
        </div>
        <div class="form-group <?php echo $agentValidator->isPasswordError() ? "has-error" : ""; ?>">
            <input class="form-control" type="password" name="password" placeholder="Password">
            <p class="help-block"><?php echo $agentValidator->getPasswordError() ?></p>
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block" type="submit"><?php echo isset($this->pageSubmitText) ? $this->pageSubmitText : "Register"; ?></button>
        </div>
    </form>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/script.js"></script>
</body>

</html>
