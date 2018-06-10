<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <title>layui</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <link rel="stylesheet" href="/71/Public/layui/css/layui.css"  media="all">
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->

</head>


<body>
<ul class="layui-nav">
  <li class="layui-nav-item"><a href="<?php echo U('Index/index');?>">最新活动</a></li>

  <li class="layui-nav-item">
    <a href="javascript:;">产品</a>
    <dl class="layui-nav-child">
      <dd><a href="">选项1</a></dd>
      <dd><a href="">选项2</a></dd>
      <dd><a href="">选项3</a></dd>
    </dl>
  </li>

  <li class="layui-nav-item"><a href="">大数据</a></li>

  <li class="layui-nav-item">
    <a href="javascript:;">解决方案</a>
    <dl class="layui-nav-child">
      <dd><a href="">移动模块</a></dd>
      <dd><a href="">后台模版</a></dd>
      <dd class="layui-this"><a href="">选中项</a></dd>
      <dd><a href="">电商平台</a></dd>
    </dl>
  </li>

  <li class="layui-nav-item"><a href="">社区</a></li>
</ul>
<body>

<link rel="stylesheet" type="text/css" href="/71/Public/css/Gameindex.css">

<div id="gameplace">
	<img src="/71/Public/images/kaifang.png" onclick="javascript:window.location.href='/71/index.php/Home/Game/kaifang.html'" id="kaifang">
	<img src="/71/Public/images/jinfang.png" onclick="javascript:window.location.href='/71/index.php/Home/Game/jinfang.html'" id="jinfang">
	<!-- <span></span> -->	
</div>
  
<script src="/71/Public/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
layui.use('element', function(){
  var element = layui.element(); //导航的hover效果、二级菜单等功能，需要依赖element模块
  
  //监听导航点击
  element.on('nav(demo)', function(elem){
    //console.log(elem)
    layer.msg(elem.text());
  });
});
</script>
</body>
</html>