<?
class View {

	/**
	 * view_filename()
	 * @param viewname
	 * returns the filename of the associated view
	 */
	private static function view_filename($viewname) {
		return App::views_path().$viewname.'.php';
	}

	/**
	 * serve()
	 * @param viewname
	 * @param data
	 * serve a document
	 */
	public static function serve($viewname, $data = array()) {
		$filename = self::view_filename($viewname);

		if (! file_exists($filename)) {
			App::abort(500, "View missing.");
			exit;
		}

		foreach($data as $key => $val) {
			$temp = $key;
			$$temp = $val;
		}

		include(self::view_filename('header'));
		include($filename);
		include(self::view_filename('footer'));
		exit;
	}

}