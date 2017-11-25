<?php
/* >_ Developed by Vy Nghia */
require 'server/config.php';
session_start();

$web = new Website;
$query = mysql_query("SELECT * FROM `file` WHERE `id` = '{$_GET['id']}'");
$files = mysql_fetch_array($query);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dowload File</title>
<base href="<?php echo WEBURL ?>" />
<link href="assets/css/bootstrap3/bootstrap.css" rel="stylesheet">
<link href="assets/css/animate.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.4/sweetalert2.css" rel="stylesheet" type="text/css">
<style>
textarea {
     width: 100%;
	 height: 100px;
	 resize: none;
     -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
     -moz-box-sizing: border-box;    /* Firefox, other Gecko */
     box-sizing: border-box;         /* Opera/IE 8+ */
}
</style>
</head>
<body class="boxed-layout fixed-sidebar">
<div id="wrapper">
<nav class="navbar-default navbar-static-side" role="navigation">
<div class="sidebar-collapse">
<ul class="nav metismenu" id="side-menu">
<li class="nav-header">
<div class="dropdown profile-element">
<a data-toggle="dropdown" class="dropdown-toggle" href="#">
<span class="clear"> <span class="block m-t-xs"> Chào bạn</strong>
</span> </a>
</div>
</li>
<li class="active">
<a href="/"><i class="fa fa-home"></i> <span class="nav-label">Trang chủ</span></a>
</li>
<?php if(isset($_SESSION['admin'])): ?>
<li>
<a href="admin"><i class="fa fa-user-circle" aria-hidden="true"></i> <span class="nav-label">Trang quản trị viên</span></a>
</li>
<?php endif; ?>
</ul>
</div>
</nav> <div id="page-wrapper" class="gray-bg">
<div class="row border-bottom">
<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
<div class="navbar-header">
<a class="navbar-minimalize minimalize-styl-2 btn btn-primary "><i class="fa fa-bars"></i> </a>
</div>
</nav>
</div>
<div class="row wrapper border-bottom white-bg page-heading">
<div class="col-lg-10">
<h2>Tải xuống tệp tin</h2>
<ol class="breadcrumb">
<li>
<a href="/">Trang chủ</a>
</li>
<li class="active">
<strong>Tải xuống tệp tin</strong>
</li>
</ol>
</div>
<div class="col-lg-2">
</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">

<div class="ibox float-e-margins">
	<div class="ibox-title">
		<h5><?php echo (mysql_num_rows($query) == 0) ? 'Tệp tin không tồn tại' : 'Thông tin tệp tin'; ?></h5>
	</div>
	<div class="ibox-content">
	   <strong>Tên tệp tin:</strong> <?php echo $files['file_name_download']; ?><br />
	   <strong>Dung lượng:</strong> <?php echo $web->formatSizeUnits(filesize('server/'.__PATH__.$files['id'].'/'.$files['file_name'])); ?><br />
	   <strong>Thời gian tải lên: </strong> <?php echo $files['time']; ?> (<?php echo $web->timeAgo(strtotime($files['time'])); ?>)
	   <center><button class="btn btn-success  dim" type="button" id="download" data-id="<?php echo $files['id']; ?>"><i class="fa fa-download"></i>  Tải xuống</button></center>
	</div>
</div>


</div>
</div>
<div class="footer">
<div>
&copy; 2017 Vy Nghia.
</div>
</div>
</div>
</div>
<script src="assets/js/jquery-2.1.1.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/js/inspinia.js"></script>
<script src="assets/js/plugins/pace/pace.min.js"></script>
<script src="assets/js/jquery.twbsPagination.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.4/sweetalert2.min.js"></script>
<script>
$("#download").on('click',(function(e) {
	let $this = $(this);
	let id = $this.data('id');
	$.ajax({
		type: "GET",
		cache: false,
		dataType: "json",
		url: 'server/action.php?do=download&id=' + id,
		success: function(data) {
			if(data.download !== null)
				window.location = data.download;
		},
		error: function(){
			swal("Đã xảy ra lỗi!", "Đã xảy ra lỗi cục bộ, vui lòng thử lại!", "error")
		}
   });
}));
</script>
</body>
</html>
