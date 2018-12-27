<?php

class ImageUpload {

	private $file_name ;
	private $file_type ;
	private $fileDir ;
	private $tmp_name;
	private $file_size;

	protected $errors;

	function __construct($file_dir, $tmp_name, $file_size, $file_name) {
		$this->file_dir = $file_dir;
		$this->tmp_name = $tmp_name;
		$this->file_size = $file_size;
		$this->file_name = $this->file_dir . $file_name;
		$this->file_type = strtolower(pathinfo($this->file_name, PATHINFO_EXTENSION));
	}

	public function isActual(){
		return getimagesize($this->tmp_name);
	}

	public function exists(){
		return file_exists($this->file_name);
	}

	public function checkSize(){
		return $this->file_size <= 500000;
	}

	public function isImage() {
		return in_array($this->file_type, ['jpg','png','jpeg','gif']);
	}

	public function moveUploadedImage(){
		return move_uploaded_file($this->tmp_name, $this->file_name);
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