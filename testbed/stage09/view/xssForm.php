<form action="xss.php" method="post">
    <input type="text" name="comment" value="">
    <input type="submit" name="submit" value="Submit">
</form>
<span><?php echo "Comment: " . $this->comment ?></span>