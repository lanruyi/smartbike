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



<!-- vimjumper ../back_footer.php -->
<?= $this->load->view('newback/back_footer'); ?>

   <script>
      jQuery(document).ready(function() {    
         App.init(); // initlayout and core plugins
         Index.init();
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



