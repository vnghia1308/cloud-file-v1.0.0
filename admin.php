<?php
/* >_ Developed by Vy Nghia */
require 'server/config.php';
session_start();
error_reporting(0);

if($_GET['p'] == null)
		$_GET['p'] = 1;
if($_GET['p'] >= 2)
	$pages = ($_GET['p'] - 1) * 10;
else
	$pages = 0;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin</title>
<base href="<?php echo WEBURL ?>" />
<link href="assets/css/bootstrap3/bootstrap.css" rel="stylesheet">
<link href="assets/css/plugins/toastr/toastr.min.css" rel="stylesheet">
<link href="assets/css/animate.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
<link href="assets/css/jasny-bootstrap.min.css" rel="stylesheet">
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
<!-- vertical menu -->
<li>
<a href="/"><i class="fa fa-home"></i> <span class="nav-label">Trang chủ</span></a>
</li>
<?php if(isset($_SESSION['admin'])): ?>
<li <?php echo ($_GET['page'] == null) ? 'class="active"' : null; ?>>
<a href="admin"><i class="fa fa-user-circle" aria-hidden="true"></i> <span class="nav-label">Trang quản trị viên</span></a>
</li>
<li <?php echo ($_GET['page'] == 'upload') ? 'class="active"' : null; ?>>
<a href="admin/upload"><i class="fa fa-upload" aria-hidden="true"></i>  <span class="nav-label">Tải tệp lên</span></a>
</li>
<li <?php echo ($_GET['page'] == 'manage') ? 'class="active"' : null; ?>>
<a href="admin/manage"><i class="fa fa-cloud" aria-hidden="true"></i>  <span class="nav-label">Quản lý tệp</span></a>
</li>
<li <?php echo ($_GET['page'] == 'change') ? 'class="active"' : null; ?>>
<a href="admin/change"><i class="fa fa-address-card" aria-hidden="true"></i>  <span class="nav-label">Đổi mật khẩu</span></a>
</li>
<li>
<a href="server/action?type=admin&do=logout"><i class="fa fa-power-off" aria-hidden="true"></i>  <span class="nav-label">Đăng xuất</span></a>
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
<!-- current page -->
<div class="row wrapper border-bottom white-bg page-heading">
<div class="col-lg-10">
<h2><?php if(!$_SESSION['admin']) echo 'Đăng nhập'; 
if(isset($_SESSION['admin'])){
	switch($_GET['page']){
		case null: echo 'Trang chủ'; break;
		case 'change': echo 'Thay đổi thông tin đăng nhập'; break;
		case 'upload': echo 'Tải tệp lên'; break;
		case 'manage': echo 'Quản lý tệp'; break;
	}
}
?></h2>
<ol class="breadcrumb">
<li>
<a href="/">Trang chủ</a>
</li>
<?php if(isset($_SESSION['admin'])): ?>
<li>
<a href="/">Quản trị viên</a>
</li>
<?php endif; ?>
<li class="active">
<strong><?php if(!$_SESSION['admin']) echo 'Đăng nhập'; 
if(isset($_SESSION['admin'])){
	switch($_GET['page']){
		case null: echo 'Trang chủ'; break;
		case 'change': echo 'Thay đổi thông tin đăng nhập'; break;
		case 'upload': echo 'Tải tệp lên'; break;
		case 'manage': echo 'Quản lý tệp'; break;
	}
}
?></strong>
</li>
</ol>
</div>
<div class="col-lg-2">
</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
<?php if(isset($_SESSION['admin'])):
switch($_GET['page']):
/* THAY ĐỔI MẬT KHẨU QUẢN TRỊ VIÊN */
case 'change': ?>
<div class="ibox float-e-margins">
	<div class="ibox-title">
		<h5>Thay đổi đăng nhập</h5>
	</div>
	<div class="ibox-content">
	   <form id="change" method="POST" class="form-horizontal">
		<div class="form-group"><label class="col-sm-2 control-label">Mật khẩu</label>
			<div class="col-sm-10"><input type="password" name="password" value="" class="form-control"></div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<button style="float: right" id="lgbtn" class="btn btn-primary" value="submit" name="submit" type="submit">Thay đổi đăng nhập</button>
			</div>
		</div>
		</form>
	</div>
