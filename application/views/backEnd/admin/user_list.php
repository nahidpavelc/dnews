
<style>
.img {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 3px;
    width: 70px;
    height: 70px;
}
</style>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-purple box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line("user_list"); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url('admin/add_user') ?>" class="btn bg-teal btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line("add_user");?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="custom_table_box">
                        <table id="userListTable" class="table table-bordered table-striped table_th_purple custom_table">
                            <thead>
                            <tr>
                                <th width="5%"><?php echo $this->lang->line('sl'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('photo'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('name'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('contact'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('user_type'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('action'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($myUsers as $key => $value) {
                                ?>
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <td>
                                             <img  class="img" src="<?php if(file_exists($value['photo'])) echo base_url($value['photo']); else echo base_url('assets/user.png') ?>" alt="photo" width="50px" height="50px" > 
                                   </td>
                                    <td> <?php echo $value['firstname'].' '.$value['lastname'] ; ?> </td>
                                    <td> <?php echo $value['email']."<br>".$value['phone'] ; ?> </td>
                                    
                                    <td> <?php echo $value['userType'] ; ?> </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default"><?php echo $this->lang->line('action'); ?></button>
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="<?php echo base_url().'admin/edit_user/'.$value['id'] ;?>"><?php echo $this->lang->line('update'); ?></a></li>
                                                <li><a href="<?php echo base_url().'admin/suspend_user/'.$value['id'].'/'. abs($value['status']-1) ;?>"> <?php echo $value['status'] == 0 ? $this->lang->line('active'):$this->lang->line('suspend'); ?> </a></li>
                                                <li class="divider"></li>
                                                <li><a href="<?php echo base_url().'admin/delete_user/'.$value['id'] ;?>" onclick="return confirm('Are you sure?')" ><?php echo $this->lang->line('delete'); ?></a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</section>
<script type="text/javascript">
    $(function () {
      $("#userListTable").DataTable();
    });
    
</script>

