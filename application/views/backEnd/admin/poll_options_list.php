
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
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line("poll_options_list"); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url("admin/poll-options/add"); ?>" class="btn bg-purple btn-sm" style="color: white; "><i class="fa fa-plus"></i> <?php echo $this->lang->line('poll_options_add') ?> </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="custom_table_box">
                        <table id="userListTable" class="table table-bordered table-striped table_th_primary custom_table" style="width: 100%;">
                            <thead>
                            <tr>
                                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('poll_title'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('option_1'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('option_2'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('option_3'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('option_4'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('option_5'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('correct_option'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                            </tr>
                            </thead>
                            <tbody >
                            <?php

                            foreach ($poll_options_list as $key=>$value) {
                                ?>
                                <tr >

                                    <td><?php echo ++$new_serial; ?></td>
                                    <td><?php echo $value->poll_title?></td>
                                    <td><?php echo $value->option_1?></td>
                                    <td><?php echo $value->option_2?></td>
                                    <td><?php echo $value->option_3?></td>
                                    <td><?php echo $value->option_4?></td>
                                    <td><?php echo $value->option_5?></td>
                                    <td><?php echo $value->correct_option?></td>
                                  
                                    
                                    
                                    


                                    <td>
                                        <a href="<?php echo base_url('admin/poll-options/edit/'.$value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                                        <a href="<?php echo base_url('admin/poll-options/delete/'.$value->id); ?>" class="btn btn-sm btn-danger" onclick = 'return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
                                    </td>

                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                        <div class="col-lg-12">
                            <center>
                                <?php echo $links; ?>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</section>

