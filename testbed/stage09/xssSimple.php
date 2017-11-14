<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 14.11.2017
 * Time: 08:52
 *
 * TODO: enter "<script>alert("hacked")</script>" to test XSS
 */
?>
<!DOCTYPE html>
<html lang="en">
<head></head>
<body>
<form action="xssSimple.php" method="post">
    <input type="text" name="comment" value="">
    <input type="submit" name="submit" value="Submit">
</form>
<span>
    <?php
    $data = "";
    if (isset($_POST["comment"]))
        $data = $_POST["comment"];
    echo "Comment: " . $data ?>
</span>
</body>
</html>
