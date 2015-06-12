<!-- vimjumper ../back_header.php -->
<?= $this->load->view('newback/back_header'); ?>

         <!-- BEGIN PAGE HEADER-->
         <div class="row">
            <div class="col-md-12">
               <!-- BEGIN PAGE TITLE & BREADCRUMB-->
               <h3 class="page-title">
                  项目&地区<small></small>
               </h3>
               <ul class="page-breadcrumb breadcrumb">
                  <li>
                     <i class="icon-home"></i>
                     <a href="#">基础数据</a> 
                     <i class="icon-angle-right"></i>
                  </li>
                  <li><a href="/newback/station/slist">项目&地区</a></li>
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



<table class="table2">
    <tr style="background-color:#ccc;font-weight:50">
        <td> 基站总数 </td>
        <td> 在线总数 </td>
        <td> 在线率</td>
    </tr>
    <tr>
        <td> <?= $system['total']?>  </td>
        <td> <?= $system['total_online']?>  </td>
        <td> 
            <?= $system['total']?h_round2($system['total_online']*100/$system['total']):""?>%    
        </td>
    </tr>
</table>

<br />

<table class="table2">
    <tr style="background-color:#ccc;font-weight:50">
        <td> 合同（执行）基站总数 </td>
        <td> 在线总数 </td>
        <td> 在线率</td>
    </tr>
    <tr>
        <td> <?= $contracted['total']?>  </td>
        <td> <?= $contracted['total_online']?>  </td>
        <td> 
            <?= $contracted['total']?h_round2($contracted['total_online']*100/$contracted['total']):""?>%    
        </td>
    </tr>
</table>

<br />

<table class="table2">
    <tr style="background-color:#ccc;font-weight:50">
        <td> 项目名 </td>
        <td> 基站数量 </td>
        <td> 在线基站数 </td>
        <td> 基站在线率 </td>
    </tr>
<? foreach($projects as $project){?>
    <tr>
        <td>
        <?= $project['name_chn']?>    
        </td>
        <td>
        <?= $project['num']?>    
        </td>
        <td>
        <?= $project['online_num']?>    
        </td>
        <td>
        <?= $project['num']?h_round2($project['online_num']*100/$project['num']):""?>%    
        </td>
    </tr>
<?}?>
</table>


























<!-- vimjumper ../back_footer.php -->
<?= $this->load->view('newback/back_footer'); ?>

   <script>
      jQuery(document).ready(function() {    
         App.init(); // initlayout and core plugins
         Index.init();
      });
   </script>
   <!-- END JAVASCRIPTS -->

</body>
<!-- END BODY -->
</html>










