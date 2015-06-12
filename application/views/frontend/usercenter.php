<style type="text/css">
	.user_center form {margin: 10px;width:30%;float:left;}
        .user_center font{font-weight:bold;font-size:16px;color:#118811;}
</style>


<div class="base_center">

		
	<?php echo form_open('/usercenter/safe?backurl='.$backurlstr);?>
		<? if ($this->session->flashdata('flash_err')){?>
		<div class="alert alert-error"> <?= $this->session->flashdata('flash_err')?> </div>
		<?}?>
		<? if ($this->session->flashdata('flash_succ')){?>
		<div class="alert alert-success"> <?= $this->session->flashdata('flash_succ')?> </div>
		<?}?>	
		<div>
                <ul>安全设置</ul>
		<ul>输入原密码: <input type="password" name="old_password" /></ul>
		<ul>输入新密码: <input type="password" name="new_password1" /></ul>		
		<ul>确认新密码: <input type="password" name="new_password2" /></ul>
		<ul>Email: <input type="text" name="email" value="<?= $user['email']?>"></ul>
		<ul><?php echo form_submit("","保存修改"); ?></ul>
                </div>
	<?php echo form_close(); ?>	
        

</div>