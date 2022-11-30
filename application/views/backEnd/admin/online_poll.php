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
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo $this->lang->line('online_pull'); ?> </h3>
                    <div class="box-tools pull-right">
                    </div>
                </div>
                <div class="box-body">
                    <?php if(isset($online_poll_info)){ ?>
                        <div class="row">
                            <div class="col-md-12">
                                <form action="<?php echo base_url('admin/online-poll/edit/'.$online_polll_id) ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-10" style="box-shadow: 0px 0px 10px 0px #337AB7;padding: 20px; margin: 18px;">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="title_one"><?php echo $this->lang->line("poll_date"); ?> *</label>
                                                    <input type="text" value="<?php if($online_poll_info->poll_date) echo date('d M Y', strtotime($online_poll_info->poll_date));?>" name="poll_date" class="form-control inner_shadow_primary date" placeholder="<?php echo $this->lang->line('poll_date')?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="title_one"><?php echo $this->lang->line("poll_title"); ?> *</label>
                                                    <input type="text" name="poll_title" value="<?php echo $online_poll_info->poll_title;?>" class="form-control inner_shadow_primary" placeholder="<?php echo $this->lang->line('poll_title')?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="title_one"><?php echo $this->lang->line("is_published"); ?> *</label>
                                                    <select name="is_published" id="is_published" class="form-control select2"> 
                                                        <option value="1" <?php if($online_poll_info->is_published == 1) echo "selected";?> >Yes</option>
                                                        <option value="2" <?php if($online_poll_info->is_published == 2) echo "selected";?> >No</option>
                                                    </select>
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
                    <?php }else {?>
                        <div class="row">
                            <div class="col-md-12" style="margin:18px ;">
                                <form action="<?php echo base_url('admin/online-poll/add/') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-10" style="box-shadow: 0px 0px 10px 0px #337AB7;padding: 20px;">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="title_one"><?php echo $this->lang->line("poll_date"); ?> *</label>
                                                    <input type="text" required name="poll_date" autocomplete="off" class="form-control inner_shadow_primary date" placeholder="<?php echo $this->lang->line('poll_date')?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="title_one"><?php echo $this->lang->line("poll_title"); ?> *</label>
                                                    <input type="text" required name="poll_title" autocomplete="off" class="form-control inner_shadow_primary" placeholder="<?php echo $this->lang->line('poll_title')?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="title_one"><?php echo $this->lang->line("is_published"); ?> </label>
                                                    <select name="is_published" id="is_published" class="form-control select2">
                                                        <option value="1">Yes</option>
                                                        <option value="2">Not</option>
                                                    </select>
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
                                <table id="userListTable" class="table table-bordered table-striped table_th_primary custom_table">
                                    <thead>
                                    <tr>
                                        <th style="width: 10%;"><?php echo $this->lang->line('sl'); ?></th>
                                        <th style="width: 20%;"><?php echo $this->lang->line('poll_date'); ?></th>
                                        <th style="width: 30%;"><?php echo $this->lang->line('poll_title'); ?></th>
                                        <th style="width: 30%;"><?php echo $this->lang->line('approve_status'); ?></th>
                                        <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($online_poll_list as $key => $value) {
                                        ?>

                                        <tr>
                                            <td><?php echo $key + 1; ?></td>

                                            <td><?php echo date('d M Y', strtotime($value->poll_date)); ?></td>
                                            <td><?php echo $value->poll_title; ?></td>
                                            <td>
                                                <?php if($value->is_published == 1){ ?>
                                                    <span class="pull-right-container">
                                                    <small class="label bg-teal">Published</small>
                                                </span>
                                                <?php } else if($value->is_published == 2){ ?>
                                                    <span class="pull-right-container">
                                                    <small class="label bg-red">Pending</small>
                                                </span>
                                                <?php }?> 
                                            </td>
                                        
                                            <td>
                                                <a href="<?= base_url('admin/online-poll/edit/'.$value->id); ?>" class="btn btn-sm bg-teal"> <i class="fa fa-edit"></i> </a>
                                                <a href="<?= base_url('admin/online-poll/delete/'.$value->id); ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm bg-red"> <i class="fa fa-trash"></i> </a>
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
    $(function () {
        $("#userListTable").DataTable();
    });

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