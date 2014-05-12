<?
class View {


	/**
	 * serve()
	 * @param viewname
	 * @param data
	 * serve a document
	 */
	public static function serve($viewname, $data = array()) {
		$filename = App::views_path().$viewname.'.php';

		if (! file_exists($filename)) {
			App::abort(500, "View missing.");
			exit;
		}

		foreach($data as $key => $val) {
			$temp = $key;
			$$temp = $val;
		}

		include($filename);
		exit;
	}

}