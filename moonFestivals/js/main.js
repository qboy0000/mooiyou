

$('.btnSubF').click(function(){
    $('.slideWrap').show();
})


function showMoon(){
    setTimeout(function(){
        $('.moonCon').show();
        
    },5000)
    setTimeout(function(){
        $('.moonMove').show();
    },6000);
}

var dragIco = document.getElementById('dragIcon'),
    icoL = 0;
function setBtn(num){
    oNum = (Math.floor(1000-num)*0.8)/1000;
    greyW = num-67;
    icoL = icoL+Math.floor(Number(num)/50);
    
    $('.btnClose').css({'left':icoL});
    //$('.slideCon,.btnClose img').css({'opacity':oNum});
    $('.closeCon').css({'opacity':oNum});
    //$('.slideCon').css({'opacity':oNum});
       
}

