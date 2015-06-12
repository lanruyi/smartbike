<?if(0){?> <!-- vim:set filetype=phtml: --> <?}?>
<?if(0){?> <!-- vimjumper ../back_header.php --> <?}?>
<?= $this->load->view('newback/back_header'); ?>
         <!-- BEGIN PAGE HEADER-->
         <div class="row">
            <div class="col-md-12">
               <!-- BEGIN PAGE TITLE & BREADCRUMB-->
               <h3 class="page-title">
                  巡检站点列表<small></small>
               </h3>
               <ul class="page-breadcrumb breadcrumb">
                  <li>
                     <i class="icon-home"></i>
                     <a href="#">巡检</a> 
                     <i class="icon-angle-right"></i>
                  </li>
                  <li><a href="/newback/station/slist">巡检站点列表</a></li>
                  <li class="pull-right">
                        <i class="icon-calendar"></i>
                  </li>
               </ul>
               <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
         </div>
         <!-- END PAGE HEADER-->

         <!-- BEGIN OVERVIEW STATISTIC BARS-->
         <div class="row stats-overview-cont">
         </div>
         <!-- END OVERVIEW STATISTIC BARS-->

<div class="row">

</div>




<!-- BEGIN Filter -->
<div class="row">
    <div class="col-xs-12 ">
        <form id="filter" method="get" action="">
            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet tabbable">
                
                <div class="portlet-body">
                    <div class=row style="padding:10px 10px 0 10px">
                        <div class="col-xs-12"> 
                        巡检人员: <input type="text" name="user_name_chn" value="<?= $this->input->get('user_name_chn') ?>"  style="width:100px">
                        
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        上站日期: <input type="text" name="create_start_time" value="<?= $this->input->get('create_start_time') ?>" style="width:100px"> 
                        到                         
                         <input type="text" name="create_stop_time" value="<?= $this->input->get('create_stop_time') ?>" style="width:100px"> 
                        
                        </div>
                         
                    </div>
                
                <div class="portlet-title">
                    <div class="pull-right">
                        <a href="#" id="confirm_s" class="btn btn-info btn-xs"> 确定筛选</a>
                        <a href="#" id="save_filter" class="btn btn-info btn-xs"> 保存筛选 </a>
                        <a href="/newback/inspection/slist" class="btn btn-info btn-xs"> 取消筛选</a>
                        <input type="button" id="filter_button" onclick="display_filter()"  value="显示高级选项" class="btn btn-info btn-xs"/> 
                    </div>
                </div>

                    <div class=row style="padding:10px;display:none" id="advance_filter">
                        <? foreach($inspection_items as $key => $item){?>
                        <? if ( in_array( $item['type'] , array("select","checkbox") ) ){?>
                        <div class="col-xs-2">
                            <?= $item['name']?>
                            <select name="<?= $key?>" class="form-control input-xs">
                                <?= h_make_options($item['options'],$this->input->get($key),"全部");?>
                            </select>
                        </div>
                        <?}?>
                        <?}?>
                    </div>
                </div>
            </div>
            <!-- End Portlet PORTLET-->
        </form>
    </div>
