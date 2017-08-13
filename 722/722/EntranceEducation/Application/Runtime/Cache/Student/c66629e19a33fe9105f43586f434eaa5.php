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

  <body ontouchstart>
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

    <div class="bd">
      <div class="weui_cells weui_cells_access">
        <a class="weui_cell" href="<?php echo U('test');?>">
          <div class="weui_cell_hd"><img src="/EntranceEducation/Public/images/onlinetest.png" class="icon_nav" alt="" style="width:28px;height:28px;margin-right:5px;display:block"></div>
          <div class="weui_cell_bd weui_cell_primary">
            <p>在线测试</p>
          </div>
          <div class="weui_cell_ft"><?php if($state): ?><i class="weui_icon_success"></i><?php else: ?> <i class="weui_icon_warn"></i><?php endif; ?></div>
        </a>
        <a class="weui_cell" href="<?php echo U('testAnalyze');?>">
          <div class="weui_cell_hd"><img src="/EntranceEducation/Public/images/analysis.png" class="icon_nav" alt="" style="width:28px;height:28px;margin-right:5px;display:block"></div>
          <div class="weui_cell_bd weui_cell_primary">
            <p>题目解析</p>
          </div>
          <div class="weui_cell_ft"><?php if($state): ?><i class="weui_icon_success"></i><?php else: ?> <i class="weui_icon_warn"></i><?php endif; ?></div>
        </a>
        <a class="weui_cell" href="<?php echo U('testDetails');?>">
          <div class="weui_cell_hd"><img src="/EntranceEducation/Public/images/account.png" class="icon_nav" alt="" style="width:28px;height:28px;margin-right:5px;display:block"></div>
          <div class="weui_cell_bd weui_cell_primary">
            <p>测试统计</p>
          </div>
          <div class="weui_cell_ft"><span class="demos-badge"><?php echo ((isset($number) && ($number !== ""))?($number):'0'); ?></span></div>
        </a>
        <a class="weui_cell" href="<?php echo U('Teacher/test_view');?>/quizId/<?php echo ($quizId); ?>">
          <div class="weui_cell_hd"><img src="/EntranceEducation/Public/images/detail.png" class="icon_nav" alt="" style="width:28px;height:28px;margin-right:5px;display:block"></div>
          <div class="weui_cell_bd weui_cell_primary">
            <p>测试详情</p>
          </div>
          <div class="weui_cell_ft"><span class="demos-badge"><?php echo ((isset($number) && ($number !== ""))?($number):'0'); ?></span></div>
        </a>
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