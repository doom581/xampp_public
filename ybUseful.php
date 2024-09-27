<?php
function consoleLog(msg, phpArray) {
    ?>
    <script>
    // Parse the JSON string into a JavaScript object
    let arr = JSON.parse('<?php echo $phpArray; ?>');
    console.log(msg, arr);
    </script>
<?php

}
?>




let playersNames = <?php echo json_encode($playersNames); ?>;












<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "Form submitted successfully";
    var_dump($_POST);
    header("HTTP/1.1 303 See Other");
    header("Location: " . $_SERVER['PHP_SELF'] . "?TeamID=" . $CookieTeamNumber); // Redirect to the same page 
    exit();
}
?>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="text" name="test" value="testValue">
    <input type="submit" name="submit" value="Submit">
</form>



