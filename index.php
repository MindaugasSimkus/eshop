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


if (isset($_POST['email']) && isset($_POST['product']) && isset($_POST['brand']) && isset($_POST['price']) && isset($_POST['weigth']) && isset($_POST['description'])) {
	$product_sql = "INSERT INTO products (email, product, brand, price, weigth, description) VALUES ('" . $_POST['email'] . "', '" . $_POST['product'] . "', '" . $_POST['brand'] . "', '" . $_POST['price'] . "', '" . $_POST['weigth'] . "', '" . $_POST['description'] . "')";
}

if (mysqli_query($conn, $product_sql)) {
	echo "Product added";
} else {
	echo "Error" . $product_sql . "<br/>". mysqli_error($conn);
} 


$product_table = "SELECT * FROM products";
$result = mysqli_query($conn, $product_table);

$from_db_products = [];


if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
       array_push($from_db_products, $row);
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
							<label for="email">Email</label>
							<textarea class="form-control" name="email" id="email" rows="1" placeholder="Describe yourself here..."> </textarea>
							<label for="product">Product</label>
							<textarea class="form-control" name="product" id="product" rows="1" placeholder="Describe yourself here..."> </textarea>
							<label for="brand">Brand</label>
							<textarea class="form-control" name="brand" id="brand" rows="1" placeholder="Describe yourself here..."> </textarea>
							<label for="price">Price</label>
							<textarea class="form-control" name="price" id="price" rows="1" placeholder="Describe yourself here..."> </textarea>
							<label for="weigth">Weigth</label>
							<textarea class="form-control" name="weigth" id="weigth" rows="1" placeholder="Describe yourself here..."> </textarea>
							<label for="description">Description</label>
							<textarea class="form-control" name="description" id="description" rows="1" placeholder="Describe yourself here..."> </textarea>
						</div>
					<button class="btn btn-success" type="submit" id="button_submit" name="button_submit">Add</button>
				</form>
			</div>
			<div class="col-sm-8">
					<h3>Product table:<br/></h3>
					<?php 
					echo "<table><tr><th>No.</th><th>Time</th><th>Email</th><th>Product</th><th>Brand</th><th>Price</th><th>Weigth</th><th>Description</th></tr><tr>";
					foreach ($from_db_products as $product_to_table) {
						echo  "<td>" . $product_to_table['id'] . "</td><td>" . $product_to_table['date'] . "</td><td>" . $product_to_table['email'] . "</td><td>" . $product_to_table['product'] . "</td><td>" . $product_to_table['brand'] . "</td><td>" . $product_to_table['price'] . "</td><td>" . $product_to_table['weigth'] . "</td><td>" . $product_to_table['description'] . "</td>";
					}
					echo "</tr></table>";

					print_r($_POST);
					print_r($from_db_products);

					?>
			</div>
		</div>
	</div>	
</body>
</html>