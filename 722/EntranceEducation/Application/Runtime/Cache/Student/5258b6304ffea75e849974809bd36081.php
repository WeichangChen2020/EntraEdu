<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<meta name="description" content="概率论与数理统计教学平台v3.0">

<link rel="stylesheet" href="/EntranceEducation/Public/lib/weui.min.css">
<link rel="stylesheet" href="/EntranceEducation/Public/css/jquery-weui.css">
<link rel="stylesheet" href="/EntranceEducation/Public/css/demos.css">
 </head>
 <body ontouchstart="">
    <div class="weui-pull-to-refresh-layer">
  <div class='pull-to-refresh-arrow'></div>
  <div class='pull-to-refresh-preloader'></div>
  <div class="down">下拉刷新页面</div>
  <div class="up">释放刷新</div>
  <div class="refresh">正在刷新</div>
</div>
    <header class='demos-header'>
      <h1 class="demos-title">入学测试</h1>
    </header>
    <div class="weui_panel weui_panel_access">
      <div class="weui_panel_bd">
        <?php if(is_array($testList)): $i = 0; $__LIST__ = $testList;if( count($__LIST__)==0 ) : echo "没有测试信息" ;else: foreach($__LIST__ as $key=>$testList): $mod = ($i % 2 );++$i;?><a href="<?php echo U('testMenu');?>/quizId/<?php echo ($testList["id"]); ?>" class="weui_media_box weui_media_appmsg">
            <div class="weui_media_bd">
              <h4 class="weui_media_title"><?php echo ((isset($testList["quizName"]) && ($testList["quizName"] !== ""))?($testList["quizName"]):"没有设置测试名称"); ?></h4>
              <p class="weui_media_desc">截止时间:<?php echo (substr($testList["deadtime"],5,11)); ?></p>
            </div>
            <div class="weui_cell_ft alert">
              <div><?php if($testList["isSubmit"] == true): ?><i class="weui_icon_success"></i>您已提交<?php else: ?> <i class="weui_icon_warn"></i>您未提交<?php endif; ?></div>
              <div><i class="weui_icon_info"></i>提交人数:<?php echo ($testList["submitNum"]); ?></div>
            </div>
          </a><?php endforeach; endif; else: echo "没有测试信息" ;endif; ?>          
      </div>
    </div>
  </body>
</html>
<script src="/EntranceEducation/Public/lib/jquery-2.1.4.js"></script>
<script src="/EntranceEducation/Public/js/jquery-weui.js"></script>
<script>
  $(document.body).pullToRefresh().on("pull-to-refresh", function() {
    setTimeout(function() {
      location.reload();
      $(document.body).pullToRefreshDone();
    }, 1200);
  });
</script>