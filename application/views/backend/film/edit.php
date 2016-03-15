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
                    <select class="form-control select2" name="typeid" id="typeid" control="film">
                      <option value="">Chọn nhóm</option>
                      <?php if(isset($type) && !is_null($type)){ ?>
                      <?php foreach ($type as $key_type => $val_type) { ?>
                            <option value="<?php echo $val_type['id'];?>" <?php if($val_type['id'] == $film['typeid']){ ?> selected <?php } ?>><?php echo $val_type['name'];?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Thể loại</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-unsorted"></i></div>
                    <select class="form-control select2" name="cateid" id="cateid">
                      <option value="">Chọn thể loại</option>
                      <?php if(isset($cate) && !is_null($cate)){ ?>
                      <?php foreach ($cate as $key_cate => $val_cate) { ?>
                            <option value="<?php echo $val_cate['id'];?>" <?php if($val_cate['id'] == $film['cateid']){ ?> selected <?php } ?>><?php echo $val_cate['name'];?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Tên phim</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                    <input type="text" class="form-control" name="name" id="name" value="<?php if(isset($film['name']) && $film['name']!=''){ echo $film['name']; }?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Title</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                    <input class="form-control" name="title" id="title" value="<?php if(isset($film['title']) && $film['title']!=''){ echo $film['title']; }?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Ngày phát hành</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                    <input class="form-control" name="released" id="released" value="<?php if(isset($film['released']) && $film['released']!=''){ echo $film['released']; }?>">
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
                        <?php if($film['image_thumb']!=''){ ?>
                            <img src="upload/film/thumb/<?php echo $film['image_thumb'];?>" alt="">
                        <?php } ?>
                    </div>
                </div>
            </div>
            </div>
            <div class="form-group">
                <label class="radio-inline">
                  <input <?php if($film['publish'] == 0){ ?> checked="" <?php } ?> type="radio" name="publish" id="publish" value="0"> Hiển thị
                </label>
                <label class="radio-inline">
                  <input <?php if($film['publish'] == 1){ ?> checked="" <?php } ?> type="radio" name="publish" id="publish" value="1"> Ẩn
                </label>
            </div>
            <div class="form-group">
                <label class="radio-inline">
                  <input <?php if($film['is_hot'] == 0){ ?> checked="" <?php } ?> type="radio" name="is_hot" id="is_hot" value="0"> Nổi bật
                </label>
                <label class="radio-inline">
                  <input <?php if($film['is_hot'] == 1){ ?> checked="" <?php } ?> type="radio" name="is_hot" id="is_hot" value="1"> Không 
                </label>
            </div>
            <div class="form-group">
                <label class="radio-inline">
                  <input <?php if($film['is_slider'] == 0){ ?> checked="" <?php } ?> type="radio" name="is_slider" id="is_slider" value="0"> Hiện thị trên slider
                </label>
                <label class="radio-inline">
                  <input <?php if($film['is_slider'] == 1){ ?> checked="" <?php } ?> type="radio" name="is_slider" id="is_slider" value="1"> Không
                </label>
            </div>
          </div><!-- /.box-body -->
        </div>
        <div class="col-md-6">
            <div class="box-body">
                <div class="form-group">
                    <label class="control-label">Quốc gia</label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-unsorted"></i></div>
                        <select class="form-control select2" name="countryid" id="countryid">
                          <option value="">Chọn quốc gia</option>
                          <?php if(isset($country) && !is_null($country)){ ?>
                          <?php foreach ($country as $key_country => $val_country) { ?>
                                <option value="<?php echo $val_country['id'];?>" <?php if($val_country['id'] == $film['countryid']){ ?> selected <?php } ?>><?php echo $val_country['name'];?></option>
                          <?php } ?>
                          <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Chất lượng</label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-unsorted"></i></div>
                        <select class="form-control select2" name="qualityid" id="qualityid">
                          <option value="">Chọn chất lượng</option>
                          <?php if(isset($quality) && !is_null($quality)){ ?>
                          <?php foreach ($quality as $key_quality => $val_quality) { ?>
                                <option value="<?php echo $val_quality['id'];?>" <?php if($val_quality['id'] == $film['qualityid']){ ?> selected <?php } ?>><?php echo $val_quality['name'];?></option>
                          <?php } ?>
                          <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Trạng thái</label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                        <input class="form-control" name="status" id="status" value="<?php if(isset($film['status']) && $film['status']!=''){ echo $film['status']; }?>">
                    </div>
                </div>
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
                            <?php if($film['image_bg']!=''){ ?>
                                <img src="upload/film/<?php echo $film['image_bg'];?>" alt="">
                            <?php } ?>
                        </div>
                    </div>
                </div>
                </div>
                <div class="form-group">
                    <label>Meta keyword</label>
                    <textarea class="form-control" rows="4" name="meta_keyword" id="meta_keyword"><?php if(isset($film['meta_keyword']) && $film['meta_keyword']!=''){ echo $film['meta_keyword']; }?></textarea>
                </div>
                <div class="form-group">
                    <label>Meta description</label>
                    <textarea class="form-control" rows="4" name="meta_description" id="meta_description"><?php if(isset($film['meta_description']) && $film['meta_description']!=''){ echo $film['meta_description']; }?></textarea>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Nội dung</label>
                <textarea id="content" name="content" class="ckeditor"><?php if(isset($film['meta_description']) && $film['meta_description']!=''){ echo $film['meta_description']; }?></textarea>
            </div>
        </div>
        <div class="clear"></div>
          <div class="box-footer">
            <a class="btn btn-success btn-flat add"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Cập nhật</a>
            <a href="admin/film/index" class="btn btn-success btn-flat"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Hủy</a>
          </div>
      </div>
    </div>
    </form>
</div>