<?php
/* >_ Developed by Vy Nghia */
class Database
{
	protected $dbhost;
	protected $dbuser;
	protected $dbpass;
	protected $dbname;
	
	public function dbhost($dbhost){
		$this->dbhost = $dbhost;
	}
	
	public function dbuser($dbuser){
		$this->dbuser = $dbuser;
	}
	
	public function dbpass($dbpass){
		$this->dbpass = $dbpass;
	}
	
	public function dbname($dbname){
		$this->dbname = $dbname;
	}
	
	public function connect(){
		$con = @mysql_connect($this->dbhost, $this->dbuser, $this->dbpass);
		@mysql_select_db($this->dbname, $con);
	}
	
	public function dbinfo($db){
		echo $this->$db;
	}
	
}

class Website
{
	/* GET DOWNLOAD FILE */
	public function getFileDownload($id) {
		global $datadownload;
		$query = mysql_query("SELECT * FROM `file` WHERE `id` = '$id'");
		$files = mysql_fetch_array($query);
		$datadownload = array("download" => "download?code=".$files['code']);
	}
	
	/* FORMAT FILE SIZE */
	function formatSizeUnits($bytes) {
        if ($bytes >= 1073741824)
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        elseif ($bytes >= 1048576)
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        elseif ($bytes >= 1024)
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        elseif ($bytes > 1)
            $bytes = $bytes . ' bytes';
        elseif ($bytes == 1)
            $bytes = $bytes . ' byte';
        else
            $bytes = '0 bytes';
		echo $bytes;
	}
	
	/* CODE DOWNLOAD */
	public function code($length) {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	/* FORAT TIME AGO */
	public function timeAgo($time_ago){
	  $cur_time 	= time();
	  $time_elapsed = $cur_time - $time_ago;
	  $seconds 		= $time_elapsed ;
	  $minutes 		= round($time_elapsed / 60 );
	  $hours 		= round($time_elapsed / 3600);
	  $days 		= round($time_elapsed / 86400 );
	  $weeks 		= round($time_elapsed / 604800);
	  $months 		= round($time_elapsed / 2600640 );
	  $years 		= round($time_elapsed / 31207680 );
	  // Seconds
	  if($seconds <= 60){
		return "$seconds giây trước";
	  }
	  //Minutes
	  else if($minutes <=60){
		if($minutes==1){
		  return "1 phút trước";
		}
		else{
		  return "$minutes phút trước";
		}
	  }
	  //Hours
	  else if($hours <=24){
		if($hours==1){
		  return "1 giờ trước";
		}else{
		  return "$hours giờ trước";
		}
	  }
	  //Days
	  else if($days <= 7){
		if($days==1){
		  return "hôm qua";
		}else{
		  return "$days ngày tước";
		}
	  }
	  //Weeks
	  else if($weeks <= 4.3){
		if($weeks==1){
		  return "1 tuần trước";
		}else{
		  return "$weeks tuần trước";
		}
	  }
	  //Months
	  else if($months <=12){
		if($months==1){
		  return "1 tháng trước";
		}else{
		  return "$months tháng trước";
		}
	  }
	  //Years
	  else{
		if($years==1){
		  return "1 năm trước";
		}else{
		  return "$years năm trước";
		}
	  }
	}
}

class Admin extends Website
{
	public $path;
	
	/* SET PATH CLOUD FILE */
	public function path($path){
		$this->path = $path;
	}
	
	/* HANGLING FILE & UPLAOD */
	public function upload($file){
		if (isset($_FILES)) {
			if(is_array($_FILES)) {
				if(is_uploaded_file($_FILES['file']['tmp_name'])) {
					$dataFiles = mysql_query("SHOW TABLE STATUS LIKE 'file'");
					$data = mysql_fetch_assoc($dataFiles);
					mkdir('cloud/files/'.$data['Auto_increment'], 0755, true);
					$sourcePath = $_FILES['file']['tmp_name'];
					$targetPath = $this->path.$data['Auto_increment']."/".$_FILES['file']['name'];
					if(move_uploaded_file($sourcePath,$targetPath)){
						mysql_query("INSERT INTO `file`(`id`, `file_name`, `file_name_download`, `file_type`, `code`, `time`) VALUES ('','{$_FILES['file']['name']}','{$_FILES['file']['name']}','{$_FILES['file']['type']}','".parent::code(20)."', '".date("Y-m-d H:i:s")."')");
						
						//RESULT ARRAY
						$content = array('status' => true, 'id' => $data['Auto_increment']);
					}
					else
						$content = array('status' => false, 'id' => null);
					echo json_encode($content);
				}
			}
		}
	}
	
	/* DELETE FILE */
	public function deleteFileID($id){
		if(isset($id)){
			/* DELETE FILE IN DATABASE */
			mysql_query("DELETE FROM `file` WHERE `id` = $id");
			
			/* DELETE FOLDER SAVE FILE */
			$deletePath = $this->path.$id;
			if (! is_dir($deletePath)) {
				throw new InvalidArgumentException("$deletePath must be a directory");
			}
			if (substr($deletePath, strlen($deletePath) - 1, 1) != '/') {
				$deletePath .= '/';
			}
			$files = glob($deletePath . '*', GLOB_MARK);
			foreach ($files as $file) {
				if (is_dir($file)) {
					self::deleteDir($file);
				} else {
					unlink($file);
				}
			}
			rmdir($deletePath);
			
			//REUSLT
			echo (true);
		} else
			echo (false);
	}
	
	/* CHECK ADMIN LOGIN */
	public function checkadmin($username, $password){
		global $status;
		$query = mysql_query("SELECT * FROM `admin` WHERE 1");
		$admin = mysql_fetch_array($query);
		
		if($admin['username'] == $username && $admin['password'] == $password)
			$status = true;
		else 
			$status = false;		
	}
}