</div>
<?php break;
/* UPLOAD FILE */
case 'upload': ?>
<div class="ibox float-e-margins">
	<div class="ibox-title">
		<h5>Tải tệp lên</h5>
	</div>
	<div class="ibox-content">
	   <form id="upload" method="POST" class="form-horizontal">
		<div id="fileinput" class="fileinput fileinput-new input-group" data-provides="fileinput">
			<div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
			<span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="file"></span>
			<a href="#" id="removeFile" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a><a id="submit" class="input-group-addon btn btn-default fileinput-exists">Upload</a>
		</div>

		<!-- UPLOAD PROGRESS -->
		<div id="upload-progress" style="display: none">
			<span id="progressbar-text">Tiến trình tải lên đang bắt đầu:</span><br />
			<div style="width: 0%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="0" role="progressbar" class="progress-bar"></div><hr />
			<button style="float: right" id="stop-upload" class="btn btn-primary" type="button">Hủy tải lên</button>
			<div style="clear: both;"></div>
		</div>

		<!-- UPLOAD RESULT -->
		<div class="form-group" id="upload-result" style="display: none"><label class="col-sm-2 control-label">Link: </label>
			<div class="col-sm-10"><input type="text" id="link" name="link" value="" class="form-control"></div>
		</div>
		</form>
	</div>
</div>
<?php break;
/* MANAGE FILES */
case 'manage': ?>
<div class="ibox float-e-margins">
	<div class="ibox-title">
		<h5>Quản lý tệp tin</h5>
	</div>
	<div class="ibox-content">
	<?php $query = mysql_query("SELECT * FROM `file` ORDER BY `time` DESC LIMIT 10 OFFSET {$pages}");
		if(mysql_num_rows($query) > 0):
		while($files = mysql_fetch_array($query)): 
		$web = new Website;?>
		<div class="social-feed-separated" id="file-id-<?php echo $files['id'] ?>">
		<div class="social-feed-box">
		<div class="social-avatar">
			<small class="text-muted"><?php echo $web->timeAgo(strtotime($files['time'])); ?></small>
		</div>
		<div class="social-body">
			<strong>Tên tệp tin:</strong> <input style="width: 70%" type="text" id="filename-change" value="<?php echo $files['file_name_download']; ?>" data-id="<?php echo $files['id'] ?>" hidden> <span id="filename" name="filename" contenteditable="false" data-id="<?php echo $files['id'] ?>"><?php echo $files['file_name_download']; ?></span> 
			<a style="pointer: pointer" id="change-name" data-id="<?php echo $files['id'] ?>" data-toggle="tooltip" title="Thay đổi tên"><i class="fa fa-pencil" aria-hidden="true"></i></a>
			<a style="pointer: pointer; display: none" id="changed" data-id="<?php echo $files['id'] ?>" data-type="cancel" data-toggle="tooltip" title="Hủy thay đổi"><i class="fa fa-times" aria-hidden="true"></i></a>
			<a style="pointer: pointer; display: none" id="changed" data-id="<?php echo $files['id'] ?>" data-type="save" data-toggle="tooltip" title="Lưu thay đổi"><i class="fa fa-check" aria-hidden="true"></i></a>
			</form>
			<br />
			<strong>Dung lượng:</strong> <?php echo $web->formatSizeUnits(filesize('server/'.__PATH__.$files['id'].'/'.$files['file_name'])); ?><br />
		<p><hr></p>
		<div class="file-option">
			<button class="btn btn-info btn-rounded btn-sm copy" id="copy" data-clipboard-text="<?php echo WEBURL.'/files/'.$files['id']; ?>"><i class="fa fa-clone"></i> Sao chép liên kết</button>
			<button class="btn btn-warning btn-rounded btn-sm" id="download" data-id="<?php echo $files['id'] ?>"><i class="fa fa-download"></i> Tải tệp xuống</button>
			<button class="btn btn-danger btn-rounded btn-sm" id="delete" data-id="<?php echo $files['id'] ?>"><i class="fa fa-times"></i> Xóa tệp này</button>
		</div>
		</div>
		</div>
		</div>
	<?php endwhile;
	else: ?>
	<p>Không có tệp nào</p>
	<?php endif; ?>
	</div>
