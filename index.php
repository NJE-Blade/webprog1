<?php
	
	require_once("includes/config.php");
	require_once("includes/controller.php");
	require_once("includes/model.php");

	$app = new Controller();
	$db = new Model();
	$currentPage = $app->getUrlParts()[0];
	$publicMenuItems = $db->getPublicMenu();

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <!-- Az oldal jelenlegi "valos" url-je:
    https://cheerful-paprenjak-1285e6.netlify.app/ 
    -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaszilij-EDC</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Rajdhani:wght@300;400;500;600;700&family=Crimson+Text:ital,wght@0,400;0,600;1,400;1,600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/main.css">
</head>
<body class="d-flex flex-column min-vh-100 <?php if($currentPage == "secret") {echo "body_secret"; } ?>" data-bs-theme="dark">
	<?php include("pages/nav.php"); ?>

	<main class="flex-fill">
    <div class="container">
		<?php 
			
			switch ($currentPage) {
				case "cikkek":
					include("pages/articles.php");
					break;
				case "kapcsolat":
					include("pages/connect.php");
					break;
				case "secret":
					include("pages/secret.php");
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
	<script src="<?php echo BASE_URL; ?>assets/script.js"></script>
	
</body>
</html>