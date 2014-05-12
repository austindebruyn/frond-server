<?

class View {


	/**
	 * serve()
	 * serve a document
	 */
	public static function serve($viewname) {
		$filename = App::views_path().$viewname.'.php';

		if (! file_exists($filename)) {
			App::abort(500, "View missing.");
			exit;
		}

		exit;
	}

}