</div>
<?php break;
/* TRANG CHỦ */
case null; ?>
<div class="ibox float-e-margins">
	<div class="ibox-title">
		<h5>Trang chủ</h5>
	</div>
	<div class="ibox-content">
	   <div class="alert alert-success" style="color:#1abc9c" role="alert">
			<font color="black">Mình mong bạn sẽ ủng hộ một chút ít cho tác giả bản web này là <a href="https://www.facebook.com/NghiaisGay">Vy Nghĩa</a>, bạn có thể sử dụng tiền đóng góp để ra 1 ý tưởng về dự án của bạn cho tác giả triển khai.
			Đây là hành động <strong>không bắt buộc</strong>, nếu bạn có nhu cầu thì hãy đóng góp để <a href="https://www.facebook.com/NghiaisGay">Vy Nghĩa</a> có thể duy trì các cơ sở vật chất và thử nghiệm các ý tưởng về sau.<br />
			<strong>Email hổ trợ:</strong> nghiaisgay@gmail.com<br />
			<strong>Liên hệ trò chuyện:</strong> 01632211065 (Vy Nghĩa)
			<br /><br />
			<strong>Cảm ơn. Mong sự tích cực từ bạn!</strong></font>
		</div>
	</div>
</div>
<?php break;
endswitch;
endif;
if(!$_SESSION['admin']): ?>
<!-- LOGIN ADMIN -->
<div class="ibox float-e-margins">
	<div class="ibox-title">
		<h5>Đăng nhập</h5>
	</div>
	<div class="ibox-content">
	   <form id="Login" method="POST" action="" class="form-horizontal">
		<div class="form-group"><label class="col-sm-2 control-label">Username</label>
			<div class="col-sm-10"><input type="text" name="username" value="" class="form-control" autocomplete="off"></div>
		</div>
		<div class="form-group"><label class="col-sm-2 control-label">Password</label>
			<div class="col-sm-10"><input type="password" name="password" value="" class="form-control"></div>
		</div>
		<div class="form-group">
			<div class="col-sm-4 col-sm-offset-2">
				<button id="lgbtn" class="btn btn-primary" value="submit" name="submit" type="submit">Đăng nhập</button>
			</div>
		</div>
		</form>
	</div>
</div>
<?php endif; ?>

</div>
<div class="row" style="text-align: center">
<?php 	
	if($_GET['page'] == 'manage')
		$query = 'SELECT * FROM `file`';
	$n = mysql_num_rows(mysql_query($query)) / 10;
	if(mysql_num_rows(mysql_query($query)) % 10 > 0)
		$n+=1;
	$n = (int) $n; 
	if(mysql_num_rows(mysql_query($query)) > 0): ?>
<ul class="pagination pagination-sm">
    <li class="<?php echo ($_GET['p']-1 != 0) ? 'first' : 'first disabled';?>"><a href="/admin/manage?p=1">First</a></li>
    <li class="<?php echo ($_GET['p']-1 != 0) ? 'prev' : 'prev disabled';?>"><a href="/admin/manage?p=<?php echo ($_GET['p']-1 != 0) ? $_GET['p']-1 : 1;?>">Previous</a></li>
	<?php for($i = 1; $i <= $n; $i++): ?>
    <li class="<?php echo ($_GET['p'] == $i) ? 'page active' : 'page'; ?>"><a href="/admin/manage?p=<?php echo $i ?>"><?php echo $i ?></a></li>
	<?php endfor; ?>
    <li class="<?php echo ($_GET['p']+1 > $n) ? 'next disabled' : 'next'; ?>"><a href="/admin/manage?p=<?php echo $_GET['p']+1 ?>">Next</a></li>
    <li class="<?php echo ($_GET['p']+1 > $n) ? 'last disabled' : 'last'; ?>"><a href="/admin/manage?p=<?php echo $n ?>">Last</a></li>
