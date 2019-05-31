
function recordAct(){
    console.log("!!!");
    Back=document.getElementById('back'),
    DialogBox=document.getElementById('dialogBox'),
    DialogClose=DialogBox.getElementsByClassName('close')[0];
        
    //打開點到會關掉的DIV
    Back.style.display='block';
    //打開FORM
    DialogBox.style.display='block';
    DialogClose.onclick=function () {
        //關閉DIV
        Back.style.display='none';
        //關閉FORM
        DialogBox.style.display='none';
    }
    Back.onclick=function () {
        //關閉如上
        Back.style.display='none';
        //關閉如上
        DialogBox.style.display='none';
    }
    //console.log(thisMonth,thisYear);
}
function closeform(){
    Back.style.display='none';
    DialogBox.style.display='none';
    loadtext();
}
function loadtext(){

    var startdate = new Date($('#start').val());
    startday = startdate.getDate();
    startmonth = startdate.getMonth() + 1;
    startyear = startdate.getFullYear();
    console.log([startday, startmonth, startyear].join('/'));
    var enddate = new Date($('#end').val());
    endday = enddate.getDate();
    endmonth = enddate.getMonth() + 1;
    endyear = enddate.getFullYear();
    console.log([endday, endmonth, endyear].join('/'));
    for(i=1;i<8;i++){
        x = document.getElementById('day'+i).innerHTML;
        if((thisYear >= startyear && thisMonth+1 >= startmonth && Number(x) >= startday) && (thisYear <= endyear && thisMonth+1 <= endmonth && Number(x) <= endday)){
            console.log("日期內");
            document.getElementsByClassName('day' + i + 'sch').innerHTML = "";
        }else{
            console.log(thisYear,thisMonth,Number(x));
            console.log(startyear,startmonth,startday);
            console.log("沒有在日期內");
        }
    }
    
}

