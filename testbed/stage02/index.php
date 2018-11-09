<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 12.09.2017
 * Time: 21:30
 */
require_once("layout.php");

ini_set( 'session.cookie_httponly', 1 );
/* TODO: start the session.
 */

if (isset($_POST['email'])) {
    session_regenerate_id(true);
    /* TODO: add the email address to the session.
    */
}

/* TODO: check is a session has been set. Otherwise redirect.
*/

layoutSetContent("customers.php");

// logout: session_destroy();