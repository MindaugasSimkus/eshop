<?php
//parsisiusti heidisql
date_default_timezone_set("Europe/Vilnius");
echo date("Y-m-d H:i:s");// 2017-07-05

session_start();

// Create connection
$conn = new mysqli("localhost", "MindaugasSimkus", "agrastaspower", "mindaugassimkus");

// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "<br/>Connected successfully";

$product_sql = '';

if (isset($_POST['email']) && isset($_POST['product']) && isset($_POST['brand']) && isset($_POST['price']) && isset($_POST['weigth']) && isset($_POST['description'])) {
	$product_sql = "INSERT INTO products (email, product, brand, price, weigth, description) VALUES ('" . $_POST['email'] . "', '" . $_POST['product'] . "', '" . $_POST['brand'] . "', '" . $_POST['price'] . "', '" . $_POST['weigth'] . "', '" . $_POST['description'] . "')";
}

$table_load_text = '';

if ($product_sql !== '') {
	if (mysqli_query($conn, $product_sql)) {
		$table_load_text = "<div class='alert alert-success'> Product added </div>";
	} else {
		$table_load_text = "<div class='alert alert-danger'> Error" . $product_sql . "</div><br/>". mysqli_error($conn);
	} 
} else {
	$table_load_text = "<div class='alert alert-success'> Table loaded successfully </div>";
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
mysqli_set_charset($conn, "utf8");

mysqli_close($conn);

?>
<!DOCTYPE html>
<html>
<head>
	<title>eShop</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  	<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  	<style>
  		table th {
  			text-align: center;
  		}
  	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12" style="background-color: lightblue; text-align: center; padding: 25px">
				<h1>Products of eShop</h1>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<br>
		</div>
		<div class="row">
			<div class="col-sm-4" style="background-color: lightyellow; padding: 5px">
				<h4>Product form</h4>
				<form action="" method="POST">
						<div class="form-group">
							<label for="email">Email</label>
							<textarea class="form-control" name="email" id="email" rows="1" placeholder="write your email"></textarea>
							<label for="product">Product</label>
							<textarea class="form-control" name="product" id="product" rows="1" placeholder="write a product name"></textarea>
							<label for="brand">Brand</label>
							<textarea class="form-control" name="brand" id="brand" rows="1" placeholder="write a product brand"></textarea>
							<label for="price">Price</label>
							<textarea class="form-control" name="price" id="price" rows="1" placeholder="write a product price"></textarea>
							<label for="weigth">Weigth</label>
							<textarea class="form-control" name="weigth" id="weigth" rows="1" placeholder="write a product weigth"></textarea>
							<label for="description">Description</label>
							<textarea class="form-control" name="description" id="description" rows="1" placeholder="write a product description"></textarea>
						</div>
					<button class="btn btn-success" type="submit" id="button_submit" name="button_submit">Add product</button>
				</form>
			</div>
			<div class="col-sm-8">
					<h3>Product table:<br/></h3>
					<?php 
					echo $table_load_text;
					echo "<table class='table text-center table-bordered table-hover'><thead class='thead-inverse'><tr><th>No.</th><th>Time</th><th>Email</th><th>Product</th><th>Brand</th><th>Price</th><th>Weigth</th><th>Description</th></tr></thead>";
					foreach ($from_db_products as $product_to_table) {
						echo  "<tr><td>" . $product_to_table['id'] . "</td><td>" . $product_to_table['date'] . "</td><td>" . $product_to_table['email'] . "</td><td>" . $product_to_table['product'] . "</td><td>" . $product_to_table['brand'] . "</td><td>" . $product_to_table['price'] . "</td><td>" . $product_to_table['weigth'] . "</td><td>" . $product_to_table['description'] . "</td></tr>";
					}
					echo "</table>";
					?>
			</div>
		</div>
	</div>	
</body>
</html>