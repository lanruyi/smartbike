<style>
    .title{margin-bottom:20px;padding:20px 20px 0px 20px;font-size:20px;}
    .body{padding:10px 30px 30px 0px}
    .mod{margin-bottom:10px;padding:0px 0px 0px 20px}
</style>

<div class="base_center">

    <div class="title">
    <?=$title?>
    </div>
    <?php 
    $attributes = array("class"=>"add_batch");

    if($mod){
        $hidden = array('id' => $batch['id']);
        echo form_open("/backend/batch/update_batch?backurl=".urlencode($this->input->get('backurl')),$attributes,$hidden); 
    }else{
        echo form_open("/backend/batch/insert_batch?backurl=".urlencode($this->input->get('backurl')),$attributes); 
    ?>
    <?}?>

        <div class="body">
            <?php if($mod){?>
                 <ul>ID: <input readonly='readonly' type="text" name="id" value="<?= $mod? $batch['id']:"" ?>" /> </ul>
            <?php }?>
        <ul>
            合同号: 
            <?= h_make_select(h_array_2_select($contracts),'contract_id',($mod)?$batch['contract_id']:0,"--请选择--","150px"); ?><span style="color:green;margin-left:10px;" id="project"><?= $mod?$project_name_chn:""?></span> 
        </ul>
        <ul>
            城市: 
            <?= h_make_select(h_array_2_select($cities),'city_id',($mod)?$batch['city_id']:0,"--请选择--","150px"); ?>
        </ul>
        <ul>
            开始时间：
            <input class="es_day" id="start_time" name='start_time' type="text"  style="width:68px; height:16px" value="<?=$mod? $batch['start_time']:""?>" />
        </ul>
        <ul>
            总收款时间（月）：
            <input type="text" name="total_month" value="<?= $mod? $batch['total_month']:"" ?>">
        </ul>
        <?php if($mod){?>
            <ul>
                上次收款时间：
                <input type="text" name="current_time" value="<?= $mod? $batch['current_time']:"" ?>">
            </ul> 
        <?}?>
                     
         <ul><?php echo form_submit("","提交"); ?> </ul>
    
    <?php echo form_close(); ?>
    </div>
</div>

<script>
    $(function(){
        $("#contract_id").change(function(){
            var obj = $(this);
            $.ajax({
                type: "GET",
                data: "contract_id="+obj.val(), 
                url: "/backend/contract/ajax_get_cities",
                dateType: "json",                  
                success: function(data){
                    var jsondata=eval("("+data+")");
                    var str="";
                    for(var i=0;i<jsondata.length;i++){
                        if(i==0){
                            $("#project").html(jsondata[i].name_chn);
                            continue;
                        }
                        str+="<option value="+jsondata[i].id+">"+jsondata[i].name_chn+"</option>";
                    }
                    $("#city_id").html(str);
                },
                error:function(){
                }
            })

        })

        $('#start_time').datepicker({
            showButtonPanel: true,
            dateFormat: "yy-mm-1",
            inline: false,
            timezone: '+8000',
            defaultDate: '+7d', 
            onClose:function(datatimeText,instance){
            
            }
        });

    })
</script>
