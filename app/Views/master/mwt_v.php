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
                                    isset(session()->get("halaman")['49']['act_create']) 
                                    && session()->get("halaman")['49']['act_create'] == "1"
                                )
                            ) { ?>
                            <form method="post" class="col-md-2">
                                <h1 class="page-header col-md-12">
                                    <button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
                                    <input type="hidden" name="wt_id" />
                                </h1>
                            </form>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $namabutton = 'name="change"';
                                $judul = "Update Vehicle";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Tambah Vehicle";
                            } ?>
                            <div class="lead">
                                <h3><?= $judul; ?></h3>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">                                                      
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="wt_jenis">Jenis Kendaraan:</label>
                                    <div class="col-sm-10">
                                        <select required class="form-control" id="wt_jenis" name="wt_jenis">
                                            <option value="0" <?=($wt_jenis=="0")?"selected":"";?>>Pilih Jenis Kendaraan</option>
                                            <option value="DT" <?=($wt_jenis=="DT")?"selected":"";?>>Dump Truck</option>
                                            <option value="WT" <?=($wt_jenis=="WT")?"selected":"";?>>Eskavator</option>
                                            <option value="WT" <?=($wt_jenis=="WT")?"selected":"";?>>Mobil Pribadi</option>
                                        </select>
                                    </div>
                                </div>                                                                     
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="wt_vendor">Masa Sewa:</label>
                                    <div class="col-sm-10">
                                        <select required class="form-control" id="wt_vendor" name="wt_vendor">
                                        <option value="" <?=($wt_sewa=="")?"selected":"";?>>Pilih Masa Sewa</option>
                                            <option value="tahunan" <?=($wt_vendor=="tahunan")?"selected":"";?>>Sewa Tahunan</option>
                                            <option value="bulanan" <?=($wt_vendor=="bulanan")?"selected":"";?>>Sewa Bulanan</option>
                                        </select>
                                    </div>
                                </div>                                                                    
                                <div class="form-group sewa">
                                    <label class="control-label col-sm-2" for="wt_sewa">Vendor:</label>
                                    <div class="col-sm-10">
                                        <select required class="form-control" id="wt_sewa" name="wt_sewa">
                                            <option value="0" <?=($wt_sewa=="0")?"selected":"";?>>Pilih Vendor</option>
                                            <option value="1" <?=($wt_sewa=="1")?"selected":"";?>>Vendor 1</option>
                                            <option value="2" <?=($wt_sewa=="2")?"selected":"";?>>Vendor 2</option>
                                        </select>
                                    </div>
                                </div>                                                      
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="wt_name">Vehicle (Kendaraan):</label>
                                    <div class="col-sm-9">
                                        <input required type="text" autofocus class="form-control" id="wt_name" name="wt_name" placeholder="" value="<?= $wt_name; ?>">
                                    </div>
                                </div>                                                     
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="wt_nopol">Plat:</label>
                                    <div class="col-sm-9">
                                        <input type="text" autofocus class="form-control" id="wt_nopol" name="wt_nopol" placeholder="" value="<?= $wt_nopol; ?>">
                                    </div>
                                </div>   

                                <input type="hidden" name="wt_id" value="<?= $wt_id; ?>" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= base_url("mwt"); ?>">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php } else { ?>
                        <?php if ($message != "") { ?>
                            <div class="alert alert-info alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong><?= $message; ?></strong>
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
                                        <!-- <th>No.</th> -->
                                        <th>Jenis Kendaraan</th>
                                        <th>Masa Sewa</th>
                                        <th>Vendor</th>
                                        <th>Nama Kendaraan</th>
                                        <th>Plat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $usr = $this->db
                                        ->table("wt")
                                        ->orderBy("wt_name", "ASC")
                                        ->get();
                                    //echo $this->db->getLastquery();
                                    $no = 1;
                                    foreach ($usr->getResult() as $usr) {                                  
                                        $vendor =array("","PAM","VF","Sewa Bulanan");                      
                                        $sewa =array("","Wong Ganteng","VF","Putri Tunggal","Surya Gemilang");
                                        ?>
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
                                                            isset(session()->get("halaman")['49']['act_update']) 
                                                            && session()->get("halaman")['49']['act_update'] == "1"
                                                        )
                                                    ) { ?>
                                                    <form method="post" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                        <input type="hidden" name="wt_id" value="<?= $usr->wt_id; ?>" />
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
                                                            isset(session()->get("halaman")['49']['act_delete']) 
                                                            && session()->get("halaman")['49']['act_delete'] == "1"
                                                        )
                                                    ) { ?>
                                                    <form method="post" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                        <input type="hidden" name="wt_id" value="<?= $usr->wt_id; ?>" />
                                                    </form>
                                                    <?php }?>
                                                </td>
                                            <?php } ?>
                                            <!-- <td><?= $no++; ?></td> -->
                                            <td><?= $usr->wt_jenis; ?></td>
                                            <td><?= $sewa[$usr->wt_sewa]; ?></td>
                                            <td><?= $vendor[$usr->wt_vendor]; ?></td>
                                            <td><?= $usr->wt_name; ?></td>
                                            <td><?= $usr->wt_nopol; ?></td>
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
    var title = "Master Vehicle";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
    $(document).ready(function(){
        sewab();
    });
</script>

<?php echo  $this->include("template/footer_v"); ?>