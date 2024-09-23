
<?php  
// Check if the cookie exists
$isLoggedIn = isset($_COOKIE[$Cookie_Name]);
echo "<script>console.log('isLoggedIn:" .$isLoggedIn . "')</script>"; 

echo "<script>console.log('LoginMgnt');</script>"; 


if($isLoggedIn == 1) {
    echo "<script>console.log('Logged in!!')</script>"; 
    echo "<script>console.log('teamID', " .  $teamID . ");</script>"; 
    if (!is_null($teamID) && $teamID > 0) {
        echo "<script>console.log('ALL GOOOOOD!!')</script>"; 
        echo "<script>var teamID = $teamID; console.log('cookie team', teamID);</script>";
       
    }else {
        echo "<script>var teamID =0; console.log('NO cookie team');</script>";
        echo "<script>console.log('Team ID is Null...   Reload!!!')</script>";  
        
       // echo "<script>console.log('reloading'); window.location.reload(); </script>"; 
    }
} else {
    echo "<script>console.log('Nobody Logged in...')</script>"; 
    echo "<script>var teamID =0; console.log('NO cookie team');</script>";
}


 
?>


<script>
  //  if(teamID > 0) {        window.location.assign('http://192.168.1.161:8001/ProTeam.php?Team=' + teamID);    }

</script>
