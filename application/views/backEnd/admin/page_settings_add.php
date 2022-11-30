
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-teal box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('page_settings_add'); ?> </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/page-settings/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('page_settings_list'); ?> </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <form action="<?php echo base_url("admin/page-settings/add");?>" method="post" enctype="multipart/form-data" class="form-horizontal">

                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('title'); ?> *</label>
                                            <input type="text" id="title" autocomplete="off" name="title" required = '' placeholder="<?php echo $this->lang->line('title');?>" class="form-control inner_shadow_teal">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('subtitle'); ?> </label>
                                            <input type="text" id="subtitle" autocomplete="off" name="subtitle"  placeholder="<?php echo $this->lang->line('subtitle');?>" class="form-control inner_shadow_teal">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('youtube_video_link'); ?> </label>
                                            <input type="text" id="youtube_video_link" autocomplete="off" name="youtube_video_link"  placeholder="<?php echo $this->lang->line('youtube_video_link');?>" class="form-control inner_shadow_teal">
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('body'); ?> </label>
                                            <textarea name="body" id="body" cols="30" rows="2" class="form-control inner_shadow_purple"></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-3">
                                <!-- Profile Image -->
                                <div class="box box-teal">
                                    <div class="box-header"> <label> <?php echo $this->lang->line('photo'); ?> </label> </div>
                                    <div class="box-body box-profile">
                                        <center>
                                            <img id="marketing_reports_change" class="img-responsive" src="<?php echo base_url('assets/upload.png') ?>" alt="Lecture Sheet Photo" style="width: 100px; height:100px;"><small style="color: gray">width : 400px, Height : 400px</small>
                                            <br>
                                            <input type="file" name="photo" onchange="readpicture1(this);">
                                        </center>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>

                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm bg-red"><?php echo $this->lang->line('reset') ?></button>
                                    <button type="submit" class="btn btn-sm bg-purple"><?php echo $this->lang->line('save') ?></button>
                                </center>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>
</section>
<script>
    // profile picture change
    function readpicture1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#marketing_reports_change')
                    .attr('src', e.target.result)
                    .width(100)
                    .height(100);
            };

            reader.readAsDataURL(input.files[0]);
        }

    }

</script>
<script type="text/javascript">
    CKEDITOR.replace('body');
</script>




