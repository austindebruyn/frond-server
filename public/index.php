<?
	//error_reporting(0);
	foreach (glob('../controllers/*.php', GLOB_NOSORT) as $controller)
		include $controller;

	App::start();
	Database::start();

	$matches = array();
	preg_match('/^get\/(\w+)$/', App::$request, $matches);
	if (isset($matches[1])) {
		Database::serve_file($matches[1]);
	}

	$dir = Database::check_hash(App::$request);

	if (! $dir)
		App::abort(404, "That URL doesn't look valid to me!");

	Files::index($dir);
	View::serve('main', array('request'=>$dir));
?>
