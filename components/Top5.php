<div class="card border border-primary  transparent-card-body shadow-0 mb-3 frontpage-card  "  >
    <div class="card-header">Top Stars</div>
    <div class="card-body mt-0 pt-0 text-primary">
    <div class="StarTableHeader"><img id="Top5" src="<?php echo $ImagesCDNPath;?>/images/top5.png" alt="Top 5"  ></div>                                   
        <table class="StarTable">
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

        </table>
              
    </div>
</div>