</div>
<!-- END Filter -->



 <div class="row">
         <div class="col-xs-12">

            <div style="padding:4px;"> <?= $pagination?>  <?= $num_str?></div>
            <? foreach($gk_stations as $gk_station){?>
            <table class="table table-bordered table-hover">
                 <tr>
                     <td colspan=10>
                         <a href="?user_id=<?= $gk_station['user_id']?>"><?= $gk_station['user_name']?></a>
                         <font>
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                            <?= h_dt_format($gk_station['datetime'],"Y-m-d H:i:s");?>
                         </font>
                     </td>
                 </tr>
                 <? $i = 0;?>
                 <?foreach($inspection_items as $key => $item){?>
                     <? if($i>14){break;}?>
                     <? if($item['type'] == "img"){continue;}?>
                     <? if($i%5 == 0){?>
                        <tr>
                     <?}?>
                         <td style="width:11%;background-color:#eee"><?=$item['name']?></td>
                         <td style="width:9%">

                            <?if($item['type'] == "text"){?>
                                <?= isset($gk_station[$key])?$gk_station[$key]:"" ?>

                            <?}else if( in_array($item['type'],array("checkbox","select")) ){?>
                                    <? $op_ids = explode(",",isset($gk_station[$key])?
                                    $gk_station[$key]:"")?>
                                <? foreach($op_ids as $op_id){?>
                                    <?= isset($item["options"][$op_id])?$item["options"][$op_id]:""?>
                                <?}?>

                            <?}else if($item['type'] == "img"){?>
                            <?}?>

                         </td>
                     <? if($i%5 == 4){?>
                        </tr>
                     <?}?>
                     <? $i++;?>
                 <?}?>
                 <!-- 这里开始显示图片 -->
                 <tr>
                     <td colspan=10 id="gall">
                        <? $j = 0 ;?>
                         <?foreach($inspection_items as $key => $item){?>
                         <? if($j<8 && $item['type'] == "img"){?>
                                  <? $imgs = explode(",",isset($gk_station[$key])?
                                  $gk_station[$key]:"")?>
                                  <? foreach($imgs as $img){?>
                                      <? if($img){ ?>
                                          <? if ($j>7){break;}?>
                                          <a href="http://pic.semos-cloud.com:9999/static/pics/<?= $img?>"
                                              data-lightbox="group-<?= $gk_station['id']?>" data-title="My caption" >
                                          <img style="margin-right:2px;border:1px solid #333;padding:2px;" 
                                            src="http://pic.semos-cloud.com:9999/static/pics/<?= $img?>" width="100"/>
                                          </a>
                                          <? $j++;?>
                                      <?}?>
                                  <?}?>
                             <?}?>
                         <?}?>
                     </td>
                 </tr>
                 <!-- 显示图片结束 -->
                 <tr>
                     <td colspan=10>
                         <a href="/newback/inspection/single/<?= $gk_station["id"]?>">查看详情</a>
                     </td>
                 </tr>
            </table>
            <?}?>
            <div style="padding:4px;"> <?= $pagination?>  <?= $num_str?></div>

             
         </div>
         </div>

<!-- vimjumper ../back_footer.php -->
<?= $this->load->view('newback/back_footer'); ?>
   <!-- BEGIN PAGE LEVEL PLUGINS -->
   <script src="/static/assets/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>   
   <script src="/static/assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>  
   <script src="/static/assets/plugins/jquery.peity.min.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/jquery-knob/js/jquery.knob.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/flot/jquery.flot.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/flot/jquery.flot.resize.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>     
   <script src="/static/assets/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
   <!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
   <script src="/static/assets/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/jquery.sparkline.min.js" type="text/javascript"></script>  
   <!-- END PAGE LEVEL PLUGINS -->
   <!-- BEGIN PAGE LEVEL SCRIPTS -->
   <script src="/static/assets/scripts/app.js" type="text/javascript"></script>
   <script src="/static/assets/scripts/index.js" type="text/javascript"></script>  
   <script src="/static/lightbox/js/lightbox.js" type="text/javascript"></script>  
   <!-- END PAGE LEVEL SCRIPTS -->  

<script>
jQuery(document).ready(function() {    
    App.init(); // initlayout and core plugins
    Index.init();
});


//提交过滤器表单
$("#confirm_s").click(function(){
    document.getElementById('filter').action = "/newback/inspection/slist";
    document.getElementById('filter').submit();
});

function display_filter(){
    var button_val = document.getElementById("filter_button").value;
    if (button_val === '显示高级选项') {
        document.getElementById("filter_button").value = '隐藏高级选项';
         document.getElementById("advance_filter").style.display="block";
    }
    if (button_val === '隐藏高级选项') {
        document.getElementById("filter_button").value = '显示高级选项';
        document.getElementById("advance_filter").style.display="none";
    }
}

//回车等于提交
document.onkeydown = function(e){
    if(!e) e=window.event;
    if(e.keyCode==13 || e.which==13){
        document.getElementById("confirm_s").click();
    }
}

$(function(){ $('#filter input[value][value!=""]').css({'background-color':'#bdb','border-color':'#363'}); })

    $(function(){ 
        $('#filter select').each(function(){
            if(this.value > 0){
                $(this).css({'background-color':'#bdb','border-color':'#363'});
            }
        })
    });
</script>
   <!-- END JAVASCRIPTS -->

</body>
<!-- END BODY -->
</html>



