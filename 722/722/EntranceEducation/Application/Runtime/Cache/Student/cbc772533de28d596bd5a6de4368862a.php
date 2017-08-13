<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
 <head>
  <title>用户注册</title>
  <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<meta name="description" content="概率论与数理统计教学平台v3.0">

<link rel="stylesheet" href="/EntranceEducation/Public/lib/weui.min.css">
<link rel="stylesheet" href="/EntranceEducation/Public/css/jquery-weui.css">
<link rel="stylesheet" href="/EntranceEducation/Public/css/demos.css">
 </head>
 <body ontouchstart="">
  <header class="demos-header"> 
   <h1 class="demos-title">注册信息</h1>
  </header> 
  
  <div class="weui_cells weui_cells_form">
   <div class="weui_cell"> 
    <div class="weui_cell_hd">
     <label class="weui_label">姓名</label>
    </div> 
    <div class="weui_cell_bd weui_cell_primary"> 
     <input class="weui_input" id="name" type="text" maxlength="4" placeholder="请输入姓名" required="required">
    </div> 
   </div>
   <div class="weui_cell">
    <div class="weui_cell_hd">
     <label class="weui_label">班级</label>
    </div> 
    <div class="weui_cell_bd weui_cell_primary"> 
     <input class="weui_input" id="banji" type="text" placeholder="请输入班级"> 
    </div> 
   </div>
   <div class="weui_cell"> 
    <div class="weui_cell_hd">
     <label class="weui_label">学号</label>
    </div> 
    <div class="weui_cell_bd weui_cell_primary"> 
     <input class="weui_input" id="number" type="number" maxlength="10" placeholder="请输入学号" required="required" />
    </div> 
   </div>
  </div>
  <div class="weui_btn_area">
    <a class="weui_btn weui_btn_primary" href="javascript:" id="submit">确定</a>
  </div>
  
  <script src="/EntranceEducation/Public/lib/jquery-2.1.4.js"></script>
<script src="/EntranceEducation/Public/js/jquery-weui.js"></script>
  <script>
      // $("#banji").select({
      //   title: "选择班级",
      //   items: ["网络1501", "网络1502" ,"test","其他班级"],
      //   onChange: function(d) {
      //     console.log(this, d);
      //   },
      //   onClose: function() {
      //     console.log("close");
      //   },
      //   onOpen: function() {
      //     console.log("open");
      //   },
      // });

      $("#submit").click(function() {
        var name = $('#name').val();
        var banji = $('#banji').val();
        var number = $('#number').val();
        if(!name) $.toptip('请输入姓名');
        else if(!banji) $.toptip('请选择班级');
        else if(!number) $.toptip('请输入学号');
        else if(number.length > 10) $.toptip('学号不能超过10位数');
        else {
          /*=============上传数据==========*/
          url  = "<?php echo U('User/register');?>",
          data = {
            name   : name,
            banji  : banji,
            number : number
          }
          $.post(url,data,function(res){
            $.showLoading();
            setTimeout(function() {
              $.hideLoading();
              $.toast("注册成功");
              $('#submit').hide(); //隐藏确定键
            }, 2000)
          });
        }
      });

    </script>  
 </body>
</html>