let RosterPlayers;
/*
let rosterPos = [{LW1:"LW1"}, {C1:"C1"}, {RW1:"RW1"}, {DG1:"DG1"}, {DD1:"DD1"}
                ,{LW2:"LW2"}, {C2:"C2"}, {RW2:"RW2"}, {DG2:"DG2"}, {DD2:"DD2"}
                ,{LW3:"LW3"}, {C3:"C3"}, {RW3:"RW3"}, {DG3:"DG3"}, {DD3:"DD3"}
                ,{LW4:"LW4"}, {C4:"C4"}, {RW4:"RW4"}]

*/
/*let lineup = []
lineup["LW1"] = { name:"LW1" }
lineup["C1"]  = { name:"C1" }
lineup["RW1"] = { name:"RW1" }
lineup["LW2"] = { name:"LW2" }
lineup["C2"]  = { name:"C2" }
lineup["RW2"] = { name:"RW2" }
lineup["LW3"] = { name:"LW3" }
lineup["C3"]  = { name:"C3" }
lineup["RW3"] = { name:"RW3" }
lineup["LW4"] = { name:"LW4" }
lineup["C4"]  = { name:"C4" }
lineup["RW4"] = { name:"RW4" }
lineup["DG1"] = { name:"DG1" }
lineup["DD1"] = { name:"DD1" }
lineup["DG2"] = { name:"DG2" }
lineup["DD2"] = { name:"DD2" }
lineup["DG3"] = { name:"DG3" }
lineup["DD3"] = { name:"DD3" } */

/*
let lines = [{ lineId:"1", lw:"LW", c:"C", rw:"RW" }
            ,{ lineId:"2", lw:"LW", c:"C", rw:"RW" }
            ,{ lineId:"3", lw:"LW", c:"C", rw:"RW" }
            ,{ lineId:"4", lw:"LW", c:"C", rw:"RW" }
            ,{ lineId:"5", dg:"DG", dd: "DD" }
            ,{ lineId:"6", dg:"DG", dd: "DD" }
            ,{ lineId:"7", dg:"DG", dd: "DD" }]
*/
let Roster = []

function setup() {

    // Create player divs using the players array (array of objects) from php
    players.forEach(player => {
        let name = player.name
        let pos = player.position
        let d = createDraggablePlayerDiv(player.name)
        Roster.push({name:name, pos: pos, div:d, lineup: "", zone:"roster"})
    });

    console.log("Roster", Roster )

    // Handle drop zones in Lines (roster-containers)
    let dropZones = document.querySelectorAll('#Lines .roster-container');
    dropZones.forEach(zone => {
        zone.addEventListener('dragover', allowDrop);
        zone.addEventListener('drop', handleDropOnContainer);
    });

    // Make the roster droppable
    let rosterDropZone = document.getElementById('Roster');
    rosterDropZone.addEventListener('dragover', allowDrop);
    rosterDropZone.addEventListener('drop', handleDropBackToRoster);

    // Make the scratched list droppable
    let scratchedDropZone = document.getElementById('Scratched');
    scratchedDropZone.addEventListener('dragover', allowDrop);
    scratchedDropZone.addEventListener('drop', handleDropToScratched);

    // Save button functionality
    let saveButton = createButton('Save');
    saveButton.parent('saveBtn');
    saveButton.mousePressed(savePositions);
}

function createDraggablePlayerDiv(playerName) {

    let contenant = createDiv()
        .parent("Roster")
        .addClass('card roster-container rosterElm draggable p-0 ')
        .elt;
    contenant.id = playerName;
    contenant.setAttribute('draggable', true);  // Make it draggable by setting the attribute
    let bodyDiv = createDiv()
        .parent(contenant)
        .addClass('card-body p-0 ')
        .elt;

     createP(playerName)
        .parent(bodyDiv)
        .addClass('card-text');


    // Add dragstart event listener
    contenant.addEventListener('dragstart', function (event) {
        event.dataTransfer.setData('playerId', playerName)
        event.dataTransfer.setData('fromZone', 'roster')
        event.dataTransfer.setData('elementId', contenant.id)
    });

    return contenant
}

function allowDrop(event) {
    event.preventDefault()
}

