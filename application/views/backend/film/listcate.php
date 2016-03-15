<option value="">Chọn thể loại</option>
<?php if(isset($cate) && !is_null($cate)){ ?>
<?php foreach ($cate as $key_cate => $val_cate) { ?>
    <option value="<?php echo $val_cate['id'];?>"><?php echo $val_cate['name'];?></option>
<?php } ?>
<?php } ?>