<div class=base_center>
    <div style="margin:0;width:100%">
        <font>后台 >> <?=$title?></font>
    </div>    
    <form id="filter" method="get" action="">
        <div class='filter'>    
            维护人员:<?= h_make_select(h_array_2_select($users),'author_id',$this->input->get('author_id')); ?>
            项目:<?= h_make_select(h_array_2_select($projects),'project_id',$this->input->get('project_id')); ?>
            城市:<?= h_make_select(h_array_2_select($cities),'city_id',$this->input->get('city_id')); ?>
            开始时间:<input type="text" id="start_time" name="start_time" style="width:80px" value="<?= $this->input->get('start_time') ?>"> 
            结束时间:<input type="text" id="stop_time" name="stop_time" style="width:80px" value="<?= $this->input->get('stop_time') ?>"> 
            每页显示:<input class="input-mini" name="per_page" value="<?= $this->input->get('per_page') ?>" type="text" />
        </div>
        <div class='operate'>
            <a href="javascript:void(0)" id="confirm_s" class="btn btn-primary">确定查询</a> 
            <a href="/backend/blog/alist" class="btn btn-primary">清除查询</a>
            <p style="float:right">
                <a href="javascript:void(0)" id="download_xls" class="btn btn-primary">导出xls</a>
            </p>
        </div>
    </form>
 
    <?= $pagination?>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
            	<th>#</th>
                <th>城市</th>
            	<th>站点名称</th>
            	<th>日志内容</th>
            	<th>创建时间</th>
            	<th>作者</th>
            	<th colspan="2">操作</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach($blogs as $blog){?>
            <tr>
                <td> <?= $blog['id'] ?></td>
                <td> <?= $blog['city_name_chn'] ?></td>
                <td> <a href="/backend/blog/index?station_id=<?=$blog['station_id']?> "  target='_blank'><?= $blog['s_name_chn']?></a></td>
                <td> <a href="/backend/blog/mod_blog/<?= $blog['id'] ?>" style="color:black;">
                	<?php if(mb_strlen($blog['content'])>40){
                				echo mb_substr($blog['content'], 0, 40)."... <全文>";
                			}else{ echo $blog['content']; }
                ?></a></td>
                <td> <?= $blog['create_time']?></td>
                <td> <?= $blog['author_name_chn']?></td>
                <td> <a href="#" onclick="confirm_jumping('确定删除日志','/backend/blog/del_blog/<?= $blog['id'] ?>?backurl=<?= $backurlstr ?>')">删除</a></td>
                <td> <a href="/backend/blog/mod_blog/<?= $blog['id']?>?backurl=<?= $backurlstr ?>">编辑</a></td>
                </tr>
        <?php }?>
        </tbody>
    </table>
    <?= $pagination?>
</div>

<script>
    $(function(){
        $("#project_id").change(function(){
        var obj = $(this);
        $.ajax({
            type: "GET",
            data: "project_id="+obj.val(), 
            url: "/backend/project/ajax_get_cities",
            dateType: "json",                  
            success: function(data){
                var jsondata=eval("("+data+")");
                var str="";
                for(var i=0;i<jsondata.length;i++){
                    str+="<option value="+jsondata[i].id+">"+jsondata[i].name_chn+"</option>";
                }
                $("#city_id").html(str);
            },
            error:function(){
            }
            })
        })
        $('#confirm_s').click(function(){
            document.getElementById('filter').action = "/backend/blog/alist";
            $("#filter").submit();
        })
        
        $("#download_xls").click(function(){
            document.getElementById('filter').action = "/backend/blog/download_xls";
            document.getElementById('filter').submit();
        });
        $('#start_time').datepicker({
            showButtonPanel: true,
            dateFormat: "yy-mm-dd",
            inline: false,
            timezone: '+8000',
            defaultDate: '+0d', 
            onClose:function(datatimeText,instance){
            
            }
        });
        $('#stop_time').datepicker({
            showButtonPanel: true,
            dateFormat: "yy-mm-dd",
            inline: false,
            timezone: '+8000',
            defaultDate: '+0d', 
            onClose:function(datatimeText,instance){
            
            }
        });
    })
</script>