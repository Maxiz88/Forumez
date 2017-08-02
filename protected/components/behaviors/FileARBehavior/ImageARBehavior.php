<?php

Yii::import('ext.image.Image');

/**
 * This behavior extends FileARBehavior to manage an image file.
 * This can create multiple images from the originale one by processing them with resize, crop, sharpen ... (see $IMG_FUNCS for the list)
 * A processing array is created like this:
 * 	'resize' => array([parameters of resize]),
 *  'crop' => array([parameters of crop]),
 *  ...
 * see the extension image of Yii (original code from Kohana Team) to know more about the parameters.
 * 
 * For an example of how to use this class, see the example file.
 */
class ImageARBehavior extends FileARBehavior {
	/**
	 * key => value which list all the desired formats. can be null (the 'normal' => _normalFormat is used then)
	 * example:
	 * 'thumb' => array(
	 *   'suffix' => '_thumb',
	 *   'process' => array('resize' => array(60, 60))
	 * )
	 */
	public $formats = array();
	
	// normal image
	protected static $_normalFormat = array('suffix' => '', 'process' => array());
	
	// functions that can be used on an image, ordered.
	protected static $IMG_FUNCS = array('resize', 'crop', 'sharpen', 'quality', 'rotate', 'flip');
	
	// used for some init
	public function setEnabled($enable) {
		parent::setEnabled($enable);
		if (!$enable) return;
		// set the normal format
		if (array_key_exists('normal', $this->formats)) $this->formats['normal'] = array_merge(self::$_normalFormat, $this->formats['normal']);
		else $this->formats['normal'] = self::$_normalFormat;
		// set suffixes if not defined
		foreach ($this->formats as $name => $f) {
			if (! array_key_exists('suffix', $f)) $f['suffix'] = $name;
		}
	}
	
	/**
	 * return an array with entries like format => file_path when file_path exists
	 */
	public function getFilePath() {
		$path = $this->getFolderPath();
		$fname = $this->getFileName();
		$fs = $this->getAnyExistingFilesName($path, $fname);
		$len = strlen($path) + strlen($fname) + 1;
		$res = array();
		foreach ($fs as $f) {
			foreach ($this->formats as $foName => $fo) {
				$s = $fo['suffix'];
				if (empty($s) || strpos($f, $s, $len)) $res[$foName] = $f;
			}
		}
		return $res;
	}
	
	protected function getAnyExistingFilesName($path, $fname) {
		$suffixes = array();
		foreach ($this->formats as $f) {
			$s = $f['suffix'];
			if (!empty($f)) $suffixes[] = $s;
		}
		return $this->getExistingFilesName($path, $fname.'{'.join(',', $suffixes).'}');
	}
	
	/**
	 * Retrieve url for a given format. see FileARBehavior::getFileUrl. 
	 */
	public function getFileUrl($format = 'normal') {
		return $this->getFileUrlWithSuffix($this->formats[$format]['suffix']);
	}
	
	/**
	 * apply some processing (listed in $options) to $img
	 */
	protected function processImage($img, $options) {
		foreach (self::$IMG_FUNCS as $f)
			if (array_key_exists($f, $options)) call_user_func_array( array($img, $f), $options[$f]);
	}
	
	protected function saveFile($file, $filePath, $fileName, $ext) {
		parent::saveFile($file, $filePath, $fileName, $ext); // move the file
		$path = $filePath.DIRECTORY_SEPARATOR.$fileName;
		// create a file for a format
		foreach ($this->formats as $f) {
			$img = new Image($path.$ext);
			if (!empty($f['process'])) $this->processImage($img, $f['process']);
			$img->save($path.$f['suffix'].$ext);
		}
	}
	
	protected function deleteFile($path, $fname) {
		$fs = $this->getAnyExistingFilesName($path, $fname);
		foreach ($fs as $f) unlink($f);
	}
}