<?
class App {

	private static $DEFAULT_APP_ERR = "An unknown error has occured.";

	public static $request;
	public static $env;

	/**
	 * abort()
	 * @param error_code
	 * @param error_string
	 * aborts the app immediately
	 */
	public static function abort($error_code = 500, $error_string) {
		$title = "Error ".$error_code;
		$content = $error_string ? $error_string : self::$DEFAULT_APP_ERR;

		$data = array('title' => $title, 'content' => $content);

		View::serve('abort', $data);
	}

	/**
	 * start()
	 * boots the app
	 */
	public static function start() {
		self::$request = substr($_SERVER['REQUEST_URI'],1);
		self::$env     = "local";
	}

	/**
	 * secure_path()
	 * returns the location of the secure credentials directory
	 */
	public static function secure_path() {
		return '../secure/';
	}

	/**
	 * public_path()
	 * returns the location of the public directory
	 */
	public static function public_path() {
		return '../public/';
	}

	/**
	 * views_path()
	 * returns the location of the views directory
	 */
	public static function views_path() {
		return '../views/';
	}

	/**
	 * install_path()
	 * returns the location of the install directory
	 */
	public static function install_path() {
		return '../install/';
	}

}