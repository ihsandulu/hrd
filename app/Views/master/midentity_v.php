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
                                <form action="<?= base_url("user"); ?>" method="get" class="col-md-2">
                                    <h1 class="page-header col-md-12">
                                        <button class="btn btn-warning btn-block btn-lg" value="OK" style="">Back</button>
                                    </h1>
                                </form>
                            <?php } ?>                            
                        <?php } ?>
                    </div>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $namabutton = 'name="change"';
                                $judul = "Update Identity";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Tambah Identity";
                            } ?>
                            <div class="lead">
                                <h3><?= $judul; ?></h3>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="identity_name">Identity:</label>
                                    <div class="col-sm-10">
                                        <input required type="text" autofocus class="form-control" id="identity_name" name="identity_name" placeholder="" value="<?= $identity_name; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="identity_address">Alamat:</label>
                                    <div class="col-sm-10">
                                        <input type="text" autofocus class="form-control" id="identity_address" name="identity_address" placeholder="" value="<?= $identity_address; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="identity_owner">Owner:</label>
                                    <div class="col-sm-10">
                                        <input type="text" autofocus class="form-control" id="identity_owner" name="identity_owner" placeholder="" value="<?= $identity_owner; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="identity_phone">Phone:</label>
                                    <div class="col-sm-10">
                                        <input type="text" autofocus class="form-control" id="identity_phone" name="identity_phone" placeholder="" value="<?= $identity_phone; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="identity_wa">Whatsapp:</label>
                                    <div class="col-sm-10">
                                        <input type="text" autofocus class="form-control" id="identity_wa" name="identity_wa" placeholder="" value="<?= $identity_wa; ?>">
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label class="control-label col-sm-2" for="identity_about">About:</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="identity_about" name="identity_about" placeholder="Mis:Barang tidak dapat ditukar."><?= $identity_about; ?></textarea>
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="identity_logo">Logo: (Max 134 X 134)</label>
                                    <div class="col-sm-12">
                                        <input type="file" autofocus class="form-control" id="identity_logo" name="identity_logo" placeholder="" value="<?= $identity_logo; ?>">
                                        <?php if($identity_logo!=""){$user_image="images/identity_logo/".$identity_logo;}else{$user_image="images/identity_logo/no_image.png";}?>
                                          <img id="identity_logo_image" width="100" height="100" src="<?=base_url($user_image);?>"/>
                                          <script>
                                            function readURL(input) {
                                                if (input.files && input.files[0]) {
                                                    var reader = new FileReader();
                                        
                                                    reader.onload = function (e) {
                                                        $('#identity_logo_image').attr('src', e.target.result);
                                                    }
                                        
                                                    reader.readAsDataURL(input.files[0]);
                                                }
                                            }
                                        
                                            $("#identity_logo").change(function () {
                                                readURL(this);
                                            });
                                          </script>
                                    </div>
                                </div>

                                <input type="hidden" name="identity_id" value="<?= $identity_id; ?>" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= base_url("midentity"); ?>">Back</a>
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
                                        <th>Identity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $usr = $this->db
                                        ->table("identity")
                                        ->orderBy("identity_name", "ASC")
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
                                                            isset(session()->get("halaman")['28']['act_update']) 
                                                            && session()->get("halaman")['28']['act_update'] == "1"
                                                        )
                                                    ) { ?>
                                                    <form method="post" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                        <input type="hidden" name="identity_id" value="<?= $usr->identity_id; ?>" />
                                                    </form>
                                                    <?php }?>  
                                                </td>
                                            <?php } ?>
                                            <td><?= $usr->identity_name; ?></td>
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
    var title = "Master Identity";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo  $this->include("template/footer_v"); ?>