<div class="base_center">
	<form method="post" action="/temp/update_download_size">
	<ul>
		<li>设置下载大小：<input type="text" name="size" value="<?= $download_size ?>"></li>
		<input type="submit" name='submit' value='保存提交' />
	</ul>
    </form>
	<form method="post" action="/temp/update_urtcq">
	<ul>
		<li>需刷的rom_1_id:    <input type="text" name="rom_1_id"    value="<?= $rom_1_id ?>"></li>
		<li>需刷的rom_2_id:    <input type="text" name="rom_2_id"    value="<?= $rom_2_id ?>"></li>
		<li>需刷的station_ids: <input type="text" name="station_ids" value="<?= $station_ids ?>"></li>
		<input type="submit" name='submit' value='保存提交' />
	</ul>
    </form>
</div>
