<?php
	
	require_once("includes/controller.php");

	$app = new Controller($db);
	$currentPage = $app->getUrlParts()[0];

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $currentPage; ?></title>
	
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo BASE_URL; ?>assets/style.css" rel="stylesheet">
</head>
<body>
	<?php include("pages/nav.php"); ?>
	<main>
    <div class="container">
		<?php 
			switch ($currentPage) {
				case "cikkek":
					include("pages/articles.php");
					break;
				case "kapcsolat":
					include("pages/connect.php");
					break;
				default:
					include("pages/main.php");
					break;
			}
		
		?>
	</div>
	</main>
	
	<?php include("pages/footer.php"); ?>
	
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/dist/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo BASE_URL; ?>assets/script.js"></script>
	
</body>
</html>