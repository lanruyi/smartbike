<script>

document.onkeydown = function(e){
	if(!e) e=window.event;
	if(e.keyCode==13 || e.which==13){
		document.getElementById("confirm_s").click();
	}
}
$(function(){ $('.filter select[value!=0],.filter input[value!=""]').css({'background-color':'green','color':'white'}); })
</script>

<div class = "base_center">

    <div style="margin:0;width:100%">
    <font>后台 >> 基站列表</font>
    </div>

<form id="filter" method="get" action="">
<div class='filter'>
    搜索站名: <input type="text" name="search" value="<?= $this->input->get('search') ?>" style="width:100px" >
    站点工作模式: <input type="text" name="esgconfs#sys_mode" value="<?= $this->input->get('esgconfs#sys_mode') ?>" style="width:100px" >
</div>
<div class='operate'>
	<a href="javascript:void(0)" id="confirm_s" class="btn btn-primary">确定查询</a> 
        <a href="/backend/station/slist" class="btn btn-primary">清除查询</a>
        
        <p style="float:right">
            <a href="/backend/station/clearStationStatus" class="btn btn-primary" title="有分期的->运营站点 无分期的->新建站点">更新基站状态</a>
            <a href="javascript:void(0)" id="download_xls" class="btn btn-primary">导出xls</a>
            <a href="/backend/station/display_abnormal_station" class="btn btn-primary">显示不正常基站</a>
            <a href="/backend/station/recycle_station_list" class="btn btn-inverse"> <i class="icon-trash icon-white"></i> 回收基站列表 </a>
        </p>
</div>
</form>

</div>



<div class = "base_center">
<form method="post" action="" id="batch_oper_form">  
    <div style="float:right;cursor: pointer;">
        <a onclick="select_all((this),'station_ids[]')" style="margin-right:5px;"> 全选 </a>
        <a onclick="select_none((this),'station_ids[]')" style="margin-right:5px;"> 全不选 </a>
        <a onclick="invert((this),'station_ids[]')" style="margin-right:5px;"> 反选 </a> 
        <input type="submit" onclick="batch_setting()" value="批量设置" />
        <input type="submit" onclick="batch_update_rom()" value="批量更新固件" />
    </div>
<div style="clear:right;"><?= $pagination ?></div>
<?php foreach ($stations as $key=>$station): ?>
    <?$this->load->view("backend/onestation",array('station'=>$station,));?>
<?php endforeach?>
</form>
<div style="clear:left;"><?= $pagination ?></div>

</div>

<script type="text/javascript">
    function batch_setting(){
        document.getElementById('batch_oper_form').action = "/backend/esgconf/batch_setting";
        document.getElementById('batch_oper_form').submit();
    }
    function batch_update_rom(){
        document.getElementById('batch_oper_form').action = 
            "/backend/rom_update/batch_update_rom?backurlstr=<?= $backurlstr?>";
        document.getElementById('batch_oper_form').submit();
    }
    
    function invert(obj,name){
        var checkboxs = document.getElementsByName(name);
        for(var i=0;i<checkboxs.length;i++){
            if(checkboxs[i].checked == true){
                checkboxs[i].checked = false;
            }else{
                checkboxs[i].checked = true;
            }
        }
    }
    function select_all(obj,name){
        var checkboxs = document.getElementsByName(name);
        for(var i=0;i<checkboxs.length;i++){
                checkboxs[i].checked = true;
        }        
    }
    function select_none(obj,name){
        var checkboxs = document.getElementsByName(name);
        for(var i=0;i<checkboxs.length;i++){
                checkboxs[i].checked = false;
        }        
    }  
</script>

<script>
    $(function(){
        $("#download_xls").click(function(){
            document.getElementById('filter').action = "/backend/station/save_csv";
            document.getElementById('filter').submit();
        });
        $("#confirm_s").click(function(){
            document.getElementById('filter').action = "/backend/station/test_join";
            document.getElementById('filter').submit();
        });


        //ajax更新城市->区域
        $("#city_id").change(function(){
            var obj = $(this);
            $.ajax({
                type: "GET",
                data: "city_id="+obj.val(), 
                url: "/backend/area/ajax_get_districts",
                dateType: "json",                  
                success: function(data){
                    var jsondata=eval("("+data+")");
                    var str="";
                    for(var i=0;i<jsondata.length;i++){
                        str+="<option value="+jsondata[i].id+">"+jsondata[i].name_chn+"</option>";
                    }
                    $("#district_id").html(str);
                },
                error:function(){
                }
            })
        })
    });
</script>
