
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('poll_option_edit'); ?> </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/poll-options/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('poll_options_list'); ?> </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <form action="<?php echo base_url("admin/poll-options/edit/".$poll_opitons_info->id);?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('poll_id'); ?> *</label>
                                            <select name="poll_id" id="poll_id" class="form-control select2">
                                                <?php foreach($poll_list as $key => $value) {?>
                                                    <option value="<?php echo $value->id;?>" <?php if($poll_opitons_info->poll_id == $value->id) echo "selected"; ?> ><?php echo $value->poll_title;?></option>
                                                <?php }?>    
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('option_1'); ?> *</label>
                                            <input type="text" id="option_1" value="<?php echo $poll_opitons_info->option_1?>" name="option_1" required = '' placeholder="<?php echo $this->lang->line('option_1');?>" class="form-control inner_shadow_primary">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('option_2'); ?> </label>
                                            <input type="text" id="option_2" value="<?php echo $poll_opitons_info->option_2?>" name="option_2" placeholder="<?php echo $this->lang->line('option_2');?>" class="form-control inner_shadow_primary">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('option_3'); ?> </label>
                                            <input type="text" id="option_3" value="<?php echo $poll_opitons_info->option_3?>" name="option_3" placeholder="<?php echo $this->lang->line('option_3');?>" class="form-control inner_shadow_primary">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('option_4'); ?> </label>
                                            <input type="text" id="option_4" name="option_4" value="<?php echo $poll_opitons_info->option_4?>" placeholder="<?php echo $this->lang->line('option_4');?>" class="form-control inner_shadow_primary">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('option_5'); ?> </label>
                                            <input type="text" id="option_5" name="option_5" value="<?php echo $poll_opitons_info->option_5?>" placeholder="<?php echo $this->lang->line('option_5');?>" class="form-control inner_shadow_primary">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('correct_option'); ?> </label>
                                            <input type="text" id="correct_option" value="<?php echo $poll_opitons_info->correct_option?>" name="correct_option" placeholder="<?php echo $this->lang->line('correct_option');?>" class="form-control inner_shadow_primary">
                                        </div>
                                    </div>
                                </div>
                                                              
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

