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
                <label class="control-label">Thuộc nhóm</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-unsorted"></i></div>
                    <select class="form-control select2" name="typeid" id="typeid" control="news">
                      <option value="">Chọn nhóm</option>
                      <?php if(isset($type) && !is_null($type)){ ?>
                      <?php foreach ($type as $key_type => $val_type) { ?>
                            <option value="<?php echo $val_type['id'];?>" <?php if($val_type['id'] == $news['typeid']){ ?> selected <?php } ?>><?php echo $val_type['name'];?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Tên</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                    <input type="text" class="form-control" name="name" id="name" value="<?php if(isset($news['name']) && $news['name']!=''){ echo $news['name']; }?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Title</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                    <input class="form-control" name="title" id="title" value="<?php if(isset($news['title']) && $news['title']!=''){ echo $news['title']; }?>">
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
                        <?php if($news['image_thumb']!=''){ ?>
                            <img src="upload/news/thumb/<?php echo $news['image_thumb'];?>" alt="">
                        <?php } ?>
                    </div>
                </div>
            </div>
            </div>
          </div><!-- /.box-body -->
        </div>
        <div class="col-md-6">
            <div class="box-body">
                <div class="form-group">
                    <label>Meta keyword</label>
                    <textarea class="form-control" rows="4" name="meta_keyword" id="meta_keyword"><?php if(isset($news['meta_keyword']) && $news['meta_keyword']!=''){ echo $news['meta_keyword']; }?></textarea>
                </div>
                <div class="form-group">
                    <label>Meta description</label>
                    <textarea class="form-control" rows="4" name="meta_description" id="meta_description"><?php if(isset($news['meta_description']) && $news['meta_description']!=''){ echo $news['meta_description']; }?></textarea>
                </div>
                <div class="form-group">
                    <label class="radio-inline">
                      <input <?php if($news['publish'] == 0){ ?> checked="" <?php } ?> type="radio" name="publish" id="publish" value="0"> Hiển thị
                    </label>
                    <label class="radio-inline">
                      <input <?php if($news['publish'] == 1){ ?> checked="" <?php } ?> type="radio" name="publish" id="publish" value="1"> Ẩn
                    </label>
                </div>
                <div class="form-group">
                    <label class="radio-inline">
                      <input <?php if($news['is_hot'] == 0){ ?> checked="" <?php } ?> type="radio" name="is_hot" id="is_hot" value="0"> Nổi bật
                    </label>
                    <label class="radio-inline">
                      <input <?php if($news['is_hot'] == 1){ ?> checked="" <?php } ?> type="radio" name="is_hot" id="is_hot" value="1"> Không 
                    </label>
                </div>
                <div class="form-group">
                    <label class="radio-inline">
                      <input <?php if($news['is_home'] == 0){ ?> checked="" <?php } ?> type="radio" name="is_home" id="is_home" value="0"> Hiện thị trên trang chủ
                    </label>
                    <label class="radio-inline">
                      <input <?php if($news['is_home'] == 1){ ?> checked="" <?php } ?> type="radio" name="is_home" id="is_home" value="1"> Không
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Nội dung</label>
                <textarea id="content" name="content" class="ckeditor"><?php if(isset($news['content']) && $news['content']!=''){ echo $news['content']; }?></textarea>
            </div>
        </div>
        <div class="clear"></div>
          <div class="box-footer">
            <a class="btn btn-success btn-flat add"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Cập nhật</a>
            <a href="admin/news/index" class="btn btn-success btn-flat"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Hủy</a>
          </div>
      </div>
    </div>
    </form>
</div>