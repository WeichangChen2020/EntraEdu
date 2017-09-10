<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <title>跳转提示</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<meta name="description" content="入学教育考试平台">

<link rel="stylesheet" href="/722/Public/lib/weui.min.css">
<link rel="stylesheet" href="/722/Public/css/jquery-weui.css">
<link rel="stylesheet" href="/722/Public/css/demos.css">
  </head>

  <body ontouchstart>
    <div class="weui_msg">
      <div class="weui_icon_area"><i class="weui_icon_msg weui_icon_warn"></i></div>
      <div class="weui_text_area">
        <h2 class="weui_msg_title"><?php echo ((isset($message) && ($message !== ""))?($message):"操作失败"); ?></h2>
        <p class="weui_msg_desc"><?php echo ($error); ?></p>
       <p class="jump">
页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b>
</p>
      </div>
      <div class="weui_opr_area">
        <p class="weui_btn_area">
          <a href="<?php echo ($jumpUrl); ?>" class="weui_btn weui_btn_primary">确定</a>
        </p>
      </div>
      <div class="weui_extra_area">
        <a href="<?php echo ($jumpUrl); ?>">查看详情</a>
      </div>
    </div>
  </body>
</html>

<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
  var time = --wait.innerHTML;
  if(time <= 0) {
    location.href = href;
    clearInterval(interval);
  };
}, 1000);
})();
</script>