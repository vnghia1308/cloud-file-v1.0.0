<?php
/* >_ Developed by Vy Nghia */
require 'server/config.php';
error_reporting(0);

if(isset($_GET['code'])){
	$query = mysql_query("SELECT * FROM `file` WHERE `code` = '{$_GET['code']}'");
	$files = mysql_fetch_array($query);
	if(mysql_num_rows($query) > 0){
		$file = 'server/'.__PATH__.$files['id'].'/'.$files['file_name'];
		if(!$file){ // file does not exist
			die('Tệp đã bị xóa khỏi server!');
		} else {
			header("Cache-Control: public");
			header("Content-Description: File Transfer");
			header("Content-Disposition: attachment; filename=".$files['file_name_download']);
			header("Content-Type: application/zip");
			header("Content-Transfer-Encoding: binary");

			// read the file from disk
			readfile($file);
			
			/* RESET CODE */
			$web = new Website;
			mysql_query("UPDATE `file` SET `code` = '".$web->code(20)."' WHERE `id` = '{$files['id']}'");
		}
	} else 
		echo 'Không tìm thấy file!';
}