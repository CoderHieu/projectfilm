<?php if(isset($media) && $media!=NULL){ ?>
    <?php foreach($media as $key => $val){ ?>
    <tr> 
      <td class="div_center"><input type="checkbox" name="chon" class="checkbox-menu" value="<?php echo $val['id']?>"></td>
      <td><a href="admin/media/edit/<?php echo $val['id']?>"><?php echo $val['name'];?></a></td>
      <td class="div_center"><?php if($val['image']!=''){ ?> <img src="upload/media/<?php echo $val['image'];?>" alt="" class="img_admin">
      <?php }?></td>
      <td><?php echo $val['created'];?></td>
      <td class="div_center publish"><a control="media" title="Hiển thị" class="div_hienthi<?php echo $val['id']?> div_hienthi" divid="div_hienthi<?php echo $val['id']?>" seq="<?php echo $val['id']?>">
        <?php if($val['publish'] == 0){ ?>
          <i class="fa fa-check-circle"></i>
        <?php }else{ ?>
          <i class="fa fa-circle"></i>
        <?php } ?></a>
      </td>
      <td class="div_center tool">
        <a href="admin/media/edit/<?php echo $val['id']?>"><i class="fa fa-edit"></i></a>
        <a class="delete" seq="<?php echo $val['id']?>" control="media"><i class="fa fa-trash"></i></a>
      </td>
    </tr>
    <?php } ?>
<?php } ?>
