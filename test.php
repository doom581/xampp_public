<?php
$db = new SQLite3('/home/yb/xampp_public/LHSQC-STHS.db');

// Test write
$result = $db->exec("UPDATE PlayerInfo SET Weight = 75 WHERE Number = 3234");

if ($result) {
    echo "Write successful!";
} else {
    echo "Write failed: " . $db->lastErrorMsg();
}


  /*  function listTables($db) {
        // Query to get all table names
        $result = $db->query("SELECT name FROM sqlite_master WHERE type='table';");
    
        if ($result) {
            $tables = [];
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $tables[] = $row['name'];
            }
            return $tables; // Return array of table names
        } else {
            return []; // Return an empty array if no tables are found
        }
    }
    	
	// Make a connection variable to pass to API
	$db = api_sqlite_connect($DatabaseFile);

    if ($db) {
        // List tables in the database
        $tables = listTables($db);
        echo json_encode($tables); // Output tables as JSON
    } else {
        echo json_encode(["error" => "Failed to connect to the database."]); // Error message
    }*/


/*
// TEST
$Player = 3234; // The player's Number
$newWeight = 180; // The new weight value you want to set

// Check if the player exists
$Query = "SELECT count(*) AS count FROM PlayerInfo WHERE Number = " . $Player;
$Result = $db->querySingle($Query, true);

if ($Result['count'] == 1) {
    // Update the weight field for the specified player
    $updateQuery = "UPDATE PlayerInfo SET weight = " . $newWeight . " WHERE Number = " . $Player;

    // Execute the update query
    if ($db->exec($updateQuery) === false) {
        echo "Error updating weight: " . $db->lastErrorMsg();
    } else {
        echo "Weight updated successfully.";
    }

    // Optionally, retrieve and display the updated player information
    $Query = "SELECT PlayerInfo.*, TeamProInfo.Name AS ProTeamName FROM PlayerInfo LEFT JOIN TeamProInfo ON PlayerInfo.Team = TeamProInfo.Number WHERE PlayerInfo.Number = " . $Player;
    $PlayerInfo = $db->querySingle($Query, true);

    if ($PlayerInfo) {
        foreach ($PlayerInfo as $field => $value) {
            echo "$field: $value <br>";
        }
    } else {
        echo "No player information found.";
    }
} else {
    echo "Player not found.";
}






*/ 

?>