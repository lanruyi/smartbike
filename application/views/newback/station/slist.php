<?if(0){?> <!-- vim:set filetype=phtml: --> <?}?>
<?if(0){?> <!-- vimjumper ../back_header.php --> <?}?>
<?= $this->load->view('newback/back_header'); ?>


<!-- BEGIN Filter -->
<div class="row">
    <div class="col-xs-12 ">
        <form id="filter" method="get" action="">
            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet tabbable">
                <div class="portlet-title">
                    <div class="caption"><i class="icon-filter"></i></div>
                </div>
                <div class="portlet-body">
                    <div class="tabbable portlet-tabs">
                        <ul class="nav nav-tabs" id="filter_tabs">
                            <li><a href="#portlet_tab4" data-toggle="tab">导出项设置</a></li>
                            <li><a href="#portlet_tab3" data-toggle="tab">数据完整性筛选</a></li>
                            <li><a href="#portlet_tab2" data-toggle="tab">设置筛选</a></li>
                            <li class="active"><a href="#portlet_tab1" data-toggle="tab">基本筛选器</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="portlet_tab1">
                                <div class="row">
                                    <div class="col-xs-1 col-2-9">
                                        <input type="text" name="search" value="<?= $this->input->get('search') ?>" 
                                        class="form-control input-xs" placeholder="搜索基站名 / ESG_ID" >
                                    </div>
                                    <div class="col-xs-2 col-1-9">
                                        <input type="text" name="create_start_time" value="<?= $this->input->get('create_start_time') ?>"
                                        class="form-control input-xs" placeholder="建站开始时间"> 
                                    </div>
                                    <div class="col-xs-2 col-1-9">
                                        <input type="text" name="create_stop_time" value="<?= $this->input->get('create_stop_time') ?>"
                                        class="form-control input-xs" placeholder="建站结束时间"> 
                                    </div>
                                </div>
                                <div class="row" style="margin-top:8px">
                                    <div class="col-xs-1 col-1-9">
                                        <select name="stations#station_type" class="form-control input-xs">
                                            <?= h_make_options(h_station_station_type_array(),$this->input->get('stations#station_type'),"全基站类型");?>
                                        </select>
                                    </div>
                                    <div class="col-xs-1 col-1-9">
                                        <select name="stations#project_id" class="form-control input-xs">
                                            <?= h_make_options(h_array_2_select($projects),$this->input->get('stations#project_id'),"全项目"); ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-1 col-1-9" >
                                        <select name="stations#city_id" class="form-control input-xs ">
                                            <?= h_make_options(h_array_2_select($cities),$this->input->get('stations#city_id'),"全城市"); ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-1 col-1-9" >
                                        <select name="stations#district_id" class="form-control input-xs ">
                                            <?= h_make_options(h_array_2_select($districts),$this->input->get('stations#district_id'),"全区县"); ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-1 col-1-9" >
                                        <select name="stations#total_load" class="form-control input-xs">
                                            <?= h_make_options(h_station_total_load_array(),$this->input->get('stations#total_load'),"全部档位"); ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-1 col-1-9" >
                                        <select name="stations#building" class="form-control input-xs">
                                            <?= h_make_options(h_station_building_array(),$this->input->get('stations#building'),"全部建筑"); ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-1 col-1-9" >
                                        <select name="stations#colds_num" class="form-control input-xs ">
                                            <?= h_make_options(array("1"=>"1台","2"=>"2台"),$this->input->get('stations#colds_num'),"空调数"); ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-1 col-1-9" >
                                        <select name="stations#status" class="form-control input-xs ">
                                            <?= h_make_options(h_station_status_array(),$this->input->get('stations#status'),"基站状态"); ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-1 col-1-9" >
                                        <select name="stations#alive" class="form-control input-xs ">
                                            <?= h_make_options(h_alive_array(),$this->input->get('stations#alive'),"在线/离线");?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" style="margin-top:8px">
                                    <div class="col-xs-1 col-1-9" >
                                        <select name="stations#frontend_visible" class="form-control input-xs ">
                                            <?= h_make_options(h_station_frontend_visible_array(), $this->input->get('stations#frontend_visible'),"隐藏/可见") ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-1 col-1-9" >
                                        <select name="stations#rom_id" class="form-control input-xs ">
                                            <?= h_make_options(h_array_2_select($roms,"version"), $this->input->get('stations#rom_id'),"全固件") ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-1 col-1-9" >
                                        <select name="stations#have_box" class="form-control input-xs ">
                                            <?= h_make_options(h_station_have_box_array(), $this->input->get('stations#have_box'),"有无恒温柜") ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-1 col-1-9" >
                                        <select name="stations#batch_id" class="form-control input-xs ">
                                            <?= h_make_options(h_array_2_select($batches),$this->input->get('stations#batch_id'),"所有分期"); ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-1 col-1-9" >
                                        <select name="stations#creator_id" class="form-control input-xs has-success">
                                            <?= h_make_options(h_array_2_select($creators),$this->input->get('stations#creator_id'),"所有督导"); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="portlet_tab2">
                                <div class="row">
                                    <div class="col-xs-2">
                                        s17.系统模式: 
                                        <input type="text" name="esgconfs#sys_mode" 
                                        class="form-control" placeholder="1/2/3/10"
                                        value="<?= $this->input->get('esgconfs#sys_mode') ?>">
                                    </div>
                                    <div class="col-xs-2">
                                        s18.简单控制: 
                                        <input type="text" name="esgconfs#simple_control" 
                                        class="form-control" placeholder="1/2/3"
                                        value="<?= $this->input->get('esgconfs#simple_control') ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="portlet_tab3">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions" style="margin-top:0px;padding:4px 10px;">
                        <div class="pull-right">
                            <a href="#" id="confirm_s" class="btn btn-info btn-xs"> 确定筛选</a>
                            <a href="/newback/station/slist" class="btn btn-info btn-xs"> 取消筛选</a>
                            <div class="btn-group">
                                <a class="btn btn-xs btn-info dropdown-toggle" href="#" data-toggle="dropdown">
                                    导出
                                    <i class="icon-angle-down "></i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="#"><i class="icon-pencil"></i> 打印</a></li>
                                    <li><a href="#"><i class="icon-pencil"></i> 导出 XML </a></li>
                                    <li><a href="#"><i class="icon-pencil"></i> 导出 Excel</a></li>
                                    <li><a href="#"><i class="icon-pencil"></i> 导出 PDF </a></li>
                                    <li class="divider"></li>
                                    <li><a href="#"><i class="icon-pencil"></i> 其他 </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Portlet PORTLET-->
        </form>
    </div>
