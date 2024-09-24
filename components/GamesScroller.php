<div class="gamesScroller mx-0 px-0 ">
    <div class="row  mx-0 px-0">

        <div class="scrollButtons ">
            <div class="scrollDivTop  ">
                <button class="scrollBtn scrollBtnLeft" id="left-button"><img src="/images/arrow-left-01-128.png" ></button>
            </div>
            <div class=" scrollDivBot  ">
                <button class="scrollBtn scrollBtnRight " id="right-button"><img src="images/arrow-right-01-128.png" ></button>
            </div>
        </div>
        <div class=" ">    
            <div class="scroll-container" id="boxscore">
                <table class="STHSTodayGame_MainTable">
                        <td style="background:white;width:43px;height:84px;display:block"><br></td>
                        
                        <?php
                        if (empty($LatestScore) == false) {
                            while ($row = $LatestScore->fetchArray()) {
                                echo "<td class=\"STHSTodayGame_GameOverall GameDayTable\">";
                                echo "<table class=STHSTodayGame_GameData style=margin-left:4px>";
                                echo "<tr style=\"font-size:10px;color:#383732;font-weight:bold;line-height:15px;\"> <td> Day " . $row['Day'] . " - #" . $row['GameNumber'] . "</td></tr>";
                                echo "<tr style=line-height:0px;color:#2a2a2a;font-weight:bold;margin:0px;font-size:14px>";
                                echo "<td><span><img src=\"" . $ImagesCDNPath . "/images/" . $row['VisitorTeamThemeID'] . ".png\" alt=\"\" style=width:24px;vertical-align:middle;padding-right:4px></span>";
                                echo $row['VisitorTeamAbbre'];
                                echo "</td><td style=width:55px;font-size:20px;text-align:center;font-weight:bold>";
                                echo $row['VisitorScore'] . "</td></tr>";
                                echo "<tr style=line-height:0px;color:#2a2a2a;font-weight:bold;margin:0px;font-size:14px>";
                                echo "<td><span><img src=\"" . $ImagesCDNPath . "/images/" . $row['HomeTeamThemeID'] . ".png\" alt=\"\" style=width:24px;vertical-align:middle;padding-right:4px></span>";
                                echo $row['HomeTeamAbbre'];
                                echo "</td><td style=width:55px;font-size:20px;text-align:center;font-weight:bold>";
                                echo $row['HomeScore'] . "</td></tr>";
                                echo "</table></td>";
                            }
                        }
                        ?>

                        <?php
                        if (empty($Schedule) == false) {
                            while ($row = $Schedule->fetchArray()) {
                                echo "<td class=\"STHSTodayGame_GameOverall GameDayTable\"><table class=\"STHSTodayGame_GameData\" style=\"margin-left:4px\">";
                                echo "<tr style=\"font-size:10px;color:#383732;font-weight:bold;line-height:15px;\"><td>Thu, Oct 10</td></tr>";
                                echo "<tr style=line-height:0px;color:#2a2a2a;font-weight:bold;margin:0px;font-size:14px><td><span>";
                                if ($row['VisitorTeamThemeID'] > 0) {
                                    echo "<img src=\"" . $ImagesCDNPath . "/images/" . $row['VisitorTeamThemeID'] . ".png\" alt=\"\" style=width:24px;vertical-align:middle;padding-right:4px></span>";
                                }
                                echo $row['VisitorTeamAbbre'] . "</td><td style=width:55px;font-size:20px;text-align:center;font-weight:bold>-</td></tr>";
                                echo "<tr style=line-height:0px;color:#2a2a2a;font-weight:bold;margin:0px;font-size:14px><td><span>";
                                if ($row['HomeTeamThemeID'] > 0) {
                                    echo "<img src=\"" . $ImagesCDNPath . "/images/" . $row['HomeTeamThemeID'] . ".png\" alt=\"\" style=width:24px;vertical-align:middle;padding-right:4px></span>";
                                }
                                echo $row['HomeTeamAbbre'] . "</td><td style=width:55px;font-size:20px;text-align:center;font-weight:bold>-</td></tr>";
                                echo "</table></td>";
                            }
                        }
                        ?>
                </table>
            </div>   
        </div>
    </div>
</div>  
    

   
    <script>
          var boxscore = document.getElementById('boxscore');
    var startX, scrollLeft, isDown = false;

    // Button click functionality
    $('#right-button').click(function(event) {
        event.preventDefault();
        $('#boxscore').animate({
            scrollLeft: '+=145px'
        }, 'fast');
    });

    $('#left-button').click(function(event) {
        event.preventDefault();
        $('#boxscore').animate({
            scrollLeft: '-=145px'
        }, 'fast');
    });

    // Touch event functionality
    boxscore.addEventListener('touchstart', function(e) {
        startX = e.touches[0].pageX - boxscore.offsetLeft;
        scrollLeft = boxscore.scrollLeft;
        isDown = true;
    });

    boxscore.addEventListener('touchmove', function(e) {
        if (!isDown) return;
        e.preventDefault();
        var x = e.touches[0].pageX - boxscore.offsetLeft;
        var walk = (x - startX) * 2; // Adjust the multiplier for faster/slower scrolling
        boxscore.scrollLeft = scrollLeft - walk;
    });

    boxscore.addEventListener('touchend', function() {
        isDown = false;
    });

    // Mouse grab functionality
    boxscore.addEventListener('mousedown', function(e) {
        isDown = true;
        startX = e.pageX - boxscore.offsetLeft;
        scrollLeft = boxscore.scrollLeft;
        boxscore.classList.add('active');
    });

    boxscore.addEventListener('mouseleave', function() {
        isDown = false;
        boxscore.classList.remove('active');
    });

    boxscore.addEventListener('mouseup', function() {
        isDown = false;
        boxscore.classList.remove('active');
    });

    boxscore.addEventListener('mousemove', function(e) {
        if (!isDown) return;
        e.preventDefault();
        var x = e.pageX - boxscore.offsetLeft;
        var walk = (x - startX) * 2; // Adjust the multiplier for faster/slower scrolling
        boxscore.scrollLeft = scrollLeft - walk;
    });
    </script>