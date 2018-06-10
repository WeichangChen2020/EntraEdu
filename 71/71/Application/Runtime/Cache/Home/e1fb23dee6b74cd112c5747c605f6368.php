<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<meta name="description" content="Write an awesome description for your new site here. You can edit this line in _config.yml. It will appear in your document head meta (for Google search results) and in your feed.xml site description.
">

<!-- <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css">
<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script> -->

<link rel="stylesheet" href="/71/Public/css/weui.min.css">
<link rel="stylesheet" href="/71/Public/css/jquery-weui.css">
<link rel="stylesheet" href="/71/Public/css/demos.css">
<link rel="stylesheet" type="text/css" href="/71/Public/css/background.css">



<title><?php echo ($title); ?></title>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<!-- bootstrap-css -->
<link href="/71/Public/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- //bootstrap-css -->
<!-- css -->
<link href="/71/Public/css/style.css" rel='stylesheet' type='text/css' />
<!-- //css -->
<script src="/71/Public/js/jquery-1.11.1.min.js"> </script>	
<script src="/71/Public/js/bootstrap.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>	










</head>
<body>
<div class="header">
			<!-- container -->
			<div class="container">
				<div class="logo">
					<h1><a href="<?php echo U('Index/index');?>"><span>C语言</span>V2</a></h1>
				</div>
				<div class="top-nav">
					<nav class="navbar navbar-default">
						<div class="container">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">Menu						
							</button>
						</div>
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<li><a href="<?php echo U('Index/index');?>" class="active">Home</a></li>
								<li><a href="about.html">About</a></li>
								<li><a href="codes.html">Codes</a></li>
								<li><a href="#" class="dropdown-toggle hvr-bounce-to-bottom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gallery<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a class="hvr-bounce-to-bottom" href="gallery.html">Gallery1</a></li>
										<li class="dropdown-submenu">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown-submenu" role="button" aria-haspopup="true" aria-expanded="false">Gallery2<span class="caret"></span></a>
											<ul class="dropdown-menu">
											  <li><a tabindex="-1" href="gallery.html">Gallery4</a></li>
												<li><a href="gallery.html">Gallery5</a></li>
											  <li><a href="gallery.html">Gallery6</a></li>
											</ul>
										  </li>
										<li><a class="hvr-bounce-to-bottom" href="gallery.html">Gallery3</a></li>           
									</ul>
								</li>	
								<li><a href="blog.html">Blog</a></li>
								<li><a href="<?php echo U('Communicationplat/index');?>}">Contact</a></li>
							</ul>	
							<div class="clearfix"> </div>
						</div>	
					</nav>		
				</div>
			</div>
			<!-- //container -->
		</div>

	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>




<input type="text" id="fangjianhao" value="<?php echo ($fangjianhao); ?>" hidden="hidden">

<div class="background">
	<div class="yuyin" style="display:<?php echo ($flag); ?>">

		<span class="weui_btn weui_btn_warn">房主操作</span>
		
		<button id="tianliangle" class="weui_btn weui_btn_primary">天亮了（先竞选警长），查看昨晚情况</button></br> 
		<span id="zuowansideshi" class="weui_btn weui_btn_plain_default"></span>  

		
		
		
		<script type="text/javascript">
		$("#tianliangle").click(function(event){
			$.ajax({
				type:"POST",
				url:"<?php echo U('Game/tianliangle');?>",
				success:function(siderenshi)
				{
					$("#zuowansideshi").html("昨晚死的人是"+siderenshi+"号");
				}
			});
		});

		</script>
		</br>

		<input type="text" id="fangzhutoupiao">
		<button type="submit" id="piao" class="weui_btn weui_btn_mini weui_btn_primary">票他出去(别输入白痴)</button>
		</br>
		<script type="text/javascript">
			$("#piao").click(function(event){
				$.ajax({
					url:"<?php echo U('Game/toupiao');?>",
					type:"POST",
					data:{fangzhutoupiao:$("#fangzhutoupiao").val()}
					
				});
				alert("已投");
			});

		</script>
		</br>
		<audio src="/71/Public/music/langrensha.mp3" controls="controls"></audio>  <!--黑闭，狼杀,女巫，预言家，天亮睁眼，竞选警长，昨晚 -->
	    <div style="border-top:2px solid #F00"></div>
	</div>
	<button id="kaiqiangzhuangtai">查看今晚开枪状态</button>
	<span hidden="hidden" id="zhuangtai"></span>
	</br>

	<script type="text/javascript">
		$("#kaiqiangzhuangtai").click(function(event){
			$.ajax({
				url:"<?php echo U('Game/lieren2');?>",
				type:"POST",
				data:{fangjianhao1:$("#fangjianhao").val()},
				success:function(flag){
					
					if (flag==1) {
						$("#zhuangtai").show();$("#zhuangtai").html("死后不能开枪");
						$("#daizou").attr({"disabled":"disabled"});
					}else{
						$("#zhuangtai").show();$("#zhuangtai").html("死后可以开枪");
					}
				}
			});
		});	
	</script>

	<span>死了以后带走几号（也可不带走人）</span>
	<input type="text" id="daizoujihao">
	<button id="daizou">带走</button>

	<script type="text/javascript">
		$("#daizou").click(function(event){
			var fangjianhao=$("#fangjianhao").val();
			$.ajax({
				url:"<?php echo U('Game/lieren');?>",
				type:"POST",
				data:{daizou:$("#daizoujihao").val(),fangjianhao1:fangjianhao},
				success:function(daizou)
				{
					alert("带走成功");
				}
			});
		});
	</script>
</div>


</body>
</html>