<?php echo $this->include("template/header_v"); ?>
<style>
    #dcari {
        border: rgba(123, 115, 115, 0.5) dashed 2px;
        border-radius: 5px;
        margin: 5px;
        padding: 10px;
    }

    tr.text-white>td {
        color: white !important;
    }
</style>

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
                    </div>
                    <div class="row" id="dcari">
                        <form method="post">
                            <div class="row">
                                <?php
                                $daftar_bulan = [
                                    0 => 'Pilih Bulan',
                                    1 => 'Januari',
                                    2 => 'Februari',
                                    3 => 'Maret',
                                    4 => 'April',
                                    5 => 'Mei',
                                    6 => 'Juni',
                                    7 => 'Juli',
                                    8 => 'Agustus',
                                    9 => 'September',
                                    10 => 'Oktober',
                                    11 => 'November',
                                    12 => 'Desember',
                                ];
                                $kalender_bulan = 0;
                                if (isset($_POST["kalender_bulan"])) {
                                    $kalender_bulan = $_POST["kalender_bulan"];
                                }
                                ?>

                                <div class="col">
                                    <select class="form-control" name="kalender_bulan">
                                        <?php foreach ($daftar_bulan as $id => $nama): ?>
                                            <option value="<?= $id; ?>" <?= ($kalender_bulan == $id) ? "selected" : ""; ?>>
                                                <?= $nama; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <button name="create" type="submit" class="btn btn-primary" value="OK"><span class="fa fa-search"></span> Submit</button>
                            </div>
                        </form>
                    </div>


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
                                    <th>Date</th>
                                    <th>Weekday</th>
                                    <th>Day Type</th>
                                    <th>Ramadlan</th>
                                    <th>Holiday Kind</th>
                                    <th>Holiday Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $usr = $this->db
                                    ->table("kalender")
                                    ->orderBy("kalender_tgl ASC")
                                    ->get();
                                //echo $this->db->getLastquery();
                                $no = 1;
                                $romadlon = array(0 => "", 1 => "Ya");
                                foreach ($usr->getResult() as $usr) {
                                    $bg = "";
                                    $tx = "";
                                    if ($usr->kalender_libur == 1) {
                                        $bg = "bg-danger";
                                        $tx = "text-white";
                                    }
                                ?>
                                    <tr id="tr<?= $usr->kalender_id; ?>" class="<?= $bg; ?> <?= $tx; ?>">
                                        <td class=""><?= $usr->kalender_tgl; ?></td>
                                        <td class="text-left"><?= $usr->kalender_hari; ?></td>
                                        <td class=""><?= $usr->kalender_name; ?></td>
                                        <td class="">
                                            <input id="rm<?= $usr->kalender_id; ?>" onclick="romadlon('<?= $usr->kalender_year; ?>-<?= $usr->kalender_bulan; ?>-<?= $usr->kalender_tgl; ?>','<?= $usr->kalender_id; ?>');" type="checkbox" value="1" <?= ($usr->kalender_romadlon == 1) ? "checked" : ""; ?> />
                                        </td>
                                        <td class="">
                                            <select onchange="klibur('<?= $usr->kalender_year; ?>-<?= $usr->kalender_bulan; ?>-<?= $usr->kalender_tgl; ?>','<?= $usr->kalender_id; ?>','<?= $usr->kalender_nhari; ?>')" class="form-control" name="kalender_libur" id="kalender_libur<?= $usr->kalender_id; ?>">
                                                <option value="0" <?= ($usr->kalender_libur == 0) ? "selected" : ""; ?>>Working Day</option>
                                                <option value="1" <?= ($usr->kalender_libur == 1) ? "selected" : ""; ?>>Holiday</option>
                                            </select>
                                        </td>
                                        <td class="">
                                            <?php if ($usr->kalender_libur == 0) {
                                                $none = "none";
                                            } else {
                                                $none = "inline";
                                            } ?>
                                            <form class="" id="flk<?= $usr->kalender_id; ?>" style="display:<?= $none; ?>;">
                                                <div class="row pr-3">
                                                    <div class="col">
                                                        <input class="form-control" id="lk<?= $usr->kalender_id; ?>" type="text" value="<?= $usr->kalender_liburk; ?>" />
                                                    </div>
                                                    <button class="btn btn-success" onclick="liburk('<?= $usr->kalender_id; ?>');"><i class="fa fa-check"></i></button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function klibur(tgl, id, libur_hari) {
        let lid = $("#kalender_libur" + id).val();
        let tr;
        if (lid == 1) {
            $("#flk" + id).show().val('');
            tr = 1;
            $("#tr" + id).addClass("bg-danger");
        } else {
            $("#flk" + id).hide();
            tr = 0;
            $("#tr" + id).removeClass("bg-danger");
        }
        $.get("<?= base_url("api/klibur"); ?>", {
                tgl: tgl,
                tr: tr,
                kalender_id: id,
                libur_hari: libur_hari
            })
            .done(function(data) {});
    }

    function romadlon(tgl, id) {
        let kalender_id = id;
        let isChecked = $("#rm" + id).is(":checked");
        let tr;
        if (isChecked) {
            tr = 1;
        } else {
            tr = 0;
        }
        $.get("<?= base_url("api/romadlon"); ?>", {
                tgl: tgl,
                tr: tr,
                kalender_id: kalender_id
            })
            .done(function(data) {

            });
    }
    $('.select').select2();
    var title = "Master Kalender";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo  $this->include("template/footer_v"); ?>