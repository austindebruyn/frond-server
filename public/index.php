<?
	$request = substr($_SERVER['REQUEST_URI'],1);


?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Frond Server</title>
		<meta name='description' content='Simple PHP file servers to deliver masters.'>
	</head>

	<body>
		<h1>Frond Server Online</h1>
		<p><?php echo $request; ?></p>
	</body>
</html>