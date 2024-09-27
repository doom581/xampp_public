
<footer class="clearfix">
		<div class="row">
			<div class="col">
				<div class="module-content">
					<h4>Legacy</h4>
					<ul>					
                    <?php
                           echo "<li><a href=\"old/index.php\"> Old Website </a></li>";
                           echo "<li><a href=\"" . $LeagueGeneralMenu['OutputName'] . ".stc\">"  . $TopMenuLang['STHSClientLeagueFile'] . "</a></li>";
                        ?>
					</ul>
				</div>
			</div>
			<div class="col">
				<div class="module-content">
					<h4>Support</h4>
					<ul>
                        <li>  </li>
					</ul>
				</div>
			</div>
           
			<div class="col-4 bg-orange">
				<div class="module-content">
                    <h5>Ligue de Hockey Simulé</h5>
                    <h5>Quebec City</h5>
					<ul >
						<li>
                            <div class="logo "><a href="index.php"> <img src="images/lhsqc_logo_2.png" alt="LHSQC" class="footer-logo"></a> </div>
                        </li>
					</ul>
                </div>
			</div>
		</div>
	</footer>

<!-- Copyright -->
<div class="text-center p-1" style="background-color: rgba(0, 0, 0, 0.2);">
        <div class="mt-1">
        <?php 
        If (isset($Footer) == True){
            echo $Footer . $LeagueOwner;

            If (file_exists($DatabaseFile) == True){
                try{
                    echo " - " . $DatabaseCreate;
                    If (isset($LeagueGeneralMenu) == True){
                        echo	$LeagueGeneralMenu['DatabaseCreationDate'];
                    }
                } catch (Exception $e) {}
            }
        }
        If (isset($PerformanceMonitorStart)){
            echo "<script>  console.log(\"STHS Page PHP Performance : " . (microtime(true)-$PerformanceMonitorStart) . " - Peak Memory Usage : " . round(memory_get_peak_usage() / 1024) . "KB  - Peak Memory Usage : " . round(memory_get_peak_usage(true) / 1024) . "KB \");  </script>";}
        ?> <small> . - . 2024 Special Blend Production . - . </small></a>
        </div>
    </div>


<a href="#" class="scrollup">Back to the Top</a>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.10.0/p5.min.js"></script>

</body>
</html> 