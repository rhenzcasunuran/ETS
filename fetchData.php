<?php
// Retrieve the selected option from the AJAX request
$selectedOption = $_POST['option'];

// Perform necessary database operations here to fetch data based on the selected option
// Replace the code below with your actual database retrieval logic

// Example database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ets";

// Create a new PDO instance
$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// Prepare a SQL statement to fetch data based on the selected option
$stmt = $pdo->prepare("SELECT category_name FROM ongoing_list_of_event WHERE option = :option");
$stmt->bindValue(':option', $selectedOption);
$stmt->execute();

// Fetch the data from the result
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
  // Return the retrieved data to the JavaScript function
  echo $result['category_name'];
} else {
  // Handle the case when no data is found for the selected option
  echo "No data found for the selected option.";
}

?>