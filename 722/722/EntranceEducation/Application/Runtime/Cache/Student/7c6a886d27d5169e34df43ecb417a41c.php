<?php if (!defined('THINK_PATH')) exit();?><!-- 随堂测试，测试题目 -->
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
        .cell_top{margin-top:0px;}
        .answer{float: right;right: 15px;margin-top: 5px;margin-bottom: 5px;}
        .answerArea{margin-left: -15px;}
        .choose{width: 25%;}
        .quesId{display: none;}
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
      <h1 class="demos-title">在线测试</h1>
    </header>
    <?php if(is_array($quesList)): $i = 0; $__LIST__ = $quesList;if( count($__LIST__)==0 ) : echo "没有测试题目" ;else: foreach($__LIST__ as $key=>$quesList): $mod = ($i % 2 );++$i;?><div class="weui_cells weui_cells_form cell_top ">
        <div class="" style="padding:0px 15px;"><?php echo ($i); ?></div>
        <div class="weui_cell weui_article" style="padding:0px 15px;">
          <img src="http://testet-public.stor.sinaapp.com<?php echo (str_replace('/Public','',$quesList["questionPicPath"])); echo ($quesList["questionPicName"]); ?>" alt="">
        </div>
        <div class="weui_cells weui_article cell_top" style="padding:0px 15px; left:15px;">
        <div><span id="<?php echo ($quesList["id"]); ?>" class="answerArea"></span><span class="quesId"><?php echo ($quesList["id"]); ?></span>
          <a class="weui_btn weui_btn_primary weui_btn_mini answer open-popup" href="javascript:answer(<?php echo ($quesList["id"]); ?>);" data-target="#half">答题</a>
        </div>  
        </div>
      </div><?php endforeach; endif; else: echo "没有测试题目" ;endif; ?>
    
    <div class="weui_btn_area">
      <a class="weui_btn weui_btn_primary" href="javascript:" id="submit">提交</a>
    </div>
    <div style="height:100px";></div>
    

    <div id="half" class='weui-popup-container popup-bottom'>
      <div class="weui-popup-modal">
        <div class="toolbar">
          <div class="toolbar-inner">
            <a href="javascript:;" class="picker-button close-popup">关闭</a>
            <h1 class="title">标题</h1>
          </div>
        </div>
        <div class="modal-content">
          <div class="weui_grids">
            <a href="javascript:choose('A');" class="weui_grid js_grid choose close-popup" data-id="dialog">
              <div class="weui_grid_icon">
                <img src="/EntranceEducation/Public/images/aa.png" alt="">
              </div>
            </a>
            <a href="javascript:choose('B');" class="weui_grid js_grid choose close-popup" data-id="progress">
              <div class="weui_grid_icon">
                <img src="/EntranceEducation/Public/images/bb.png" alt="">
              </div>
            </a>
            <a href="javascript:choose('C');" class="weui_grid js_grid choose close-popup" data-id="progress">
              <div class="weui_grid_icon">
                <img src="/EntranceEducation/Public/images/cc.png" alt="">
              </div>
            </a>
            <a href="javascript:choose('D');" class="weui_grid js_grid choose close-popup" data-id="msg">
              <div class="weui_grid_icon">
                <img src="/EntranceEducation/Public/images/dd.png" alt="">
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div id="test"></div>
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
<script>


$(document).on("open", ".weui-popup-modal", function() {
  console.log("open popup");
}).on("close", ".weui-popup-modal", function() {
  console.log("close popup");
});


function answer(id){
  quesId = id;
}

function choose(choice){
  $('#'+quesId).html('你的答案：'+choice);
}

$('#submit').click(function(){
  var answer = '';
  var quesIdStr = '';
  $('.answerArea').each(function(){
    answer += ($(this).html().substr(5));
    answer += '_';
  });
  $('.quesId').each(function(){
    quesIdStr += $(this).html();
    quesIdStr += '_';
  });

  if((answer.length) !== $('.answerArea').length * 2)  $.toptip('请完成你的题目！');
  else if(answer.length == 0) $.toptip('没有选择答案！');
  else 
    $.confirm("您确定要给提交本次测试", "确认提交?", function(){
      $.showLoading('试题提交中');
      setTimeout(function(){
        url = "<?php echo U('testSubmit');?>";
        data = {
          answer:answer,
          quesId:quesIdStr,
        };
        $.post(url,data,function(res){
          if(res == 'failure'){
            $.hideLoading();
            $.toast('提交失败','cancel');
          }else{
            $.hideLoading();
            $.toast('提交成功!');
            $('#submit').hide();
            window.location.href="<?php echo U('testResult');?>/result/"+res;
          }
        });
      },function(){
        //取消操作
      });
    });
});
</script>