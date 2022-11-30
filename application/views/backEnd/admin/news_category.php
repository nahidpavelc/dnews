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
                    <h3 class="box-title"> <?php echo $this->lang->line('news_category'); ?> </h3>
                    <div class="box-tools pull-right">
                    </div>
                </div>
                <div class="box-body">
                    <?php if(isset($news_category_info)){ ?>
                        <div class="row">
                            <div class="col-md-12">
                                <form action="<?php echo base_url('admin/news-category/edit/'.$news_category_id) ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-10" style="box-shadow: 0px 0px 10px 0px purple;padding: 20px; margin: 18px;">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="title_one"><?php echo $this->lang->line("category_name"); ?> *</label>
                                                    <input name="category_name" autocomplete="off" class="form-control inner_shadow_purple" placeholder="<?php echo $this->lang->line('category_name'); ?>" required="" type="text" value="<?php echo $news_category_info->category_name; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <!-- Profile Image -->
                                            <div class="box box-purple">
                                                <div class="box-header"> <label> <?php echo $this->lang->line('category_photo'); ?> </label> </div>
                                                <div class="box-body box-profile">
                                                    <center>
                                                        <img  id="news_category" class="img-responsive" src="<?php if(file_exists($news_category_info->category_photo)) echo base_url($news_category_info->category_photo);else echo base_url('assets/upload.png') ?>" alt="News Category Photo" style="height: 100px; width: 100px;"><small style="color: gray">width : 400px, Height : 400px</small>
                                                        <br>
                                                        <input  type="file" name="category_photo" onchange="readpicture1(this);" >
                                                    </center>
                                                </div>
                                                <!-- /.box-body -->
                                            </div>
                                            <!-- /.box -->
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
                                <form action="<?php echo base_url('admin/news-category/add/') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-10" style="box-shadow: 0px 0px 10px 0px purple;padding: 20px;">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="title_one"><?php echo $this->lang->line("category_name"); ?> *</label>
                                                    <input name="category_name" autocomplete="off" class="form-control inner_shadow_purple" placeholder="<?php echo $this->lang->line('category_name'); ?>" required="" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <!-- Profile Image -->
                                            <div class="box box-purple">
                                                <div class="box-header"> <label> <?php echo $this->lang->line('category_photo'); ?> </label> </div>
                                                <div class="box-body box-profile">
                                                    <center>
                                                        <img  id="news_category" class="img-responsive" src="<?php echo base_url('assets/upload.png') ?>" alt="News Category Photo" style="width: 100px; height:100px;"><small style="color: gray">width : 400px, Height : 400px</small>
                                                        <br>
                                                        <input  type="file" name="category_photo" onchange="readpicture1(this);" >
                                                    </center>
                                                </div>
                                                <!-- /.box-body -->
                                            </div>
                                            <!-- /.box -->
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
                                        <th style="width: 20%;"><?php echo $this->lang->line('category_name'); ?></th>
                                        <th style="width: 20%;"><?php echo $this->lang->line('category_photo'); ?></th>
                                        <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($news_category_list as $key => $value) {
                                        ?>

                                        <tr>
                                            <td><?php echo $key + 1; ?></td>

                                            <td><?php echo $value->category_name; ?></td>
                                            <td>
                                                <img class="img" src="<?php if(file_exists($value->category_photo)) echo base_url($value->category_photo);else echo base_url("assets/gallery.png") ?>" alt="Photo" width="50px" height="50px">

                                            </td>


                                            <td>
                                                <a href="<?= base_url('admin/news-category/edit/'.$value->id); ?>" class="btn btn-sm bg-teal"> <i class="fa fa-edit"></i> </a>
                                                <a href="<?= base_url('admin/news-category/delete/'.$value->id); ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm bg-red"> <i class="fa fa-trash"></i> </a>
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
    // profile picture change
    function readpicture1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#news_category')
                    .attr('src', e.target.result)
                    .width(100)
                    .height(100);
            };

            reader.readAsDataURL(input.files[0]);
        }

    }



</script>