</ul>
<?php endif; ?>
</div>
</div>

<div class="footer">
<div>
&copy; 2017 Vy Nghia.
</div>
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
<script src="assets/js/plugins/toastr/toastr.min.js"></script>
<script src="assets/js/plugins/jasny/jasny-bootstrap.min.js"></script>
<script src="assets/js//plugins/clipboard/clipboard.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.4/sweetalert2.min.js"></script>
<script>
<?php if(isset($_SESSION['admin'])): ?>
$('[data-toggle="tooltip"]').tooltip();

/* COPY CLIPBOARD */
var clipboard = new Clipboard('.copy');
clipboard.on('success', function(e) {
    toastr.success("Đã sao chép liên kết")
});

clipboard.on('error', function(e) {
    toastr.error("Đã xảy ra lỗi sao chép")
});

/* WEBURL DEFINE */
var WEBURL = '<?php echo WEBURL ?>';

/* UPLOAD FILE */
//submit upload form
$("#submit").click(function() {
  $("#upload").submit()
});

//stop upload to server
$("#stop-upload").click(function() {
  location.reload();
});

//upload & transfer file
$("#upload").on('submit',(function(e) {
	e.preventDefault();
	var upload = $.ajax({
		url: "server/action.php?do=upload",
		type: "POST",
		dataType: "json",
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		xhr: function () {
				var xhr = new window.XMLHttpRequest();
				//Upload progress
				xhr.upload.addEventListener("progress", function (e) {
					if (e.lengthComputable) {
						var percentComplete = (e.loaded || e.position) * 100 / e.total;
						//Do something with upload progress
						$("#upload").find('.progress-bar').width(percentComplete+'%').html(parseFloat(Math.round(percentComplete * 100) / 100).toFixed(2)+'%');
					}
				}, false);
					xhr.addEventListener('load',function(e){
				$("#upload").find('.progress-bar').addClass('progress-bar-success').html('upload completed....');
			});
			  return xhr;
			},
		beforeSend: function () {
			$('#upload-result').fadeOut("slow")
			$("#fileinput").fadeOut("slow")
			$("#upload-progress").fadeIn("slow")
			$('#stop-upload').fadeIn("slow")
		},
		success: function(data) {
			$("#td_id").attr('class', 'progress-bar');
			$('#upload_btn').text('Upload').prop('disabled', false)
			if(data !== false){
				swal("Uploaded!", "Tệp đã được tải lên server!", "success")
				$("#fileinput").fadeIn("slow")
				$("#upload-progress").fadeOut("slow")
				$('#stop-upload').hide()
				$('#upload-result').show()
				$('#removeFile').click() //set null input file
				
				/* SET LINK TO INPUT */
				$('#link').val(WEBURL + '/files/' + data.id)
			}
			else {
				/* ERROR UPLOAD */
				swal("Upload error!", "Không thể tải tệp lên server!", "error")
				$("#fileinput").fadeIn("slow")
				$("#upload-progress").fadeOut("slow")
				$('#stop-upload').hide()
				$('#removeFile').click()
			}
		},
		error: function(){
			swal("Đã xảy ra lỗi!", "Đã xảy ra lỗi cục bộ, vui lòng thử lại!", "error")
			$("#fileinput").fadeIn("slow")
			$("#upload-progress").fadeOut("slow")
			$('#stop-upload').hide()
			$('#removeFile').click()
		}
   });
}));

/* CHANGE PASSWORD ADMIN */
$("#change").on('submit',(function(e) {
	e.preventDefault();
	$.ajax({
		url: "server/action.php?do=change&type=admin",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function () {
			$('#lgbtn').text('Đang xử lý...').prop('disabled', true)
		},
		success: function(data) {
			$('#lgbtn').text('Thay đổi đăng nhập').prop('disabled', false)
			if(data == true)
				location.reload();
		},
		error: function(){
			swal("Đã xảy ra lỗi!", "Đã xảy ra lỗi cục bộ, vui lòng thử lại!", "error")
			$('#lgbtn').text('Đăng nhập').prop('disabled', false)
		}
   });
}));

