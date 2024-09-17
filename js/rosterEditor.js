let Roster = [];


function setup() {
    
    // Create player divs using the players array (array of objects) from PHP
    players.forEach(player => {
        let name = player.name;
        let pos = player.position;
        let d = createDraggablePlayerDiv(player.name);
        Roster.push({ name: name, pos: pos, div: d, lineup: "", zone: "roster" });
    });

    // Handle drop zones in Lines (roster-containers)
    let dropZones = document.querySelectorAll('#Lines .roster-container');
    dropZones.forEach(zone => {
        zone.addEventListener('dragover', allowDrop);
        zone.addEventListener('drop', handleDropOnContainer);
        //zone.addEventListener('touchmove', handleTouchMove);
        zone.addEventListener('touchend', handleTouchEnd);
    });

    // Make the roster droppable
    let rosterDropZone = document.getElementById('Roster');
    rosterDropZone.addEventListener('dragover', allowDrop);
    rosterDropZone.addEventListener('drop', handleDropBackToRoster);
   // rosterDropZone.addEventListener('touchmove', handleTouchMove);
    rosterDropZone.addEventListener('touchend', handleTouchEnd);

    // Make the scratched list droppable
    let scratchedDropZone = document.getElementById('Scratched');
    scratchedDropZone.addEventListener('dragover', allowDrop);
    scratchedDropZone.addEventListener('drop', handleDropToScratched);
    //scratchedDropZone.addEventListener('touchmove', handleTouchMove);
    scratchedDropZone.addEventListener('touchend', handleTouchEnd);

    // Save button functionality
    let saveButton = createButton('Save');
    saveButton.parent('saveBtn');
    saveButton.mousePressed(savePositions);
}

function createDraggablePlayerDiv(playerName) {
    let contenant = createDiv()
        .parent("Roster")
        .addClass('card Roster rosterElm draggable p-0')
        .elt;
    contenant.id = playerName;
    contenant.setAttribute('draggable', true);  // Make it draggable by setting the attribute
    let bodyDiv = createDiv()
        .parent(contenant)
        .addClass('card-body p-0')
        .elt;

    createP(playerName)
        .parent(bodyDiv)
        .addClass('card-text');

    // Add dragstart event listener
    contenant.addEventListener('dragstart', function (event) {
        event.dataTransfer.setData('playerId', playerName);
        event.dataTransfer.setData('fromZone', 'Roster');
        event.dataTransfer.setData('elementId', contenant.id);
    });

    contenant.addEventListener('touchstart', handleTouchStart);
    contenant.addEventListener('touchmove', handleTouchMove);

    return contenant;
}

function allowDrop(event) {
    event.preventDefault();
    /*  TODO:   implement effect to show possible drop here   */   
}

function handleDropOnContainer(event) {
    event.preventDefault()
  
    let target = event.currentTarget;
    let playerName = event.dataTransfer.getData('playerId')
    let rosterPlayerDiv = document.getElementById(playerName)
    let fromZone = event.dataTransfer.getData('fromZone')
    let playerDivId = event.dataTransfer.getData('elementId')
    let playerDiv = document.getElementById(playerDivId)
 

    let currentPlayerInZone = target.querySelector('.card-text').innerHTML;

    if (fromZone === 'roster-container') {


        let targetOriginalPlayerName =  target.querySelector('.card-text').innerHTML 


     
        if(target.id === targetOriginalPlayerName) {  // Empty lineup
            console.log("YES" ,"playerName:", playerName,"target:", target)
            
            target.querySelector('.card-text').innerHTML = playerName;
            target.style.border = "2px solid green";
            if (playerDiv) {
                playerDiv.style.border = "1px solid black";
                
                playerDiv.setAttribute('draggable', false);
                playerDiv.innerHTML = "<div class=\"card\"><div class=\"card-body \"><p class=\"card-text\">" + playerDiv.id + "</p></div></div>";
            }

        } else {    //  a player was already assigned.
            console.log("NO", "playerName:", playerName, "target:", target)

            target.querySelector('.card-text').innerHTML = playerName;
            target.style.border = "2px solid green";
            if (playerDiv) {
                playerDiv.style.border = "1px solid black";
                
                playerDiv.setAttribute('draggable', false);
                playerDiv.innerHTML = "<div class=\"card-body \"><p class=\"card-text\">" + playerDiv.id + "</p></div>";
            }

            createDraggablePlayerDiv(currentPlayerInZone);
        }
       
    








    } else if (fromZone === 'Roster' || fromZone === 'Scratched') {
        console.log("setting a new player!")
        if (currentPlayerInZone === target.id) {  //  if the location was empty
           
            target.querySelector('.card-text').innerHTML =  playerName 
            target.style.border = "2px solid green";
            playerDiv.remove()
        } 
        else if (currentPlayerInZone !== target.id) {  //  if a player was previously assigned
                let existingPlayerName = currentPlayerInZone;
                playerDiv.remove();
                target.innerHTML = "<div class=\"card\"><div class=\"card-body \"><p class=\"card-text\">" + playerDiv.id + "</p></div></div>";
                createDraggablePlayerDiv(existingPlayerName);
            
        }
    }

    target.setAttribute('draggable', true);
    target.addEventListener('dragstart', function (event) {
        event.dataTransfer.setData('playerId', playerName);
        event.dataTransfer.setData('fromZone', 'roster-container');
        event.dataTransfer.setData('elementId', target.id);
    });
}

