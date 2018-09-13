<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 12.09.2017
 * Time: 21:30
 */
require_once("layout.php");

/* TODO: start the session.
 */
session_start();

if (isset($_POST['email'])) {
    session_regenerate_id(true);
    /* TODO: add the email address to the session.
    */
    $_SESSION['agentLogin'] = $_POST['email'];
}

/* TODO: check is a session has been set. Otherwise redirect.
*/
if (!isset($_SESSION["agentLogin"])) {
    header("Location: agentLogin.php");
}

layoutSetContent("customers.php");

// logout: session_destroy();