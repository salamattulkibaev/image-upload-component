<?php
$filename = isset($_GET['filename']) ? $_GET['filename'] : '';
if ($filename && unlink($filename)) {
	header('Location: /index.php');
} else {
	echo "Some error";
}