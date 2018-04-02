<link type="text/css" rel="stylesheet" href="../webcss.css"/>

<?php
echo "
<!-- Trigger/Open The Modal -->
<button type='button' id='lockbtn'>Lock Changes</button>

<!-- The Modal -->
<div id='lockModal' class='modal'>

  <!-- Modal content -->
  <div class='modal-content'>
    <div class='modal-header'>
      <span class='lockclose'>&times;</span>
      <h2>Lock Changes</h2>
    </div>
    <div class='modal-body'>
    ";
    if ($lockchanges["Upper"] == 'update'){
      echo"<div class='update'>
        <h3>Where would you like to place the lock that was moved</h3>
        Coordinates:<input type='number' name='locknsMovedUpper' id='keylockinput' placeholder='Y Coordinate' min='$minns' max='$maxns'><input type='number' name='lockewMovedUpper' id='keylockinput' placeholder='X Coordinate' min='$minew' max='$maxew'>
      </div>";
    }
    if ($lockchanges["Upper"] == 'insert'){
      echo"<div class='insert'>
          <h3>Where would you like to place the lock that was inserted</h3>
          Coordinates:<input type='number' name='locknsPlacedUpper' id='keylockinput' placeholder='Y Coordinate' min='$minns' max='$maxns'><input type='number' name='lockewPlacedUpper' id='keylockinput' placeholder='X Coordinate' min='$minew' max='$maxew'>
      </div>";
  }
  if ($lockchanges["Left"] == 'update'){
      echo"<div class='update'>
        <h3>Where would you like to place the lock that was moved</h3>
        Coordinates:<input type='number' name='locknsMovedLeft' id='keylockinput' placeholder='Y Coordinate' min='$minns' max='$maxns'><input type='number' name='lockewMovedLeft' id='keylockinput' placeholder='X Coordinate' min='$minew' max='$maxew'>
      </div>";
    }
    if ($lockchanges["Left"] == 'insert'){
      echo"<div class='insert'>
          <h3>Where would you like to place the lock that was inserted</h3>
          Coordinates:<input type='number' name='locknsPlacedLeft' id='keylockinput' placeholder='Y Coordinate' min='$minns' max='$maxns'><input type='number' name='lockewPlacedLeft' id='keylockinput' placeholder='X Coordinate' min='$minew' max='$maxew'>
      </div>";
  }
  if ($lockchanges["Right"] == 'update'){
      echo"<div class='update'>
        <h3>Where would you like to place the lock that was moved</h3>
        Coordinates:<input type='number' name='locknsMovedRight' id='keylockinput' placeholder='Y Coordinate' min='$minns' max='$maxns'><input type='number' name='lockewMovedRight' id='keylockinput' placeholder='X Coordinate' min='$minew' max='$maxew'>
      </div>";
    }
    if ($lockchanges["Right"] == 'insert'){
      echo"<div class='insert'>
          <h3>Where would you like to place the lock that was inserted</h3>
          Coordinates:<input type='number' name='locknsPlacedRight' id='keylockinput' placeholder='Y Coordinate' min='$minns' max='$maxns'><input type='number' name='lockewPlacedRight' id='keylockinput' placeholder='X Coordinate' min='$minew' max='$maxew'>
      </div>";
  }
  if ($lockchanges["Lower"] == 'update'){
      echo"<div class='update'>
        <h3>Where would you like to place the lock that was moved</h3>
        Coordinates:<input type='number' name='locknsMovedLower' id='keylockinput' placeholder='Y Coordinate' min='$minns' max='$maxns'><input type='number' name='lockewMovedLower' id='keylockinput' placeholder='X Coordinate' min='$minew' max='$maxew'>
      </div>";
    }
    if ($lockchanges["Lower"] == 'insert'){
      echo"<div class='insert'>
          <h3>Where would you like to place the lock that was inserted</h3>
          Coordinates:<input type='number' name='locknsPlacedLower' id='keylockinput' placeholder='Y Coordinate' min='$minns' max='$maxns'><input type='number' name='lockewPlacedLower' id='keylockinput' placeholder='X Coordinate' min='$minew' max='$maxew'>
      </div>";
  }
  if ($lockchanges["Current"] == 'update'){
      echo"<div class='update'>
        <h3>Where would you like to place the lock that was moved</h3>
        Coordinates:<input type='number' name='locknsMovedCurrent' id='keylockinput' placeholder='Y Coordinate' min='$minns' max='$maxns'><input type='number' name='lockewMovedCurrent' id='keylockinput' placeholder='X Coordinate' min='$minew' max='$maxew'>
      </div>";
    }
    if ($lockchanges["Current"] == 'insert'){
      echo"<div class='insert'>
          <h3>Where would you like to place the lock that was inserted</h3>
          Coordinates:<input type='number' name='locknsPlacedCurrent' id='keylockinput' placeholder='Y Coordinate' min='$minns' max='$maxns'><input type='number' name='lockewPlacedCurrent' id='keylockinput' placeholder='X Coordinate' min='$minew' max='$maxew'>
      </div>";
  }
  if ($lockchanges["Upper"] == 'none' && $lockchanges["Left"] == 'none' && $lockchanges["Right"] == 'none' && $lockchanges["Lower"] == 'none' && $lockchanges["Current"] == 'none'){
    echo"<div class='error'>
          <p>No lock changes detected</p>
      </div>";
  }
?>
</div>
</div>
</div>
<script>
// Get the modal
var modal = document.getElementById('lockModal');

// Get the button that opens the modal
var btn = document.getElementById("lockbtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("lockclose")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>