// 输入开始时间，考试时间
function countdown(endtime) {

	var EndTime= new Date(endtime*1000);
    // console.log(EndTime);
    var NowTime = new Date();


    var t = endtime*1000 - NowTime.getTime();

    // console.log(EndTime.toLocaleString());
    // // // new Date().format("yyyy-MM-dd")
    // console.log(NowTime.toLocaleString());
    // t = 50 * 60 * 1000;
    var h=0;
    var m=0;
    var s=0;
    if(t>=0){
        h = Math.floor(t/1000/60/60%24);
        m = Math.floor(t/1000/60%60);
        s = Math.floor(t/1000%60);
    }

    if (h>0)
        $('title').html('模拟考试-'+h+'时'+m+'分'+s+'秒');
    else
        $('title').html('模拟考试-'+m+'分'+s+'秒');

}