/* DOWNLOAD FILE */
$(".ibox-content").on('click', '#download',(function(e) {
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

/* DELETE FILE */
$(".ibox-content").on('click', '#delete',(function(e) {
	let $this = $(this);
	let id = $this.data('id');
	$.ajax({
		type: "POST",
		url: 'server/action.php?do=delete',
		data: {id : id},
		success: function(data) {
			if(data == true){
				swal("Deleted", "File này đã bị xóa khỏi server!", "success")
				$('#file-id-' + id).remove()
			} else 
				swal("Đã xảy ra lỗi!", "Lỗi không xác định, không thể xóa file này!", "error")
		},
		error: function(){
			swal("Đã xảy ra lỗi!", "Đã xảy ra lỗi cục bộ, vui lòng thử lại!", "error")
		}
   });
}));

/* CHANGE FILENAME */
$(".social-body").on('click', '#change-name',(function(e) {
	toastr.info("Chế độ chỉnh sửa đã mở")
	let $this = $(this);
	let id = $this.data('id');
	$('a[data-id="'+ id +'"]').show()
	$('#filename[data-id="'+ id +'"]').hide()
	$('#filename-change[data-id="'+ id +'"').show()
	$this.hide()
}));

$(".social-body").on('click', '#changed',(function(e) {
	let $this = $(this);
	let id = $this.data('id');
	let type = $this.data('type');
	
	if(type == 'save'){
		$('a[data-id="'+ id +'"]').hide()
		$('#change-name[data-id="'+ id +'"').show()
		$('#filename-change[data-id="'+ id +'"').hide()
		$('#filename[data-id="'+ id +'"]').text($('#filename-change[data-id="'+ id +'"').val()).show()
		
		$.ajax({
		type: "POST",
		url: 'server/action.php?do=rename&id=' + id,
		data: {name : $('#filename-change[data-id="'+ id +'"').val()},
		success: function(data) {
			if(data != true)
				swal("Đã xảy ra lỗi!", "Lỗi không xác định, không thể đổi tên file này!", "error")
			else
				toastr.success("Tên file đã được thay đổi")
		},
		error: function(){
			swal("Đã xảy ra lỗi!", "Đã xảy ra lỗi cục bộ, vui lòng thử lại!", "error")
		}
   });
	} else {
		$('a[data-id="'+ id +'"]').hide()
		$('#change-name[data-id="'+ id +'"').show()
		$('#filename[data-id="'+ id +'"]').show()
		$('#filename-change[data-id="'+ id +'"').hide()
		$('#filename-change[data-id="'+ id +'"').val($('#filename[data-id="'+ id +'"]').text())
	}
}));
<?php endif; ?>
$("#Login").on('submit',(function(e) {
	e.preventDefault();
	$.ajax({
		url: "server/auth.php?login=admin",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function () {
			$('#lgbtn').text('Đang xử lý...').prop('disabled', true)
		},
		success: function(data) {
			$('#lgbtn').text('Đăng nhập').prop('disabled', false)
			if(data == 'success')
				location.reload();
			else if (data == 'failed')
				swal("Lỗi đăng nhập!", "Tài khoản hoặc mật khẩu không đúng!", "error")
			else if(data == 'null')
				swal("Lỗi đăng nhập!", "Vui lòng điền đủ thông tin!", "error")
			else
				swal("Lỗi đăng nhập!", "Máy chủ không phản hồi dữ liệu!", "error")
				console.log(data);
		},
		error: function(){
			swal("Đã xảy ra lỗi!", "Đã xảy ra lỗi cục bộ, vui lòng thử lại!", "error")
			$('#lgbtn').text('Đăng nhập').prop('disabled', false)
		}
   });
}));
</script>
</body>
</html>
