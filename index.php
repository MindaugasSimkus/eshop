<?php
//parsisiusti heidisql
date_default_timezone_set("Europe/Vilnius");
echo date("Y-m-d H:i:s");// 2017-07-05

session_start();

// Create connection
$conn = new mysqli("localhost", "root", "", "eshop");

// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "<br/>Connected successfully";


if (isset($_POST['message'])) {
	$sql = "INSERT INTO messages (body) VALUES ('" . $_POST['message'] . "')";
}

if (mysqli_query($conn, $sql)) {
	echo "New record";
} else {
	echo "Error" . $sql . "<br/>". mysqli_error($conn);
}

$sql = "SELECT * FROM messages";
$result = mysqli_query($conn, $sql);

$db_messages = [];


if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
       array_push($db_messages, $row);
    }
} else {
    echo "0 results";
}

mysqli_close($conn);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Recordbook</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  	<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Leave a record</h1>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<form action="" method="POST">
						<div class="form-group">
							<label for="message">Item
							</label>
							<textarea class="form-control" name="message" id="message" rows="1" placeholder="Describe yourself here..."> </textarea>
						</div>
					<button class="btn btn-success" type="submit" id="button_submit" name="button_submit">Add</button>
				</form>
			</div>
			<div class="col-sm-8">
					<h3>Record log:<br/></h3>
					<pre>
					<?php 

					foreach ($db_messages as $message) {
						echo  "<br/><div class='card'><div class='card-block'> [" . $message['id'] . "] <strong>" . $message['time'] . "</strong>: " . $message['body'] . "</div></div>";
					}

					?>
					</pre>
			</div>
		</div>
	</div>	
</body>
</html>