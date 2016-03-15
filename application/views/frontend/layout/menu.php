<?php if(isset($data_index['menu']) && $data_index['menu'] != NULL){ ?>
<div id="menu">
	<ul class="clearfix">
		<?php foreach ($data_index['menu'] as $key_menu => $val_menu) { ?>
			<li><a href="<?php echo base_url();?><?php echo $val_menu['alias'];?>.html" title="<?php echo $val_menu['name'];?>"><?php echo $val_menu['name'];?></a></li>
		<?php } ?>
	</ul>
</div>
<?php } ?>