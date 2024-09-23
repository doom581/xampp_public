
<?php 
include "Header.php";



// Enable PHP error reporting to catch any issues
error_reporting(E_ALL);
ini_set('display_errors', 1);

//session_start();

if (isset($_COOKIE[$Cookie_Name])) {
   /* $cookie_value = $_COOKIE[$Cookie_Name];

    //echo "Raw Cookie Value: " . htmlspecialchars($cookie_value) . "<br>";

    // Decode the cookie from Base64
    $decoded_cookie_value = base64_decode($cookie_value);

    if ($decoded_cookie_value === false) {
        //echo "Base64 decoding failed.<br>";
        exit;
    } else {

        //echo "Decoded Cookie Value: " . htmlspecialchars($decoded_cookie_value) . "<br>";
        
        $encryption_key = base64_decode($CookieTeamNumberKey);
        list($encrypted_data, $iv) = explode('::', base64_decode($_COOKIE[$Cookie_Name]), 2);
        $CookieArray = unserialize(openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv));
        $CookieTeamNumber = $CookieArray['TeamNumber'] ?? 0;
        $CookieTeamName = $CookieArray['TeamName'] ?? "";
        
        $teamID = $CookieArray['TeamNumber'] ?? 0; // Adjust as necessary
        echo "<script>var teamID = $teamID; console.log('cookie team', teamID);</script>";

    }*/
} else {
   // echo "Cookie is missing. Name: " . htmlspecialchars($Cookie_Name) . "<br>";
}

/*
// Function to fetch player info from API
function getPlayerInfo($team_id) {
    $url = "http://192.168.1.161:8001/API.php?PlayerInfo&Team=$team_id";  // TODO:   URL fixed a remplacer par HOST
    $response = file_get_contents($url);
    
    if ($response === false) {
        return []; // Return empty array if API call fails
    }

    $players = json_decode($response, true); // Decode JSON response to array
    return $players;
}
*/
 ?>




</head>
<body>
<header>
  <?php include "Menu.php"; ?>	
  <?php include "loginMgnt.php"; ?>


  <?php
// Assuming you have a PHP array of player names
$playersNames = ['Player1', 'Player2', 'Player3', 'Player4'];
$playersPositions = ['LW', 'C', 'RW', 'DD'];
$playersStatus = ['H', 'H', 'H', 'S'];
?>


<script>
    // Pass the PHP array to a JavaScript variable
    let playersNames = <?php echo json_encode($playersNames); ?>;
    let playersPositions = <?php echo json_encode($playersPositions); ?>;
    let playersStatus = <?php echo json_encode($playersStatus); ?>;
    let players = [];

    for (let i = 0; i < playersNames.length; i++) {
        let name = playersNames[i];
        let position = playersPositions[i];
        let status = playersStatus[i];
        players.push({ name: name, position: position, status: status});
    }

    console.log(players); // Check the structure of the players array
</script>




<div class="container">

    <div class="row ">


        <div class="col-9 m-0 p-0" id="Lines">
            <div class="card h-100 mt-1 mx-1">
                <div class="card-header">Lines</div>
                <div class="card-body">
                    
                    <div class="row m-0 p-0" id="divF1">
                        <div class="col m-1 p-0"> <div class="card roster-container" id="LW1"> LW1 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="C1">   C1 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="RW1"> RW1 </div></div>
                    </div> 

                    <div class="row m-0 p-0" id="divF2">
                        <div class="col m-1 p-0"> <div class="card roster-container" id="LW2"> LW2 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="C2">   C2 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="RW2"> RW2 </div></div>
                    </div>

                    <div class="row m-0 p-0" id="divF3">
                        <div class="col m-1 p-0"> <div class="card roster-container" id="LW3"> LW3 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="C3">   C3 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="RW3"> RW3 </div></div>
                    </div>

                    <div class="row m-0 p-0" id="divF4">
                        <div class="col m-1 p-0"> <div class="card roster-container" id="LW4"> LW4 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="C4">   C4 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="RW4"> RW4 </div></div>
                    </div>


                    <div class="row m-0 p-0" id="divD1">
                        <div class="col-1 m-1 p-0"></div> 
                        <div class="col m-1 p-0"> <div class="card roster-container" id="DG1"> DG1 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="DD1"> DD1 </div></div>
                        <div class="col-1 m-1 p-0"></div> 
                    </div>
                    <div class="row m-0 p-0" id="divD2">
                        <div class="col-1 m-1 p-0"></div> 
                        <div class="col m-1 p-0"> <div class="card roster-container" id="DG2"> DG2 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="DD2"> DD2 </div></div>
                        <div class="col-1 m-1 p-0"></div> 
                    </div>
                    <div class="row m-0 p-0" id="divD3">
                        <div class="col-1 m-1 p-0"> </div> 
                        <div class="col m-1 p-0"> <div class="card roster-container" id="DG3"> DG3 </div></div>
                        <div class="col m-1 p-0"> <div class="card roster-container" id="DD3"> DD3 </div></div>
                        <div class="col-1 m-1 p-0"> </div> 
                    </div>
                   
                
                </div>
            </div>
        </div>



        <div class="col-3 m-0 p-0">
            <div class="card text-center h-75 mb-1 mx-0 mt-1 ">
                <div class="card-header">Healthy</div>
                <div class="card-body m-0 p-1 Roster" id="Roster">
                    <!--     list created from JS-->
                </div>
            </div>
            <div class="card text-center ">
                <div class="card-header">Scratch</div>
                <div class="card-body m-0 p-1 Scratched" style="min-height:50px;" id="Scratched"></div>
            </div>
        </div>

    </div>


    <div class="row text-center">
                   
    
    
        <div class ="col-12">
            <div id="saveBtn"></div>
        </div>

    </div>
    

