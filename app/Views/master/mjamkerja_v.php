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
                                        <input type="hidden" name="jamkerja_id" />
                                    </h1>
                                </form>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $namabutton = 'name="change"';
                                $judul = "Update Jam Kerja";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Tambah Jam Kerja";
                            } ?>
                            <div class="lead">
                                <h3><?= $judul; ?></h3>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="jamkerja_name">Nama Jam Kerja:</label>
                                    <div class="col-sm-10">
                                        <input autofocus type="text"  class="form-control" id="jamkerja_name" name="jamkerja_name" placeholder="" value="<?= $jamkerja_name; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="jamkerja_type">Tipe Jam/Hari:</label>
                                    <div class="col-sm-10">
                                        <select onchange="jtipe()" class="form-control" id="jamkerja_type" name="jamkerja_type">
                                            <option value="normal" <?= ($jamkerja_type == "normal") ? "selected" : ""; ?>>Normal</option>
                                            <option value="lembur" <?= ($jamkerja_type == "lembur") ? "selected" : ""; ?>>Lembur</option>
                                            <option value="libur" <?= ($jamkerja_type == "libur") ? "selected" : ""; ?>>Libur</option>
                                        </select>
                                    </div>
                                </div>

                                

                                <div class="form-group awalakhir">
                                    <label class="control-label col-sm-2" for="jamkerja_ramadlan">Kategory Ramadlan:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control iawalakhir" id="jamkerja_ramadlan" name="jamkerja_ramadlan">
                                            <option value="0" <?= ($jamkerja_ramadlan == "0") ? "selected" : ""; ?>>Bukan Ramadlan</option>
                                            <option value="1" <?= ($jamkerja_ramadlan == "1") ? "selected" : ""; ?>>Ramadlan</option>
                                        </select>
                                    </div>
                                </div>
                                <script>
                                    function jtipe() {
                                        let a = $("#jamkerja_type").val();
                                        if (a == "libur") {
                                            $(".awalakhir").hide();
                                            $(".iawalakhir").prop("value", "");
                                            $(".lembur").hide();
                                            $(".ilembur").val("");
                                            $(".nominal").hide();
                                            $(".inominal").val("");
                                        } else if (a == "lembur") {
                                            $(".awalakhir").hide();
                                            $(".iawalakhir").prop("value", "");
                                            $(".lembur").show();
                                            $(".nominal").show();
                                            $(".inominal").val("");
                                        } else {
                                            $(".awalakhir").show();
                                            $(".lembur").hide();
                                            $(".ilembur").val("");
                                            $(".nominal").hide();
                                            $(".inominal").val("");
                                        }
                                    }
                                    function jtipeawal() {
                                        let a = $("#jamkerja_type").val();
                                        if (a == "libur") {
                                            $(".awalakhir").hide();
                                            $(".lembur").hide();
                                            $(".nominal").hide();
                                        } else if (a == "lembur") {
                                            $(".awalakhir").hide();
                                            $(".lembur").show();
                                            $(".nominal").show();
                                        } else {
                                            $(".awalakhir").show();
                                            $(".lembur").hide();
                                            $(".nominal").hide();
                                        }
                                    }
                                    $(document).ready(function() {
                                        jtipeawal();
                                    });
                                </script>

                                <div class="form-group awalakhir">
                                    <label class="control-label col-sm-2" for="jamkerja_awal">Jam Kerja Awal:</label>
                                    <div class="col-sm-10">
                                        <input type="time"  class="form-control iawalakhir" id="jamkerja_awal" name="jamkerja_awal" placeholder="" value="<?= $jamkerja_awal; ?>">
                                    </div>
                                </div>


                                <div class="form-group awalakhir">
                                    <label class="control-label col-sm-2" for="jamkerja_akhir">Jam Kerja Akhir:</label>
                                    <div class="col-sm-10">
                                        <input type="time"  class="form-control iawalakhir" id="jamkerja_akhir" name="jamkerja_akhir" placeholder="" value="<?= $jamkerja_akhir; ?>">
                                    </div>
                                </div>


                                <div class="form-group lembur">
                                    <label class="control-label col-sm-2" for="jamkerja_menitawal">Lembur Menit Awal:</label>
                                    <div class="col-sm-10">
                                        <input type="number"  class="form-control ilembur" id="jamkerja_menitawal" name="jamkerja_menitawal" placeholder="" value="<?= $jamkerja_menitawal; ?>">
                                    </div>
                                </div>
                                <div class="form-group lembur">
                                    <label class="control-label col-sm-2" for="jamkerja_menitakhir">Lembur Menit Akhir:</label>
                                    <div class="col-sm-10">
                                        <input type="number"  class="form-control ilembur" id="jamkerja_menitakhir" name="jamkerja_menitakhir" placeholder="" value="<?= $jamkerja_menitakhir; ?>">
                                    </div>
                                </div>

                                <div class="form-group nominal">
                                    <label class="control-label col-sm-2" for="jamkerja_lnominal">Nominal:</label>
                                    <div class="col-sm-10">
                                        <input type="text"  class="form-control inominal" id="jamkerja_lnominal" name="jamkerja_lnominal" placeholder="" value="<?= $jamkerja_lnominal; ?>">
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label class="control-label col-sm-2" for="jamkerja_position">Jabatan:</label>
                                    <div class="col-sm-10">
                                        <?php
                                        $base = $this->db->table("position");
                                        $base->where("position_id!=", "1");
                                        $position = $base->orderBy("position_name", "ASC")->get();
                                        $jamkerja_position = isset($jamkerja_position) ? explode(",", $jamkerja_position) : [];

                                        ?>

                                        <select required class="form-control select" id="jamkerja_position" name="jamkerja_position[]" multiple>
                                            <?php
                                            foreach ($position->getResult() as $pos) { ?>
                                                <option value="<?= $pos->position_id; ?>" <?= (in_array($pos->position_id, $jamkerja_position)) ? "selected" : ""; ?>>
                                                    <?= $pos->position_name; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div> -->

                                <div class="form-group lembur">
                                    <label class="control-label col-sm-2" for="jamkerja_libur">Hari Libur:</label>
                                    <div class="col-sm-10">
                                        <select onchange="jtipe()" class="form-control ilembur" id="jamkerja_libur" name="jamkerja_libur">
                                            <option value="0" <?= ($jamkerja_libur == "0") ? "selected" : ""; ?>>Tidak</option>
                                            <option value="1" <?= ($jamkerja_libur == "1") ? "selected" : ""; ?>>Ya</option>
                                        </select>
                                    </div>
                                </div>

                                



                                <input type="hidden" name="jamkerja_id" value="<?= $jamkerja_id; ?>" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= base_url("mjamkerja"); ?>">Back</a>
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
                                        <th>Ramadlan</th>
                                        <th>Type</th>
                                        <th>Jam Kerja</th>
                                        <th>Jam Awal</th>
                                        <th>Jam Akhir</th>
                                        <th>Lembur Menit</th>
                                        <!-- <th>lembur</th> -->
                                        <th>Nominal</th>
                                        <th>Lembur Hari Libur</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $position = $this->db->table("position")->get();
                                    foreach ($position->getResult() as $pos) {
                                        $positionList[$pos->position_id] = $pos->position_name;
                                    }
                                    $usr = $this->db
                                        ->table("jamkerja")
                                        ->orderBy("jamkerja_ramadlan ASC, jamkerja_type ASC, jamkerja_libur ASC, jamkerja_name ASC")
                                        ->get();
                                    //echo $this->db->getLastquery();
                                    $no = 1;
                                    $ramadlan = array("Tidak", "Ya");                                    
                                    $libur = array("Tidak", "Ya");
                                    foreach ($usr->getResult() as $usr) {
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
                                                            <input type="hidden" name="jamkerja_id" value="<?= $usr->jamkerja_id; ?>" />
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
                                                            isset(session()->get("halaman")['49']['act_delete'])
                                                            && session()->get("halaman")['49']['act_delete'] == "1"
                                                        )
                                                    ) { ?>
                                                        <form method="post" class="btn-action" style="">
                                                            <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                            <input type="hidden" name="jamkerja_id" value="<?= $usr->jamkerja_id; ?>" />
                                                        </form>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>
                                            <!-- <td><?= $no++; ?></td> -->
                                            <td class=""><?= $ramadlan[$usr->jamkerja_ramadlan]; ?></td>
                                            <td class=""><?= ucfirst($usr->jamkerja_type); ?></td>
                                            <td class=""><?= $usr->jamkerja_name; ?></td>
                                            <td class=""><?= $usr->jamkerja_awal; ?></td>
                                            <td class=""><?= $usr->jamkerja_akhir; ?></td>
                                            <td class=""><?= $usr->jamkerja_menitawal; ?> - <?= $usr->jamkerja_menitakhir; ?></td>
                                            <td class=""><?= number_format($usr->jamkerja_lnominal,2,",","."); ?></td>                                            
                                            <td class=""><?= $libur[$usr->jamkerja_libur]; ?></td>
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
    var title = "Master Jam Kerja";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo  $this->include("template/footer_v"); ?>