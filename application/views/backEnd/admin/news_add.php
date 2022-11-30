
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-purple box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('news_add'); ?> </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/news/list" type="submit" class="btn bg-teal btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('news_list'); ?> </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <form action="<?php echo base_url("admin/news/add");?>" method="post" enctype="multipart/form-data" class="form-horizontal">

                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('news_date'); ?> *</label>
                                            <input type="text" autocomplete="off" id="news_date" name="news_date" required = '' placeholder="<?php echo $this->lang->line('news_date');?>" class="form-control inner_shadow_purple date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('title'); ?> *</label>
                                            <input type="text" id="title" name="title" required = '' placeholder="<?php echo $this->lang->line('title');?>" class="form-control inner_shadow_purple">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('subtitle'); ?> </label>
                                            <input type="text" id="subtitle" name="subtitle" placeholder="<?php echo $this->lang->line('subtitle');?>" class="form-control inner_shadow_purple">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('tags'); ?> </label>
                                            <input name="tags[]" autocomplete="off" placeholder="<?php echo $this->lang->line('tags'); ?>" class="form-control inner_shadow_purple" required="" type="text">
                                            <span id="input_field_format" style="width: 100%; margin-bottom: 5px;"></span> 
                                            <span onclick="input_field_format()" class="bg-purple" style="padding: 1px 10px 1px 10px;border-radius: 5px;cursor: copy;"> <i class="fa fa-plus"></i> <?php echo $this->lang->line("add_tags"); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('is_published'); ?> </label>
                                            <select name="is_published" id="is_published" class="form-control select2">
                                                <option value="1">Yes</option>
                                                <option value="2">Not</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('approve_status'); ?> </label>
                                            <select name="approve_status" id="approve_status" class="form-control select2">
                                                <option value="1">Yes</option>
                                                <option value="2">Not</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('news_body'); ?> </label>
                                            <textarea name="news_body" id="body" cols="30" rows="2" class="form-control inner_shadow_purple"></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-3">
                                <!-- Profile Image -->
                                <div class="box box-purple">
                                    <div class="box-header"> <label> <?php echo $this->lang->line('thumb_photo'); ?> </label> </div>
                                    <div class="box-body box-profile">
                                        <center>
                                            <img id="marketing_reports_change" class="img-responsive" src="<?php echo base_url('assets/upload.png') ?>" alt="Lecture Sheet Photo" style="width: 100px; Height:100px;"><small style="color: gray">width : 400px, Height : 400px</small>
                                            <br>
                                            <input type="file" name="thumb_photo" onchange="readpicture1(this);">
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


<script>
    $(document).ready(function () {

        $('.date').datepicker({
            autoclose: true,
            changeYear:true,
            changeMonth:true,
            dateFormat: "dd M yy",
            yearRange: "-62:+0"
        });

    });

</script>
<script>
     function input_field_format() {
        $('#input_field_format').append('<input name="tags[]" style="margin-top:7px" placeholder="Tags" class="form-control inner_shadow_purple" type="text">')
    }
</script>