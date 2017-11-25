<?php
/* >_ Developed by Vy Nghia */
require 'server/config.php';
session_start();
$web = new Website;
$_SESSION['code'] = $web->code(10);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home</title>
<base href="<?php echo WEBURL ?>" />
<link href="assets/css/bootstrap3/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-wysihtml5.css" rel="stylesheet">
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
<h2>Trang chủ</h2>
<ol class="breadcrumb">
<li>
<a href="/">Website</a>
</li>
<li class="active">
<strong>Trang chủ</strong>
</li>
</ol>
</div>
<div class="col-lg-2">
</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="ibox float-e-margins">
	<div class="ibox-title">
		<h5>Trang chủ</h5>
	</div>
	<div class="ibox-content">
	   <!-- // CODE HERE // -->
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
<script src="assets/js/wysihtml5-0.3.0.js"></script>
<script src="assets/js/bootstrap-wysihtml5.js?v=1509569870"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.4/sweetalert2.min.js"></script>
<script>
$("#post").on('submit',(function(e) {
	e.preventDefault();
	if($('textarea').val() == ''){
		swal("Không thể thực hiện!", "Bạn chưa nhập nội dung bài viết!", "error")
	} else {
		$.ajax({
			url: 'send.php?action=post',
			type: "POST",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function () {
				$('#postSubmit').text('Đang xử lý...').prop('disabled', true)
			},
			success: function(data) {
			if(data !== false){
					$('#post-success').show()
					$('#postSubmit').text('Đăng bài viết').prop('disabled', false)
					$('textarea').val(null)
					setTimeout(function(){ 
						$('#post-success').hide()
					}, 3000);
					console.log(data);
				} else {
					console.log('null');
				}
			},
			error: function(){
				swal("Đã xảy ra lỗi!", "Đã xảy ra lỗi cục bộ, vui lòng thử lại!", "error")
				$('#postSubmit').text('Đăng bài viết').prop('disabled', false)
			}
	   });
	}
}));
</script>
</body>
</html>
