<?php
/**
 * This behavior manage a file associated to a model attribute of a CActiveRecord.
 * It will write an uploaded file after saving a model if one is provided,
 * and delete it after removing the model from db.
 * The file name will be calculated with attribute(s) of the model.
 * 
 * For an example, see example file.
 */
class FileARBehavior extends CActiveRecordBehavior {
	public $attributeForName; // this attribute (or array of attributes) will determine a part of the file name. default to primary key(s)
	public $attribute; // the attribute filled by a filefield on the form. must be set.
	public $extension; // possible extensions of the file name, comma separated.
	public $relativeWebRootFolder; // without the first and last /, the folder where to put the image relative to webroot. must be set.
	public $defaultName; // name of the default file if needed.
	public $prefix = ''; // file prefix
	
	private $_fileName;
	
	// override to init some things
	public function setEnabled($enable) {
		parent::setEnabled($enable);
		if (!$enable) return;
		if (empty($this->extension)) throw new CException('extension must be set.');
	}
	
	/**
	 * return the file path, or null if file does not exists.
	 */
	public function getFilePath() {
		$fs = $this->getExistingFilesName($this->getFolderPath(), $this->getFileName());
		return empty($fs) ? null : $fs[0];
	}
	
	/**
	 * get the file name without extension
	 */
	protected function getFileName() {
		if (!isset($this->_fileName)) {
			if (!isset($this->attributeForName)) $this->attributeForName = $this->owner->tableSchema->primaryKey;
			if (!is_array($this->attributeForName)) $partName = $this->owner->{$this->attributeForName};
			else {
				$partName = array();
				foreach ($this->$attributeForName as $attr) $partName[] = $this->owner->{$attr};
				$partName = join('_', $partName);
			}
			$this->_fileName = $this->prefix.$partName;
		}
		return $this->_fileName;
	}
	
	/**
	 * get the default file name without extension
	 */
	public function getDefaultFileName() {
		return $this->prefix.$this->defaultName;
	}
	
	/**
	 * get the path folder of the stored files
	 */
	protected function getFolderPath() {
		return Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$this->relativeWebRootFolder;
	}
	
	/*
	 * get existing files matching fname in path $path whith glob (and GLOB_BRACE).
	 */
	protected function getExistingFilesName($path, $fname) {
		return glob($path.DIRECTORY_SEPARATOR.$fname.'.{'.str_replace(' ', '', $this->extension).'}', GLOB_NOSORT | GLOB_BRACE);
	}
	
	// used by subclass
	protected function getFileUrlWithSuffix($suffix) {
		$path = $this->getFolderPath();
		$fs = $this->getExistingFilesName($path, $this->getFileName().$suffix);
		if (!empty($fs)) return Yii::app()->baseUrl.'/'.$this->relativeWebRootFolder.'/'.basename($fs[0]);
		if (!isset($this->defaultName)) return null;
		$fs = $this->getExistingFilesName($path, $this->getDefaultFileName().$suffix);
		if (!empty($fs)) return Yii::app()->baseUrl.'/'.$this->relativeWebRootFolder.'/'.basename($fs[0]);
		return null;
	}
	
	/**
	 * return a valid url to the file, or null if file or default file does not exist.
	 */
	public function getFileUrl() {
		return $this->getFileUrlWithSuffix('');
	}
	
	/**
	 * Save an uploaded file if given, after removing possible other files.
	 */
	public function afterSave($evt) {
		$file = CUploadedFile::getInstance($this->owner, $this->attribute);
		if ($file && strpos($this->extension, $file->extensionName) !== FALSE) {
			$path = $this->getFolderPath();
			$fname = $this->getFileName();
			$this->deleteFile($path, $fname);
			$this->saveFile($file, $path, $fname, '.'.$file->extensionName);
		}
	}
	
	protected function saveFile($file, $filePath, $fileName, $ext) {
		$file->saveAs($filePath.DIRECTORY_SEPARATOR.$fileName.$ext);
	}
	
	/**
	 * Delete the file on delete.
	 */
	public function afterDelete($evt) {
		$this->deleteFile($this->getFolderPath(), $this->getFileName());
	}
	
	/**
	 * Delete the files retrieved by getExistingFilesName
	 */
	protected function deleteFile($path, $fname) {
		$fs = $this->getExistingFilesName($path, $fname);
		foreach ($fs as $f) unlink($f);
	}
}