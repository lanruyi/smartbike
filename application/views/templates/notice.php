<? if ($this->session->flashdata('flash_err')){?>
<div class="container-fluid">
<div class="alert alert-error"> <?= "<b>错误!</b> ".$this->session->flashdata('flash_err')?> </div>
</div>
<?}?>
<? if ($this->session->flashdata('flash_succ')){?>
<div class="container-fluid">
<div class="alert alert-success"> <?= "<b>干得好!</b> ".$this->session->flashdata('flash_succ')?> </div>
</div>
<?}?>
