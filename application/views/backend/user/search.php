<?php if(isset($user) && $user!=NULL){ ?>
    <?php foreach($user as $key => $val){ ?>
    <tr> 
      <td class="div_center"><input type="checkbox" name="chon" class="checkbox-menu" value="<?php echo $val['id']?>"></td>
      <td><a href="admin/user/edit/<?php echo $val['id']?>"><?php echo $val['fullname'];?></a></td>
      <td><?php echo $val['username'];?></td>
      <td><?php echo $val['role_name'];?></td>
      <td class="div_center"><?php if($val['avatar_thumb']!=''){ ?> <img src="upload/user/thumb/<?php echo $val['avatar_thumb'];?>" alt="" class="img_admin">
      <?php }?></td>
      <td><?php echo $val['created'];?></td>
      <td class="div_center publish"><a control="user" title="Hiển thị" class="div_active<?php echo $val['id']?> div_active" divid="div_active<?php echo $val['id']?>" seq="<?php echo $val['id']?>">
        <?php if($val['active'] == 0){ ?>
          <i class="fa fa-check-circle"></i>
        <?php }else{ ?>
          <i class="fa fa-circle"></i>
        <?php } ?></a>
      </td>
      <td class="div_center tool">
        <a href="admin/user/edit/<?php echo $val['id']?>"><i class="fa fa-edit"></i></a>
        <a class="delete" seq="<?php echo $val['id']?>" control="user"><i class="fa fa-trash"></i></a>
      </td>
    </tr>
    <?php } ?>
<?php } ?>

