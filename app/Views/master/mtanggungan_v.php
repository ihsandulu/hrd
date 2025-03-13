<?php echo $this->include("template/header_v"); ?>

<div class='container-fluid'>
    <div class='row'>
        <div class='col-12'>
            <div class="card">
                <div class="card-body">


                    <div class="row">
                        <?php if (!isset($_GET['user_id']) && !isset($_POST['new']) && !isset($_POST['edit'])) {
                            $coltitle = "col-md-10";
                        } else {
                            $coltitle = "col-md-8";
                        } ?>
                        <div class="<?= $coltitle; ?>">
                            <h4 class="card-title"></h4>
                            <!-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6> -->
                        </div>
                        <?php if (!isset($_POST['new']) && !isset($_POST['edit']) && !isset($_GET['report'])) { ?>
                            <?php if (isset($_GET["user_id"])) { ?>
                                <form action="<?= base_url("manggota"); ?>" method="get" class="col-md-2">
                                    <h1 class="page-header col-md-12">
                                        <button class="btn btn-warning btn-block btn-lg" value="OK" style="">Back</button>
                                    </h1>
                                </form>
                            <?php } ?>
                            <?php 
                            if (
                                (
                                    isset(session()->get("position_administrator")[0][0]) 
                                    && (
                                        session()->get("position_administrator") == "1" 
                                        || session()->get("position_administrator") == "2"
                                    )
                                ) ||
                                (
                                    isset(session()->get("halaman")['37']['act_create']) 
                                    && session()->get("halaman")['37']['act_create'] == "1"
                                )
                            ) { ?>
                            <form method="post" class="col-md-2">
                                <h1 class="page-header col-md-12">
                                    <button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
                                    <input type="hidden" name="tanggungan_id" />
                                </h1>
                            </form>
                            <?php } ?>                            
                        <?php } ?>
                    </div>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $namabutton = 'name="change"';
                                $judul = "Update Tanggungan";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Tambah Tanggungan";
                            } ?>
                            <div class="lead">
                                <h3><?= $judul; ?></h3>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="tanggungan_name">Nama:</label>
                                    <div class="col-sm-10">
                                        <input required type="text" autofocus class="form-control" id="tanggungan_name" name="tanggungan_name" placeholder="" value="<?= $tanggungan_name; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="tanggungan_status">Status:</label>
                                    <div class="col-sm-10">
                                        <select required class="form-control" id="tanggungan_status" name="tanggungan_status" >
                                            <option value="Istri" <?=($tanggungan_status=="Istri")?"selected":"";?>>Istri</option>
                                            <option value="Suami" <?=($tanggungan_status=="Suami")?"selected":"";?>>Suami</option>
                                            <option value="Anak" <?=($tanggungan_status=="Anak")?"selected":"";?>>Anak</option>
                                            <option value="Saudara" <?=($tanggungan_status=="Saudara")?"selected":"";?>>Saudara</option>
                                            <option value="Orang Tua" <?=($tanggungan_status=="Orang Tua")?"selected":"";?>>Orang Tua</option>
                                            <option value="Kerabat" <?=($tanggungan_status=="Kerabat")?"selected":"";?>>Kerabat</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="tanggungan_picture">Photo:</label>
                                    <div class="col-sm-10">
                                        <input type="file" autofocus class="form-control" id="tanggungan_picture" name="tanggungan_picture" placeholder="" value="<?= $tanggungan_picture; ?>">
                                        <?php if($tanggungan_picture!=""){$user_image="images/tanggungan_picture/".$tanggungan_picture;}else{$user_image="images/tanggungan_picture/no_image.png";}?>
                                          <img id="tanggungan_picture_image" width="100" height="100" src="<?=base_url($user_image);?>"/>
                                          <script>
                                            function readURL(input) {
                                                if (input.files && input.files[0]) {
                                                    var reader = new FileReader();
                                        
                                                    reader.onload = function (e) {
                                                        $('#tanggungan_picture_image').attr('src', e.target.result);
                                                    }
                                        
                                                    reader.readAsDataURL(input.files[0]);
                                                }
                                            }
                                        
                                            $("#tanggungan_picture").change(function () {
                                                readURL(this);
                                            });
                                          </script>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="tanggungan_surat">Photo:</label>
                                    <div class="col-sm-10">
                                        <input type="file" autofocus class="form-control" id="tanggungan_surat" name="tanggungan_surat" placeholder="" value="<?= $tanggungan_surat; ?>">
                                        <?php if($tanggungan_surat!=""){$user_image="images/tanggungan_surat/".$tanggungan_surat;}else{$user_image="images/tanggungan_surat/no_image.png";}?>
                                          <img id="tanggungan_surat_image" width="100" height="100" src="<?=base_url($user_image);?>"/>
                                          <script>
                                            function readURL1(input) {
                                                if (input.files && input.files[0]) {
                                                    var reader = new FileReader();
                                        
                                                    reader.onload = function (e) {
                                                        $('#tanggungan_surat_image').attr('src', e.target.result);
                                                    }
                                        
                                                    reader.readAsDataURL(input.files[0]);
                                                }
                                            }
                                        
                                            $("#tanggungan_surat").change(function () {
                                                readURL1(this);
                                            });
                                          </script>
                                    </div>
                                </div>

                                <input type="hidden" name="tanggungan_id" value="<?= $tanggungan_id; ?>" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= base_url("mtanggungan"); ?>">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php } else { ?>
                        <?php if ($message != "") { ?>
                            <div class="alert alert-info alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong><?= $message; ?></strong><br />
                            </div>
                        <?php } ?>

                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                                <thead class="">
                                    <tr>
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <th>Action</th>
                                        <?php } ?>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Photo</th>
                                        <th>Surat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $usr = $this->db
                                        ->table("tanggungan")
                                        ->where("user_id",$this->request->getGet('user_id'))
                                        ->orderBy("tanggungan_id", "DESC")
                                        ->get();
                                    //echo $this->db->getLastquery();
                                    $no = 1;
                                    foreach ($usr->getResult() as $usr) { ?>
                                        <tr>
                                            <?php if (!isset($_GET["report"])) { ?>
                                                <td style="padding-left:0px; padding-right:0px;">
                                                    <?php 
                                                    if (
                                                        (
                                                            isset(session()->get("position_administrator")[0][0]) 
                                                            && (
                                                                session()->get("position_administrator") == "1" 
                                                                || session()->get("position_administrator") == "2"
                                                            )
                                                        ) ||
                                                        (
                                                            isset(session()->get("halaman")['37']['act_update']) 
                                                            && session()->get("halaman")['37']['act_update'] == "1"
                                                        )
                                                    ) { ?>
                                                    <form method="post" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                        <input type="hidden" name="tanggungan_id" value="<?= $usr->tanggungan_id; ?>" />
                                                    </form>
                                                    <?php }?>  
                                                    
                                                    <?php 
                                                    if (
                                                        (
                                                            isset(session()->get("position_administrator")[0][0]) 
                                                            && (
                                                                session()->get("position_administrator") == "1" 
                                                                || session()->get("position_administrator") == "2"
                                                            )
                                                        ) ||
                                                        (
                                                            isset(session()->get("halaman")['37']['act_delete']) 
                                                            && session()->get("halaman")['37']['act_delete'] == "1"
                                                        )
                                                    ) { ?>
                                                    <form method="post" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                        <input type="hidden" name="tanggungan_id" value="<?= $usr->tanggungan_id; ?>" />
                                                    </form>
                                                    <?php }?>
                                                </td>
                                            <?php } ?>
                                            <td><?= $usr->tanggungan_name; ?></td>
                                            <td><?= $usr->tanggungan_status; ?></td>
                                            <td><img src="images/tanggungan_picture/<?= $usr->tanggungan_picture; ?>"/></td>
                                            <td>
                                                <?php if($usr->tanggungan_surat!=""){?>
                                                <a target="_blank" href="images/tanggungan_surat/<?= $usr->tanggungan_surat; ?>">Download</a>
                                                <?php }?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.select').select2();
    var title = "Master Tanggungan";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo  $this->include("template/footer_v"); ?>