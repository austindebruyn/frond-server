<!DOCTYPE HTML>
<html>
	<head>
		<title>Frond Server</title>
		<meta name='description' content='Simple PHP file servers to deliver masters.'>
	</head>

	<body>
		<h1>Files for <?php echo $name; ?></h1>
		<ul>
		<?foreach ($filesList as $file) { ?>
		<li><a href=<? echo '"'.$file->download_link.'"'; ?> > <? echo $file->name.$file->filesize; ?></a></li>
		<? } ?>
		</ul>
	</body>
</html>