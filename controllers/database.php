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

		$stmt = self::$con->prepare('SELECT `dirname`, `name` FROM `dirs` WHERE `hash`=?');
		$stmt->bind_param('s', $hash);
		$stmt->execute();
		$stmt->bind_result($dir, $name);
		$stmt->fetch();

		if (! $dir)
			return FALSE;

		return array('dir' => $dir, 'name' => $name);
	}

	/**
	 * get_download_link()
	 * @param filename
	 * returns the hashed download link to a file, or creates it if it doesn't exist
	 */
	public static function get_download_link($filename) {
		$stmt = self::$con->prepare('SELECT `hash` FROM `files` WHERE `location`=?');
		$stmt->bind_param('s', $filename);
		$stmt->execute();
		$stmt->bind_result($hash);
		$stmt->fetch();

		if (! $hash) {
			$stmt = self::$con->prepare('INSERT INTO `files` (`location`, `hash`) VALUES (?, ?)');
			$newhash = md5(App::$request.$filename);
			$stmt->bind_param('ss', $filename, $newhash);
			$stmt->execute();
			return '/get/'.$newhash;
		}

		return '/get/'.$hash;
	}

	/**
	 * get_dir_link()
	 * @param pagename
	 * returns the hashed link to a page for a specific directory
	 */
	public static function get_dir_link($pagename, $dirname) {
		$stmt = self::$con->prepare('SELECT `hash` FROM `dirs` WHERE `dirname`=?');
		$stmt->bind_param('s', $dirname);
		$stmt->execute();
		$stmt->bind_result($hash);
		$stmt->fetch();

		if (! $hash) {
			$hash = md5(rand().$dirname);
			$stmt = self::$con->prepare('INSERT INTO `dirs` (`name`, `dirname`, `hash`) VALUES (?, ?, ?)');
			$newhash = md5(App::$request.$filename);
			$stmt->bind_param('sss', $pagename, $dirname, $hash);
			$stmt->execute();
		}

		header('Location: /'.$hash);
	}

	/**
	 * serve_file()
	 * @param filehash
	 * downloads the requested file
	 */
	public static function serve_file($filehash) {
		$stmt = self::$con->prepare('SELECT `location` FROM `files` WHERE `hash`=?');
		$stmt->bind_param('s', $filehash);
		$stmt->execute();
		$stmt->bind_result($location);
		$stmt->fetch();

		if (! $location)
			App::abort(404, 'File not found.');

        $fsize = filesize($location);
        $path_parts = pathinfo($location);

        $fd = fopen ($location, "r");
        
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=".$path_parts['basename']."");
        header("Content-length: $fsize");
        header("Transfer-length: $fsize");
        header("Cache-control: private"); //use this to open files directly
        while(!feof($fd)) {
            $buffer = fread($fd, 2048);
            echo $buffer;
        }

        exit;
	}

}