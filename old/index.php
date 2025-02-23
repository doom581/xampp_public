<?php include "Header.php";
If ($lang == "fr"){include 'LanguageFR-Main.php';}else{include 'LanguageEN-Main.php';}
$IndexQueryOK = (boolean)False;
If (file_exists($DatabaseFile) == false){
	Goto STHSErrorIndex;
}else{
	$LeagueName = (string)"";
try{
	$db = new SQLite3($DatabaseFile);
	
	$Query = "Select Name, ScheduleNextDay, IndexHeadLineDay0, IndexHeadLineDay1 ,IndexHeadLineDay2, DefaultSimulationPerDay, PointSystemSO, OffSeason, Days73StarPro, Days303StarPro, Days73StarFarm, Days303StarFarm, Today3StarPro1, Today3StarPro2, Today3StarPro3, Today3StarFarm1, Today3StarFarm2, Today3StarFarm3 from LeagueGeneral";
	$LeagueGeneral = $db->querySingle($Query,true);		
	$LeagueName = $LeagueGeneral['Name'];
		
	$Query = "SELECT LeagueLog.* FROM LeagueLog WHERE (Datetxt = '" . $LeagueGeneral['IndexHeadLineDay0'] . "') AND ((LeagueLog.TransactionType = 2) OR (LeagueLog.TransactionType = 3) OR (LeagueLog.TransactionType = 6)) ORDER BY LeagueLog.Number ";
	$Headlines0 = $db->query($Query);
	$Query = "SELECT TradeLog.* FROM TradeLog WHERE (Datetxt = '" . $LeagueGeneral['IndexHeadLineDay0'] . "') ORDER BY TradeLog.Number";
	$Transaction0 = $db->query($Query);
	$Query = "SELECT LeagueLog.* FROM LeagueLog WHERE (Datetxt = '" . $LeagueGeneral['IndexHeadLineDay1'] . "') AND ((LeagueLog.TransactionType = 2) OR (LeagueLog.TransactionType = 3) OR (LeagueLog.TransactionType = 6)) ORDER BY LeagueLog.Number ";
	$Headlines1 = $db->query($Query);
	$Query = "SELECT TradeLog.* FROM TradeLog WHERE (Datetxt = '" . $LeagueGeneral['IndexHeadLineDay1'] . "') ORDER BY TradeLog.Number";
	$Transaction1 = $db->query($Query);
	$Query = "SELECT LeagueLog.* FROM LeagueLog WHERE (Datetxt = '" . $LeagueGeneral['IndexHeadLineDay2'] . "') AND ((LeagueLog.TransactionType = 2) OR (LeagueLog.TransactionType = 3) OR (LeagueLog.TransactionType = 6)) ORDER BY LeagueLog.Number ";
	$Headlines2 = $db->query($Query);
	$Query = "SELECT TradeLog.* FROM TradeLog WHERE (Datetxt = '" . $LeagueGeneral['IndexHeadLineDay2'] . "') ORDER BY TradeLog.Number";
	$Transaction2 = $db->query($Query);


	$Query = "Select PlayersMugShotBaseURL, PlayersMugShotFileExtension, ProMinimumGamePlayerLeader, ShowFarmScoreinPHPHomePage, NumberofNewsinPHPHomePage, NumberofLatestScoreinPHPHomePage from LeagueOutputOption";
	$LeagueOutputOption = $db->querySingle($Query,true);		
		
	If ($LeagueOutputOption['ShowFarmScoreinPHPHomePage'] == 'True'){
		$Query = "SELECT *,'Pro' as Type FROM SchedulePro WHERE Day >= " . ($LeagueGeneral['ScheduleNextDay'] - $LeagueGeneral['DefaultSimulationPerDay']) . " AND PLAY = 'True' UNION SELECT *,'Farm' as Type FROM ScheduleFarm WHERE Day = " . ($LeagueGeneral['ScheduleNextDay'] - $LeagueGeneral['DefaultSimulationPerDay']) . " AND PLAY = 'True' ORDER BY TYPE DESC, GAMENUMBER";
		$QuerySchedule = "Select ProSchedule.*, 'Pro' AS Type FROM (SELECT TeamProStatVisitor.Last10W AS VLast10W, TeamProStatVisitor.Last10L AS VLast10L, TeamProStatVisitor.Last10T AS VLast10T, TeamProStatVisitor.Last10OTW AS VLast10OTW, TeamProStatVisitor.Last10OTL AS VLast10OTL, TeamProStatVisitor.Last10SOW AS VLast10SOW, TeamProStatVisitor.Last10SOL AS VLast10SOL, TeamProStatVisitor.GP AS VGP, TeamProStatVisitor.W AS VW, TeamProStatVisitor.L AS VL, TeamProStatVisitor.T AS VT, TeamProStatVisitor.OTW AS VOTW, TeamProStatVisitor.OTL AS VOTL, TeamProStatVisitor.SOW AS VSOW, TeamProStatVisitor.SOL AS VSOL, TeamProStatVisitor.Points AS VPoints, TeamProStatVisitor.Streak AS VStreak, TeamProStatHome.Last10W AS HLast10W, TeamProStatHome.Last10L AS HLast10L, TeamProStatHome.Last10T AS HLast10T, TeamProStatHome.Last10OTW AS HLast10OTW, TeamProStatHome.Last10OTL AS HLast10OTL, TeamProStatHome.Last10SOW AS HLast10SOW, TeamProStatHome.Last10SOL AS HLast10SOL, TeamProStatHome.GP AS HGP, TeamProStatHome.W AS HW, TeamProStatHome.L AS HL, TeamProStatHome.T AS HT, TeamProStatHome.OTW AS HOTW, TeamProStatHome.OTL AS HOTL, TeamProStatHome.SOW AS HSOW, TeamProStatHome.SOL AS HSOL, TeamProStatHome.Points AS HPoints, TeamProStatHome.Streak AS HStreak, SchedulePro.* FROM (SchedulePRO LEFT JOIN TeamProStat AS TeamProStatHome ON SchedulePRO.HomeTeam = TeamProStatHome.Number) LEFT JOIN TeamProStat AS TeamProStatVisitor ON SchedulePRO.VisitorTeam = TeamProStatVisitor.Number WHERE DAY >= " . $LeagueGeneral['ScheduleNextDay'] . " AND DAY <= " . ($LeagueGeneral['ScheduleNextDay'] + $LeagueGeneral['DefaultSimulationPerDay'] -1) . ") AS ProSchedule  UNION ALL Select FarmSchedule.*, 'Farm' AS Type FROM (SELECT TeamFarmStatVisitor.Last10W AS VLast10W, TeamFarmStatVisitor.Last10L AS VLast10L, TeamFarmStatVisitor.Last10T AS VLast10T, TeamFarmStatVisitor.Last10OTW AS VLast10OTW, TeamFarmStatVisitor.Last10OTL AS VLast10OTL, TeamFarmStatVisitor.Last10SOW AS VLast10SOW, TeamFarmStatVisitor.Last10SOL AS VLast10SOL, TeamFarmStatVisitor.GP AS VGP, TeamFarmStatVisitor.W AS VW, TeamFarmStatVisitor.L AS VL, TeamFarmStatVisitor.T AS VT, TeamFarmStatVisitor.OTW AS VOTW, TeamFarmStatVisitor.OTL AS VOTL, TeamFarmStatVisitor.SOW AS VSOW, TeamFarmStatVisitor.SOL AS VSOL, TeamFarmStatVisitor.Points AS VPoints, TeamFarmStatVisitor.Streak AS VStreak, TeamFarmStatHome.Last10W AS HLast10W, TeamFarmStatHome.Last10L AS HLast10L, TeamFarmStatHome.Last10T AS HLast10T, TeamFarmStatHome.Last10OTW AS HLast10OTW, TeamFarmStatHome.Last10OTL AS HLast10OTL, TeamFarmStatHome.Last10SOW AS HLast10SOW, TeamFarmStatHome.Last10SOL AS HLast10SOL, TeamFarmStatHome.GP AS HGP, TeamFarmStatHome.W AS HW, TeamFarmStatHome.L AS HL, TeamFarmStatHome.T AS HT, TeamFarmStatHome.OTW AS HOTW, TeamFarmStatHome.OTL AS HOTL, TeamFarmStatHome.SOW AS HSOW, TeamFarmStatHome.SOL AS HSOL, TeamFarmStatHome.Points AS HPoints, TeamFarmStatHome.Streak AS HStreak, ScheduleFarm.* FROM (ScheduleFarm LEFT JOIN TeamFarmStat AS TeamFarmStatHome ON ScheduleFarm.HomeTeam = TeamFarmStatHome.Number) LEFT JOIN TeamFarmStat AS TeamFarmStatVisitor ON ScheduleFarm.VisitorTeam = TeamFarmStatVisitor.Number WHERE DAY >= " . $LeagueGeneral['ScheduleNextDay'] . " AND DAY <= " . ($LeagueGeneral['ScheduleNextDay'] + $LeagueGeneral['DefaultSimulationPerDay'] -1) . ") AS FarmSchedule ORDER BY Day, Type DESC, GameNumber";
	}else{
		$Query = "SELECT *,'Pro' as Type FROM SchedulePro WHERE Day >= " . ($LeagueGeneral['ScheduleNextDay'] - $LeagueGeneral['DefaultSimulationPerDay']) . " AND PLAY = 'True' ORDER BY GameNumber ";
		$QuerySchedule = "SELECT SchedulePro.*, 'Pro' AS Type, TeamProStatVisitor.Last10W AS VLast10W, TeamProStatVisitor.Last10L AS VLast10L, TeamProStatVisitor.Last10T AS VLast10T, TeamProStatVisitor.Last10OTW AS VLast10OTW, TeamProStatVisitor.Last10OTL AS VLast10OTL, TeamProStatVisitor.Last10SOW AS VLast10SOW, TeamProStatVisitor.Last10SOL AS VLast10SOL, TeamProStatVisitor.GP AS VGP, TeamProStatVisitor.W AS VW, TeamProStatVisitor.L AS VL, TeamProStatVisitor.T AS VT, TeamProStatVisitor.OTW AS VOTW, TeamProStatVisitor.OTL AS VOTL, TeamProStatVisitor.SOW AS VSOW, TeamProStatVisitor.SOL AS VSOL, TeamProStatVisitor.Points AS VPoints, TeamProStatVisitor.Streak AS VStreak, TeamProStatHome.Last10W AS HLast10W, TeamProStatHome.Last10L AS HLast10L, TeamProStatHome.Last10T AS HLast10T, TeamProStatHome.Last10OTW AS HLast10OTW, TeamProStatHome.Last10OTL AS HLast10OTL, TeamProStatHome.Last10SOW AS HLast10SOW, TeamProStatHome.Last10SOL AS HLast10SOL, TeamProStatHome.GP AS HGP, TeamProStatHome.W AS HW, TeamProStatHome.L AS HL, TeamProStatHome.T AS HT, TeamProStatHome.OTW AS HOTW, TeamProStatHome.OTL AS HOTL, TeamProStatHome.SOW AS HSOW, TeamProStatHome.SOL AS HSOL, TeamProStatHome.Points AS HPoints, TeamProStatHome.Streak AS HStreak FROM (SchedulePRO LEFT JOIN TeamProStat AS TeamProStatHome ON SchedulePRO.HomeTeam = TeamProStatHome.Number) LEFT JOIN TeamProStat AS TeamProStatVisitor ON SchedulePRO.VisitorTeam = TeamProStatVisitor.Number WHERE DAY >= " . $LeagueGeneral['ScheduleNextDay'] . " AND DAY <= " . ($LeagueGeneral['ScheduleNextDay'] + $LeagueGeneral['DefaultSimulationPerDay'] -1) . " ORDER BY Day, GameNumber";
	}
	$LatestScore = $db->query($Query);
	$Schedule = $db->query($QuerySchedule);
	
	echo "<title>" . $LeagueName . " - " . $IndexLang['IndexTitle'] . "</title>";
	echo "<style>";

	echo ".Headshot {display: inline;}";
    echo "</style>";
	$IndexQueryOK = True;
} catch (Exception $e) {
    STHSErrorIndex:
	$LeagueName = $DatabaseNotFound;
	$Transaction = Null;
	$Schedule = Null;
	$LeagueGeneral = Null;
	$LeagueOutputOption = Null;
	echo "<title>" . $DatabaseNotFound . "</title>";
}}
try{
If ($IndexQueryOK== True){	
	If (file_exists($NewsDatabaseFile) == false){
		$LeagueNews = Null;
	}else{
		$dbNews = new SQLite3($NewsDatabaseFile);
		$Query = "Select LeagueNews.*, TeamProInfo.TeamThemeID, TeamProInfo.Name FROM LeagueNews LEFT JOIN TeamProInfo ON LeagueNews.TeamNumber = TeamProInfo.Number WHERE Remove = 'False' ORDER BY Time DESC";
		$dbNews -> query("ATTACH DATABASE '".realpath($DatabaseFile)."' AS CurrentDB");
		$LeagueNews = $dbNews->query($Query);
	}	
}} catch (Exception $e) {
    $LeagueNews = Null;
}

