<style>
    .command{ background-color:#507AAA;word-spacing:10px;color:white;line-height:30px;padding:30px 20px 20px 20px;margin:20px 30px 0px 0px} 
    .title{font-size:25px;padding:30px 30px 30px 0px}
</style>
<div class="base_center">
    <span class="title">
        新增命令
    </span>


    <form action='/backend/command/insert_command'>
        <input type='hidden' name='station_id' value='<?= $this->input->get('station_id')?>'>
        <input type='hidden' name='backurl' value='<?= urlencode($this->input->get('backurl'))?>'>

        <div class="command">
             命令类型:<?= h_command_type_select($this->input->get('command')) ?>
             参数:<input type="text" name="params" value="">
         </div>

            <div style="padding:20px 30px 20px 0px">
            <button type="submit" class="btn btn-primary">确定执行</button> 
            <a href="/backend/command?station_id=<?= $this->input->get('station_id')?>" class="btn btn-primary">取消执行</a>
        </div>
    </form>
    
</div>
