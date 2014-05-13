<?
	error_reporting(0);

	// Locate MVC structure
	foreach (glob('../controllers/*.php', GLOB_NOSORT) as $controller)
		include $controller;

	// Boot up the app
	App::start();
	Database::start();

	// Route the URL
	$matches = array();

	//------------------------------------
	// frond.com/activate
	//
	if (App::$request == 'activate' && $_SERVER['REQUEST_METHOD'] == 'GET') {
		View::serve('activate');
	}

	if (App::$request == 'activate' && $_SERVER['REQUEST_METHOD'] == 'POST') {
		$pagename = $_POST['pagename'];
		$dirname = $_POST['dirname'];
		die(Database::get_dir_link($pagename, $dirname));
	}

	if (App::$request == 'activate/noscript' && $_SERVER['REQUEST_METHOD'] == 'POST') {
		if (!isset($_POST['pagename']) || !isset($_POST['dirname']))
			App::abort(404);

		$pagename = $_POST['pagename'];
		$dirname = $_POST['dirname'];

		$hash = Database::get_dir_link($pagename, $dirname);
		if ($hash == -1)
			App::abort(404, "That directory doesn't exist in the files dir.");
		else
			header('Location: /'.$hash);
	}


	//------------------------------------
	// frond.com/get/*
	//
	preg_match('/^get\/(\w+)$/', App::$request, $matches);
	if (isset($matches[1]) && $_SERVER['REQUEST_METHOD'] == 'GET') {
		Database::serve_file($matches[1]);
	}

	//------------------------------------
	// frond.com/*
	//
	$dir = Database::check_hash(App::$request);
	if ($dir && $_SERVER['REQUEST_METHOD'] == 'GET')
		Files::index($dir);

	//------------------------------------
	// 404
	//
	App::abort(404, "That URL doesn't look valid to me!");
?>
