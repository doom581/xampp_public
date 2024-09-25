<?php
$db = new SQLite3('/home/yb/xampp_public/LHSQC-STHS.db');

// Check integrity
$result = $db->querySingle("PRAGMA integrity_check;", true);
echo "Integrity check result: " . $result['integrity_check'];
echo "<br>";echo "<br>";


// testing db access       
try {
    $db->exec("INSERT INTO test_table (col) VALUES ('test')");
    echo "Default Write test successful!";
} catch (Exception $e) {
    echo "Default Write test failed: " . $e->getMessage();
}


echo "<br>";echo "<br>";


   function listTables($db) {
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
    	


if ($db) {
    // List tables in the database
    $tables = listTables($db);
    echo "Tables list:";
    echo json_encode($tables); // Output tables as JSON
} else {
    echo json_encode(["error" => "Failed to connect to the database."]); // Error message
}

echo "<br>";echo "<br>";

// TEST
$Player = 3234; // The player's Number
$newWeight = 215; // The new weight value you want to set

// Check if the player exists
$Query = "SELECT count(*) AS count FROM PlayerInfo WHERE Number = " . $Player;
$Result = $db->querySingle($Query, true);

if ($Result['count'] == 1) {
    // Update the weight field for the specified player
    $updateQuery = "UPDATE PlayerInfo SET weight = " . $newWeight . " WHERE Number = " . $Player;

    // Execute the update query
    if ($db->exec($updateQuery) === false) {
        echo "Error updating weight: " . $db->lastErrorMsg();echo "<br>";echo "<br>";
    } else {
        echo "Weight updated successfully.";echo "<br>";echo "<br>";
    }

    // Optionally, retrieve and display the updated player information
    $Query = "SELECT PlayerInfo.*, TeamProInfo.Name AS ProTeamName FROM PlayerInfo LEFT JOIN TeamProInfo ON PlayerInfo.Team = TeamProInfo.Number WHERE PlayerInfo.Number = " . $Player;
    $PlayerInfo = $db->querySingle($Query, true);

    if ($PlayerInfo) {
        foreach ($PlayerInfo as $field => $value) {
            echo "$field: $value <br>";
        }
    } else {
        echo "No player information found.";echo "<br>";echo "<br>";
    }
} else {
    echo "Player not found.";echo "<br>";echo "<br>";
}








?>