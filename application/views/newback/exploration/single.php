<?if(0){?> <!-- vim:set filetype=phtml: --> <?}?>
<?if(0){?> <!-- vimjumper ../back_header.php --> <?}?>
<?= $this->load->view('newback/back_header'); ?>

         <!-- BEGIN PAGE HEADER-->
         <div class="row">
            <div class="col-md-12">
               <!-- BEGIN PAGE TITLE & BREADCRUMB-->
               <h3 class="page-title">
                  工勘单个站点<small></small>
               </h3>
               <ul class="page-breadcrumb breadcrumb">
                  <li>
                     <i class="icon-home"></i>
                     <a href="#">工勘</a> 
                     <i class="icon-angle-right"></i>
                  </li>
                  <li><a href="/newback/exploration/slist">工勘站点列表</a></li>
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



 <div class="row">
         <div class="col-xs-12">

            <table class="table table-bordered table-hover">
                 <tr>
                     <td colspan=10>
                         <?= $gk_station['user_name']?>
                     </td>
                 </tr>
                 <? $i = 0;?>
                 <?foreach($exploration_items as $key => $item){?>
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
                     <td colspan=10>
                         <?foreach($exploration_items as $key => $item){?>
                         <? if($item['type'] == "img"){?>
                                  <? $imgs = explode(",",isset($gk_station[$key])?$gk_station[$key]:"")?>
                                      <tr>
                                          <td colspan=10 style="background-color:#eee">
                                                <?= $item['name']?>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan=10>
                                      <? foreach($imgs as $img){?>
                                          <? if($img){ ?>
                                              <a href="http://pic.semos-cloud.com:9999/static/pics/<?= $img?>"
                                                  data-lightbox="same" data-title="My caption" >
                                                  <img style="margin-right:2px;border:1px solid #333;padding:2px;" 
                                                    src="http://pic.semos-cloud.com:9999/static/pics/<?= $img?>" width="100"/>
                                                </a>
                                          <?}?>
                                      <?}?>
                                          </td>
                                      </tr>
                             <?}?>
                         <?}?>
                     </td>
                 </tr>
                 <!-- 显示图片结束 -->
            </table>

             
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
            document.getElementById('filter').action = "/newback/exploration/slist";
            document.getElementById('filter').submit();
        });

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



