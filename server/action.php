<?php
/* >_ Developed by Vy Nghia */
require 'config.php';
session_start();
error_reporting(0);
switch($_GET['do']){
	case 'logout':
		if(isset($_SESSION['admin'])){
			if($_GET['type'] == 'admin')
				unset($_SESSION['admin']);
		}
		if(isset($_SERVER[ 'HTTP_REFERER' ]))
			header("Location: " . $_SERVER[ 'HTTP_REFERER' ]);
		else 
			header("Location: /");
		break;
	/* UPLOAD FILE */
	case 'upload':
		if(isset($_SESSION['admin'])){
			$admin = new Admin;
			$admin->path(__PATH__);
			$admin->upload($_FILE['file']);
		}
		break;
	case 'rename':
		if(isset($_SESSION['admin']) && isset($_POST['name']) && isset($_GET['id'])){
			mysql_query("UPDATE `file` SET `file_name_download`='{$_POST['name']}' WHERE `id`={$_GET['id']}");
			
			echo (true);
		}
		break;
	/* DELETE FILE */
	case 'delete':
		if(isset($_SESSION['admin'])){
			$admin = new Admin;
			$admin->path(__PATH__);
			$admin->deleteFileID($_POST['id']);
		}
		break;
	/* GET FILE DOWNLOAD */
	case 'download':
		$web = new Website;
		$web->getFileDownload($_GET['id']);
		
		echo json_encode($datadownload);
		break;
	/* CHANGE ADMIN PASSWORD */
	case 'change':
		if(isset($_SESSION['admin']) && $_POST['password']){
			if($_GET['type'] == 'admin')
				mysql_query("UPDATE `admin` SET `password` = '{$_POST['password']}' WHERE 1");
			unset($_SESSION['admin']);
			echo (true);
		}
		break;
	/* INSTALL DATA SERVER */
	case 'install':
		if(isset($_SESSION['install'])){
			if($_GET['type'] == 'mysql')
				include ('lib/data/mysql/install/database.install.php');
		}
		break;
}
