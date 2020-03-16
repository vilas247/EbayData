$(function() {
    var $items = $('#vtab>ul>li');
    $items.mouseover(function() {
        $items.removeClass('selected');
        $(this).addClass('selected');

        var index = $items.index($(this));
        $('#vtab>div').hide().eq(index).show();
    }).eq(1).mouseover();

    $(".collapsed-header-1").click(function() {
        $(".in-collapsed-1").slideToggle("fast");
        if ($(".collapsed-header-1").find("em").attr('class') == 'fa fa-caret-up') {
            $(".collapsed-header-1").find("em").removeClass();
            $(".collapsed-header-1").find("em").addClass('fa fa-caret-down');
        } else if ($(".collapsed-header-1").find("em").attr('class') == 'fa fa-caret-down') {
            $(".collapsed-header-1").find("em").removeClass();
            $(".collapsed-header-1").find("em").addClass('fa fa-caret-up');
        }
        return false;
    });
    $(".collapsed-header-2").click(function() {
        $(".in-collapsed-2").slideToggle("fast");
        if ($(".collapsed-header-2").find("em").attr('class') == 'fa fa-caret-up') {
            $(".collapsed-header-2").find("em").removeClass();
            $(".collapsed-header-2").find("em").addClass('fa fa-caret-down');
        } else if ($(".collapsed-header-2").find("em").attr('class') == 'fa fa-caret-down') {
            $(".collapsed-header-2").find("em").removeClass();
            $(".collapsed-header-2").find("em").addClass('fa fa-caret-up');
        }

        return false;
    });
    $(".collapsed-header-3").click(function() {
        $(".in-collapsed-3").slideToggle("fast");
        if ($(".collapsed-header-3").find("em").attr('class') == 'fa fa-caret-up') {
            $(".collapsed-header-3").find("em").removeClass();
            $(".collapsed-header-3").find("em").addClass('fa fa-caret-down');
        } else if ($(".collapsed-header-3").find("em").attr('class') == 'fa fa-caret-down') {
            $(".collapsed-header-3").find("em").removeClass();
            $(".collapsed-header-3").find("em").addClass('fa fa-caret-up');
        }
        return false;
    });
    $(".collapsed-header-4").click(function() {
        $(".in-collapsed-4").slideToggle("fast");
        if ($(".collapsed-header-4").find("em").attr('class') == 'fa fa-caret-up') {
            $(".collapsed-header-4").find("em").removeClass();
            $(".collapsed-header-4").find("em").addClass('fa fa-caret-down');
        } else if ($(".collapsed-header-4").find("em").attr('class') == 'fa fa-caret-down') {
            $(".collapsed-header-4").find("em").removeClass();
            $(".collapsed-header-4").find("em").addClass('fa fa-caret-up');
        }
        return false;
    });
    $(".collapsed-header-5").click(function() {
        $(".in-collapsed-5").slideToggle("fast");
        if ($(".collapsed-header-5").find("em").attr('class') == 'fa fa-caret-up') {
            $(".collapsed-header-5").find("em").removeClass();
            $(".collapsed-header-5").find("em").addClass('fa fa-caret-down');
        } else if ($(".collapsed-header-5").find("em").attr('class') == 'fa fa-caret-down') {
            $(".collapsed-header-5").find("em").removeClass();
            $(".collapsed-header-5").find("em").addClass('fa fa-caret-up');
        }
        return false;
    });
    $(".collapsed-header-6").click(function() {
        $(".in-collapsed-6").slideToggle("fast");
        if ($(".collapsed-header-6").find("em").attr('class') == 'fa fa-caret-up') {
            $(".collapsed-header-6").find("em").removeClass();
            $(".collapsed-header-6").find("em").addClass('fa fa-caret-down');
        } else if ($(".collapsed-header-6").find("em").attr('class') == 'fa fa-caret-down') {
            $(".collapsed-header-6").find("em").removeClass();
            $(".collapsed-header-6").find("em").addClass('fa fa-caret-up');
        }
        return false;
    });
    $(".collapsed-header-7").click(function() {
        $(".in-collapsed-7").slideToggle("fast");
        if ($(".collapsed-header-7").find("em").attr('class') == 'fa fa-caret-up') {
            $(".collapsed-header-7").find("em").removeClass();
            $(".collapsed-header-7").find("em").addClass('fa fa-caret-down');
        } else if ($(".collapsed-header-7").find("em").attr('class') == 'fa fa-caret-down') {
            $(".collapsed-header-7").find("em").removeClass();
            $(".collapsed-header-7").find("em").addClass('fa fa-caret-up');
        }
        return false;
    });
    $(".dashboard_li").click(function() {
        $('.dashboard_div').removeClass('inactive').addClass('active');
        $('.dashboard_li').removeClass('inactive').addClass('active');
        $('.services_div').removeClass('active').addClass('inactive');
        $('.services_li').removeClass('active').addClass('inactive');
    });
    $(".services_li").click(function() {
        $('.dashboard_div').removeClass('active').addClass('inactive');
        $('.dashboard_li').removeClass('active').addClass('inactive');
        $('.services_div').removeClass('inactive').addClass('active');
        $('.services_li').removeClass('inactive').addClass('active');
    });
});