function handleDropOnContainer(event) {
    event.preventDefault()
    let playerId = event.dataTransfer.getData('playerId')
    let fromZone = event.dataTransfer.getData('fromZone')
    let elementId = event.dataTransfer.getData('elementId')
    let playerElement = document.getElementById(elementId)

    console.log('FromZone: ', fromZone)
    let currentZone = event.currentTarget
    console.log('CurrentZone: ', currentZone)

    let currentPlayerInZone = currentZone.querySelector('.card-text').innerHTML
    console.log('CurrentPlayerInZone: ', currentPlayerInZone)

    if (fromZone === 'roster-container') {

         // if dropped on same container or if container was free
            // Set player in the container
            currentZone.querySelector('.card-text').innerHTML = playerId
            currentZone.style.border = "2px solid green"
            // Remove the player element from its source
            //playerElement.remove()
            console.log("Player assigned to a free slot")
             // Reset element 
             if (playerElement) {
                playerElement.style.border = "1px solid black";
                playerElement.setAttribute('draggable', false);
                playerElement.innerHTML =   "<div class=\"card-body p-0 \"><p class=\"card-text\">" + playerElement.id  +"</p></div>"   
                // playerDiv.style.color =  "#b0ccbb";
                playerElement.style.padding =  "10px";    
            }
    } else if ((fromZone === 'roster')||(fromZone === 'scratched')) {  
        if (currentPlayerInZone === currentZone.id) {  // if dropped on same container or if container was free
            // Set player in the container
            currentZone.querySelector('.card-text').innerHTML = playerId
            currentZone.style.border = "2px solid green"
            // Remove the player element from its source
            playerElement.remove()
            console.log("Player assigned to a free slot")
            } else { 
                if (currentPlayerInZone !== currentZone.id) {  //  Container was already assigned a player
                    // Move the existing player from the container back to the appropriate list
                    let existingPlayerName = currentPlayerInZone
                    // Set player in the container
                    currentZone.querySelector('.card-text').innerHTML = playerId
                    currentZone.style.border = "2px solid green"
                    // Remove the player element from its source
                    playerElement.remove()
                    createDraggablePlayerDiv(existingPlayerName)
                }
            }

    } 


        // Make the container draggable
        currentZone.setAttribute('draggable', true);
        currentZone.addEventListener('dragstart', function (event) {
            event.dataTransfer.setData('playerId', playerId);
            event.dataTransfer.setData('fromZone', 'roster-container');
            event.dataTransfer.setData('elementId', currentZone.id);
        });
    
}

function handleDropBackToRoster(event) {
    event.preventDefault();
    let playerId = event.dataTransfer.getData('playerId');
    let elementId = event.dataTransfer.getData('elementId');
    let fromZone = event.dataTransfer.getData('fromZone');
    let playerDiv = document.getElementById(elementId)

    if (fromZone === 'roster') {
        return
    }

    if (fromZone === 'scratched') {
        // Remove the player element from its source
        playerDiv.remove()
        createDraggablePlayerDiv(playerId)
        return
    }

    if (fromZone === 'roster-container') {
         
        if (playerDiv) {
            playerDiv.innerHTML =   "<div class=\"card-body p-0 \"><p class=\"card-text\">" + playerDiv.id  +"</p></div>"             
            // Add the player back to the roster
            createDraggablePlayerDiv(playerId);

           // playerDiv.querySelector('.card-text').innerText = playerDiv.id;
            playerDiv.style.border = "1px solid black";
            playerDiv.setAttribute('draggable', false);

            playerDiv.style.border = "1px solid black";
            playerDiv.style.color =  "#b0ccbb";
            playerDiv.style.padding =  "10px";
            //playerDiv.innerHTML = playerDiv.id;  
          
        } else {
            console.error("Container element not found");
        }
    
    
    }

   
}



function handleDropToScratched(event) {
    event.preventDefault();

    let playerId = event.dataTransfer.getData('playerId');
    let elementId = event.dataTransfer.getData('elementId');
    let fromZone = event.dataTransfer.getData('fromZone');
    let playerDiv = document.getElementById(elementId)

    if (fromZone === 'roster-container') {
          // Reset the original container to its default state
          let container = document.getElementById(event.target.id);
          if (container) {
              container.innerHTML = "<div class=\"card-body p-0 \"><p class=\"card-text\">" + event.target.id + "</p></div>";
              //container.style.border = "1px solid black";
              container.setAttribute('draggable', false);
          }


          console.log(container, playerDiv)
           // Reset element 
            if (playerDiv) {
                playerDiv.style.border = "1px solid black";
                playerDiv.setAttribute('draggable', false);
                playerDiv.innerHTML =   "<div class=\"card-body p-0 \"><p class=\"card-text\">" + playerDiv.id  +"</p></div>"   
            // playerDiv.style.color =  "#b0ccbb";
                playerDiv.style.padding =  "10px";
                
            }
    } else {
        // Remove the player from the previous roster-container
        if (playerDiv) {
        playerDiv.remove();
        }
    }

   // Add the player to the scratched list
   let scratchDiv = createDiv(playerId)
                        .parent('Scratched')
                        .addClass('rosterElm scratch')
                        .elt;
    scratchDiv.setAttribute('draggable', true);
    scratchDiv.id = playerId;

    scratchDiv.addEventListener('dragstart', function (event) {
        event.dataTransfer.setData('playerId', playerId);
        event.dataTransfer.setData('fromZone', 'scratched');
        event.dataTransfer.setData('elementId', scratchDiv.id);
    });


}




function savePositions() {
    let dropZones = document.querySelectorAll('#Lines .roster-container');
    let positions = [];

    dropZones.forEach(zone => {
        let playerName = zone.querySelector('.card-text').innerHTML;
        if (playerName !== originalTexts[zone.id]) {
            positions.push({
                positionId: zone.id,
                playerName: playerName
            });
        }
    });

    console.log("Saved Positions:", positions);
}

function draw() {
    // Empty function, P5.js needs this for compatibility
}
