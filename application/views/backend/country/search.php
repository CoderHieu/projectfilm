<?php if(isset($country) && $country!=NULL){ ?>
<?php foreach($country as $key => $val){ ?>
<tr> 
  <td class="div_center"><input type="checkbox" name="chon" class="checkbox-menu" value="<?php echo $val['id']?>"></td>
  <td><a href="admin/country/edit/<?php echo $val['id']?>"><?php echo $val['name'];?></a></td>
  <td><?php echo $val['created'];?></td>
  <td class="div_center"><input class="sort div_center" name="sort" control="country" value="<?php echo isset($val['sort'])?$val['sort']:'';?>" id="sort" size="5" seq="<?php echo $val['id']?>"></td>
  <td class="div_center publish"><a control="country" title="Hiển thị" class="div_hienthi<?php echo $val['id']?> div_hienthi" divid="div_hienthi<?php echo $val['id']?>" seq="<?php echo $val['id']?>">
    <?php if($val['publish'] == 0){ ?>
      <i class="fa fa-check-circle"></i>
    <?php }else{ ?>
      <i class="fa fa-circle"></i>
    <?php } ?></a>
  </td>
  <td class="div_center tool">
    <a href="admin/country/edit/<?php echo $val['id']?>"><i class="fa fa-edit"></i></a>
    <a class="delete" seq="<?php echo $val['id']?>" control="country"><i class="fa fa-trash"></i></a>
    
  </td>
</tr>
<?php } ?>
<?php } ?>
                    