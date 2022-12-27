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
          <h3 class="box-title"> <?php echo $this->lang->line('poll_voting'); ?> </h3>
          <div class="box-tools pull-right">
          </div>
        </div>
        <div class="box-body">
          <?php if (isset($poll_voting_info)) { ?>
            <div class="row">
              <div class="col-md-12">
                <form action="<?php echo base_url('admin/poll-voting/edit/' . $poll_voting_id) ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                  <div class="col-md-1"></div>
                  <div class="col-md-10" style="box-shadow: 0px 0px 10px 0px #337AB7;padding: 20px; margin: 18px;">
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="title_one"><?php echo $this->lang->line("poll_id"); ?> *</label>
                          <select name="poll_id" id="poll_id" class="form-control select2">
                            <?php foreach ($poll_list as $key => $value) { ?>
                              <option value="<?php echo $value->id ?>"><?php echo $value->poll_title; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="title_one"><?php echo $this->lang->line("ip_address"); ?> </label>
                          <input type="text" name="ip_address" value="<?php echo $poll_voting_info->ip_address; ?>" class="form-control inner_shadow_primary" placeholder="<?php echo $this->lang->line('ip_address') ?>">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="title_one"><?php echo $this->lang->line("selected_option_id"); ?> </label>
                          <select name="selected_option_id" id="selected_option_id" class="form-control select2">
                            <option value="0">Select One</option>
                            <option value="1" <?php if ($poll_voting_info->selected_option_id == 1) echo "selected"; ?>>Option One</option>
                            <option value="2" <?php if ($poll_voting_info->selected_option_id == 2) echo "selected"; ?>>Option Two</option>
                            <option value="3" <?php if ($poll_voting_info->selected_option_id == 3) echo "selected"; ?>>Option Thre</option>
                            <option value="4" <?php if ($poll_voting_info->selected_option_id == 4) echo "selected"; ?>>Option Four</option>
                            <option value="5" <?php if ($poll_voting_info->selected_option_id == 5) echo "selected"; ?>>Option Five</option>
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
          <?php } else { ?>
            <div class="row">
              <div class="col-md-12" style="margin:18px ;">
                <form action="<?php echo base_url('admin/poll-voting/add/') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                  <div class="col-md-1"></div>
                  <div class="col-md-10" style="box-shadow: 0px 0px 10px 0px #337AB7;padding: 20px;">
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="title_one"><?php echo $this->lang->line("poll_id"); ?> *</label>
                          <select name="poll_id" id="poll_id" class="form-control select2">
                            <option value="0">Select One</option>
                            <?php foreach ($poll_list as $key => $value) { ?>
                              <option value="<?php echo $value->id ?>"><?php echo $value->poll_title; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="title_one"><?php echo $this->lang->line("ip_address"); ?> *</label>
                          <input type="text" required name="ip_address" autocomplete="off" class="form-control inner_shadow_primary" placeholder="<?php echo $this->lang->line('ip_address') ?>">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <label for="title_one"><?php echo $this->lang->line("selected_option_id"); ?> </label>
                          <select name="selected_option_id" id="selected_option_id" class="form-control select2">
                            <option value="0">Select One</option>
                            <option value="1">Option One</option>
                            <option value="2">Option Two</option>
                            <option value="3">Option Thre</option>
                            <option value="4">Option Four</option>
                            <option value="5">Option Five</option>
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
                      <th style="width: 20%;"><?php echo $this->lang->line('poll_title'); ?></th>
                      <th style="width: 30%;"><?php echo $this->lang->line('ip_address'); ?></th>
                      <th style="width: 30%;"><?php echo $this->lang->line('selected_option_id'); ?></th>
                      <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($poll_voting_list as $key => $value) {
                    ?>

                      <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $value->poll_title; ?></td>
                        <td><?php echo $value->ip_address; ?></td>
                        <td>
                          <?php if ($value->selected_option_id == 1) { ?>
                            <span class="pull-right-container">
                              <small class="label bg-teal">Option One</small>
                            </span>
                          <?php } else if ($value->selected_option_id == 2) { ?>
                            <span class="pull-right-container">
                              <small class="label bg-teal">Option Two</small>
                            </span>
                          <?php } else if ($value->selected_option_id == 3) { ?>
                            <span class="pull-right-container">
                              <small class="label bg-teal">Option Three</small>
                            </span>
                          <?php } else if ($value->selected_option_id == 4) { ?>
                            <span class="pull-right-container">
                              <small class="label bg-teal">Option Four</small>
                            </span>
                          <?php } else if ($value->selected_option_id == 5) { ?>
                            <span class="pull-right-container">
                              <small class="label bg-teal">Option Five</small>
                            </span>
                          <?php } ?>
                        </td>

                        <td>
                          <a href="<?= base_url('admin/poll-voting/edit/' . $value->id); ?>" class="btn btn-sm bg-teal"> <i class="fa fa-edit"></i> </a>
                          <a href="<?= base_url('admin/poll-voting/delete/' . $value->id); ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm bg-red"> <i class="fa fa-trash"></i> </a>
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