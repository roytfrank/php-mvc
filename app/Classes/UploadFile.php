<?php declare (strict_types = 1);

namespace App\Classes;

class UploadFile {

	protected $filename;
	protected $file_size = 8742835;
	protected $file_extension;
	static $path;

	/**
	 * set file name to save
	 * @param [type] $file [description]
	 * @param string $name [description]
	 */
	public function setFilename($file) {
		$part_name = pathinfo($file, PATHINFO_FILENAME);
		$hash = md5(microtime());
		$ext = $this->fileExtension($file);
		$this->filename = "{$part_name}-{$hash}-{$ext}";
	}

	/**
	 * get file name to save
	 * @return string
	 */
	public function getFilename() {
		return $this->filename;
	}

	/**
	 * get file extension to build save name
	 * @param $file
	 * @return string
	 */
	public function fileExtension($file) {
		return $this->file_extension = pathinfo($file, PATHINFO_EXTENSION);
	}

	/**
	 * checkfile size
	 * @param  $file
	 * @return mix
	 */
	public static function checkFilesize($file) {
		$obj = new static;
		return $file <= $obj->file_size ? true : false;
	}

	/**
	 * validate file extension
	 * @param string $file
	 * @return mix
	 */
	public static function validExtension($file) {
		$obj = new static;
		$ext = $obj->fileExtension($file);
		$validExtensions = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
		if (!in_array($ext, $validExtensions)) {
			return false;
		}
		return true;
	}

	/**
	 * file path
	 * @return [type] [description]
	 */
	public static function path() {
		return self::$path;
	}

	/**
	 * move uploade dfile
	 * @param  $tmp_path
	 * @param  $folder
	 * @param  $file
	 * @return object
	 */
	public static function move($tmp_name, $folder, $file) {
		try {
			$obj = new static;
			$obj->setFilename($file);
			$file_name = $obj->getFilename();
			if (!is_dir($folder)) {
				mkdir($folder, 0777, true);
			}
			$ds = DIRECTORY_SEPARATOR;
			self::$path = "{$folder}{$ds}{$file_name}";
			$absolute_path = BASE_PATH . "{$ds}public{$ds}" . self::$path . "";
			if (move_uploaded_file($tmp_name, $absolute_path)) {
				return $obj; //return file obj for method chaining
			}
		} catch (\Exception $ex) {
			throw new \Exception("Moving upload file " . $ex->getMessage());
		}
	}
}
