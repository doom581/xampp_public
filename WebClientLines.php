<?php
	$lang = "en"; 
	require_once("LanguageEN.php");
	$LeagueName = Null;
	session_start();
	mb_internal_encoding("UTF-8");
	$PerformanceMonitorStart = microtime(true); 
	require_once("STHSSetting.php");
	require_once("WebClientAPI.php");
	// exempt is an array of api names.
	// example, if you do not need the html or layout api then add as an array item
	// $exempt = array("html","layout");
	$exempt = array();
	
	// Call the required APIs
	load_apis($exempt);
	
	// Make a connection variable to pass to API
	$db = api_sqlite_connect($DatabaseFile);
	if ($db != Null){
		
		$Query = "Select ShowWebClientInDymanicWebsite FROM LeagueOutputOption";
		$LeagueOutputOption = $db->querySingle($Query,true);
		
		$Query = "Select BlockAutoProLineFunctionForGM,BlockAutoFarmLineFunctionForGM FROM LeagueWebClient";
		$LeagueWebClient = $db->querySingle($Query,true);

		// Look for a team ID in the URL, if non exists use 0
		$t = (isset($_REQUEST["TeamID"])) ? filter_var($_REQUEST["TeamID"], FILTER_SANITIZE_NUMBER_INT): 0;
		$l = (isset($_REQUEST["League"])) ? filter_var($_REQUEST["League"], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW || FILTER_FLAG_STRIP_HIGH) : false;
		If (strtolower($l) <> "farm"){$l = "Pro";}else{$l = "Farm";}
		$row = array();
		if($t > 0 AND $t <= 100){
			$rs = api_dbresult_teamsbyname($db,"Pro",$t);
			$row = $rs->fetchArray();
		}
		If ($l == "Pro" AND $LeagueWebClient['BlockAutoProLineFunctionForGM'] == "True"){echo "<style>#autolines {display:none};</style>";}
		If ($l == "Farm" AND $LeagueWebClient['BlockAutoFarmLineFunctionForGM'] == "True"){echo "<style>#autolines {display:none};</style>";}
		
        
        // LHSQC
        $WebClientHeadCode = "<link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH\" crossorigin=\"anonymous\">
                            
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js\"></script>
        <script src=\"https://code.jquery.com/ui/1.14.0/jquery-ui.min.js\" integrity=\"sha256-Fb0zP4jE3JHqu+IBB9YktLcSjI1Zc6J2b6gTjB0LpoM=\" crossorigin=\"anonymous\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js\"></script>
        
        <link href=\"css/lhsqc.css\" rel=\"stylesheet\" type=\"text/css\" /> 
        <script src=\"js/lhsqc_new.js\"    type=\"text/javascript\"></script>";
        //<script src=\"LHSQC.js\"    type=\"text/javascript\"></script>";  



		// Make a default header 
		api_layout_header("lineeditor",$db,$t,$l,$WebClientHeadCode);
        ?>

        <header>

        <?php include "Menu.php";

		If ($CookieTeamNumber == 102){$DoNotRequiredLoginDynamicWebsite = TRUE;} // Commish is allow to edit any Teams so we are using the code from the 'Do Not Required Login Dynamic Website' to achieve this goal.
		
		if(($CookieTeamNumber == $t OR $DoNotRequiredLoginDynamicWebsite == TRUE) AND $t > 0 AND $t <= 100){
			// Display the line editor page using API.
			// use 4 paramaters Database, TeamID, $league("Pro","Farm"), showH1Tag (DEFAULT true/false)   
			if($t > 0){
                api_pageinfo_editor_lines($db,$t,$l, false);
            }
		}else{
			echo "<div class=\"STHSDivInformationMessage\">" . $NoUserLogin . "<br /><br /></div>";		
		}


        ?>

    </header>

        <?php

		// Close the db connection
		$db->close();


		 include ("Footer.php");// Display the default footer.
		api_layout_footer();
       
	}
?>