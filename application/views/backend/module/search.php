<?php if(isset($module) && $module!=NULL){ ?>
<?php foreach($module as $key => $val){ ?>
<tr> 
  <td class="div_center"><input type="checkbox" name="chon" class="checkbox-menu" value="<?php echo $val['id']?>"></td>
  <td><a href="admin/module/edit/<?php echo $val['id']?>"><?php echo $val['name'];?></a></td>
  <td>
      <div class="col-xs-12">
      <div></div>
      <div class="form-group" style="margin-bottom:0px;">
          <select class="form-control select2 select-search parentid" control="module" seq="<?php echo $val['id']?>" name="parentid" id="parentid" style="width: 100%;" tabindex="-1" aria-hidden="true">
            <option value="0">Gốc</option>
            <?php if(isset($module) && !is_null($module)){ ?>
            <?php foreach ($module as $key_module => $val_module) { ?>
                  <option value="<?php echo $val_module['id'];?>" <?php if($val_module['id'] == $val['parentid']){ ?> selected <?php } ?>><?php echo $val_module['name'];?></option>
            <?php } ?>
            <?php } ?>
          </select>
      </div></div>
  </td>
  <td><?php echo $val['created'];?></td>
  <td class="div_center"><input class="sort div_center" name="sort" control="module" value="<?php echo isset($val['sort'])?$val['sort']:'';?>" id="sort" size="5" seq="<?php echo $val['id']?>"></td>
  <td class="div_center publish"><a control="module" title="Hiển thị" class="div_hienthi<?php echo $val['id']?> div_hienthi" divid="div_hienthi<?php echo $val['id']?>" seq="<?php echo $val['id']?>">
    <?php if($val['publish'] == 0){ ?>
      <i class="fa fa-check-circle"></i>
    <?php }else{ ?>
      <i class="fa fa-circle"></i>
    <?php } ?></a>
  </td>
  <td class="div_center tool">
    <a href="admin/module/edit/<?php echo $val['id']?>"><i class="fa fa-edit"></i></a>
    <a class="delete" seq="<?php echo $val['id']?>" control="module"><i class="fa fa-trash"></i></a>
    
  </td>
</tr>
    <?php if(isset($val['module_child']) && !is_null($val['module_child'])){ ?>
        <?php foreach ($val['module_child'] as $key_child => $val_child) { ?>
            <tr>
              <td class="div_center"><input type="checkbox" name="chon" class="checkbox-menu" value="<?php echo $val_child['id']?>"></td>
              <td><a href="admin/module/edit/<?php echo $val_child['id']?>"><i class="fa fa-mail-forward"></i> <?php echo $val_child['name'];?></a></td>
              <td><div class="col-xs-12">
                  <div class="form-group" style="margin-bottom:0px;">
                      <select class="form-control select2 select-search parentid" name="parentid" id="parentid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option value="0">Gốc</option>
                        <?php if(isset($module) && !is_null($module)){ ?>
                        <?php foreach ($module as $key_module => $val_module) { ?>
                              <option value="<?php echo $val_module['id'];?>" <?php if($val_module['id'] == $val_child['parentid']){ ?> selected <?php } ?>><?php echo $val_module['name'];?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>
                  </div></div>
              </td>
              <td><?php echo $val_child['created'];?></td>
              <td class="div_center"><input class="sort div_center" name="sort" control="module" value="<?php echo isset($val_child['sort'])?$val_child['sort']:'';?>" id="sort" size="5" seq="<?php echo $val_child['id']?>"></td>
              <td class="div_center publish"><a control="module" title="Hiển thị" class="div_hienthi<?php echo $val_child['id']?> div_hienthi" divid="div_hienthi<?php echo $val_child['id']?>" seq="<?php echo $val_child['id']?>">
                <?php if($val_child['publish'] == 0){ ?>
                  <i class="fa fa-check-circle"></i>
                <?php }else{ ?>
                  <i class="fa fa-circle"></i>
                <?php } ?></a>
              </td>
              <td class="div_center tool">
                <a href="admin/module/edit/<?php echo $val_child['id']?>"><i class="fa fa-edit"></i></a>
                <a class="delete" seq="<?php echo $val_child['id']?>" control="module"><i class="fa fa-trash"></i></a>
                
              </td>
            </tr>
        <?php } ?>
    <?php } ?>
<?php } ?>
<?php } ?>

