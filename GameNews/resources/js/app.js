require('./bootstrap');
function ShowMenu(){
    let menu=$("#menu");
    if(menu.is(":visible")) {
        menu.hide();
        $("#header").style.marginLeft="0";
    }
    else
    {
        menu.show();
        $("#header").style.marginLeft=menu.style.height;
    }
}
$("#header_button").on("click",function (){ShowMenu()});
window.addEventListener(`resize`, event => {
    if(window.innerHeight<=screen.height/2){
        $(".Game_Buttons").hide();
    }
    else {
        $(".Game_Buttons").show();
    }
    if (window.innerHeight<=screen.height/5){
        $(".menu_button").hide();
    }
    else {
        $(".menu_button").show();
    }
}, false);
