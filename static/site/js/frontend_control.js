$(function(){   
    //关闭   
    $(".ad_on").live("click",function(){   
        var add_on = $(this);   
        var status_id = $(this).attr("rel");   
        add_on.removeClass("ad_on").addClass("ad_off").attr("title","点击开启");   
    });   
    //开启   
    $(".ad_off").live("click",function(){   
        var add_off = $(this);   
        var status_id = $(this).attr("rel");   
        add_off.removeClass("ad_off").addClass("ad_on").attr("title","点击关闭");   
    });   
});  
