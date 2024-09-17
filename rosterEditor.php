
<?php include "Header.php"; ?>	


</head>
<body>
<header>
  <?php include "Menu.php"; ?>	


  <?php
// Assuming you have a PHP array of player names
$playersNames = ['Player1', 'Player2', 'Player3', 'Player4'];
$playersPositions = ['LW', 'C', 'RW', 'DD'];
?>

<script>
    // Pass the PHP array to a JavaScript variable
    let playersNames = <?php echo json_encode($playersNames); ?>;
    let playersPositions = <?php echo json_encode($playersPositions); ?>;
    let players = [];

    for (let i = 0; i < playersNames.length; i++) {
        let name = playersNames[i];
        let position = playersPositions[i];
        players.push({ name: name, position: position });
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
                        <div class="col m-1 p-0" >
                            <div class="card roster-container" id="LW1">
                                <div class="card-body">
                                    <p class="card-text ">LW1</p>
                                </div>
                            </div>
                        </div>
                        <div class="col m-1 p-0">
                            <div class="card roster-container" id="C1">
                                <div class="card-body">
                                    <p class="card-text">C1</p>
                                </div>
                            </div>
                        </div>
                        <div class="col m-1 p-0">
                            <div class="card roster-container" id="RW1">
                                <div class="card-body">
                                    <p class="card-text">RW1</p>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <div class="row m-0 p-0" id="divF2">
                        <div class="col m-1 p-0" >
                            <div class="card roster-container" id="LW2">
                                <div class="card-body">
                                    <p class="card-text">LW2</p>
                                </div>
                            </div>
                        </div>
                        <div class="col m-1 p-0">
                            <div class="card roster-container" id="C2">
                                <div class="card-body">
                                    <p class="card-text">C2</p>
                                </div>
                            </div>
                        </div>
                        <div class="col m-1 p-0">
                            <div class="card roster-container" id="RW2">
                                <div class="card-body">
                                    <p class="card-text ">RW2</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row m-0 p-0" id="divF3">
                        <div class="col m-1 p-0">
                            <div class="card roster-container" id="LW3">
                                <div class="card-body">
                                    <p class="card-text">LW3</p>
                                </div>
                            </div>
                        </div>
                        <div class="col m-1 p-0">
                            <div class="card roster-container" id="C3">
                                <div class="card-body">
                                    <p class="card-text">C3</p>
                                </div>
                            </div>
                        </div>
                        <div class="col m-1 p-0">
                            <div class="card roster-container" id="RW3">
                                <div class="card-body">
                                    <p class="card-text">RW3</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row m-0 p-0" id="divF4">
                        <div class="col m-1 p-0">
                            <div class="card roster-container" id="LW4">
                                <div class="card-body">
                                    <p class="card-text">LW4</p>
                                </div>
                            </div>
                        </div>
                        <div class="col m-1 p-0">
                            <div class="card roster-container" id="C4">
                                <div class="card-body">
                                    <p class="card-text">C4</p>
                                </div>
                            </div>
                        </div>
                        <div class="col m-1 p-0">
                            <div class="card roster-container" id="RW4">
                                <div class="card-body">
                                    <p class="card-text">RW4</p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row m-0 p-0" id="divD1">
                        <div class="col-1 m-1 p-0"></div>
                        <div class="col   m-1 p-0">
                            <div class="card roster-container" id="DG1">
                                <div class="card-body">
                                    <p class="card-text">DG1</p>
                                </div>
                            </div>
                        </div>
                        <div class="col m-1 p-0">
                            <div class="card roster-container" id="DD1">
                                <div class="card-body">
                                    <p class="card-text">DD1</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-1 m-1 p-0"></div> 
                    </div>
                    <div class="row m-0 p-0" id="divD2">
                        <div class="col-1 m-1 p-0"></div> 
                        <div class="col m-1 p-0">
                            <div class="card roster-container" id="DG2">
                                <div class="card-body">
                                    <p class="card-text">DG2</p>
                                </div>
                            </div>
                        </div>
                        <div class="col m-1 p-0">
                            <div class="card roster-container" id="DD2">
                                <div class="card-body">
                                    <p class="card-text ">DD2</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-1 m-1 p-0"></div> 
                    </div>
                    <div class="row m-0 p-0" id="divD3">
                        <div class="col-1 m-1 p-0"></div> 
                        <div class="col m-1 p-0">
                            <div class="card roster-container" id="DG3">
                                <div class="card-body">
                                    <p class="card-text">DG3</p>
                                </div>
                            </div>
                        </div>
                        <div class="col m-1 p-0">
                            <div class="card roster-container" id="DD3">
                                <div class="card-body">
                                    <p class="card-text ">DD3</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-1 m-1 p-0"></div> 
                    </div>
                   
                
                </div>
            </div>
        </div>



        <div class="col-3 m-0 p-0">
            <div class="card text-center h-75 mb-1 mx-0 mt-1 ">
                <div class="card-header">Healthy</div>
                <div class="card-body m-0 p-1 Roster" id="Roster">
                    <!--     ul li   list created from JS-->
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

<?php include "Footer.php";?>
