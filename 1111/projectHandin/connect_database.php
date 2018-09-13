<?php 
//$mysql_server_name = "localhost";
//$mysql_username = "root";
//$mysql_password ="";
//$mysql_database = "app_cprogramplatform";
$mysql_database = "app_".$_SERVER['HTTP_APPNAME'];
$link=mysql_connect(SAE_MYSQL_HOST_S.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
 //连接数据
//$link=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS); //连接数据库
mysql_select_db("$mysql_database",$link);//选择数据库
mysql_query("set names 'utf-8'");
date_default_timezone_set("Asia/Shanghai");

// $nyear = 'co_2016_';
// $app_name="4.cprogramplatform";
$nyear = 'fc_2017_';
$app_name="4.cprogramplatform";

// $_classw1='网络1601';
// $_classw2='网络1602';
 $_class1='网络1702';
 $_class2='网络1703';


$_acc_s = $nyear.'acc_s';
$_accuracy = $nyear.'accuracy';
$_acm_task = 'co_2016_acm_task';
$_acm_un = $nyear.'acm_un';
$_classes = $nyear.'classes';
$_debate = $nyear.'debate';
$_debate_comment = $nyear.'debate_comment';
$_danger_name = $nyear.'danger_name';
$_exercise_ans = $nyear.'exercise_ans';
$_erjiswitch = $nyear.'erjiswitch';
$_final_score=$nyear.'final_score';
$_grade_count = $nyear.'grade_count';

$_homework =  $nyear.'homework';
$_homework_comment = $nyear.'homework_comment';
$_home_work_score = $nyear.'home_work_score';
$_homework_mark = $nyear.'homework_mark';
$_home_work_detail = $nyear.'home_work_detail';
$_homework_recom = $nyear.'homework_recom';
$_homework_list =$nyear.'homework_list';
$_lesson = $nyear.'lesson';
$_mark = $nyear.'mark';
$_mul_task = $nyear.'mul_task';

$_project = $nyear.'project';
$_project_comment = $nyear.'project_comment';
$_pv_vistor = $nyear.'pv_vistor';
$_problem = $nyear.'problem';//acm题库
$_re_testans = $nyear.'re_testans';
$_r_accuracy = $nyear.'r_accuracy';
$_solution = $nyear.'solution';
$_team_group = $nyear.'team_group';
$_testans = $nyear.'testans';
$_testerji = 'co_2016_testerji';//二级题库
$_testerjians = $nyear.'testerjians';
$_test_menbers_all = $nyear.'test_menbers_all';
$_testcontent = 'testcontent';
$_test_wrong_ans = $nyear.'test_wrong_ans';


$_users = $nyear.'users';

?>