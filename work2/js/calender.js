
var dt = new Date();
thisYear = dt.getFullYear();
thisMonth = dt.getMonth();
thisDay = dt.getDay() ;
thisDate = dt.getDate();
monthDays = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
monthNames = new Array("一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月");

function calender(year,month){
        var thisdt = new Date(year,month,1);
        if (((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0)) {
            monthDays[1] = 29;
        }
        x = thisdt.getDay() -1;
        jumpToNext = 1;
        cal = document.getElementById('tb1');
        var s = "";
        var y = '<Button onclick=last() style=font-size:8pt;border-style:none; >-</Button><Button onclick=next() style=font-size:8pt;border-style:none;>+</Button>' + 
        '<Button onclick=today() style=font-size:8pt; >今天</Button>';
        document.getElementById("y").innerHTML = year + "年" + monthNames[month] + y;
        s += '<tr class="ta"> ';
        for(x>0;x--;){
            s+='<td></td>';
            jumpToNext++;
        }
        for(i=1;i<=monthDays[month];i++){
            s +="<td id="+i+" class='"+i + " ta"+"' onclick=changeWeek("+i+","+jumpToNext+")>"+i+"</td>";
            jumpToNext++;
            if(jumpToNext == 8){
                s +='</tr><tr>';
                jumpToNext = 1;
            }
        }
        

        cal.innerHTML += s;
        if(month == dt.getMonth()){
            $("#"+thisDate).css("color","blue");
        }else{
            $("#"+thisDate).css("color","black");
        }
        
}

function next(){
    thisMonth += 1;
    if(thisMonth > 11){
        thisYear += 1;
        thisMonth = 0;s
    }
    $(".ta").remove();
    calender(thisYear,thisMonth);
}
function last(){
    thisMonth -= 1;
    if(thisMonth < 0){
        thisYear -= 1;
        thisMonth = 11;
    }
    $(".ta").remove();
    calender(thisYear,thisMonth);
}
function today(){
    thisMonth = dt.getMonth();
    changeWeek(thisDate,thisDay);
    $(".ta").remove();
    calender(dt.getFullYear(),dt.getMonth());
    
}
function changeWeek(date,days){
    x = date;
    y = date;
    switch(days){
        case 7:
            setdays(x,y,7);
            break;
        case 6:
            setdays(x,y,6);
            break;
        case 5:
            setdays(x,y,5);
            break;
        case 4:
            setdays(x,y,4);
            break;
        case 3:
            setdays(x,y,3);
            break;
        case 2:
            setdays(x,y,2);
            break;
        case 1:
            setdays(x,y,1);
            break;
    }
    for(i=1;i<8;i++){
        if(thisMonth == dt.getMonth()){
            if($("#day"+i).html()==thisDate){
                console.log("換色");
                $("#day" + i).css("color","blue");
            }else{
                console.log("不換色");
                $("#day" + i).css("color","black");
            }
        }else{
            console.log("不換色");
            $("#day" + i).css("color","black");
        }
    }
    
}
function setdays(x,y,days){
    for(i=1;i<=7;i++){
        inner = document.getElementById("day"+i);
        inner.innerHTML = "";
        
    }//先把全部變成空白
    for(i=days;i>0;i--){
        if(x > 0){
            $("#day"+i).html(x);
            
            ajax_update(thisYear,thisMonth+1,x);
            for(time=0;time<24;time++){
                ajax_update_time(thisYear,thisMonth+1,x,time);
            }
            
            x-=1;
        }else{
            x-=1;
            break;
        }
    }
    for(i=days;i<8;i++){
        if(y<=monthDays[thisMonth]){
            $("#day"+i).html(y);
            ajax_update(thisYear,thisMonth+1,y);
            for(time=0;time<24;time++){
                ajax_update_time(thisYear,thisMonth+1,y,time);
            }
            y+=1;
        }else{
            y+=1;
            break;
        }
        
        
    }
    for(i=1;i<=7;i++){
        $("#day"+i).removeClass();
        $("#day"+i + 'sch').removeClass();
        $("#day"+i+'sch').html("");
    }
    add_class();
}
function createTable(){
    var append_table = "<tr><td>本日行程</td>";
    for(i=1;i<8;i++){
        append_table += '<td onclick=recordAct() id="day'+ i + 'sch' + '"'+'</td>';
    }
    append_table += "'</tr>'";
    for(i=0;i<24;i++){
        append_table += '<tr><td>'+i+':00'+'</td>' + '<td onclick=recordAct() id="day'+ 1 + 'time' + i + '"'+'</td>'+'<td onclick=recordAct() id="day'+ 2 + 'time' + i + '"'+'</td>'+
        '<td onclick=recordAct() id="day'+ 3 + 'time' + i + '"'+'</td>' + '<td onclick=recordAct() id="day'+ 4 + 'time' + i + '"'+'</td>' + '<td onclick=recordAct() id="day'+ 5 + 'time' + i + '"'+'</td>' + 
        '<td onclick=recordAct() id="day'+ 6 + 'time' + i + '"'+'</td>' + '<td onclick=recordAct() id="day'+ 7 + 'time' + i + '"'+'</td>' +  
        '</tr>';
    }
    $('#schedule').append(append_table);
}

function ajax_update(year,month,date){
    month = add_zero_m(month);
    date = add_zero_d(date);
    date = year+'-'+month+'-'+date;
    $.ajax({
        type:'GET',
        url: "receive.php", 
        data:{'date': date,'user':user},
        dataType:'html',
        success: function(data){
            console.log(data);
            $("."+date+'sch').html(data);
    }});
    
    
}
function ajax_update_time(year,month,date,time){
    month = add_zero_m(month);
    date = add_zero_d(date);
    date = year+'-'+month+'-'+date;
    $.ajax({
        type:'GET',
        url: "receive_time.php", 
        data:{'date': date,'time':time,'user':user},
        dataType:'html',
        success: function(data){
            console.log("TIME" + data);
            console.log(date+'-'+time+":00");
            $("."+date+'-'+time).html(data);
    }});
    
    
}
function add_class(){
    month = add_zero_m(thisMonth+1);
    dates = add_zero_d($("#day1").html());
    if($("#day1").html()){
        for(day=1;day<8;day++){
            x = day-1;
            x = parseInt(x) + parseInt(dates);
            //console.log("日期:" + x);
            $("#day"+day).addClass(thisYear + '-' + month + '-' + x);
            $("#day"+day + 'sch').addClass(thisYear + '-' + month + '-' + x + 'sch');
            for(i = 0; i<= 23; i++){
                $("#day"+day + 'time' + i).removeClass();
                $("#day"+day + 'time' + i).addClass(thisYear + '-' + month + '-' + x + '-' + i);
            }
        }
    }else{
        dates = add_zero_d($("#day7").html());
        for(day=7;day>0;day--){
            x = day-7;
            x = parseInt(x) + parseInt(dates);
            console.log("日期:" + x);
            $("#day"+day).addClass(thisYear + '-' + month + '-' + x);
            $("#day"+day + 'sch').addClass(thisYear + '-' + month + '-' + x + 'sch');
            for(i = 0; i<= 23; i++){
                $("#day"+day + 'time' + i).removeClass();
                $("#day"+day + 'time' + i).addClass(thisYear + '-' + month + '-' + x + '-' + i);
            }
        }
    }
    
    
    
    console.log(dates);
    
    
}
function add_zero_m(month){
    switch(month){
        case 1:
            month = '01';
            break;
        case 2:
            month = '02';
            break;
        case 3:
            month = '03';
            break;
        case 4:
            month = '04';
            break;
        case 5:
            month = '05';
            break;
        case 6:
            month = '06';
            break;     
        case 7:
            month = '07';
            break;   
        case 8:
            month = '08';
            break;
        case 9:
            month = '09';
            break;
        default:
            break;
    }
    return month;
}
function add_zero_d(dates){
    switch(dates){
        case 1:
            dates = '1';
            break;
        case 2:
            dates = '2';
            break;
        case 3:
            dates = '3';
            break;
        case 4:
            dates = '4';
            break;
        case 5:
            dates = '5';
            break;
        case 6:
            dates = '6';
            break;     
        case 7:
            dates = '7';
            break;   
        case 8:
            dates = '8';
            break;
        case 9:
            dates = '9';
            break;
        default:
            break;
    }
    return dates;
}


