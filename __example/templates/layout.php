<!doctype html>
<html lang="<?=$lang?>">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?=$title?></title>
		<link rel="shortcut icon" type="image/x-icon" href="<?=$icon?>">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
	<!--<link rel="stylesheet" href="/svratenkov/scssweb/app/public/assets/css/style.css">-->
	
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	</head>

	<body>
		<header>
			<?=$header;?>
		</header>

		<section>
			<?=$content;?>
		</section>

		<footer>
			<?=$footer;?>
		</footer>
	</body>
</html>
