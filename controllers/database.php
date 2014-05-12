<?
class Database {

	private static $creds = array();
	private static $stmt  = array();
	private static $con;

	/**
	 * read_creds()
	 * DATABASE CREDENTIALS
	 * The database login details are loaded from a file included in the secure dir.
	 * The secure dir is gitignore'd. The format for details is
	 * |host: <hostname>
	 * |user: <username>
	 * |pass: <password>
	 * |db: <database name>
	 * The vertical lines are not included in the file.
	 */
	private static function read_creds() {
		$scanner = file_get_contents(App::secure_path().App::$env);

		//Connect to the database
		$matches = array(array(), array(), array());
		preg_match('/host: (\S*)\n/', $scanner, $matches[0]);
		preg_match('/user: (\S*)\n/', $scanner, $matches[1]);
		preg_match('/pass: (\S*)(\n|$)/', $scanner, $matches[2]);
		preg_match('/db: (\S*)(\n|$)/', $scanner, $matches[3]);

		self::$creds['host'] = isset($matches[0][1]) ? $matches[0][1] : '';
		self::$creds['user'] = isset($matches[1][1]) ? $matches[1][1] : '';
		self::$creds['pass'] = isset($matches[2][1]) ? $matches[2][1] : '';
		self::$creds['db']   = isset($matches[3][1]) ? $matches[3][1] : '';
	}


	/**
	 * start()
	 * initializes the database
	 */
	public static function start() {

		self::read_creds();
		self::$con = new mysqli(self::$creds['host'],
						  self::$creds['user'],
						  self::$creds['pass'],
						  self::$creds['db']);

	}

	/**
	 * check_hash()
	 * @param hash
	 * checks a given hash to see if it corresponds to a table entry. returns the dirname or false
	 */
	public static function check_hash($hash) {
		$hash = substr($hash, 0, 32);

		$stmt = self::$con->prepare('SELECT `dirname` FROM `dirs` WHERE `hash`=?');
		$stmt->bind_param('s', $hash);
		$stmt->execute();
		$stmt->bind_result($dir);
		$stmt->fetch();


		return $dir;
	}

}