
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-teal box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> SMS Setting</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <form action="<?php echo base_url("admin/sms-send-setting");?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                        
                            <div class="col-md-1"></div>
                            <div class="col-md-10" style="box-shadow: 0px 0px 10px 0px teal;padding: 20px; margin: 18px;">
                           
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Username*</label>
                                            <input type="text" value="<?php echo $sms_setting_info->username;?>" id="username" autocomplete="off" name="username" required = '' placeholder="<?php echo $this->lang->line('username');?>" class="form-control inner_shadow_teal">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('password'); ?> </label>
                                            <input type="password" id="password" value="<?php echo $sms_setting_info->password;?>" name="password" placeholder="<?php echo $this->lang->line('password');?>" class="form-control inner_shadow_teal">
                                        </div>
                                    </div>
                                </div>
                                
                           
                            
                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm bg-red"><?php echo $this->lang->line('reset') ?></button>
                                    <button type="submit" class="btn btn-sm bg-purple"><?php echo $this->lang->line('save') ?></button>
                                </center>
                            </div>
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