</div>
<!-- END Filter -->


<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-xs-12">
        <div class="tabbable tabbable-custom boxless ">
            <ul class="nav nav-tabs" id="display_tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">基本信息</a></li>
                <li class=""><a href="#2" data-toggle="tab">设备信息</a></li>
                <li class=""><a href="#addr" data-toggle="tab">位置/备注</a></li>
                <li class=""><a href="#3" data-toggle="tab">数据</a></li>
                <li class=""><a href="#4" data-toggle="tab">设置</a></li>
                <li class=""><a href="#5" data-toggle="tab">当前故障</a></li>
                <li class=""><a href="#6" data-toggle="tab">远程升级</a></li>
                <li class=""><a href="#8" data-toggle="tab">自定义列</a></li>
            </ul>
            <div class="tab-content" style="padding:0px">
                <form action="" method="post">
                    <div class="row" style="border-bottom:1px solid #bbb;padding:16px 23px;height:45px;">
                        <a href="javascript:;"  id="mulit_setting">
                            <i class="icon-tasks"></i>
                            &nbsp;  
                            批量设置
                        </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;  
                        <a href="javascript:;" id="mulit_rom_update">
                            <i class="icon-tasks"></i>
                            &nbsp;  
                            批量升级
                        </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;  
                        <a href="javascript:;" id="mulit_station_update">
                            <i class="icon-tasks"></i>
                            &nbsp;  
                            批量修改基站
                        </a>
                        <div class="pull-right"><?= $pagination?> &nbsp;<?= $num_str?></div>
                    </div>
                    <table class="table table-striped table-condensed flip-content" style="font-size:13px;margin:0px">
                        <thead>
                            <tr style="background-color:#ccc">
                                <th style="width:18px">
                                    <input type="checkbox" id="all_check"/>
                                </th>
                                <th style="width:40px"></th>
                                <th style="">基站</th>
                                <th>ESG</th>
                                <th>项目</th>
                                <th>城市</th>
                                <th>建筑</th>
                                <th>档位</th>
                                <th>负载</th>
                                <th style="width:188px;">合同分期</th>
                                <th>状态</th>
                            </tr>
                        </thead>
                        <tbody>
                        <? foreach($stations as $station){?>
                        <tr class="odd gradeX">
                            <td>
                                <input type="checkbox" name="station_ids[]" value="<?= $station['id']?>" />
                            </td>
                            <td>
                                <div class="task-config">
                                    <div class="task-config-btn btn-group">
                                        <a class="btn btn-xs btn-default dropdown-toggle" href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                            <i class="icon-cog"></i>&nbsp;<i class="icon-angle-down"></i></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#"><i class="icon-ok"></i> 重启 </a></li>
                                            <li><a href="#"><i class="icon-pencil"></i> 远程开 </a></li>
                                            <li><a href="#"><i class="icon-trash"></i> 删除 </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <img src=<?= h_online_gif_new($station['alive'])?> />
                                <a href="/newback/station/single/<?= $station['id']?>"><?= $station['name_chn']?></a>
                                <? if(count($station['bugs'])){?>
                                <!-- todo: 还有warning 和 info -->
                                <span class="badge badge-danger pull-right"><?= count($station['bugs'])?></span>
                                <?}?>
                            </td>
                            <td><?= $station['esg']['id']?></td>
                            <td><?= $station['project']['name_chn']?></td>
                            <td><?= $station['city']['name_chn']?></td>
                            <td><?= h_station_building_name_chn($station['building'])?></td>
                            <td><?= h_station_total_load_name_chn($station['total_load'])?></td>
                            <td><?= $station['load_num']?></td>
                            <td><?= $station['batch']?$station['batch']['name_chn']:"无"?></td>
                            <td >
                                <span class="label label-sm label-success">运营</span>
                            </td>
                        </tr>
                        <?}?>
                        </tbody>
                    </table>
                    <div class="row" style="border-top:1px solid #bbb;padding:5px 36px;height:35px;">
                        <div class="col-xs-6">
                        </div>
                        <div class="col-xs-6">
                        </div>
                    </div>
                    <div class="modal fade" id="modal_setting" tabindex="-1" role="basic" aria-hidden="true">
                       <img src="/static/assets/img/ajax-modal-loading.gif" alt="" class="loading">
                    </div>
                    <div class="modal fade" id="modal_rom_update" tabindex="-1" role="basic" aria-hidden="true">
                       <img src="/static/assets/img/ajax-modal-loading.gif" alt="" class="loading">
                    </div>
                    <div class="modal fade" id="modal_station_update" tabindex="-1" role="basic" aria-hidden="true">
                       <img src="/static/assets/img/ajax-modal-loading.gif" alt="" class="loading">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT-->


<!-- vimjumper ../back_footer.php -->
<?= $this->load->view('newback/back_footer'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<!--
<script src="/static/assets/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
-->
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/static/assets/scripts/app.js" type="text/javascript"></script>
<!-- vimjumper ../../../../static/assets/custom_scripts/station_slist.js -->
<script src="/static/assets/custom_scripts/station_slist.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->  
<script>

$(function() {    
    App.init(); // initlayout and core plugins
    StationSlist.init();
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



