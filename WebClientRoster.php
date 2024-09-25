<?php
ob_start(); // Start output buffering

	$lang = "en"; 
	require_once("LanguageEN.php");
	$LeagueName = Null;
	session_start();
	mb_internal_encoding("UTF-8");
	$PerformanceMonitorStart = microtime(true); 
	require_once("STHSSetting.php");
	require_once("WebClientAPI.php");
	
	$exempt = array();
	
	// Call the required APIs
	load_apis($exempt);
	
    // Make a connection variable to pass to API
	$db = api_sqlite_connect($DatabaseFile);

    if ($db != Null){

		$Query = "Select ShowWebClientInDymanicWebsite FROM LeagueOutputOption";
		$LeagueOutputOption = $db->querySingle($Query,true);
		
		// Look for a team ID in the URL, if non exists use 0
		if ($LeagueOutputOption['ShowWebClientInDymanicWebsite'] == "True"){
			$t = (isset($_REQUEST["TeamID"])) ? filter_var($_REQUEST["TeamID"], FILTER_SANITIZE_NUMBER_INT): 0;
			$row = array();
			if($t > 0 AND $t <= 100){
				$rs = api_dbresult_teamsbyname($db,"Pro",$t);
				$row = $rs->fetchArray();
			}
		}

        // LHSQC
        $WebClientHeadCode = "  <link  href=\"https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.min.css\"  rel=\"stylesheet\"/>  
                                <link href=\"css/lhsqc.css\" rel=\"stylesheet\" type=\"text/css\" /> 
                                <script src=\"js/lhsqc.js\"    type=\"text/javascript\"></script>                    
                                <script src=\"https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js\"></script>"; 


		// Make a default header 
		// 5 Paramaters. PageID, database, teamid, League = Pro/Farm, $headcode (custom headercode can be added. DEFAULT "")
		api_layout_header("rostereditor",$db,$t,false,$WebClientHeadCode);
        ?>

        <header>
            
            
    
        <?php include "Menu.php";

$FullFarmEnableGlobal = false;
$FullFarmEnableLocal = false;

		if ($CookieTeamNumber == 102){$DoNotRequiredLoginDynamicWebsite = TRUE;} 
		
		if(($CookieTeamNumber == $t OR $DoNotRequiredLoginDynamicWebsite == TRUE) AND $t > 0 AND $t <= 100){
			if($t > 0){
                $teamid = $t;
                $showHeader=false;

                 ?>


   




                <div id="rostereditor">
                    <input type="hidden" id="FullFarmEnableLocal" name="FullFarmEnableLocal" value="false">
                    <div class="pagewrapper pagewrapperrostereditor"><?php 
                       
                        if($showHeader){
                            $row = ($teamid > 0) ? api_dbresult_teamname($db,$teamid,"Pro") : array();
                            $teamname = (!empty($row)) ? $row["FullTeamName"] . " - " : "";
                            ?>
                            <h1><?= $teamname ?>Roster Editor - <a href="WebClientLines.php?League=Pro&TeamID=<?=$teamid;?>">Pro Line Editor</a> - <a href="WebClientLines.php?League=Farm&TeamID=<?=$teamid;?>">Farm Line Editor</a></h1><?php
                        }
                        
                        $confirmbanner = "";
                        $sql = "";
                        $execute = false;

                        $confirmbanner = isset($_SESSION['confirmbanner']) ? "<div class=\"confirm\">".$_SESSION['confirmbanner']."</div>" : "";
                        unset($_SESSION['confirmbanner']); // prevent it from showing again on refresh


                    // If the Save button has been clicked.
                    if(isset($_POST["sbtRoster"])){
                        
                        $arrSort = array();
                 
                        foreach($_POST["txtRoster"] AS $statuses=>$status){
                            foreach($status AS $s){
                                $explodeValue = explode("|",$s);
                                if(count($explodeValue) == 2){
                                    if($explodeValue[1] == "ProDress")$playerStatus = 3;
                                    elseif($explodeValue[1] == "ProScratch") $playerStatus = 2;
                                    elseif($explodeValue[1] == "FarmDress") $playerStatus = 1;
                                    else $playerStatus = 0;
                                }else{
                                    // Check to see if the updated player status = what is already in the DB. 
                                    // If there is a change, add to the arrSort array.
                                    $table = ($explodeValue[2] == 16) ? "Goaler" : "Player";
                                    $arrSort[$table][$explodeValue[1]]["Status". $statuses] = $playerStatus;    
                                }
                            } 
                        } 
                     
                        $success = true; // Track the success of the SQL operations

                        if (count($arrSort) > 0) {
                            foreach ($arrSort as $table => $player) {
                                foreach ($player as $number => $statuses) {
                                    if ($table == "Goaler") $number -= 10000;
                                    $sql = "UPDATE " . $table . "Info ";
                                    $sql .= "SET ";
                                    foreach ($statuses as $status => $s) {
                                        for ($x = 1; $x <= 10; $x++) {
                                            $sql .= "Status" . $x . " = " . $s . ", ";
                                        }
                                    }
                                    $sql .= "WebClientModify = 'True', ";
                                    $sql .= "WebClientIP = '" . $_SERVER['REMOTE_ADDR'] . "' ";
                                    $sql .= "WHERE Number = " . $number . ";";

                                    // Execute update and check for success
                                    if ($db->exec($sql) === false) {
                                        $success = false; // Mark failure
                                        error_log("SQL error: " . $db->lastErrorMsg());
                                    }
                                }
                            }

                            // Update TeamFarmInfo
                            $sql = "UPDATE TeamFarmInfo SET FullFarm = '" . (($_POST['FullFarmEnableLocal'] == "true") ? 'True' : 'False') . "' WHERE Number = " . $teamid . ";";
                            if ($db->exec($sql) === false) {
                                $success = false; // Mark failure
                                error_log("SQL error: " . $db->lastErrorMsg());
                            }

                            // Insert into LeagueLog
                            $TransactionSQL = "INSERT INTO LeagueLog (Number, Text, DateTime, TransactionType) VALUES ('" . rand(90000, 99999) . "','Save Roster for " . $teamname . "','" . gmdate('Y-m-d H:i:s') . "','8')";
                            if ($db->exec($TransactionSQL) === false) {
                                $success = false; // Mark failure
                                error_log("SQL error: " . $db->lastErrorMsg());
                            }

                            // Confirm banner based on success
                            if ($success) $confirmbannertext = "Roster has been saved.";
                            else          $confirmbannertext = "Error saving roster. Please try again. <br>" .  $db->lastErrorMsg();
                            
                        } else $confirmbannertext = "No changes have been made to your roster.";
                        
                        $confirmbanner = "<div class=\"confirm\">". $confirmbannertext ."</div>";  
                        $_SESSION['confirmbanner'] = $confirmbannertext; // Store the message in session
                        header("HTTP/1.1 303 See Other");
                        header("Location: " . $_SERVER['PHP_SELF'] . "?TeamID=" . $CookieTeamNumber); // Redirect to the same page                 
                      //  header("Location: index.php" ); // Redirect to the same page 
                        exit();
                    }
                        


                       

                        // If there is a valid team ID to use
                        if(api_validate_teamid($db,$teamid)){

                                $status = array();
                                $sql = api_sql_get_roster_players($teamid);
                                $oRS = $db->query($sql);
                                // Loop through queries result and add values to new array to display players and goalies
                                while($row = $oRS->fetchArray()){
                                    // Loop s for each status on each player
                                    for($s=1;$s<=1;$s++){
                                        // If the player is a goalie, add 10000 to the PLayer Number
                                        // This takes into account ID numbers can be duplicated in the PlayerInfo and GoalerInfo tables
                                        if($row["PositionString"] == "G"){$row["Number"]+=10000;}
                                        // Do not allow players without contracts to be dressed.
                                        if($row["Contract"] == 0){
                                            //$row["Injury"] = "No Contract";
                                            // Make them Pro Scratched or Farm Scratched.
                                            $row["Status".$s] = ($row["Status".$s] == 3 || $row["Status".$s] == 2) ? 2 : 0;
                                        }
                                        if($row["Condition"] < 95 && $row["Status".$s] == 3){
                                            $row["Status".$s] = 2;
                                        }
                                        if($row["Condition"] < 95 && $row["Status".$s] == 1){
                                            $row["Status".$s] = 0;
                                        }
                                        $status[$s][$row["Status".$s]][$row["Number"]]["Number"] = $row["Number"];
                                        $status[$s][$row["Status".$s]][$row["Number"]]["Name"] = $row["Name"];
                                        $status[$s][$row["Status".$s]][$row["Number"]]["Injury"] = $row["Injury"];
                                        $status[$s][$row["Status".$s]][$row["Number"]]["PositionString"] = $row["PositionString"];
                                        $status[$s][$row["Status".$s]][$row["Number"]]["PositionNumber"] = $row["PositionNumber"];
                                        $status[$s][$row["Status".$s]][$row["Number"]]["Status1"] = $row["Status".$s];
                                        $status[$s][$row["Status".$s]][$row["Number"]]["Overall"] = $row["Overall"];
                                        $status[$s][$row["Status".$s]][$row["Number"]]["ForceWaiver"] = $row["ForceWaiver"];
                                        $status[$s][$row["Status".$s]][$row["Number"]]["Condition"] = $row["Condition"];
                                        $status[$s][$row["Status".$s]][$row["Number"]]["Contract"] = $row["Contract"];
                                        $status[$s][$row["Status".$s]][$row["Number"]]["Suspension"] = $row["Suspension"];
                                        $status[$s][$row["Status".$s]][$row["Number"]]["Salary1"] = $row["Salary1"];
                                        $status[$s][$row["Status".$s]][$row["Number"]]["CanPlayPro"] = $row["CanPlayPro"];
                                        $status[$s][$row["Status".$s]][$row["Number"]]["CanPlayFarm"] = $row["CanPlayFarm"];
                                        $status[$s][$row["Status".$s]][$row["Number"]]["WaiverPossible"] = $row["WaiverPossible"];
                                        $status[$s][$row["Status".$s]][$row["Number"]]["EmergencyRecall"] = $row["EmergencyRecall"];
                                    } // End for loop for statuses
                                } // End while loop for players in result.
                             

                                // Create a next 10 games array to see the games both Pro and Farm will play.
                                $nextgames = api_get_nextgames($db,$teamid);
                               
                                
                                // start the form to submit the roster.?>
                                <div class="container">
                                <form name="frmRosterEditor" method="POST" id="frmRoster" class="STHSWebClient_Form ">
                                    <?php 
                                        foreach(api_dbresult_roster_editor_fields($db,$teamid) AS $k=>$f){
                                            if(!is_numeric($k)){
                                                ?><input type="hidden" class="rvField" id="<?= $k ?>" name="<?= $k ?>" value="<?=strtolower($f); ?>"><?php 
                                                echo "\n";
                                                
                                                if ($k === "FullFarmEnableGlobal") {
                                                    if (strtolower($f)== "true") {$FullFarmEnableGlobal = true;}
                                                }
                                                elseif ($k === "FullFarmEnableLocal") {
                                                    if (strtolower($f)== "true") {$FullFarmEnableLocal = true;}
                                                }
                                            }
                                        }
                                    ?>
                                 <div id="accordionfuture">
                                        <?php 
                                        // Loop through the next games variable to get the lines for the next 10 games.
                                        foreach($nextgames AS $nextgame=>$games){?>
                                            <?php  //$accordionhead = ($games["Pro"]["Day"] != "") ? $nextgame . ". Pro Day " . $games["Pro"]["Day"] ." - " . $games["Pro"]["AtVs"] . " " . $games["Pro"]["Opponent"] ." | Farm: Day " . $games["Farm"]["Day"] . " - " . $games["Farm"]["AtVs"] . " " . $games["Farm"]["Opponent"] : "Currently No Schedule"; ?>
                                            <?php  $accordionhead = api_make_nextgame($games,"Pro") . " | " . api_make_nextgame($games,"Farm"); ?>
                                            <h3 class="withsave paleText"><?= $accordionhead?>
                                            <span id="linevalidate<?=$nextgame;?>"></span></h3>
                                            <div>
                                                <?php echo $confirmbanner; ?>
                                                <script>
                                                    // Hide the confirm banner after 5 seconds
                                                    setTimeout(() => {
                                                        const banner = document.querySelector('.confirm');
                                                        if (banner) banner.style.display = 'none'; // Hides the banner
                                                        
                                                    }, 5000);

                                                    // Optionally hide on user interaction
                                                    document.addEventListener('click', () => {
                                                        const banner = document.querySelector('.confirm');
                                                        if (banner) banner.style.display = 'none'; // Hides the banner
                                                    });
                                                </script>
                                                <div id="errors rostererror<?= $nextgame ?>" class="rostererror">
                                                </div>
                                              
                                                <div class="row Save">
                                                    <div class="col-7">
                                                        <?php api_html_checkboxes_positionlist("rosterline1","false","list-item",$FullFarmEnableGlobal,$FullFarmEnableLocal); ?>
                                                    </div>
                                                    <div class="col">
                                                        <div class="py-1 my-0">
                                                            <input id="saveroster" class="btn btn-warning" type="submit" name="sbtRoster" value="Save"> 
                                                            <?php if(api_security_isLogged($teamid)){ api_html_logout_button(); } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="columnwrapper"><?php 
                                                    for($x=3;$x>=0;$x--){
                                                        if($x == 3){
                                                            $type = "Pro Dress";	
                                                        }elseif($x == 2){
                                                            $type = "Pro Scratch";
                                                        }elseif($x == 1){
                                                            $type = "Farm Dress";
                                                        }else{
                                                            $type = "Farm Scratch";
                                                        }
                                                        $columnid = str_replace(" ","",$type);
                                                        $colcount = 0;
                                                        
                                                        ?>
                                                        <div class="">
                                                        <div class="col4">
                                                            <ol id="sort<?= str_replace(" ","",$columnid)?>" class="sort<?= str_replace(" ","",$columnid) . $nextgame; ?> connectedSortable ui-sortable list-group mt-2  ">
                                                                <h4 class="columnheader paleText"><?= $type?></h4>
                                                                <input class="rosterline<?=$nextgame; ?>" type="hidden" name="txtRoster[<?=$nextgame; ?>][]" value="LINE|<?= $columnid; ?>">
                                                                <?php  	
                                                                    if(array_key_exists($x, $status[$nextgame])){
                                                                        foreach($status[$nextgame][$x] AS $sid=>$s){
                                                                              $stick = ($s["Condition"] < 95 || $s["Contract"] == 0 || $s["Suspension"]  > 0) ? " sticky": "";
                                                                            $inj = ($s["Condition"] < 95) ? " injury": "";
                                                                            $noc = ($s["Contract"] == 0) ? " nocontract": "";
                                                                            $sus = ($s["Suspension"]  > 0) ? " suspension": "";
                                                                            
                                                                            ?>
                                                                            <li id="line<?=$nextgame . "_" . api_MakeCSSClass($s["Name"])?>" class="list-group-item  playerrow <?= $columnid . $stick . $inj . $noc . $sus; ?>">
                                                                                <div class="rowinfo  ">
                                                                                    <?php 
                                                                                     $value = api_fields_input_values($s);
                                                                                    ?>
                                                                                    <input class="rosterline<?=$nextgame; ?> <?= "input".$columnid . $nextgame?>" id="g<?=$nextgame;?>t<?=$columnid;?><?= $colcount++;?>" type="hidden" name="txtRoster[<?=$nextgame; ?>][]" value="<?= $value; ?>">

                                                                                    <div class="row ">
                                                                                        <div class="rowname text-wrap p-1  my-0"><span class="text-center"><?= $s["Name"]?></span></div>    
                                                                                    </div>

                                                                                    <div class="row ">
                                                                                        <div class="col-1">
                                                                                            <span class="badge badge-primary d-flex justify-content-center  "><?= $s["PositionString"]?> </span> 
                                                                                        </div> 
                                                                                        

                                                                                        <div class="col-2 text-end px-3 mx-2">
                                                                                            <div class="row ">
                                                                                                <div class="cardlabel d-flex justify-content-center ">overall</div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="d-flex justify-content-center"><?= $s["Overall"]?></div>
                                                                                            </div>
                                                                                        </div> 
                                                                                    </div>
                                                                                    
                                                                                    <?php if($s["Condition"] < 100){?>
                                                                                        <div class="rowcondition"><?= $s["Condition"]; ?> CD</div>
                                                                                    <?php } ?>
                                                                                    <?php if($s["Suspension"] > 0 and $s["Suspension"] != 99){?>
                                                                                        <div class="rowsuspension"><?= $s["Suspension"]; ?> S</div>
                                                                                    <?php } ?>
                                                                                    <?php if($s["Suspension"] == 99){?>
                                                                                        <div class="rowsuspension99">HO</div>
                                                                                    <?php } ?>																			
                                                                                    <?php if($s["WaiverPossible"] == "True" and $s["Suspension"] == 0){?>
                                                                                        <div class="rowwaiver">Waiver</div>
                                                                                    <?php } ?>
                                                                                </div>
                                                                            </li>
                                                                        <?php }
                                                                    }?>
                                                            </ol>
                                                        </div>
                                                        </div><?php
                                                    }?>
                                                </div>
                                            </div><?php 
                                        break;
                                        } ?>
                                    </div>
                                </form> 
                                </div>
                                
                                <?php 
                        }elseif(!api_validate_teamid($db,$teamid) && isset($_REQUEST["TeamID"])){
                            ?><div class="doesntexits">The team you are looking for does not exist.</div><?php
                        }

                        
                        
                        ?>
                    </div>
                </div><?php
            }
		}else{
			echo "<div class=\"STHSDivInformationMessage\">" . $NoUserLogin . "<br /><br /></div>";
		}

		// Close the db connection
		$db->close();

        ?>
        </header>
        <?php
		// Display the default footer.
		api_layout_footer();
        include ("Footer.php");
	}

    ob_end_flush(); // Flush the buffer

?>