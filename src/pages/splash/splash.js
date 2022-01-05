$(document).ready(() => {
    /* Span Click */
    $("span").click(function(e) {
        e.preventDefault();
        removeAllActiveItem();
        activeItem(this);
        showCorrectPage(this);
    });

    setInterval(nextSlide, 5000);

});

function nextSlide() {
    const actual = $("span.item-active");
    let next = actual.next();
    if (next.length == 0) {
        next = $("span").first();
    }
    actual.removeClass('item-active');
    next.addClass('item-active');
    showCorrectPage(next);
}

function activeItem(item) {
    $(item).addClass('item-active');
}

function removeAllActiveItem() {
    $("body > main > footer > div span").each(function(index) {
        $(this).removeClass('item-active');
    });
}

function showCorrectPage(item) {
    $("body > main > footer > div span").each(function(index) {
        if ($(this).is(item)) {
            $("#" + index).removeClass('page-hide');
        } else {
            $("#" + index).addClass('page-hide');
        }
    });
}