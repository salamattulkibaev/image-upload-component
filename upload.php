<?php

include 'file/ImageUpload.php';

function dd($var){
	echo "<pre>";
	print_r($var);
	echo "</pre>";
	die ;
}

if ($_POST['submit'] && $_FILES) {
	$obj = new ImageUpload($_FILES['fileUpload'], 'images/');
	if ($obj->uploadImage())
		header('Location: /index.php');
	else
		echo $obj->getErrors();
} else
	dd($_FILES['fileUpload']);