$LoopCurrentDate = (string)"";
?>
<script>function toggleDiv(divId) {$("#"+divId).toggle();}</script>
</head>

<body>
<?php include "Menu.php";

If ($IndexQueryOK == False){echo "<br /><br /><h1 class=\"STHSCenter\">" . $DatabaseNotFound . "</h1>";}
?>
<table class="STHSIndex_Main"><tr><td class="STHSIndex_Score">
<table class="STHSTableFullW"><tr><td>
<div class="STHSIndex_LastestResult"><?php echo $IndexLang['LatestScores'];?></div>
<?php
if (empty($LatestScore) == false){while ($row = $LatestScore ->fetchArray()) {
	echo "<table class=\"STHSIndex_GamesResult\">";
	echo "<tr><th>" . $row['Type'] . " Day " . $row['Day']. "</th><th class=\"STHSW45\">#" . $row['GameNumber']. "</th></tr>";
	echo "<tr><td>";
	If ($row['VisitorTeamThemeID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $row['VisitorTeamThemeID'] .".png\" alt=\"\" class=\"STHSPHPIndexTeamImage\" />";}
	echo $row['VisitorTeamName']. "</td><td class=\"STHSRight\">" . $row['VisitorScore'] . "</td></tr>";
	echo "<tr><td>";
	If ($row['HomeTeamThemeID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $row['HomeTeamThemeID'] .".png\" alt=\"\" class=\"STHSPHPIndexTeamImage\" />";}
	echo $row['HomeTeamName']. "</td><td class=\"STHSRight\">" . $row['HomeScore'] . "</td></tr>";
	echo "<tr><td colspan=\"2\" class=\"STHSPHPIndexBoxScore\"><a href=\"" . $row['Link'] ."\">" . $IndexLang['BoxScore'] .  "</a></td></tr>";
	echo "</table>";
}}
?>

</td></tr><tr><td>
<div class="STHSIndex_LastestResult"><?php echo $IndexLang['NextGames'];?></div>
<?php
if (empty($Schedule) == false){while ($row = $Schedule ->fetchArray()) {
	echo "<table class=\"STHSIndex_GamesResult\">";
	echo "<tr><th>" . $row['Type'] . " Day " . $row['Day'] .  " - " . $row['GameNumber']. "</th></tr>";
	echo "<tr><td>";
	If ($row['VisitorTeamThemeID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $row['VisitorTeamThemeID'] .".png\" alt=\"\" class=\"STHSPHPIndexTeamImage\" />";}
	echo "<a href=\"" . $row['Type']  . "Team.php?Team=" . $row['VisitorTeam'] . "\">" . $row['VisitorTeamName']. "</a> (" . ($row['VW'] + $row['VOTW'] + $row['VSOW']) . "-";
	if ($LeagueGeneral['PointSystemSO'] == "True"){
		echo $row['VL'] . "-" . ($row['VOTL'] + $row['VSOL']);
	}else{
		echo ($row['VL'] + $row['VOTL'] + $row['VSOL']) . "-" . $row['VT'];
	}
	echo ") - " . $row['VStreak'] . "</td></tr>";
	echo "<tr><td>";
	If ($row['HomeTeamThemeID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $row['HomeTeamThemeID'] .".png\" alt=\"\" class=\"STHSPHPIndexTeamImage\" />";}
	echo "<a href=\"" . $row['Type'] . "Team.php?Team=" . $row['HomeTeam'] . "\">" . $row['HomeTeamName']. "</a> (" . ($row['HW'] + $row['HOTW'] + $row['HSOW']) . "-";
	if ($LeagueGeneral['PointSystemSO'] == "True"){
		echo $row['HL'] . "-" . ($row['HOTL'] + $row['HSOL']);
	}else{
		echo ($row['HL'] + $row['HOTL'] + $row['HSOL']) . "-" . $row['HT'];
	}
	echo ") - " . $row['HStreak']. "</td></tr>";
	echo "</table>";
}}
?>

</td></tr></table>
</td><td class="STHSIndex_NewsTD">
<div class="STHSIndex_TheNews"><?php echo $LeagueName . $IndexLang['News'];?></div>
<div class="STHSIndex_NewsDiv"><?php include "NewsSub.php";?></div>
<br /><br />
</td><td class="STHSIndex_Top5">
    <?php include "components/TopHeadlines.php";?>



<div class="STHSIndex_Top5TableImage"><img id="Top5" src="<?php echo $ImagesCDNPath;?>/images/top5.png" alt="Top 5" width="281" height="56"></div>
<table class="STHSIndex_Top5Table">
<?php if(isset($LeagueGeneral)){
echo "<tr><th colspan=\"2\" class=\"STHSIndex_3StarNameHeader\">" . $IndexLang['ProGamesDaysStar'] . "</th></tr>";
echo "<tr><td colspan=\"2\"><img src=\"" . $ImagesCDNPath . "/images/Star1.png\" alt=\"Star1\" style=\"width:25px;vertical-align:middle;padding-right:4px\" />" . $LeagueGeneral['Today3StarPro1'] . "</td></tr>";
echo "<tr><td colspan=\"2\"><img src=\"" . $ImagesCDNPath . "/images/Star2.png\" alt=\"Star2\" style=\"width:25px;vertical-align:middle;padding-right:4px\" />" . $LeagueGeneral['Today3StarPro2'] . "</td></tr>";
echo "<tr><td colspan=\"2\"><img src=\"" . $ImagesCDNPath . "/images/Star3.png\" alt=\"Star3\" style=\"width:25px;vertical-align:middle;padding-right:4px\" />" . $LeagueGeneral['Today3StarPro3'] . "</td></tr>";
If ($LeagueOutputOption['ShowFarmScoreinPHPHomePage'] == 'True'){
	echo "<tr><th colspan=\"2\" class=\"STHSIndex_3StarNameHeader\">" . $IndexLang['FarmGamesDaysStar'] . "</th></tr>";
	echo "<tr><td colspan=\"2\"><img src=\"" . $ImagesCDNPath . "/images/Star1.png\" alt=\"Star1\" style=\"width:25px;vertical-align:middle;padding-right:4px\" />" . $LeagueGeneral['Today3StarFarm1'] . "</td></tr>";
	echo "<tr><td colspan=\"2\"><img src=\"" . $ImagesCDNPath . "/images/Star2.png\" alt=\"Star2\" style=\"width:25px;vertical-align:middle;padding-right:4px\" />" . $LeagueGeneral['Today3StarFarm2'] . "</td></tr>";
	echo "<tr><td colspan=\"2\"><img src=\"" . $ImagesCDNPath . "/images/Star3.png\" alt=\"Star3\" style=\"width:25px;vertical-align:middle;padding-right:4px\" />" . $LeagueGeneral['Today3StarFarm3'] . "</td></tr>";
}}?>
<tr><th colspan="2" class="STHSTop5"><?php echo $IndexLang['Top5Point'];?></th></tr>
<tr><td class="STHSIndex_Top5PointNameHeader"><?php echo $PlayersLang['PlayerName'];?></td><td class="STHSIndex_Top5PointResultHeader">G-A-P</td></tr>
<?php
If ($IndexQueryOK== True){
	$Query = "SELECT PlayerProStat.G, PlayerProStat.A, PlayerProStat.P, PlayerProStat.GP, PlayerProStat.Name, PlayerProStat.Number, TeamProInfo.Abbre, TeamProInfo.TeamThemeID, PlayerInfo.NHLID  FROM (PlayerInfo INNER JOIN PlayerProStat ON PlayerInfo.Number = PlayerProStat.Number) LEFT JOIN TeamProInfo ON PlayerInfo.Team = TeamProInfo.Number WHERE (PlayerProStat.GP >= " . $LeagueOutputOption['ProMinimumGamePlayerLeader'] . ") AND (PlayerInfo.Team > 0) AND (PlayerProStat.P > 0) ORDER BY PlayerProStat.P DESC, PlayerProStat.G DESC, PlayerProStat.GP ASC LIMIT 5";
	$PlayerStat = $db->query($Query);
}
$LoopCount = (integer)0;
if (empty($PlayerStat) == false){while ($Row = $PlayerStat ->fetchArray()) {
	$LoopCount +=1;echo "<tr><td>";
	If ($Row['TeamThemeID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $Row['TeamThemeID'] .".png\" alt=\"\" class=\"STHSPHPIndividualLeadersTeamImage\" />";}
	echo "<a href=\"PlayerReport.php?Player=" . $Row['Number'] . "\">" . $Row['Name'] . " (" . $Row['Abbre'] . ")</a>";
	If($LoopCount == 1){If ($LeagueOutputOption['PlayersMugShotBaseURL'] != "" AND $LeagueOutputOption['PlayersMugShotFileExtension'] != "" AND $Row['NHLID'] != ""){
	echo "<div class=\"Headshot\"><img loading=\"lazy\" src=\"" . $LeagueOutputOption['PlayersMugShotBaseURL'] . $Row['NHLID'] . "." . $LeagueOutputOption['PlayersMugShotFileExtension'] . "\" alt=\"" . $Row['Name']. "\" class=\"STHSPHPIndexLeadersHeadshot\" /></div>";}}
	echo "</td><td>" . $Row['G'] . "-" . $Row['A'] . "-" . $Row['P'] . "</td></tr>\n";
}}?>

<tr><th colspan="2" class="STHSTop5"><?php echo $IndexLang['Top5Goal'];?></th></tr>
<tr><td class="STHSIndex_Top5PointNameHeader"><?php echo $PlayersLang['PlayerName'];?></td><td class="STHSIndex_Top5PointResultHeader">GP-G</td></tr>
<?php
If ($IndexQueryOK== True){
	$Query = "SELECT PlayerProStat.G, PlayerProStat.A, PlayerProStat.P, PlayerProStat.GP, PlayerProStat.Name, PlayerProStat.Number, TeamProInfo.Abbre, TeamProInfo.TeamThemeID, PlayerInfo.NHLID  FROM (PlayerInfo INNER JOIN PlayerProStat ON PlayerInfo.Number = PlayerProStat.Number) LEFT JOIN TeamProInfo ON PlayerInfo.Team = TeamProInfo.Number WHERE (PlayerProStat.GP >= " . $LeagueOutputOption['ProMinimumGamePlayerLeader'] . ") AND (PlayerInfo.Team > 0) AND (PlayerProStat.P > 0) ORDER BY PlayerProStat.G DESC, PlayerProStat.GP ASC LIMIT 5";
	$PlayerStat = $db->query($Query);
}
$LoopCount = (integer)0;
if (empty($PlayerStat) == false){while ($Row = $PlayerStat ->fetchArray()) {
	$LoopCount +=1;echo "<tr><td>";
	If ($Row['TeamThemeID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $Row['TeamThemeID'] .".png\" alt=\"\" class=\"STHSPHPIndividualLeadersTeamImage\" />";}
	echo "<a href=\"PlayerReport.php?Player=" . $Row['Number'] . "\">" . $Row['Name'] . " (" . $Row['Abbre'] . ")</a>";
	If($LoopCount == 1){If ($LeagueOutputOption['PlayersMugShotBaseURL'] != "" AND $LeagueOutputOption['PlayersMugShotFileExtension'] != "" AND $Row['NHLID'] != ""){
	echo "<div class=\"Headshot\"><img loading=\"lazy\" src=\"" . $LeagueOutputOption['PlayersMugShotBaseURL'] . $Row['NHLID'] . "." . $LeagueOutputOption['PlayersMugShotFileExtension'] . "\" alt=\"" . $Row['Name']. "\" class=\"STHSPHPIndexLeadersHeadshot\" /></div>";}}
	echo "</td><td>" . $Row['GP'] . " - " . $Row['G'] . "</td></tr>\n";
}}?>

<tr><th colspan="2" class="STHSTop5"><?php echo $IndexLang['Top5Goalies'];?></th></tr>
<tr><td class="STHSIndex_Top5PointNameHeader"><?php echo $PlayersLang['GoalieName'];?></td><td class="STHSIndex_Top5PointResultHeader">W-PCT</td></tr>
<?php
If ($IndexQueryOK== True){
	$Query = "SELECT ROUND((CAST(GoalerProStat.SA - GoalerProStat.GA AS REAL) / (GoalerProStat.SA)),3) AS PCT, GoalerProStat.W, GoalerProStat.SecondPlay, GoalerProStat.Name, GoalerProStat.Number, TeamProInfo.Abbre, TeamProInfo.TeamThemeID, GoalerInfo.NHLID  FROM (GoalerInfo INNER JOIN GoalerProStat ON GoalerInfo.Number = GoalerProStat.Number) LEFT JOIN TeamProInfo ON GoalerInfo.Team = TeamProInfo.Number WHERE (GoalerProStat.SecondPlay >= (" . $LeagueOutputOption['ProMinimumGamePlayerLeader'] . "*3600)) AND (GoalerInfo.Team > 0) AND (PCT > 0) ORDER BY PCT DESC, GoalerProStat.W DESC LIMIT 5";
	$PlayerStat = $db->query($Query);
}
$LoopCount = (integer)0;
if (empty($PlayerStat) == false){while ($Row = $PlayerStat ->fetchArray()) {
	$LoopCount +=1;echo "<tr><td>";
	If ($Row['TeamThemeID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $Row['TeamThemeID'] .".png\" alt=\"\" class=\"STHSPHPIndividualLeadersTeamImage\" />";}
	echo "<a href=\"GoalieReport.php?Goalie=" . $Row['Number'] . "\">" . $Row['Name'] . " (" . $Row['Abbre'] . ")</a>";
	If($LoopCount == 1){If ($LeagueOutputOption['PlayersMugShotBaseURL'] != "" AND $LeagueOutputOption['PlayersMugShotFileExtension'] != "" AND $Row['NHLID'] != ""){
	echo "<div class=\"Headshot\"><img loading=\"lazy\" src=\"" . $LeagueOutputOption['PlayersMugShotBaseURL'] . $Row['NHLID'] . "." . $LeagueOutputOption['PlayersMugShotFileExtension'] . "\" alt=\"" . $Row['Name']. "\" class=\"STHSPHPIndexLeadersHeadshot\" /></div>";}}
	echo "</td><td>" . $Row['W'] . " - " . number_Format($Row['PCT'],3) .  "</td></tr>\n";
}}?>

<tr><th colspan="2" class="STHSTop5"><?php echo $IndexLang['Top5Defenseman'];?></th></tr>
<tr><td class="STHSIndex_Top5PointNameHeader"><?php echo $PlayersLang['PlayerName'];?></td><td class="STHSIndex_Top5PointResultHeader">G-A-P</td></tr>
<?php
If ($IndexQueryOK== True){
	$Query = "SELECT PlayerProStat.G, PlayerProStat.A, PlayerProStat.P, PlayerProStat.GP, PlayerProStat.Name, PlayerProStat.Number, TeamProInfo.Abbre, TeamProInfo.TeamThemeID, PlayerInfo.NHLID  FROM (PlayerInfo INNER JOIN PlayerProStat ON PlayerInfo.Number = PlayerProStat.Number) LEFT JOIN TeamProInfo ON PlayerInfo.Team = TeamProInfo.Number WHERE (PlayerProStat.GP >= " . $LeagueOutputOption['ProMinimumGamePlayerLeader'] . ") AND (PlayerInfo.Team > 0) AND (PlayerInfo.PosD='True') AND (PlayerProStat.P > 0) ORDER BY PlayerProStat.P DESC, PlayerProStat.G DESC, PlayerProStat.GP ASC LIMIT 5";
	$PlayerStat = $db->query($Query);
}
$LoopCount = (integer)0;
if (empty($PlayerStat) == false){while ($Row = $PlayerStat ->fetchArray()) {
	$LoopCount +=1;echo "<tr><td>";
	If ($Row['TeamThemeID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $Row['TeamThemeID'] .".png\" alt=\"\" class=\"STHSPHPIndividualLeadersTeamImage\" />";}
	echo "<a href=\"PlayerReport.php?Player=" . $Row['Number'] . "\">" . $Row['Name'] . " (" . $Row['Abbre'] . ")</a>";
	If($LoopCount == 1){If ($LeagueOutputOption['PlayersMugShotBaseURL'] != "" AND $LeagueOutputOption['PlayersMugShotFileExtension'] != "" AND $Row['NHLID'] != ""){
	echo "<div class=\"Headshot\"><img loading=\"lazy\" src=\"" . $LeagueOutputOption['PlayersMugShotBaseURL'] . $Row['NHLID'] . "." . $LeagueOutputOption['PlayersMugShotFileExtension'] . "\" alt=\"" . $Row['Name']. "\" class=\"STHSPHPIndexLeadersHeadshot\" /></div>";}}
	echo "</td><td>" . $Row['G'] . "-" . $Row['A'] . "-" . $Row['P'] . "</td></tr>\n";
}}?>

<tr><th colspan="2" class="STHSTop5"><?php echo $IndexLang['Top5Rookies'];?></th></tr>
<tr><td class="STHSIndex_Top5PointNameHeader"><?php echo $PlayersLang['PlayerName'];?></td><td class="STHSIndex_Top5PointResultHeader">G-A-P</td></tr>
<?php
If ($IndexQueryOK== True){
	$Query = "SELECT PlayerProStat.G, PlayerProStat.A, PlayerProStat.P, PlayerProStat.GP, PlayerProStat.Name, PlayerProStat.Number, TeamProInfo.Abbre, TeamProInfo.TeamThemeID, PlayerInfo.NHLID  FROM (PlayerInfo INNER JOIN PlayerProStat ON PlayerInfo.Number = PlayerProStat.Number) LEFT JOIN TeamProInfo ON PlayerInfo.Team = TeamProInfo.Number WHERE (PlayerProStat.GP >= " . $LeagueOutputOption['ProMinimumGamePlayerLeader'] . ") AND (PlayerInfo.Team > 0) AND (PlayerInfo.Rookie='True') AND (PlayerProStat.P > 0) ORDER BY PlayerProStat.P DESC, PlayerProStat.G DESC, PlayerProStat.GP ASC LIMIT 5";
	$PlayerStat = $db->query($Query);
}
$LoopCount = (integer)0;
if (empty($PlayerStat) == false){while ($Row = $PlayerStat ->fetchArray()) {
	$LoopCount +=1;echo "<tr><td>";
	If ($Row['TeamThemeID'] > 0){echo "<img src=\"" . $ImagesCDNPath . "/images/" . $Row['TeamThemeID'] .".png\" alt=\"\" class=\"STHSPHPIndividualLeadersTeamImage\" />";}
	echo "<a href=\"PlayerReport.php?Player=" . $Row['Number'] . "\">" . $Row['Name'] . " (" . $Row['Abbre'] . ")</a>";
	If($LoopCount == 1){If ($LeagueOutputOption['PlayersMugShotBaseURL'] != "" AND $LeagueOutputOption['PlayersMugShotFileExtension'] != "" AND $Row['NHLID'] != ""){
	echo "<div class=\"Headshot\"><img loading=\"lazy\" src=\"" . $LeagueOutputOption['PlayersMugShotBaseURL'] . $Row['NHLID'] . "." . $LeagueOutputOption['PlayersMugShotFileExtension'] . "\" alt=\"" . $Row['Name']. "\" class=\"STHSPHPIndexLeadersHeadshot\" /></div>";}}
	echo "</td><td>" . $Row['G'] . "-" . $Row['A'] . "-" . $Row['P'] . "</td></tr>\n";
}}?>
<?php if(isset($LeagueGeneral)){
if (strlen($LeagueGeneral['Days73StarPro']) > 20){echo "<tr><th colspan=\"2\" class=\"STHSTop5\"><br /><br />" . $IndexLang['7DaysStar'] . "</th></tr><tr><td colspan=\"2\">" . str_replace("/", "<br />",$LeagueGeneral['Days73StarPro']) . "</td></tr>";}
if (strlen($LeagueGeneral['Days303StarPro']) > 20){echo "<tr><th colspan=\"2\" class=\"STHSTop5\"><br /><br />" . $IndexLang['30DaysStar'] . "</th></tr><tr><td colspan=\"2\">" . str_replace("/", "<br />",$LeagueGeneral['Days303StarPro']) . "</td></tr>";}

If ($LeagueOutputOption['ShowFarmScoreinPHPHomePage'] == 'True'){
	if (strlen($LeagueGeneral['Days73StarFarm']) > 20){echo "<tr><th colspan=\"2\" class=\"STHSTop5\"><br /><br />" . $TopMenuLang['FarmLeague'] . " : " . $IndexLang['7DaysStar'] . "</th></tr><tr><td colspan=\"2\">" . str_replace("/", "<br />",$LeagueGeneral['Days73StarFarm']) . "</td></tr>";}
	if (strlen($LeagueGeneral['Days303StarFarm']) > 20){echo "<tr><th colspan=\"2\" class=\"STHSTop5\"><br /><br />" . $TopMenuLang['FarmLeague'] . " : " . $IndexLang['30DaysStar'] . "</th></tr><tr><td colspan=\"2\">" . str_replace("/", 	"<br />",$LeagueGeneral['Days303StarFarm']) . "</td></tr>";}
}
}?>


</td>
</tr>
</table>

<?php include "Footer.php";?>
