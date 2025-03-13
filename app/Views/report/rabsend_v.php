<?php echo $this->include("template/header_v"); ?>
<style>
    .resumeg {
        background-color: aqua !important;
        color: white !important;
    }

    .resumer {
        background-color: indianred !important;
        color: white !important;
    }

    .resumey {
        background-color: beige !important;
        color: white !important;
    }

    .resumebl {
        background-color: aquamarine !important;
        color: white !important;
    }

    .resumeb {
        background-color: darkgrey !important;
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
                                    isset(session()->get("halaman")['3']['act_create'])
                                    && session()->get("halaman")['3']['act_create'] == "1"
                                )
                            ) { ?>
                                <!-- <form method="post" class="col-md-2">
                                <h1 class="page-header col-md-12">
                                    <button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
                                    <input type="hidden" name="panen_id" />
                                </h1>
                            </form> -->
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <?php if ($message != "") { ?>
                        <div class="alert alert-info alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><?= $message; ?></strong>
                        </div>
                    <?php } ?>
                    <div class="alert alert-success">
                        <form>
                            <div class="row">
                                <?php
                                $bln = date("n");
                                if (isset($_GET["bln"])) {
                                    $bln = $_GET["bln"];
                                }

                                $estate = "";
                                $divisi = "";
                                if (isset($_GET["estate"])) {
                                    $estate = $_GET["estate"];
                                }
                                if (isset($_GET["divisi"])) {
                                    $divisi = $_GET["divisi"];
                                }
                                ?>
                                <div class="col-4 row mb-2">
                                    <div class="col-3">
                                        <label class="text-dark">Estate</label>
                                    </div>
                                    <div class="col-9">
                                        <select onChange="divisid()" class="form-control" id="estate" name="estate">
                                            <option value="" <?= ($estate == "") ? "selected" : ""; ?>>
                                                Semua Estate
                                            </option>
                                            <?php
                                            $estated = $this->db->table("estate")->get();
                                            foreach ($estated->getResult() as $estated) { ?>
                                                <option value="<?= $estated->estate_id; ?>" <?= ($estated->estate_id == $estate) ? "selected" : ""; ?>>
                                                    <?= $estated->estate_name; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <script>
                                            function divisid() {
                                                let estaten = $("#estate").val();
                                                let divisin = '<?= $divisi; ?>';
                                                $.get("<?= base_url("api/divisi"); ?>", {
                                                        estate_id: estaten,
                                                        divisi_id: divisin
                                                    })
                                                    .done(function(data) {
                                                        $("#divisi").html(data);
                                                    });
                                            }
                                            divisid();
                                        </script>
                                    </div>
                                </div>
                                <div class="col-4 row mb-2">
                                    <div class="col-3">
                                        <label class="text-dark">Divisi</label>
                                    </div>
                                    <div class="col-9">
                                        <select class="form-control" id="divisi" name="divisi">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-4 row mb-2">
                                    <div class="col-3">

                                    </div>
                                    <div class="col-9">

                                    </div>
                                </div>
                                <div class="col-4 row">
                                    <div class="col-3">
                                        <label class="text-dark">Bulan</label>
                                    </div>
                                    <div class="col-9">
                                        <select class="form-control" name="bln">
                                            <option value="1" <?= ($bln == "1") ? "selected" : ""; ?>>Januari</option>
                                            <option value="2" <?= ($bln == "2") ? "selected" : ""; ?>>Februari</option>
                                            <option value="3" <?= ($bln == "3") ? "selected" : ""; ?>>Maret</option>
                                            <option value="4" <?= ($bln == "4") ? "selected" : ""; ?>>April</option>
                                            <option value="5" <?= ($bln == "5") ? "selected" : ""; ?>>Mei</option>
                                            <option value="6" <?= ($bln == "6") ? "selected" : ""; ?>>Juni</option>
                                            <option value="7" <?= ($bln == "7") ? "selected" : ""; ?>>Juli</option>
                                            <option value="8" <?= ($bln == "8") ? "selected" : ""; ?>>Agustus</option>
                                            <option value="9" <?= ($bln == "9") ? "selected" : ""; ?>>September</option>
                                            <option value="10" <?= ($bln == "10") ? "selected" : ""; ?>>Oktober</option>
                                            <option value="11" <?= ($bln == "11") ? "selected" : ""; ?>>November</option>
                                            <option value="12" <?= ($bln == "12") ? "selected" : ""; ?>>Desember</option>
                                        </select>
                                    </div>
                                </div>
                                <?php if (isset($_GET["report"])) { ?>
                                    <input type="hidden" name="report" value="OK" />
                                <?php } ?>
                                <div class="col-4 row mb-2">
                                    <div class="col-3">
                                        <label class="text-dark"></label>
                                    </div>
                                    <div class="col-9">
                                        <button type="submit" class="btn btn-block btn-primary">Cari</button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive m-t-40">
                        <table id="example2310" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                            <thead class="">
                                <tr>
                                    <th>Divisi</th>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <?php
                                    for ($x = 1; $x <= 31; $x++) { ?>
                                        <th><?= $x; ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $build = $this->db
                                    ->table("absen")
                                    ->select("DAY(absen_date) AS day, absen_type, absen_user")
                                    ->join("t_user", "t_user.user_id = absen.absen_user")
                                    ->where("MONTH(absen_date)", $bln);
                                    if($estate>0){
                                        $build->where("estate_id",$estate);
                                    }
                                    if($divisi>0){
                                        $build->where("divisi_id",$divisi);
                                    }
                                    $usr = $build
                                    ->groupBy("absen_date, absen_user")
                                    ->get();

                                $array = [];
                                $Masuk = 0;
                                $Keluar = 0;
                                $Izin = 0;
                                $Sakit = 0;
                                $Mangkir = 0;
                                foreach ($usr->getResult() as $row) {
                                    $absen_type = $row->absen_type;
                                    $day = $row->day;
                                    switch ($absen_type) {
                                        case "Masuk":
                                            $Masuk++;
                                            $array[$day][$row->absen_user] = "M";
                                            break;
                                        case "Keluar":
                                            $Keluar++;
                                            $array[$day][$row->absen_user] = "MP";
                                            break;
                                        case "Izin":
                                            $Izin++;
                                            $array[$day][$row->absen_user] = "I";
                                            break;
                                        case "Sakit":
                                            $Sakit++;
                                            $array[$day][$row->absen_user] = "S";
                                            break;
                                        case "Mangkir":
                                            $Mangkir++;
                                            $array[$day][$row->absen_user] = "A";
                                            break;
                                    }
                                }

                                $build = $this->db
                                    ->table("absen")
                                    ->select("absen.divisi_name,absen.absen_user,absen.absen_username,t_user.user_nik")
                                    ->join("t_user", "t_user.user_id = absen.absen_user", "left")
                                    ->where("MONTH(absen_date)", $bln);
                                    if($estate>0){
                                        $build->where("estate_id",$estate);
                                    }
                                    if($divisi>0){
                                        $build->where("divisi_id",$divisi);
                                    }
                                    $usr = $build->groupBy("absen_user")
                                    ->orderBy("absen.absen_date", "ASC")
                                    ->orderBy("absen.absen_username", "ASC")
                                    ->get();
                                $no = 1;
                                foreach ($usr->getResult() as $usr) { ?>
                                    <tr>
                                        <td><?= $usr->divisi_name; ?></td>
                                        <td><?= $usr->absen_username; ?></td>
                                        <td><?= $usr->user_nik; ?></td>
                                        <?php
                                        for ($x = 1; $x <= 31; $x++) { ?>
                                            <td>
                                                <?php
                                                // $tgl=str_pad($x, 2, "0", STR_PAD_LEFT);
                                                $tgl = $x;
                                                if (isset($array[$tgl][$usr->absen_user])) {
                                                    echo $array[$tgl][$usr->absen_user];
                                                }; ?>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                                <tr class="resumeg">
                                    <td>Masuk</td>
                                    <td><?= $Masuk; ?></td>
                                    <td></td>
                                    <?php
                                    for ($x = 1; $x <= 31; $x++) { ?>
                                        <td></td>
                                    <?php } ?>
                                </tr>
                                <tr class="resumebl">
                                    <td>Pulang</td>
                                    <td><?= $Keluar; ?></td>
                                    <td></td>
                                    <?php
                                    for ($x = 1; $x <= 31; $x++) { ?>
                                        <td></td>
                                    <?php } ?>
                                </tr>
                                <tr class="resumey">
                                    <td>Izin</td>
                                    <td><?= $Izin; ?></td>
                                    <td></td>
                                    <?php
                                    for ($x = 1; $x <= 31; $x++) { ?>
                                        <td></td>
                                    <?php } ?>
                                </tr>
                                <tr class="resumeb">
                                    <td>Sakit</td>
                                    <td><?= $Sakit; ?></td>
                                    <td></td>
                                    <?php
                                    for ($x = 1; $x <= 31; $x++) { ?>
                                        <td></td>
                                    <?php } ?>
                                </tr>
                                <tr class="resumer">
                                    <td>Mangkir</td>
                                    <td><?= $Mangkir; ?></td>
                                    <td></td>
                                    <?php
                                    for ($x = 1; $x <= 31; $x++) { ?>
                                        <td></td>
                                    <?php } ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.select').select2();
    var title = "Rangkuman Absensi";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo $this->include("template/footer_v"); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example2310').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'copyHtml5',
                    title: 'Rangkuman Absensi',
                    filename: 'Rangkuman Absensi ',
                    text: 'Copy'
                },
                {
                    extend: 'csvHtml5',
                    title: 'Rangkuman Absensi',
                    filename: 'Rangkuman Absensi ',
                    text: 'Export to CSV'
                },
                {
                    extend: 'excelHtml5',
                    title: 'Rangkuman Absensi Excel',
                    filename: 'Rangkuman Absensi ',
                    text: 'Export to Excel'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Rangkuman Absensi',
                    filename: 'Rangkuman Absensi ',
                    text: 'Export to PDF',
                    customize: function(doc) {
                        doc.content[1].table.headerRows = 1;
                        doc.content[1].table.body[0].forEach(function(h) {
                            h.text = h.text.toUpperCase();
                            h.fillColor = '#dddddd';
                        });
                    }
                },
                {
                    extend: 'print',
                    title: 'Judul Custom',
                    text: 'Print'
                }
            ],
            footerCallback: function(row, data, start, end, display) {
                var api = this.api();

                // Data statis untuk baris rekap
                var masuk = <?= $Masuk; ?>;
                var keluar = <?= $Keluar; ?>;
                var izin = <?= $Izin; ?>;
                var sakit = <?= $Sakit; ?>;
                var mangkir = <?= $Mangkir; ?>;

                // Update footer dengan data rekap
                $(api.column(0).footer()).html('Masuk');
                $(api.column(1).footer()).html(masuk);
                for (var i = 2; i <= 32; i++) {
                    $(api.column(i).footer()).html('');
                }

                var footerRow = $(api.column(0).footer().parentNode);
                footerRow.next('tr').html('<td>Pulang</td><td>' + keluar + '</td><td></td>' + '<td></td>'.repeat(31));
                footerRow.next('tr').next('tr').html('<td>Izin</td><td>' + izin + '</td><td></td>' + '<td></td>'.repeat(31));
                footerRow.next('tr').next('tr').next('tr').html('<td>Sakit</td><td>' + sakit + '</td><td></td>' + '<td></td>'.repeat(31));
                footerRow.next('tr').next('tr').next('tr').next('tr').html('<td>Mangkir</td><td>' + mangkir + '</td><td></td>' + '<td></td>'.repeat(31));
            }
        });
    });
</script>