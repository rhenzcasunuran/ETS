<?php
include("database_connect.php");
include("TOU-fetch-data.php");
?>
<select name="team_name">
   <option>Select Course</option>
  <?php 
  foreach ($options as $option) {
  ?>
    <option><?php echo $option['team_name']; ?> </option>
    <?php 
    }
   ?>
</select>