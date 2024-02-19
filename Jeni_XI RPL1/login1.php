<!DOCTYPE html>
<html>
<head>
	<title>Login Admin</title>	
</head>
<body>
	<h1>Jie Sweet Dessert🍪</h1>
	<h3>Login Admin</h3>
	<form action="login.php" method="post">		
		<table>
			<tr>
				<td>Username</td>
				<td><input type="text" name="username"></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="login" value="Log In"></td>
			</tr>
		</table>
	</form>
</body>
</html>



<a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?php echo $wishlist_num_rows; ?>)</span></a> 
            <?php

?>
               
$select_cart_count = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
$cart_num_rows = mysqli_num_rows($select_cart_count);

?>
<input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn">
<input type="submit" value="add to cart" name="add_to_cart" class="btn">

if(isset($_POST['add_to_wishlist'])){

$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];
$product_image = $_POST['product_image'];

$check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

$check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

if(mysqli_num_rows($check_wishlist_numbers) > 0){
	$message[] = 'already added to wishlist';
}elseif(mysqli_num_rows($check_cart_numbers) > 0){
	$message[] = 'already added to cart';
}else{
	mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
	$message[] = 'product added to wishlist';
}

}

if(isset($_POST['add_to_cart'])){

$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];
$product_image = $_POST['product_image'];
$product_quantity = $_POST['product_quantity'];

$check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

if(mysqli_num_rows($check_cart_numbers) > 0){
	$message[] = 'already added to cart';
}else{

	$check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

	if(mysqli_num_rows($check_wishlist_numbers) > 0){
		mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
	}

	mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
	$message[] = 'product added to cart';
}

}