<?php if (!defined('THINK_PATH')) exit();?><!-- 已经提列表 -->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<meta name="description" content="概率论与数理统计教学平台v3.0">

<link rel="stylesheet" href="/EntranceEducation/Public/lib/weui.min.css">
<link rel="stylesheet" href="/EntranceEducation/Public/css/jquery-weui.css">
<link rel="stylesheet" href="/EntranceEducation/Public/css/demos.css">
    <style>
      [class*="weui-col-"] {
        border: 1px solid #ccc;
        height: 40px;
        line-height: 40px;
        text-align: center;
      }

    </style>
  </head>
  <body ontouchstart>
    <div class="weui-pull-to-refresh-layer">
  <div class='pull-to-refresh-arrow'></div>
  <div class='pull-to-refresh-preloader'></div>
  <div class="down">下拉刷新页面</div>
  <div class="up">释放刷新</div>
  <div class="refresh">正在刷新</div>
</div>
    <header class='demos-header'>
      <h1 class="demos-title">提交列表</h1>
    </header>

    <div class="weui-row weui-no-gutter">
      <div class="weui-col-10"></div>
        <div class="weui-col-20">姓名</div>
        <div class="weui-col-20">得分 </div>
      <div class="weui-col-50">提交时间</div>
    </div>
    <?php if(is_array($stuTestList)): $k = 0; $__LIST__ = $stuTestList;if( count($__LIST__)==0 ) : echo "没有测试提交信息" ;else: foreach($__LIST__ as $key=>$stuTestList): $mod = ($k % 2 );++$k;?><div class="weui-row weui-no-gutter">
        <div class="weui-col-10"><?php echo ($k); ?></div>
        <div class="weui-col-20"><?php echo ((isset($stuTestList["name"]) && ($stuTestList["name"] !== ""))?($stuTestList["name"]):'null'); ?></div>
        <div class="weui-col-20"><?php echo ((isset($stuTestList["rightNum"]) && ($stuTestList["rightNum"] !== ""))?($stuTestList["rightNum"]):'null'); ?></div>
        <div class="weui-col-50"><?php echo ((isset($stuTestList["time"]) && ($stuTestList["time"] !== ""))?($stuTestList["time"]):'null'); ?></div>
      </div><?php endforeach; endif; else: echo "没有测试提交信息" ;endif; ?>
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