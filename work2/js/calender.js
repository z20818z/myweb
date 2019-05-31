
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
            s +="<td class='"+i + " ta"+"' onclick=changeWeek("+i+","+jumpToNext+")>"+i+"</td>";
            jumpToNext++;
            if(jumpToNext == 8){
                s +='</tr><tr>';
                jumpToNext = 1;
            }
        }
        cal.innerHTML += s;
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
    
    
}
function setdays(x,y,days){
    for(i=1;i<=7;i++){
        inner = document.getElementById("day"+i);
        inner.innerHTML = "";
        
    }//先把全部變成空白
    for(i=days;i>0;i--){
        if(x > 0){
            //add_class(i,x);
            //inner = document.getElementById("day"+i);
            //inner.innerHTML = x;
            $("#day"+i).html(x);
            //console.log("day"+i,x);
            
            ajax_update(thisYear,thisMonth+1,x);
            x-=1;
        }else{
            x-=1;
            break;
        }
    }
    for(i=days;i<8;i++){
        if(y<=monthDays[thisMonth]){
            //add_class(i,y);
            //inner = document.getElementById("day"+i);
            //inner.innerHTML = y;
            $("#day"+i).html(y);
            ajax_update(thisYear,thisMonth+1,y);
            //console.log("day"+i,y);
            y+=1;
        }else{
            y+=1;
            break;
        }
        
        
    }
    console.log(thisMonth,thisYear);
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
    $('#schedule').append(append_table);
}
function ajax_update(year,month,date){
    month = add_zero_m(month);
    date = add_zero_d(date);
    date = year+'-'+month+'-'+date
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
function add_class(){
    month = add_zero_m(thisMonth+1);
    dates = add_zero_d($("#day1").html());
        for(day=1;day<8;day++){
            //console.log(day);
            x = day-1;
            x = parseInt(x) + parseInt(dates);
            console.log("日期:" + x);
            $("#day"+day).addClass(thisYear + '-' + month + '-' + x);
            $("#day"+day + 'sch').addClass(thisYear + '-' + month + '-' + x + 'sch');
            for(i = 0; i<= 23; i++){
                $("#day"+day + 'time' + i).removeClass();
                $("#day"+day + 'time' + i).addClass(thisYear + '-' + month + '-' + x + '-' + i + ':00');
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
            dates = '01';
            break;
        case 2:
            dates = '02';
            break;
        case 3:
            dates = '03';
            break;
        case 4:
            dates = '04';
            break;
        case 5:
            dates = '05';
            break;
        case 6:
            dates = '06';
            break;     
        case 7:
            dates = '07';
            break;   
        case 8:
            dates = '08';
            break;
        case 9:
            dates = '09';
            break;
        default:
            break;
    }
    return dates;
}


