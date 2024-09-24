<?php
	$lang = "en"; 
	require_once("LanguageEN.php");
	$LeagueName = Null;
	session_start();
	mb_internal_encoding("UTF-8");
	$PerformanceMonitorStart = microtime(true); 
	require_once("STHSSetting.php");
	//  Get STHS Setting $Database Value	

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
        $WebClientHeadCode = "   <link  href=\"https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.min.css\"  rel=\"stylesheet\"/>  <link href=\"css/lhsqc.css\" rel=\"stylesheet\" type=\"text/css\" /> 
                 
                                    <script src=\"js/lhsqc.js\"    type=\"text/javascript\"></script>";                      //<link href=\"css/styleT.css\" rel=\"stylesheet\" type=\"text/css\" />   le bouton est autre truc du menu sont encore dams StyleT  :S  mais ca ralenti le drag n drop



		// Make a default header 
		// 5 Paramaters. PageID, database, teamid, League = Pro/Farm, $headcode (custom headercode can be added. DEFAULT "")
		api_layout_header("rostereditor",$db,$t,false,$WebClientHeadCode);
        ?>
        <header>
        <?php
		include "Menu.php";
		
		if ($CookieTeamNumber == 102){$DoNotRequiredLoginDynamicWebsite = TRUE;} // Commish is allow to upload anything so we are using the code from the 'Do Not Required Login Dynamic Website' to achieve this goal.
		
		if(($CookieTeamNumber == $t OR $DoNotRequiredLoginDynamicWebsite == TRUE) AND $t > 0 AND $t <= 100){
			// Display the roster editor page using API.
			// use 3 paramaters Database, TeamID, showH1Tag (DEFAULT true/false)   
			if($t > 0){
                //api_pageinfo_editor_roster($db,$t, false);
                $teamid = $t;
                $showHeader=false;

            


                $FullFarmEnableGlobal = false;
                $FullFarmEnableLocal = false; ?>
                
                <div id="rostereditor">
                    <div class="pagewrapper pagewrapperrostereditor"><?php 
                        // $db = sqlite DB
                        // $teamid is a teamid to use that teams roster.
                        // $showDropdown is a flag if you want to toggle between teams.
                        // $showHeader is a flag is you want to show the H1 Tag.
                        if($showHeader){
                            $row = ($teamid > 0) ? api_dbresult_teamname($db,$teamid,"Pro") : array();
                            $teamname = (!empty($row)) ? $row["FullTeamName"] . " - " : "";
                            ?>
                            <h1><?= $teamname ?>Roster Editor - <a href="WebClientLines.php?League=Pro&TeamID=<?=$teamid;?>">Pro Line Editor</a> - <a href="WebClientLines.php?League=Farm&TeamID=<?=$teamid;?>">Farm Line Editor</a></h1><?php
                        }
                        
                        $confirmbanner = "";
                        $sql = "";
                        $execute = false;
                        // If the Save button has been clicked.
                        if(isset($_POST["sbtRoster"])){
                            // Create an array to organize the information
                            // $arrSort[$table][$playerid][$status]
                            // 		$table = Player or Goalie
                            // 		$playerid = Player Number from PlayerInfo Table
                            // 		$status = selected status for that game. 
                            $arrSort = array();
                            // Loop through the txtRoster array. txtRoster[$nextgame][] = Divider = LINE|LineType, Player = FirstName LastName| Number | PositionNumber | PositionString
                            // Explode at the pipe | 
                            // If the count of the explode is 2 then its a different line
                            // Section.  Switch the value of what the status should be
                            // $_POST["txtRoster"][$game][$status]
                            // $game = int 1-10
                            // $status = int 0-3

                            foreach($_POST["txtRoster"] AS $statuses=>$status){
                                foreach($status AS $s){
                                    $explodeValue = explode("|",$s);
                                    if(count($explodeValue) == 2){
                                        if($explodeValue[1] == "ProDress")$playerStatus = 3;
                                        elseif($explodeValue[1] == "ProScratch") $playerStatus = 2;
                                        elseif($explodeValue[1] == "FarmDress") $playerStatus = 1;
                                        else $playerStatus = 0;
                                    }else{
                                        // Remove the Check for no change.
                                        //if($explodeValue[4] != $playerStatus){
                                            // Check to see if the updated player status = what is already in the DB. 
                                            // If there is a change, add to the arrSort array.
                                            $table = ($explodeValue[2] == 16) ? "Goaler" : "Player";
                                            $arrSort[$table][$explodeValue[1]]["Status". $statuses] = $playerStatus;
                                        //}	
                                    }// End if count($explodeValue)
                                } // End foreach $status
                            } // End foreach $_POST["txtRoster"]
                            // If there is something in the arrSort variable, then:
                            // Loop through the arrSort variable to make 1 individual line of SQL
                            // Per player to update the Status values in the DB.

                            // Convert the PHP array to a JSON string
                            $jsonArrSort = json_encode($arrSort);

                            ?>
                            <script>
                            // Parse the JSON string into a JavaScript object
                            let arr = JSON.parse('<?php echo $jsonArrSort; ?>');
                            console.log(arr);
                            </script>
                            <?php

                            if(count($arrSort) > 0){
                                foreach($arrSort AS $table=>$player){
                                    foreach($player AS $number=>$statuses){
                                        if($table == "Goaler")$number -= 10000;
                                        $sql .= "UPDATE " . $table . "Info ";
                                        $sql .= "SET ";
                                        foreach($statuses AS $status=>$s){
                                            for($x=1;$x<=10;$x++){
                                                $sql .= "Status". $x ." = " . $s . ", ";
                                            }
                                        }
                                        $sql .= "WebClientModify = 'True' ";
                                        $sql .= ", WebClientIP = '" . $_SERVER['REMOTE_ADDR'] . "' ";
                                        $sql .= "WHERE Number = " . $number . ";";
                                    } // End foreach $player
                                }// End foreach $arrSort
                                $sql.= "Update TeamFarmInfo SET FullFarm = '". (($_POST['FullFarmEnableLocal'] == "true") ? 'True' : 'False') ."' WHERE Number = " . $teamid . ";";
                                //Update the database and save the lines.
                                $db->busyTimeout(5000);
                                $db->exec("pragma journal_mode=memory;");
                                $db->exec($sql);
                                
                                $TransactionSQL = "INSERT Into LeagueLog (Number, Text, DateTime, TransactionType) VALUES ('" . rand(90000,99999) . "','Save Roster for " . $teamname . "','" . gmdate('Y-m-d H:i:s') . "','8')";
                                $db->exec($TransactionSQL);						
                                
                                $confirmbannertext = "Roster has been saved."; 
                            }else{
                                $confirmbannertext = "No changes have been made to your roster."; 
                            }
                            
                            $confirmbanner = "<div class=\"confirm\">". $confirmbannertext ."</div>";  
                        } // End if isset($_POST["sbtRoster"])


                        // If there is a valid team ID to use
                        if(api_validate_teamid($db,$teamid)){

                                //echo $confirmbanner;
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
                                    
                                    

                                    <?php  
                                        
                                    // This accordion id is a JQuery accordion. If this ID changes then the JQuery has to be changed as well.
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
                                                        
                                                        // the id in the ol will be one of #sortProDress, #sortProScratch, #sortFarmDress, #sortFarmScratch.
                                                        // These id's are in the JQuery call to make the columns sortable via drag and drop. If the IDs change
                                                        // the calls will have to change in the JQuery.
                                                        ?>
                                                        <div class="">
                                                        <div class="col4">
                                                            <ol id="sort<?= str_replace(" ","",$columnid)?>" class="sort<?= str_replace(" ","",$columnid) . $nextgame; ?> connectedSortable ui-sortable list-group mt-2  ">
                                                                <h4 class="columnheader paleText"><?= $type?></h4>
                                                                <input class="rosterline<?=$nextgame; ?>" type="hidden" name="txtRoster[<?=$nextgame; ?>][]" value="LINE|<?= $columnid; ?>">
                                                                <?php  	
                                                                    // Checks to see if there are players in the current category.
                                                                    // example, if there is at least 1 player in the ProScratch category, loop through and display
                                                                    if(array_key_exists($x, $status[$nextgame])){
                                                                        foreach($status[$nextgame][$x] AS $sid=>$s){
                                                                            // Checks to see if a player is injured or has 0 contract. if so, it will add an injury or nocontract class
                                                                            // to the <li> which will not allow him to be part of the JQuery drag and drop
                                                                            // therefore unmovable. 
                                                                            $stick = ($s["Condition"] < 95 || $s["Contract"] == 0 || $s["Suspension"]  > 0) ? " sticky": "";
                                                                            $inj = ($s["Condition"] < 95) ? " injury": "";
                                                                            $noc = ($s["Contract"] == 0) ? " nocontract": "";
                                                                            $sus = ($s["Suspension"]  > 0) ? " suspension": "";
                                                                            
                                                                            // playerrow class is the class JQuery is looking for to allow the drag and drop process
                                                                            // if an <li> field has this, it can potentially be moved up and down the column.
                                                                        ?>
                                                                            <li id="line<?=$nextgame . "_" . api_MakeCSSClass($s["Name"])?>" class="list-group-item  playerrow <?= $columnid . $stick . $inj . $noc . $sus; ?>">
                                                                                <div class="rowinfo  ">
                                                                                    <?php 
                                                                                    // Use a hidden field in the form to get the info to save to the SQLite DB.
                                                                                    // The value of the hidden field is a string separated by pipes (|) to parse
                                                                                    // on submit "fieldName|fieldNumber|positionNumber(1-16)|positionString(C,LW)"
                                                                                    $value = api_fields_input_values($s);
                                                                                    ?>
                                                                                    <input class="rosterline<?=$nextgame; ?> <?= "input".$columnid . $nextgame?>" id="g<?=$nextgame;?>t<?=$columnid;?><?= $colcount++;?>" type="hidden" name="txtRoster[<?=$nextgame; ?>][]" value="<?= $value; ?>">

                                                                                    <div class="">
                                                                                        

                                                                                            <div class="row p-0 m-0">
                                                                                                <div class="rowname text-wrap p-0 mx-auto my-0"><p class="text-center"><?= $s["Name"]?></p></div>    
                                                                                            </div>

                                                                                            <div class="row p-0 m-0">
                                                                                                <div class="col p-0 m-0">
                                                                                                    <span class="badge badge-primary  "><?= $s["PositionString"]?> </span> 
                                                                                                </div> 
                                                                                                <div class="col p-0 m-0">
                                                                                                    <span class= "p-0 m-0 "> </span> 
                                                                                                </div>  

                                                                                                <div class="col text-end mx-2 p-0  ">
                                                                                                    <div class="row p-0 m-0">
                                                                                                        <div class="cardlabel mx-auto">overall</div>
                                                                                                    </div>
                                                                                                    <div class="row p-0 m-0">
                                                                                                        <div class="mx-auto"><?= $s["Overall"]?></div>
                                                                                                    </div>
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
                                                </div><!-- End .columnwrapper-->
                                            </div><!-- End classless/id-less div for the accordion--><?php 
                                        break;
                                        } // End foreach $nextgames?>
                                    </div><!-- End #accordion-->
                                </form> <!-- End frmRostereditor -->
                                </div>
                                
                                <?php 
                        }elseif(!api_validate_teamid($db,$teamid) && isset($_REQUEST["TeamID"])){
                            // If there is not a valid Teamid, let them know.
                            ?><div class="doesntexits">The team you are looking for does not exist.</div><?php
                        }// End if/else there is a teamid as a parameter?>
                    </div><!-- end pagewrapper -->
                </div><!-- end id rostereditor --><?php
















            
            
            
            
            
            
            
            
            
            
            
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
?>