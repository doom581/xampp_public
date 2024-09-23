<?php include "Header.php"; ?>
<?php 
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
	
	echo "<title>" . "NEW ". $LeagueName . " - " . $IndexLang['IndexTitle'] . "</title>";
	echo "<style>";

 
	If ($LeagueGeneral['OffSeason'] == "True"){
		echo ".STHSIndex_Score{display:none;}";
		echo ".STHSIndex_Top5Table {display:none;}";
		echo "@media screen and (max-width: 890px) {.STHSIndex_Top5 {display:none;}}";
	}else{
		echo ".STHSIndex_Top20FreeAgents {display:none;}";
		echo "@media screen and (max-width: 890px) {.STHSIndex_Score{display:none;}}";
		echo "@media screen and (max-width: 1210px) {.STHSIndex_Top5 {display:none;}}";
	}
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
	echo "<style>";
	echo ".STHSIndex_Main{display:none;}";
	echo "#cssmenu{display:none;}";
    echo "</style>";
}}
?>


</head>
<body>

<!--Main Navigation-->

<header>
    

<?php include "Menu.php"; ?>	

<?php include "components/GamesScroller.php"; ?>	
    
       
        

      







    <div class="clearfix header-content style="display:inline-block;">
        <div class="row mt-2  mx-2 row-cols-1 row-cols-md-2 row-cols-lg-3" >
            <div class="col-mb-6 "> <?php include "components/Top5.php"; ?> </div> 
            <div class="col-mb-6 "> <?php include "components/TopHeadlines.php"; ?> </div>
            <div class="col-mb-3 "> <?php include "components/NextGames.php"; ?> </div> 
            <div class="col-mb-6 "> <?php include "components/Top20FreeAgents.php"; ?> </div>   
            <div class="col-mb-3 "> <?php include "components/LastGames.php"; ?> </div> 
        </div>
	</div>
</header>

<div id=proBar><?php include "components/ProTeamsBar.php" ?></div>

<section class="sport-news">
  

    <main class="mt-5 text-white" data-mdb-theme="dark"">
        <div class="container">
            <div class="STHSIndex_NewsTD">
                <div class="STHSIndex_TheNews"><?php echo $LeagueName . $IndexLang['News'];?></div>
                <div class="STHSIndex_NewsDiv"><?php include "NewsSub.php";?></div>
                <br /><br />
            </div>
        </div>
    </main>
</section>



<section class="bg-10">
<div class="m-06 bg-dark-blue">
    <div class="module-content">

        <div class="title-default">
            <h2>Scores Table</h2>	
        </div>

        <div class="tab-dark-blue">
            <div class="m-03">
                <ul class="vertical tab-nav click-tab">
                    <li><h4>Yesterday</h4></li>
                    <li><h4>Today</h4></li>
                    <li><h4>Tomorrow</h4></li>
                </ul>
            </div>
            <div class="m-09">
                <div class="tab-content ">
                    <div>			
                        <table class="table-scores">
                            <tr>
                                <td>12:45</td>
                                <td>Man City</td>
                                <td><span>4-1</span></td>
                                <td>Southampton</td>
                                <td><a href="#"><i class="fa fa-file-text"></i></a></td>
                            </tr>
                            <tr>
                                <td>12:45</td>
                                <td>A Villa</td>
                                <td><span>1-2</span></td>
                                <td>Fulham</td>
                                <td><a href="#"><i class="fa fa-file-text"></i></a></td>
                            </tr>
                            <tr>
                                <td>12:45</td>
                                <td>Cardiff</td>
                                <td><span>0-3</span></td>
                                <td>C Palace</td>
                                <td><a href="#"><i class="fa fa-file-text"></i></a></td>
                            </tr>	
                            <tr>
                                <td>12:45</td>
                                <td>Man City</td>
                                <td><span>4-1</span></td>
                                <td>Southampton</td>
                                <td><a href="#"><i class="fa fa-file-text"></i></a></td>
                            </tr>
                            <tr>
                                <td>12:45</td>
                                <td>A Villa</td>
                                <td><span>1-2</span></td>
                                <td>Fulham</td>
                                <td><a href="#"><i class="fa fa-file-text"></i></a></td>
                            </tr>
                        </table>	
                    </div>
                    <div>
                        <table class="table-scores">
                            <tr>
                                <td>12:45</td>
                                <td>Man City</td>
                                <td><span>4-1</span></td>
                                <td>Southampton</td>
                                <td><a href="#"><i class="fa fa-file-text"></i></a></td>
                            </tr>
                            <tr>
                                <td>12:45</td>
                                <td>A Villa</td>
                                <td><span>1-2</span></td>
                                <td>Fulham</td>
                                <td><a href="#"><i class="fa fa-file-text"></i></a></td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <table class="table-scores">
                            <tr>
                                <td>12:45</td>
                                <td>Cardiff</td>
                                <td><span>0-3</span></td>
                                <td>C Palace</td>
                                <td><a href="#"><i class="fa fa-file-text"></i></a></td>
                            </tr>	
                            <tr>
                                <td>12:45</td>
                                <td>Man City</td>
                                <td><span>4-1</span></td>
                                <td>Southampton</td>
                                <td><a href="#"><i class="fa fa-file-text"></i></a></td>
                            </tr>
                            <tr>
                                <td>12:45</td>
                                <td>A Villa</td>
                                <td><span>1-2</span></td>
                                <td>Fulham</td>
                                <td><a href="#"><i class="fa fa-file-text"></i></a></td>
                            </tr>																																													
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>																										
</section>



<?php include "Footer.php"; ?>
