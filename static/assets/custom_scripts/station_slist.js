/**
 **/
var StationSlist= function () {

    var display_tab="";
    var filter_tab="";



    //记录当前tab 并再再次开启时还原
    var tab_change_init = function(){
        display_tab = $.cookie('display_tab');
        filter_tab  = $.cookie('filter_tab')
            $("#display_tabs a[href='"+display_tab+"']").click();
        $("#display_tabs").on('click',"a",function(e){
            display_tab = $(this).attr("href");
            $.cookie('display_tab',display_tab,{expires: 7,path:'/newback/station/slist'});
        });
        $("#filter_tabs a[href='"+filter_tab+"']").click();
        $("#filter_tabs").on('click',"a",function(e){
            filter_tab = $(this).attr("href");
            $.cookie('filter_tab',filter_tab,{expires: 7,path:'/newback/station/slist'});
        });
    }

    var common_init = function(){
        //回车等于提交
        document.onkeydown = function(e){
            if(!e) e=window.event; if(e.keyCode==13 || e.which==13){ document.getElementById("confirm_s").click();}
        }
        //提交过滤器表单
        $("#confirm_s").click(function(){
            document.getElementById('filter').action = "/newback/station/slist";
            document.getElementById('filter').submit();
        });
        //改变选中的input和select的颜色
        $('#filter input[value][value!=""]').css({'background-color':'#bdb','border-color':'#363'});
        $('#filter select').each(function(){
            if(this.value > 0){$(this).css({'background-color':'#bdb','border-color':'#363'});}
        });
    }

    //var layoutColorCodes = {
    //'blue': '#4b8df8',
    //'red': '#e02222',
    //};

    //var _getViewPort = function () {
    //return {
    //width: e[a + 'Width'],
    //height: e[a + 'Height']
    //}
    //}

    return {
        //main function to initiate the theme
        init: function () {
                  tab_change_init();
                  common_init();

                  $("#all_check").change(function(){
                      if($(this).attr("checked")){
                          $("input[name='station_ids[]']").attr('checked',true);
                          $("input[name='station_ids[]']").parent().addClass('checked');
                      }else{
                          $("input[name='station_ids[]']").attr('checked',false);
                          $("input[name='station_ids[]']").parent().removeClass('checked');
                      }
                  });


                  $("#mulit_rom_update").click(function(){
                      if($("input[name='station_ids[]']:checked").size()==0){
                          alert("请选择站点");
                          return;
                      }
                      $("#modal_rom_update").modal("show");
                      $.ajax({
                          type: "POST",
                          cache: true,
                          url: "/ajax/rom/mulit",
                          data: $("input[name='station_ids[]']").serialize(),
                          dataType: "html",
                          success: function (res) {
                              App.fixContentHeight(); // fix content height
                              App.initAjax(); // initialize core stuff
                              $("#modal_rom_update").html(res);
                          },
                          error: function (xhr, ajaxOptions, thrownError) { },
                          async: true 
                      });
                  });

                  $("#mulit_setting").click(function(){
                      if($("input[name='station_ids[]']:checked").size()==0){
                          alert("请选择站点");
                          return;
                      }
                      $("#modal_setting").modal("show");
                      $.ajax({
                          type: "POST",
                          cache: true,
                          url: "/ajax/esgconf/mulit",
                          data: $("input[name='station_ids[]']").serialize(),
                          dataType: "html",
                          success: function (res) {
                              App.fixContentHeight(); // fix content height
                              App.initAjax(); // initialize core stuff
                              $("#modal_setting").html(res);
                          },
                          error: function (xhr, ajaxOptions, thrownError) { },
                          async: true 
                      });
                  });

                  $("#mulit_station_update").click(function(){
                      if($("input[name='station_ids[]']:checked").size()==0){
                          alert("请选择站点");
                          return;
                      }
                      $("#modal_station_update").modal("show");
                      $.ajax({
                          type: "POST",
                          cache: true,
                          url: "/ajax/station/mulit",
                          data: $("input[name='station_ids[]']").serialize(),
                          dataType: "html",
                          success: function (res) {
                              App.fixContentHeight(); // fix content height
                              App.initAjax(); // initialize core stuff
                              $("#modal_station_update").html(res);
                          },
                          error: function (xhr, ajaxOptions, thrownError) { },
                          async: true 
                      });
                  });

              }
    };

}();
