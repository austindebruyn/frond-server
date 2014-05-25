<?php

class File {

	/**
	 * formatBytes
	 * @param size an int, number of bytes
	 * @param precision number of decimal places
	 * returns a formatted string ie. 8192 returns 8k
	 */
	public static function formatBytes($size, $precision = 2) {
		if ($size < 1) return '???';
	    $base = log($size, 1024);
	    $suffixes = array('b', 'kb', 'Mb', 'Gb', 'Tb');
	    $i = floor($base);

	    return round(pow(1024, $base - floor($base)), $precision).$suffixes[$i];
	}

	public $filename;
	public $name;
	public $filesize;
	public $download_link;

	public function __construct($filename) {

		if (!file_exists($filename)) {
			App::abort(500, 'File object created on non-existent file');
		}

		$this->filename = $filename;
		$this->name     = basename($filename);
		$this->filesize = File::formatBytes(filesize($filename));

		$this->download_link = Database::get_download_link($filename);
	}
}

class Files {
	
	/**
	 * index()
	 * @param input, array containing name, dir
	 * GET request for the index of a particular directory
	 */
	public static function index($input) {
		$name = $input['name'];
		$dir = $input['dir'];

		$filesList = array();

		foreach (glob(App::files_path().$dir.'/*', GLOB_NOSORT) as $fname)
			array_push($filesList, new File($fname));


		$data = array(
			'name' => $name,
			'filesList' => $filesList
			);
		View::serve('dir', $data);
	}


}