/*var people = 6;*/

if(people > 6) {
  $("#people").get(0).selectedIndex = people - 6;
  changeAll(people);
}

$(":checkbox").click(function(v) {
  var cm = parseInt($("#cunmin").val());
  if($(this).attr("checked")) {
    if(cm <= 1) {
      err("人数超过上限");
      $(this).removeAttr("checked");
    }
    else $("#cunmin").val(cm-1);
  }
  else $("#cunmin").val(cm+1);
});


function changeAll(people) {
 

  if(people >= 10) {
    $("#shouwei").attr("checked","checked");
  }
  else $("#shouwei").removeAttr("checked");

  if(people >= 11) {
    $("#baichi").attr("checked","checked");
  }
  else $("#baichi").removeAttr("checked");

  count = 0;
  $(":checkbox[checked]").each(function() {
    count = count + 1;
  });
  
  var lr = 0;
  if(people >= 6 && people <=  7) {
    lr = 1;
  }

  if(people >= 8 && people <=  11) {
    lr = 2;
  }

  if(people >= 12 && people <=  15) {
    lr = 3;
  }

  if(people >= 16 && people <= 19) {
    lr = 4;
  }

  if(people >=  20 && people <= 23) {
    lr = 5;
  }

  if(people >= 24 && people <= 27) {
    lr = 6;
  }

  if(people >= 28)
    lr = 7;
  
  $("#langren").get(0).selectedIndex = lr - 1;
  
  var cunmin = people-count-$("#langren").val();
  if(cunmin > 0) {
    $("#cunmin").val(cunmin);
  }
  else {
    err("总人数错误");
    $("#cunmin").val(people-count-1);
    $("#langren").get(0).selectedIndex=0
  }
}

function changeLr(lr) {
  count = 0;
  $(":checkbox[checked]").each(function() {
    count = count + 1;
  });

  people = $("#people").val();

  var cunmin = people - lr - count;
  if(cunmin > 0) {
    $("#cunmin").val(cunmin);
  }
  else {
    err("人数超过上限");
    $("#cunmin").val(people-count-1);
    $("#langren").get(0).selectedIndex=0
  }
}

/*function changeAuto() {
  href = "http://zhuoyouwx.weapp.me/game/create_lr_auto/oOWHXjrtTI80zwnROS18OwLekWZw";
  href += "?people="+$("#people").val();
  window.location.href = href;
}*/
function err(info) {
  alert(info);
}