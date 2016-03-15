<div class="row">
    <form id="frm-admin" method="post" action="" enctype="multipart/form-data">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo isset($title)?$title:'';?></h3>
        </div>
        <div class="col-md-6">
          <div class="box-body">
            <div class="form-group">
                <label class="control-label">Tên media</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                    <input type="text" class="form-control" name="name" id="name" value="<?php if(isset($media['name']) && $media['name']!=''){ echo $media['name']; }?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Title</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                    <input class="form-control" name="title" id="title" value="<?php if(isset($media['title']) && $media['title']!=''){ echo $media['title']; }?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Link</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                    <input class="form-control" name="link" id="link" value="<?php if(isset($media['link']) && $media['link']!=''){ echo $media['link']; }?>">
                </div>
            </div>
            <div class="form-group">
                <label for="name">Hình ảnh đại diện</label>
                <span class="btn btn-primary btn-file btn-sm">
                    Browse <input type="file" name="image" id="image">
                </span>
            </div>
            <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12 col-sm-9 col-md-10 col-lg-10">
                    <div id="box_img" class="div_avatar">
                        <?php if($media['image']!=''){ ?>
                            <img src="upload/media/<?php echo $media['image'];?>" alt="">
                        <?php } ?>
                    </div>
                </div>
            </div>
            </div>
            <div class="form-group">
                <label class="radio-inline">
                  <input <?php if($media['publish'] == 0){ ?> checked="" <?php } ?> type="radio" name="publish" id="publish" value="0"> Hiển thị
                </label>
                <label class="radio-inline">
                  <input <?php if($media['publish'] == 1){ ?> checked="" <?php } ?> type="radio" name="publish" id="publish" value="1"> Ẩn
                </label>
            </div>
          </div><!-- /.box-body -->
        </div>
        <div class="col-md-6">
            <div class="box-body">
                <div class="form-group">
                    <label for="name">Ảnh background</label>
                    <span class="btn btn-primary btn-file btn-sm">
                        Browse <input type="file" name="image_bg" id="image_bg">
                    </span>
                </div>
                <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-9 col-md-10 col-lg-10">
                        <div id="box_img_bg" class="div_avatar">
                            <?php if($media['image_bg']!=''){ ?>
                                <img src="upload/media/<?php echo $media['image_bg'];?>" alt="">
                            <?php } ?>
                        </div>
                    </div>
                </div>
                </div>
                <div class="form-group">
                    <label>Meta keyword</label>
                    <textarea class="form-control" rows="4" name="meta_keyword" id="meta_keyword"><?php if(isset($media['meta_keyword']) && $media['meta_keyword']!=''){ echo $media['meta_keyword']; }?></textarea>
                </div>
                <div class="form-group">
                    <label>Meta description</label>
                    <textarea class="form-control" rows="4" name="meta_description" id="meta_description"><?php if(isset($media['meta_description']) && $media['meta_description']!=''){ echo $media['meta_description']; }?></textarea>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Nội dung</label>
                <textarea id="content" name="content" class="ckeditor"><?php if(isset($media['meta_description']) && $media['meta_description']!=''){ echo $media['meta_description']; }?></textarea>
            </div>
        </div>
        <div class="clear"></div>
          <div class="box-footer">
            <a class="btn btn-success btn-flat add"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Cập nhật</a>
            <a href="admin/media/index" class="btn btn-success btn-flat"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Hủy</a>
          </div>
      </div>
    </div>
    </form>
</div>