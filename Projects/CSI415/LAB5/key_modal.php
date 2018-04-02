<link type="text/css" rel="stylesheet" href="../webcss.css"/>

<?php
echo "
<!-- Trigger/Open The Modal -->
<button type='button' id='keyBtn'>Key Changes</button>

<!-- The Modal -->
<div id='keyModal' class='modal'>

  <!-- Modal content -->
  <div class='modal-content'>
    <div class='modal-header'>
      <span class='keyclose'>&times;</span>
      <h2>Key Changes</h2>
    </div>
    <div class='modal-body'>
    ";
    if ($keychanges["Upper"] == 'update'){
    	echo"<div class='update'>
    		<h3>Where would you like to place the key that was moved</h3>
    		Coordinates:<input type='number' name='keynsMovedUpper' id='keylockinput' placeholder='Y Coordinate' min='$minns' max='$maxns'><input type='number' name='keyewMovedUpper' id='keylockinput' placeholder='X Coordinate' min='$minew' max='$maxew'>
	    </div>";
    }
    if ($keychanges["Upper"] == 'insert'){
	    echo"<div class='insert'>
	        <h3>Where would you like to place the key that was inserted</h3>
	        Coordinates:<input type='number' name='keynsPlacedUpper' id='keylockinput' placeholder='Y Coordinate' min='$minns' max='$maxns'><input type='number' name='keyewPlacedUpper' id='keylockinput' placeholder='X Coordinate' min='$minew' max='$maxew'>
	    </div>";
	}
	if ($keychanges["Left"] == 'update'){
    	echo"<div class='update'>
    		<h3>Where would you like to place the key that was moved</h3>
    		Coordinates:<input type='number' name='keynsMovedLeft' id='keylockinput' placeholder='Y Coordinate' min='$minns' max='$maxns'><input type='number' name='keyewMovedLeft' id='keylockinput' placeholder='X Coordinate' min='$minew' max='$maxew'>
	    </div>";
    }
    if ($keychanges["Left"] == 'insert'){
	    echo"<div class='insert'>
	        <h3>Where would you like to place the key that was inserted</h3>
	        Coordinates:<input type='number' name='keynsPlacedLeft' id='keylockinput' placeholder='Y Coordinate' min='$minns' max='$maxns'><input type='number' name='keyewPlacedLeft' id='keylockinput' placeholder='X Coordinate' min='$minew' max='$maxew'>
	    </div>";
	}
	if ($keychanges["Right"] == 'update'){
    	echo"<div class='update'>
    		<h3>Where would you like to place the key that was moved</h3>
    		Coordinates:<input type='number' name='keynsMovedRight' id='keylockinput' placeholder='Y Coordinate' min='$minns' max='$maxns'><input type='number' name='keyewMovedRight' id='keylockinput' placeholder='X Coordinate' min='$minew' max='$maxew'>
	    </div>";
    }
    if ($keychanges["Right"] == 'insert'){
	    echo"<div class='insert'>
	        <h3>Where would you like to place the key that was inserted</h3>
	        Coordinates:<input type='number' name='keynsPlacedRight' id='keylockinput' placeholder='Y Coordinate' min='$minns' max='$maxns'><input type='number' name='keyewPlacedRight' id='keylockinput' placeholder='X Coordinate' min='$minew' max='$maxew'>
	    </div>";
	}
	if ($keychanges["Lower"] == 'update'){
    	echo"<div class='update'>
    		<h3>Where would you like to place the key that was moved</h3>
    		Coordinates:<input type='number' name='keynsMovedLower' id='keylockinput' placeholder='Y Coordinate' min='$minns' max='$maxns'><input type='number' name='keyewMovedLower' id='keylockinput' placeholder='X Coordinate' min='$minew' max='$maxew'>
	    </div>";
    }
    if ($keychanges["Lower"] == 'insert'){
	    echo"<div class='insert'>
	        <h3>Where would you like to place the key that was inserted</h3>
	        Coordinates:<input type='number' name='keynsPlacedLower' id='keylockinput' placeholder='Y Coordinate' min='$minns' max='$maxns'><input type='number' name='keyewPlacedLower' id='keylockinput' placeholder='X Coordinate' min='$minew' max='$maxew'>
	    </div>";
	}
	if ($keychanges["Current"] == 'update'){
    	echo"<div class='update'>
    		<h3>Where would you like to place the key that was moved</h3>
    		Coordinates:<input type='number' name='keynsMovedCurrent' id='keylockinput' placeholder='Y Coordinate' min='$minns' max='$maxns'><input type='number' name='keyewMovedCurrent' id='keylockinput' placeholder='X Coordinate' min='$minew' max='$maxew'>
	    </div>";
    }
    if ($keychanges["Current"] == 'insert'){
	    echo"<div class='insert'>
	        <h3>Where would you like to place the key that was inserted</h3>
	        Coordinates:<input type='number' name='keynsPlacedCurrent' id='keylockinput' placeholder='Y Coordinate' min='$minns' max='$maxns'><input type='number' name='keyewPlacedCurrent' id='keylockinput' placeholder='X Coordinate' min='$minew' max='$maxew'>
	    </div>";
	}
	if ($keychanges["Upper"] == 'none' && $keychanges["Left"] == 'none' && $keychanges["Right"] == 'none' && $keychanges["Lower"] == 'none' && $keychanges["Current"] == 'none'){
		echo"<div class='error'>
	        <p>No key lock changes detected</p>
	    </div>";
	}
?>
</div>
</div>
</div>
<script>
// Get the modal
var keymodal = document.getElementById('keyModal');

// Get the button that opens the modal
var keybtn = document.getElementById("keyBtn");

// Get the <span> element that closes the modal
var keyspan = document.getElementsByClassName("keyclose")[0];

// When the user clicks the button, open the modal
keybtn.onclick = function() {
    keymodal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
keyspan.onclick = function() {
    keymodal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it

</script>