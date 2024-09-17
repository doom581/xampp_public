<div class="ProTeamsBar">
<?php

try{
	$dbMenu = new SQLite3($DatabaseFile);

	$Query = "Select Number, Name, Abbre, TeamThemeID from TeamProInfo Where TeamThemeID > 0 ORDER BY Name ";
	$TeamProMenu = $dbMenu->query($Query);
	
    if (empty($TeamProMenu) == false)
    { 
        while ($Row = $TeamProMenu ->fetchArray()) 
        {
		    if ($Row['TeamThemeID'] > 0){ 
                echo "<div class=\"TeamLink\">";
                echo "<a href=\"ProTeam.php?Team=" . $Row['Number'] . "\" class=\"TeamLink\" ><img src=\"" . $ImagesCDNPath . "/images/" . $Row['TeamThemeID'] .".png\" alt=\"\" class=\"ProTeamsBarTeamImage\"></a>";
                echo "</div>";
                }
    	}
       
    }

} catch (Exception $e) {
	
	echo "<br /><br /><h1 class=\"STHSCenter\">" . $DatabaseNotFound . "</h1>";
	
}

?>

</div>