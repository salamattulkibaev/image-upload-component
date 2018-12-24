<?php

class ImageUpload {

	protected $filename ;
	protected $file_type ;
	protected $fileDir ;
	protected $tmp_name;
	protected $file_size;

	protected $errors;

	function __construct($fileData, $fileDir) {
		$this->fileDir = $fileDir;
		$this->tmp_name = $fileData['tmp_name'];
		$this->file_size = $fileData['size'];
		$this->filename = $this->fileDir . $fileData['name'];
		$this->file_type = strtolower(pathinfo($this->filename, PATHINFO_EXTENSION));
	}

	public function isActual(){
		return getimagesize($this->tmp_name);
	}

	public function exists(){
		return file_exists($this->filename);
	}

	public function checkSize(){
		return $this->file_size <= 500000;
	}

	public function isImage() {
		return in_array($this->file_type, ['jpg','png','jpeg','gif']);
	}

	public function moveUploadedImage(){
		return move_uploaded_file($this->tmp_name, $this->filename);
	}

	public function validateImage() {
		if (!$this->isImage()) {
			$this->setErrors('File is not image!');
		}

		if (!$this->checkSize()) {
			$this->setErrors('File is too large!');
		}

		if ($this->exists()) {
			$this->setErrors('File already exists!');
		}

		if (!$this->isActual()) {
			$this->setErrors('File is fake!');
		}

		if(!$this->errors) {
			return true ;
		} else {
			return false ;
		}
	}

	protected function setErrors($error){
		$this->errors .= $error .'<br>';
	}

	public function getErrors(){
		return $this->errors ; 
	}

	public function uploadImage() {
		
		if ($this->validateImage() && $this->moveUploadedImage()) {
			return true;
		} else {
			return false;
		}
	}
}