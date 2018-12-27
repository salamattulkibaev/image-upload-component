<?php

include 'file/ImageUpload.php';

function dd($var){
	echo "<pre>";
	print_r($var);
	echo "</pre>";
	die ;
}

if ($_POST['submit'] && $_FILES) {
	$fileData = $_FILES['fileUpload'];
	$obj = new ImageUpload('images/', $fileData['tmp_name'], $fileData['size'], $fileData['name']);
	if ($obj->uploadImage())
		header('Location: /index.php');
	else
		echo $obj->getErrors();
} else
	dd($_FILES['fileUpload']);