function handleDropBackToRoster(event) {
    event.preventDefault();
    let playerId = event.dataTransfer.getData('playerId');
    let elementId = event.dataTransfer.getData('elementId');
    let fromZone = event.dataTransfer.getData('fromZone');
    let playerDiv = document.getElementById(elementId);

    if (fromZone === 'Roster') {
        return;
    }

    if (fromZone === 'Scratched') {
        playerDiv.remove();
        createDraggablePlayerDiv(playerId);
        return;
    }

    if (fromZone === 'roster-container') {
        if (playerDiv) {
            playerDiv.innerHTML = "<div class=\"card\"><div class=\"card-body \"><p class=\"card-text\">" + playerDiv.id + "</p></div></div>";
            createDraggablePlayerDiv(playerId);
            playerDiv.style.border = "1px solid black";
            playerDiv.setAttribute('draggable', false);
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
    let playerDiv = document.getElementById(elementId);

    if (fromZone === 'Scratched') {
        return;
    }

    if (fromZone === 'roster-container') {
        let container = document.getElementById(event.target.id);
       
        if (playerDiv) {
            playerDiv.style.border = "1px solid black";
            playerDiv.innerHTML ="<div class=\"card\"><div class=\"card-body \"><p class=\"card-text\">" + playerDiv.id + "</p></div></div>";
            playerDiv.setAttribute('draggable', false);
        }
    } else {
        if (playerDiv) {
            playerDiv.remove();
        }
    }

    let scratchDiv = createDiv(playerId)
        .parent('Scratched')
        .addClass('rosterElm scratch')
        .elt;
    scratchDiv.setAttribute('draggable', true);
    scratchDiv.id = playerId;

    scratchDiv.addEventListener('dragstart', function (event) {
        event.dataTransfer.setData('playerId', playerId);
        event.dataTransfer.setData('fromZone', 'Scratched');
        event.dataTransfer.setData('elementId', scratchDiv.id);
    });
}




function handleTouchEndOnContainer(data) {
    let dragged = data.dragged; // The player element being dragged
    let target = data.currentTarget; // The target container
    let fromZone = data.fromZone; // The zone from where the player was dragged
    let playerName = dragged.querySelector('.card-text').innerHTML; // Current player in the target container
   

    let currentPlayerInZone = target.querySelector('.card-text').innerHTML; // Current player in the target container

    if (fromZone === 'roster-container') {
        let targetOriginalPlayerName = target.querySelector('.card-text').innerHTML;

        // Case: Dropping into an empty lineup position
        if (target.id === targetOriginalPlayerName) {
            console.log("YES", "dragged:", dragged.id, "target:", target);

            target.querySelector('.card-text').innerHTML = playerName;
            target.style.border = "2px solid green";

            if (dragged) {
                dragged.style.border = "1px solid black";
                dragged.setAttribute('draggable', false);
                dragged.innerHTML = "<div class=\"card \"><div class=\"card-body \"><p class=\"card-text\">" + dragged.id + "</p></div></div>";
            }
        } else {
            // Case: A player was already assigned, swap players
            console.log("NO", "dragged:", dragged.id, "target:", target);

            target.querySelector('.card-text').innerHTML = playerName;
            target.style.border = "2px solid green";

            if (dragged) {
                dragged.style.border = "1px solid black";
                dragged.setAttribute('draggable', false);
                dragged.innerHTML = "<div class=\"card \"><div class=\"card-body \"><p class=\"card-text\">" + dragged.id + "</p></div></div>";
            }

            // Move the existing player back to their original zone
            createDraggablePlayerDiv(currentPlayerInZone);
        }

    } else if (fromZone === 'Roster' || fromZone === 'Scratched') {
        console.log("setting a new player!");

        if (currentPlayerInZone === target.id) { // If target was empty
            target.querySelector('.card-text').innerHTML = dragged.id;
            target.style.border = "2px solid green";
            dragged.remove();
        } else if (currentPlayerInZone !== target.id) { // A player was already assigned
            let existingPlayerName = currentPlayerInZone;
            target.querySelector('.card-text').innerHTML = dragged.id;
            target.style.border = "2px solid green";
            
            createDraggablePlayerDiv(existingPlayerName); // Move the existing player back to original zone
        }
    }

    // Ensure touch events are re-enabled after handling
    target.addEventListener('touchstart', handleTouchStart);
    target.addEventListener('touchmove', handleTouchMove);
    // Optionally: Add touchend event again if needed (depends on your logic flow)
    // target.addEventListener('touchend', handleTouchEnd);
}


function handleTouchEndBackToRoster(data) {
 
    let dragged = data.dragged;
    let target = data.currentTarget;
    let fromZone = data.fromZone;

    const parentDiv = dragged.querySelector('.card-body');
    const pElement = parentDiv.querySelector('.card-text');// Find the <p> element within the parent <div>
    const playerName = pElement.textContent; // Get the text content of the <p> element
    console.log(playerName)

    if (fromZone === 'Roster') {
        return;
    }

    if (fromZone === 'Scratched') {
        dragged.remove();
        createDraggablePlayerDiv(playerName);
        return;
    }

    if (fromZone === 'roster-container') {

        // Find the container the player was dragged out from
        const rosterContainer = dragged.parentElement;  // Assuming dragged was inside a roster-container
        
        //rosterContainer.style.border = "1px solid black";
        rosterContainer.setAttribute('draggable', false);
        rosterContainer.innerHTML = "<div class=\"card roster-container\"><div class=\"card-body \"><p class=\"card-text\">" + dragged.id + "</p></div></div>";
        //rosterContainer.style.padding = "10px";
   
        createDraggablePlayerDiv(playerName);
    }
}

function handleTouchEndToScratched(data) {
    
    let dragged = data.dragged;
    let target = data.currentTarget;
    let fromZone = data.fromZone;

    let playerName = dragged.querySelector('.card-text').innerHTML;
    let playerId = dragged.id;

    if (fromZone === 'scratched') {  return;   }

    if (fromZone === 'roster-container') {

        // Find the container the player was dragged out from
        const rosterContainer = dragged.parentElement;  // Assuming dragged was inside a roster-container

        if (rosterContainer) {
           // rosterContainer.style.border = "1px solid black";
            rosterContainer.setAttribute('draggable', false);
            rosterContainer.innerHTML = "<div class=\"card roster-container\"><div class=\"card-body \"><p class=\"card-text\">" + playerId + "</p></div></div>";
           // rosterContainer.style.padding = "10px";
        }
    } else {
        if (dragged) {
            dragged.remove();
        }
    }


    let scratchDiv = createDiv()
        .parent('Scratched')
        .addClass('card Scratched rosterElm draggable scratch p-0 ')
        .elt;
    scratchDiv.innerHTML = "<div class=\"card-body p-0 \"><p class=\"card-text\">" + playerName + "</p></div>";
    scratchDiv.setAttribute('draggable', true);
    scratchDiv.id = playerId;


    scratchDiv.addEventListener('touchstart', handleTouchStart);
    scratchDiv.addEventListener('touchmove', handleTouchMove);
}


// Mobile touch handlers
let activeDraggedElement = null;
let originalDropzone = null;
let originalPosition = { left: 0, top: 0 };
let lastHoveredElement = null;

function handleTouchStart(event) {
    event.preventDefault();
    let touch = event.touches[0];

    activeDraggedElement = event.currentTarget; // Get the element being dragged
    originalDropzone = getDropzone(activeDraggedElement); // Store the original dropzone

    activeDraggedElement.style.opacity = '0.4'; // Visual feedback
    //activeDraggedElement.style.position = 'absolute';
    activeDraggedElement.fromZone = "Roster"  //  TODO:  TEST!!!  comment trouvé le bon :S

    console.log("Touch:", activeDraggedElement, "from ", originalDropzone )
  

    // Store original position in case we need to revert it
    const rect = activeDraggedElement.getBoundingClientRect();
    originalPosition.left = rect.left;
    originalPosition.top = rect.top;

    // Correct the offset
    activeDraggedElement.touchStartX = touch.clientX - rect.left;
    activeDraggedElement.touchStartY = touch.clientY - rect.top;
}

function handleTouchMove(event) {
    event.preventDefault();
    let touch = event.touches[0];

   // console.log("Move:", activeDraggedElement)
    if (activeDraggedElement) {
        // Update the element's position during dragging
        activeDraggedElement.style.left = `${touch.clientX - activeDraggedElement.touchStartX}px`;
        activeDraggedElement.style.top = `${touch.clientY - activeDraggedElement.touchStartY}px`;
    }

    let element = document.elementFromPoint(touch.clientX, touch.clientY);


   // console.log(" over :", element)
    // Reset border of the previously hovered element if it's not the current one
    if (lastHoveredElement && lastHoveredElement !== element) {
        lastHoveredElement.style.border = ""; // Reset border to original
    }

    // Highlight the current hovered element if it's a valid dropzone
    if (getDropzone(element)) {
        element.style.border = "2px solid green";
        lastHoveredElement = element; // Update the last hovered element
    }
}

function handleTouchEnd(event) {
    event.preventDefault();

    console.log("endTouch", activeDraggedElement)
    if (activeDraggedElement) {
        let touch = event.changedTouches[0];
        let element = document.elementFromPoint(touch.clientX, touch.clientY);
        // Walk up the DOM tree to find a valid dropzone if the element is inside a p or similar
        while (element && !getDropzone(element)) {
            element = element.parentElement;
        }
        console.log('intended destination', element)

        let destination = getDropzone(element)
        if (destination) {    // If a valid dropzone is found
            if (destination === 'Roster') {
                console.log("Back to roster")
                handleTouchEndBackToRoster({ dragged: activeDraggedElement, currentTarget: element, fromZone: originalDropzone });
            } else if (destination === 'roster-container') {
                console.log("Back to Container")
                handleTouchEndOnContainer({ dragged: activeDraggedElement, currentTarget: element, fromZone: originalDropzone });
            } else if (destination === 'Scratched') {
                console.log("Back to Scratched")
                handleTouchEndToScratched({ dragged: activeDraggedElement, currentTarget: element, fromZone:originalDropzone });
            }
        } else {
            // If no valid dropzone is found, revert the element to its original position
            activeDraggedElement.style.left = `${originalPosition.left}px`;
            activeDraggedElement.style.top = `${originalPosition.top}px`;
        }

        console.log("endTouch", activeDraggedElement, "from",originalDropzone, "to", destination )

        // Reset the dragged element state
        activeDraggedElement.style.opacity = '1';
        activeDraggedElement.style.position = 'static'; // Reset position style
        activeDraggedElement = null;
        originalDropzone = null; // Clear the stored dropzone
    }
}


// Function to get the dropzone of an element
function getDropzone(element) {
    let dz = null
    if(element.classList.contains('Roster'))           dz = "Roster"
    if(element.classList.contains('roster-container')) dz = "roster-container"
    if(element.classList.contains('Scratched'))        dz = "Scratched"

    return dz;
}



function savePositions() {
    console.log(Roster);
}


function draw() {
    /* for p5.js compatibility */
}