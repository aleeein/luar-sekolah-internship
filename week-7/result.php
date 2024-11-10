<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$fullName = $_POST['fullName'];
	$gender = $_POST['gender'];
	$dob = $_POST['dob'];
	$address = $_POST['address'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$hobbies = $_POST['hobbies'];

	// Handle file upload
	$photo = $_FILES['photo'];
	$photoName = basename($photo['name']);
	$uploadDir = "images/";
	$uploadFile = $uploadDir . $photoName;

	// Move the uploaded file to the images folder
	if (move_uploaded_file($photo['tmp_name'], $uploadFile)) {
		$photoURL = $uploadFile;
	} else {
		$photoURL = "images/default.jpg"; // Fallback if upload fails
	}

	// Determine card style based on gender
	if ($gender == 'male') {
		$bgColor = 'blue';
		$fontColor = 'black';
	} else {
		$bgColor = 'red';
		$fontColor = 'white';
	}
} else {
	header("Location: register.php");
	exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registration Card</title>
	<link rel="stylesheet" href="css/styles.css">
	<style>
		.card {
			background-color: <?php echo $bgColor; ?>;
			color: <?php echo $fontColor; ?>;
			padding: 20px;
			border-radius: 10px;
			max-width: 400px;
			margin: 0 auto;
			text-align: center;
		}

		.card img {
			width: 100px;
			height: 100px;
			border-radius: 50%;
		}
	</style>
</head>

<body>

	<div class="card">
		<h2><?php echo $fullName; ?></h2>
		<img src="<?php echo $photoURL; ?>" alt="User Photo">
		<p>Gender: <?php echo ucfirst($gender); ?></p>
		<p>Date of Birth: <?php echo $dob; ?></p>
		<p>Address: <?php echo $address; ?></p>
		<p>Email: <?php echo $email; ?></p>
		<p>Phone: <?php echo $phone; ?></p>
		<p>Hobbies: <?php echo $hobbies; ?></p>
	</div>

</body>

</html>