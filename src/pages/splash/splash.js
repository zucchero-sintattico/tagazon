/*
$(() => {
    UserManager.start(
        ifLogged = () => {
            window.location.href = './?page=home';
        },
        ifNotLogged = () => {}
    );
})
*/
$(document).ready(() => {
    /* Span Click */
    $("span").click(function (e) {
        e.preventDefault();
        removeAllActiveItem();
        activeItem(this);
        showCorrectPage(this);
    });


});


function activeItem(item){
    $(item).addClass('item-active');
}

function removeAllActiveItem(){
    $("body > main > footer > div span").each(function (index){
        $(this).removeClass('item-active');
    });
}

function showCorrectPage(item){
    $("body > main > footer > div span").each(function (index){
        if($(this).is(item)){
            $("#" + index).removeClass('page-hide');
        }else{
            $("#" + index).addClass('page-hide');
        }
    });
}