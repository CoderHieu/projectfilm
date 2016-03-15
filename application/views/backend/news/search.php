<?php if(isset($news) && $news!=NULL){ ?>
    <?php foreach($news as $key => $val){ ?>
    <tr> 
      <td class="div_center"><input type="checkbox" name="chon" class="checkbox-menu" value="<?php echo $val['id']?>"></td>
      <td><a href="admin/news/edit/<?php echo $val['id']?>"><?php echo $val['name'];?></a></td>
      <td><?php echo $val['type_name'];?></td>
      <td class="div_center"><?php if($val['image_thumb']!=''){ ?> <img src="upload/news/thumb/<?php echo $val['image_thumb'];?>" alt="" class="img_admin">
      <?php }?></td>
      <td><?php echo $val['created'];?></td>
      <td class="div_center publish"><a control="news" title="Hiển thị" class="div_hienthi<?php echo $val['id']?> div_hienthi" divid="div_hienthi<?php echo $val['id']?>" seq="<?php echo $val['id']?>">
        <?php if($val['publish'] == 0){ ?>
          <i class="fa fa-check-circle"></i>
        <?php }else{ ?>
          <i class="fa fa-circle"></i>
        <?php } ?></a>
      </td>
      <td class="div_center tool">
        <a href="admin/news/edit/<?php echo $val['id']?>"><i class="fa fa-edit"></i></a>
        <a class="delete" seq="<?php echo $val['id']?>" control="news"><i class="fa fa-trash"></i></a>
      </td>
    </tr>
    <?php } ?>
<?php } ?>