</div>
</header>


<script src="js/rosterEditor.js"></script>

<script>

var teamID = 21   //   TODO    DEBUG Hardcoded....    teamID is not set...


document.addEventListener('DOMContentLoaded', function() {
    // Check if teamID is set
    if (typeof teamID !== 'undefined' && teamID > 0) {
        // Fetch player info from API
        fetch(`http://192.168.1.161:8001/API.php?PlayerInfo&Team=${teamID}`)
            .then(response => {
                console.log('Raw response:', response);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Process and display player data
                //displayPlayers(data);
                players = data;
                console.log(players)
                createPlayers()
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
            });
    } else {
        console.log('Team ID is not set or invalid.');
    }
});

function displayPlayers(playersArray) {
    const playerCategories = {
        farmScratched: [],
        farmDressed: [],
        proScratched: [],
        proDressed: [],
        // Add more categories as needed
    };

    // Split players into categories based on Status1
    playersArray.forEach(player => {
        switch (player.Status1) {
            case 0:   
                playerCategories.farmScratched.push(player);
                break;
            case 1:  
                playerCategories.farmDressed.push(player);
                break;
            case 2:   
                playerCategories.proScratched.push(player);
                break;
            case 3:    
                playerCategories.proDressed.push(player);
                break;
            // Add more cases as needed
            default:
                // Handle other statuses or ignore
                break;
        }
    });

    // Display the categorized players
    displayCategorizedPlayers(playerCategories);
}

function displayCategorizedPlayers(categories) {
    const playerListContainer = document.getElementById('player-list');
    playerListContainer.innerHTML = ''; // Clear previous content

    for (const [status, players] of Object.entries(categories)) {
        if (players.length > 0) {
            const categoryDiv = document.createElement('div');
            categoryDiv.className = 'player-category';
            categoryDiv.innerHTML = `<h2>Status ${status}</h2>`;
            
            players.forEach(player => {
                const playerItem = document.createElement('div');
                playerItem.className = 'player-item';
                playerItem.innerHTML = `
                    <h3>${player.Name} (${player.Number})</h3>
                    <p>Team: ${player.TeamName}</p>
                    <p>Age: ${player.Age}</p>
                    <p>Position: ${player.PosD ? 'Defenseman' : 'Unknown'}</p>
                    <a href="${player.URLLink}" target="_blank">View Profile</a>
                `;
                categoryDiv.appendChild(playerItem);
            });

            playerListContainer.appendChild(categoryDiv);
        }
    }
}

</script>

<div id="player-list"></div>


<?php include "Footer.php";?>





<?php
/*	$lang = "en"; 
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

            echo "t$ = " . $t . "";
			$row = array();
			if($t > 0 AND $t <= 100){
				$rs = api_dbresult_teamsbyname($db,"Pro",$t);
				$row = $rs->fetchArray();
			}
		}
		// Make a default header 
		// 5 Paramaters. PageID, database, teamid, League = Pro/Farm, $headcode (custom headercode can be added. DEFAULT "")
		api_layout_header("rostereditor",$db,$t,false,$WebClientHeadCode);
		include "Menu.php";
		
		if ($CookieTeamNumber == 102){$DoNotRequiredLoginDynamicWebsite = TRUE;} // Commish is allow to upload anything so we are using the code from the 'Do Not Required Login Dynamic Website' to achieve this goal.
		
		if ($LeagueOutputOption['ShowWebClientInDymanicWebsite'] == "False"){
			echo "<div class=\"STHSDivInformationMessage\">" . $ThisPageNotAvailable . "<br /><br /></div>";
		}elseif(($CookieTeamNumber == $t OR $DoNotRequiredLoginDynamicWebsite == TRUE) AND $t > 0 AND $t <= 100){
			// Display the roster editor page using API.
			// use 3 paramaters Database, TeamID, showH1Tag (DEFAULT true/false)   
			if($t > 0){
                echo "pageInfo" . $DatabaseFile . "team:" . $t . "";
                api_pageinfo_editor_roster($db,$t);
            }
		}else{
			echo "<div class=\"STHSDivInformationMessage\">" . $NoUserLogin . "<br /><br /></div>";
		}

		// Close the db connection
		$db->close();

		// Display the default footer.
		api_layout_footer();
	}*/
?>