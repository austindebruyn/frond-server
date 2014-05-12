<?
	//error_reporting(0);

	foreach (glob('../controllers/*.php', GLOB_NOSORT) as $controller)
		include $controller;

	$app = new App;
	$db = new Database;

	$app->start();
	$db->start();


?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Frond Server</title>
		<meta name='description' content='Simple PHP file servers to deliver masters.'>
	</head>

	<body>
		<h1>Frond Server Online</h1>
		<p><?php echo 'Request: '.App::$request; ?></p>
	</body>
</html>