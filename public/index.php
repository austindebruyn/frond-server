<?
	//error_reporting(0);
	foreach (glob('../controllers/*.php', GLOB_NOSORT) as $controller)
		include $controller;

	App::start();
	Database::start();

	$dir = Database::check_hash(App::$request);

	if (! $dir)
		App::abort(404, "That URL doesn't look valid to me!");

	View::serve('main', array('request'=>$dir));
?>
