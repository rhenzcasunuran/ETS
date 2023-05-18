<?php
 @include("connections.php");

    if(isset($_POST['update_score_data'])) {

        $id = $_POST['score_id'];

        $scoring_team_a = $_POST['scoring_team_a'];

        $query = "UPDATE scores SET scoring_team_a='$scoring_team_a' WHERE id='$id";

        $query_run = mysqli_query($conn, $query);

    if($query_run){
        $_SESSION['status'] = "Not Updated";
        header("Location: LiveScoringAdmin.php");
    }
    else 
    {
        $_SESSION['status'] = "Not Updated";
        header("Location: LiveScoringAdmin.php");
    }
    
    }

    

?>
