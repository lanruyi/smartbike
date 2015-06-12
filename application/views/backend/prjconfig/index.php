<style type="text/css">
.projects_config{width:450px;}
.projects_config input{width:100px;}
#alerts{width:400px;}
</style>


<div class="base_center">
    <?php echo form_open("/backend/prjconfig/update_cfg"); ?>
    <table class="table projects_config">
    <thead>
        <tr><th>项目</th><th>站内报警温度(℃)[有恒温柜]</th><th>站内报警温度(℃)[无恒温柜]</th><th>恒温柜报警温度(℃)</th></tr>
    </thead>
    <tbody>
        <?php foreach ($projects as $project){ ?>
        <tr>
            <td><?= $project['name_chn']?></td>
            <td><input type="text" name=<?= "highest_indoor_tmp_".$project['id']?> 
                value="<?= $configs[$project['id']]['highest_indoor_tmp']?>" /></td>
            <td><input type="text" name=<?= "no_box_highest_indoor_tmp_".$project['id']?> 
                value="<?= $configs[$project['id']]['no_box_highest_indoor_tmp']?>" /></td>
            <td><input type="text" name=<?= "highest_box_tmp_".$project['id']?> 
                value="<?= $configs[$project['id']]['highest_box_tmp']?>" /></td>
        </tr>
        <? }?>
    </tbody>
    </table>
    <ul id="config_save">
        <?php echo form_submit("", "保存"); ?> 
        <input type="button" value="重置" onclick="window.location='/backend/prjconfig/reset_cfg'" />
    </ul>
    <?php echo form_close(); ?>
    <ul id="alerts">
        <? if ($this->session->flashdata('flash_update')) { ?>
            <p class="alert alert-success"> <?= $this->session->flashdata('flash_update') ?> </p>
        <? } ?>
        <? if ($this->session->flashdata('flash_reset')) { ?>
            <p class="alert"> <?= $this->session->flashdata('flash_reset') ?> </p>
        <? } ?>
    </ul>
</div>

