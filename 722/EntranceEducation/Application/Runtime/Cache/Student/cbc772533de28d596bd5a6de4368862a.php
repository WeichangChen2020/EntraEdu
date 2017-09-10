<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
 <head>
  <title>用户注册</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<meta name="description" content="入学教育考试平台">

<link rel="stylesheet" href="/722/Public/lib/weui.min.css">
<link rel="stylesheet" href="/722/Public/css/jquery-weui.css">
<link rel="stylesheet" href="/722/Public/css/demos.css">
 </head>
 <body ontouchstart="">
  <header class="demos-header"> 
   <h1 class="demos-title">新生注册</h1>
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
     <label for="home-city" class="weui_label">班级</label>
    </div> 
    <div class="weui_cell_bd weui_cell_primary"> 
     <input class="weui_input" id="home-city" type="text" placeholder="请选择班级">
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
    <a class="weui_btn weui_btn_primary" href="javascript:" id="submit">注册</a>
  </div>
  
   

  <script src="/722/Public/lib/jquery-2.1.4.js"></script>
<script src="/722/Public/js/jquery-weui.js"></script>
  <script src="/722/Public/js/city-picker.js"></script>

  <script type="text/javascript">
       var college,banji;//定义全局变量
       $("#home-city").cityPicker({
        title: "请选择学院班级",
        showDistrict: false,
        onChange: function (picker, values, displayValues) {
          college = displayValues[0];
          banji = displayValues[1];
          // console.log(displayValues);
        }
        });

      $("#submit").click(function() {
        var name = $('#name').val();
        // var banji = $('#banji').val();
        var number = $('#number').val();
        if(!name)
          $.toptip('请输入姓名');
        else if(!banji)
          $.toptip('请选择班级');
        else if(!number)
          $.toptip('请输入学号');
        else if(number.length != 10)
          $.toptip('学号必须是10位数');
        else {
          /*=============上传数据==========*/
          url  = "<?php echo U('User/register');?>",
          data = {
            'name'   : name,
            'college':college,
            'banji'  : banji,
            'number' : number
          }
          $.post(url,data,function(res){
            $.showLoading();
            setTimeout(function() {
              $.hideLoading();
              $.toast("注册成功");
              $('#submit').hide(); //隐藏确定键
            }, 1000)
             window.location.href="<?php echo U('User/index');?>/openId/<?php echo ($openId); ?>";//注册成功后跳转到首页，如果直接Index/index，就没有学生信息数组，首页就没有学生信息，所以跳转到User/index
          });
        }
      });
       
      

    </script>  
 </body>
</html>