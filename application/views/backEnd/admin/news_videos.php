<style>
  .img {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 3px;
    width: 70px;
    height: 60px;
  }
</style>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-purple box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $this->lang->line('news_videos'); ?> </h3>
          <div class="box-tools pull-right">
          </div>
        </div>
        <div class="box-body">
          <?php if (isset($news_video_info)) { ?>
            <div class="row">
              <div class="col-md-12">
                <form action="<?php echo base_url('admin/news-videos/edit/' . $news_video_id) ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                  <div class="col-md-1"></div>
                  <div class="col-md-10" style="box-shadow: 0px 0px 10px 0px purple;padding: 20px; margin: 18px;">
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="title_one"><?php echo $this->lang->line("news_id"); ?> *</label>
                          <select name="news_id" id="news_id" class="form-control select2">
                            <option value="0">Select One</option>
                            <?php foreach ($get_news_list as $key => $value) { ?>
                              <option value="<?php echo $value->id; ?>" <?php if ($news_video_info->news_id == $value->id) echo "selected"; ?>><?php echo $value->title; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="title_one"><?php echo $this->lang->line("youtube_video_link"); ?> </label>
                          <input type="url" value="<?php echo $news_video_info->youtube_video_link; ?>" name="youtube_video_link" class="form-control inner_shadow_purple" placeholder="<?php echo $this->lang->line('youtube_video_link') ?>" required="">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="title_one"><?php echo $this->lang->line("facebook_video_link"); ?> *</label>
                          <input type="url" name="facebook_video_link" value="<?php echo $news_video_info->facebook_video_link; ?>" class="form-control inner_shadow_purple" placeholder="<?php echo $this->lang->line('facebook_video_link') ?>" required="">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <center>
                        <button type="reset" class="btn-sm btn btn-danger"> <?php echo $this->lang->line('cancel'); ?> </button>
                        <button type="submit" class="btn btn-sm bg-teal"> <?php echo $this->lang->line('update'); ?> </button>
                      </center>
                    </div>
                  </div>
                  <div class="col-md-1"></div>
                </form>
              </div>
            </div>
          <?php } else { ?>
            <div class="row">
              <div class="col-md-12" style="margin:18px ;">
                <form action="<?php echo base_url('admin/news-videos/add/') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                  <div class="col-md-1"></div>
                  <div class="col-md-10" style="box-shadow: 0px 0px 10px 0px purple;padding: 20px;">
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="title_one"><?php echo $this->lang->line("news_id"); ?> *</label>
                          <select name="news_id" id="news_id" class="form-control select2">
                            <option value="0">Select One</option>
                            <?php foreach ($get_news_list as $key => $value) { ?>
                              <option value="<?php echo $value->id; ?>"><?php echo $value->title; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="title_one"><?php echo $this->lang->line("youtube_video_link"); ?> *</label>
                          <input type="url" name="youtube_video_link" autocomplete="off" class="form-control inner_shadow_purple" placeholder="<?php echo $this->lang->line('youtube_video_link') ?>">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="title_one"><?php echo $this->lang->line("facebook_video_link"); ?> *</label>
                          <input type="url" name="facebook_video_link" autocomplete="off" class="form-control inner_shadow_purple" placeholder="<?php echo $this->lang->line('facebook_video_link') ?>">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <center>
                        <button type="reset" class="btn-sm btn btn-danger"> <?php echo $this->lang->line('reset'); ?> </button>
                        <button type="submit" class="btn btn-sm bg-teal"> <?php echo $this->lang->line('save'); ?> </button>
                      </center>
                    </div>
                  </div>
                  <div class="col-md-1"></div>
                </form>
              </div>
            </div>
          <?php } ?>
          <div class="row">
            <div class="col-sm-12">
              <div class="custom_table_box">
                <table id="userListTable" class="table table-bordered table-striped table_th_purple custom_table">
                  <thead>
                    <tr>
                      <th style="width: 10%;"><?php echo $this->lang->line('sl'); ?></th>
                      <th style="width: 20%;"><?php echo $this->lang->line('news_title'); ?></th>
                      <th style="width: 30%;"><?php echo $this->lang->line('youtube_video_link'); ?></th>
                      <th style="width: 30%;"><?php echo $this->lang->line('facebook_video_link'); ?></th>
                      <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($news_video_list as $key => $value) {
                    ?>

                      <tr>
                        <td><?php echo $key + 1; ?></td>

                        <td><?php echo $value->title; ?></td>
                        <td><?php echo $value->youtube_video_link; ?></td>
                        <td><?php echo $value->facebook_video_link; ?></td>

                        <td>
                          <a href="<?= base_url('admin/news-videos/edit/' . $value->id); ?>" class="btn btn-sm bg-teal"> <i class="fa fa-edit"></i> </a>
                          <a href="<?= base_url('admin/news-videos/delete/' . $value->id); ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm bg-red"> <i class="fa fa-trash"></i> </a>
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class=" box-footer">
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (right) -->
  </div>
</section>

<script type="text/javascript">
  $(function() {
    $("#userListTable").DataTable();
  });
</script>

<script>
  // profile picture change
  function readpicture1(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#news_category')
          .attr('src', e.target.result)
          .width(100)
          .height(100);
      };

      reader.readAsDataURL(input.files[0]);
    }

  }
</script>