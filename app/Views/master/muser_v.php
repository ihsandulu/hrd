<?php echo $this->include("template/header_v"); ?>
<style>
    th,
    td {
        padding: 5px !important;
        white-space: nowrap !important;
    }

    .float-left {
        float: left;
    }

    #dimport {
        border: rgba(123, 115, 115, 0.5) dashed 2px;
        border-radius: 5px;
        margin: 5px;
        padding: 10px;
    }

    #dcari {
        border: rgba(123, 115, 115, 0.5) dashed 2px;
        border-radius: 5px;
        margin: 5px;
        padding: 10px;
    }

    .form-inline label {
        justify-content: left;
    }

    .nowrap {
        white-space: nowrap;
    }

    .card-title {
        background-color: rgba(3, 150, 23, 0.5);
        padding: 5px;
        font-size: 15px;
        border-radius: 5px;
        color: white;
    }

    .sub-title {
        background-color: rgba(150, 189, 72, 0.5);
        padding: 5px;
        font-size: 15px;
        border-radius: 5px;
        color: white;
        margin-bottom: 5px;
    }

    .blok {
        border: rgba(174, 168, 168, 0.5) solid 2px;
        border-radius: 5px;
        margin: 5px;
        padding: 10px;
    }
</style>
<div class='container-fluid'>
    <div class='row'>
        <div class='col-12'>
            <div class="card">
                <div class="card-body">


                    <div class="row">
                        <?php if (!isset($_GET['user_id']) && !isset($_POST['new']) && !isset($_POST['edit'])) {
                            $coltitle = "float-left";
                        } else {
                            $coltitle = "float-left";
                        } ?>
                        <div class="pl-3 <?= $coltitle; ?>">
                            <div class="card-title "></div>
                            <!-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6> -->
                        </div>
                        <?php if (!isset($_POST['new']) && !isset($_POST['edit']) && !isset($_GET['report'])) { ?>
                            <?php if (isset($_GET["user_id"])) { ?>
                                <form action="<?= base_url("user"); ?>" method="get" class="float-left">
                                    <h1 class="page-header col-md-12">
                                        <button class="btn btn-warning btn-block btn-lg" value="OK" style="">Back</button>
                                    </h1>
                                </form>
                            <?php } ?>
                            <form method="post" class="float-left">
                                <h1 class="page-header col-md-12">
                                    <button name="new" class="btn btn-info btn-block btn-sm" value="OK" style="">New</button>
                                    <input type="hidden" name="user_id" />
                                </h1>
                            </form>
                            <form method="post" class="float-left">
                                <h1 class="page-header col-md-12">
                                    <button type="button" onclick="tampilimport()" class="btn btn-info btn-block btn-sm" value="" style="">Import Data</button>
                                </h1>
                            </form>
                            <form method="post" class="float-left">
                                <h1 class="page-header col-md-12">
                                    <button type="button" onclick="tampilcari()" class="btn btn-info btn-block btn-sm" value="" style="">Cari</button>
                                </h1>
                                <script>
                                    function tampilimport() {
                                        $("#dimport").toggle();
                                    }
                                    $().ready(function() {
                                        $("#dimport").hide();
                                    });
                                </script>
                            </form>
                        <?php } ?>
                    </div>
                    <script>
                        function tampilimport() {
                            $("#dimport").toggle();
                        }

                        function tampilcari() {
                            $("#dcari").toggle();
                        }
                        $().ready(function() {
                            $("#dimport").hide();
                            $("#dcari").show();
                        });
                    </script>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $user_namabutton = 'name="change"';
                                $ketuser_password = "Kosongkan jika tidak ingin merubah user_password!";
                            } else {
                                $user_namabutton = 'name="create"';
                                $ketuser_password = "Jangan dikosongkan!";
                            } ?>
                            <form class="form-horizontal " method="post" enctype="multipart/form-data">
                                <?php if (session()->get("position_id") == "110" || session()->get("position_id") == "111" || session()->get("position_id") == "112" || session()->get("position_id") == "1") { ?>
                                    <div class="blok row ">
                                        <div class="sub-title col-12">* HR Recruitment</div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <select autofocus title="Status" data-bs-toggle="tooltip" data-bs-placement="top" required class="form-control" id="user_status" name="user_status">
                                                    <option value="1" <?= ($user_status == 1) ? "selected" : ""; ?>>Aktif</option>
                                                    <option value="0" <?= ($user_status == 0) ? "selected" : ""; ?>>Tidak Aktif</option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <?php
                                                $departemen = $this->db->table("departemen")->orderBy("departemen_name", "ASC")
                                                    ->get();
                                                //echo $this->db->getLastQuery();
                                                ?>
                                                <select title="Departemen" data-bs-toggle="tooltip" data-bs-placement="top" required class="form-control select" id="departemen_id" name="departemen_id">
                                                    <option value="" <?= ($departemen_id == "") ? "selected" : ""; ?>>Pilih Departemen</option>
                                                    <?php
                                                    foreach ($departemen->getResult() as $departemen) { ?>
                                                        <option value="<?= $departemen->departemen_id; ?>" <?= ($departemen_id == $departemen->departemen_id) ? "selected" : ""; ?>><?= $departemen->departemen_name; ?></option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <?php
                                                $base = $this->db->table("position");
                                                if (session()->get("position_id") != "1") {
                                                    $base->where("position_id!=", "1");
                                                }
                                                $position = $base->orderBy("position_name", "ASC")
                                                    ->get();
                                                //echo $this->db->getLastQuery();
                                                ?>
                                                <select title="Jabatan" data-bs-toggle="tooltip" data-bs-placement="top" required class="form-control select" id="position_id" name="position_id">
                                                    <option value="" <?= ($position_id == "") ? "selected" : ""; ?>>Pilih Jabatan</option>
                                                    <?php
                                                    foreach ($position->getResult() as $position) { ?>
                                                        <option value="<?= $position->position_id; ?>" <?= ($position_id == $position->position_id) ? "selected" : ""; ?>><?= $position->position_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Nama Lengkap" data-bs-toggle="tooltip" data-bs-placement="top" required type="text" class="form-control" id="user_nama" name="user_nama" placeholder="Nama Lengkap" value="<?= $user_nama; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="NIK" data-bs-toggle="tooltip" data-bs-placement="top" type="text" class="form-control" id="user_nik" name="user_nik" placeholder="NIK" value="<?= $user_nik; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="KTP" data-bs-toggle="tooltip" data-bs-placement="top" type="text" class="form-control" id="user_ktp" name="user_ktp" placeholder="KTP" value="<?= $user_ktp; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="ETAG" data-bs-toggle="tooltip" data-bs-placement="top" type="text" class="form-control" id="user_etag" name="user_etag" placeholder="ETAG" value="<?= $user_etag; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Tgl Masuk" data-bs-toggle="tooltip" data-bs-placement="top" required type="date" class="form-control" id="user_masuk" name="user_masuk" placeholder="Tgl Masuk" value="<?= $user_masuk; ?>">

                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Tgl Keluar" data-bs-toggle="tooltip" data-bs-placement="top" type="date" class="form-control" id="user_keluar" name="user_keluar" placeholder="Tgl Keluar" value="<?= $user_keluar; ?>">

                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Whatsapp" data-bs-toggle="tooltip" data-bs-placement="top" type="text" class="form-control" id="user_wa" name="user_wa" placeholder="Whatsapp" value="<?= $user_wa; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="NPWP" data-bs-toggle="tooltip" data-bs-placement="top" type="text" class="form-control" id="user_npwp" name="user_npwp" placeholder="NPWP" value="<?= $user_npwp; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Nomor BPJS TK" data-bs-toggle="tooltip" data-bs-placement="top" type="text" class="form-control" id="user_bpjstk" name="user_bpjstk" placeholder="Nomor BPJS TK" value="<?= $user_bpjstk; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Nomor BPJS Kesehatan" data-bs-toggle="tooltip" data-bs-placement="top" type="text" class="form-control" id="user_bpjskesehatan" name="user_bpjskesehatan" placeholder="Nomor BPJS Kesehatan" value="<?= $user_bpjskesehatan; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Alamat" data-bs-toggle="tooltip" data-bs-placement="top" type="text" class="form-control" id="user_address" name="user_address" placeholder="Alamat" value="<?= $user_address; ?>">

                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Kartu Keluarga" data-bs-toggle="tooltip" data-bs-placement="top" type="text" class="form-control" id="user_kk" name="user_kk" placeholder="Kartu Keluarga" value="<?= $user_kk; ?>">

                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <select title="Bank" data-bs-toggle="tooltip" data-bs-placement="top" class="form-control" id="user_bank" name="user_bank">
                                                    <option value="MANDIRI" <?= ($user_bank == "MANDIRI") ? "selected" : ""; ?>>MANDIRI</option>
                                                    <option value="BCA" <?= ($user_bank == "BCA") ? "selected" : ""; ?>>BCA</option>
                                                    <option value="BNI" <?= ($user_bank == "BNI") ? "selected" : ""; ?>>BNI</option>
                                                    <option value="BRI" <?= ($user_bank == "BRI") ? "selected" : ""; ?>>BRI</option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="No Rek" data-bs-toggle="tooltip" data-bs-placement="top" type="text" class="form-control" id="user_norek" name="user_norek" placeholder="No Rek" value="<?= $user_norek; ?>">

                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Nama Ibu" data-bs-toggle="tooltip" data-bs-placement="top" type="text" class="form-control" id="user_ibu" name="user_ibu" placeholder="Nama Ibu" value="<?= $user_ibu; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <select title="Pendidikan" data-bs-toggle="tooltip" data-bs-placement="top" class="form-control" id="user_pendidikan" name="user_pendidikan">
                                                    <option value="SD" <?= ($user_pendidikan == "SD") ? "selected" : ""; ?>>SD</option>
                                                    <option value="SMP" <?= ($user_pendidikan == "SMP") ? "selected" : ""; ?>>SMP</option>
                                                    <option value="SMA" <?= ($user_pendidikan == "SMA") ? "selected" : ""; ?>>SMA</option>
                                                    <option value="D1" <?= ($user_pendidikan == "D1") ? "selected" : ""; ?>>D1</option>
                                                    <option value="D2" <?= ($user_pendidikan == "D2") ? "selected" : ""; ?>>D2</option>
                                                    <option value="D3" <?= ($user_pendidikan == "D3") ? "selected" : ""; ?>>D3</option>
                                                    <option value="S1" <?= ($user_pendidikan == "S1") ? "selected" : ""; ?>>S1</option>
                                                    <option value="S2" <?= ($user_pendidikan == "S2") ? "selected" : ""; ?>>S2</option>
                                                    <option value="S3" <?= ($user_pendidikan == "S3") ? "selected" : ""; ?>>S3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Tgl Lahir" data-bs-toggle="tooltip" data-bs-placement="top" type="date" class="form-control" id="user_borndate" name="user_borndate" placeholder="Tgl Lahir" value="<?= $user_borndate; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Tempat Lahir" data-bs-toggle="tooltip" data-bs-placement="top" type="text" class="form-control" id="user_borncity" name="user_borncity" placeholder="Tempat Lahir" value="<?= $user_borncity; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <select title="L/P" data-bs-toggle="tooltip" data-bs-placement="top" class="form-control" id="user_gender" name="user_gender">
                                                    <option value="" <?= ($user_gender == "") ? "selected" : ""; ?>>Pilih Gender</option>
                                                    <option value="L" <?= ($user_gender == "L") ? "selected" : ""; ?>>L</option>
                                                    <option value="P" <?= ($user_gender == "P") ? "selected" : ""; ?>>P</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <select title="Status Tanggungan" data-bs-toggle="tooltip" data-bs-placement="top" onchange="pph()" class="form-control" id="user_tanggungan" name="user_tanggungan">
                                                    <option value="" <?= ($user_tanggungan == "") ? "selected" : ""; ?>>Pilih Status</option>
                                                    <?php $tanggungan = $this->db->table("tanggungan")->get();
                                                    foreach ($tanggungan->getResult() as $tanggungan) { ?>
                                                        <option value="<?= $tanggungan->tanggungan_jenis; ?>" data-ter="<?= $tanggungan->tanggungan_ter; ?>" <?= ($user_tanggungan == $tanggungan->tanggungan_jenis) ? "selected" : ""; ?>><?= $tanggungan->tanggungan_jenis; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <script>
                                            function pph() {
                                                let ter = $("#user_tanggungan option:selected").attr("data-ter");
                                                $("#user_tanggunganjenis").val(ter);
                                            }
                                        </script>

                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Jenis Tanggungan" data-bs-toggle="tooltip" data-bs-placement="top" type="text" class="form-control" id="user_tanggunganjenis" name="user_tanggunganjenis" placeholder="Jenis Tanggungan" value="<?= $user_tanggunganjenis; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <select title="Tipe Penggajian" data-bs-toggle="tooltip" data-bs-placement="top" class="form-control" id="user_payrolltype" name="user_payrolltype">
                                                    <option value="bulanan" <?= ($user_payrolltype == "bulanan") ? "selected" : ""; ?>>Bulanan</option>
                                                    <option value="harian" <?= ($user_payrolltype == "harian") ? "selected" : ""; ?>>Harian</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (session()->get("position_id") == "109" || session()->get("position_id") == "112" || session()->get("position_id") == "1") { ?>
                                    <div class="blok row ">
                                        <div class="sub-title col-12">* HR General</div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Password" data-bs-toggle="tooltip" data-bs-placement="top" type="text" class="form-control" id="user_password" name="user_password" placeholder="<?= $ketuser_password; ?>" value="<?= $user_password; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Email" data-bs-toggle="tooltip" data-bs-placement="top" type="email" class="form-control" id="user_email" name="user_email" placeholder="Email" value="<?= $user_email; ?>">

                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Sisa Cuti" data-bs-toggle="tooltip" data-bs-placement="top" type="number" class="form-control" id="user_cuti" name="user_cuti" placeholder="Sisa Cuti" value="<?= $user_cuti; ?>">

                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <select title="Lembur" data-bs-toggle="tooltip" data-bs-placement="top" class="form-control" id="user_lembur" name="user_lembur">
                                                    <option value="0" <?= ($user_lembur == "0") ? "selected" : ""; ?>>Tidak</option>
                                                    <option value="1" <?= ($user_lembur == "1") ? "selected" : ""; ?>>Perjam</option>
                                                    <option value="2" <?= ($user_lembur == "2") ? "selected" : ""; ?>>Insentif</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Gaji Kotor" data-bs-toggle="tooltip" data-bs-placement="top" onchange="tlain()" type="text" class="form-control" id="user_gakot" name="user_gakot" placeholder="Gaji Kotor" value="<?= $user_gakot; ?>">
                                            </div>
                                        </div>

                                        <script>
                                            function tlain() {
                                                let identity_tunjanganlain = "<?= session()->get("identity_tunjanganlain"); ?>";
                                                let identity_persentjabatan = "<?= session()->get("identity_persentjabatan"); ?>";
                                                let user_payrolltype = $("#user_payrolltype").val();
                                                if (user_payrolltype == "bulanan") {
                                                    let user_gakot = $("#user_gakot").val();
                                                    let tlainlain = user_gakot * identity_tunjanganlain / 100;
                                                    // alert("<?= base_url("api/tlain"); ?>?tlainlain="+tlainlain);
                                                    $.get("<?= base_url("api/tlain"); ?>", {
                                                            tlainlain: tlainlain
                                                        })
                                                        .done(function(data) {
                                                            $("#user_ttransport").val(data.transport);
                                                            $("#user_thadir").val(data.hadir);
                                                            $("#user_tmakan").val(data.makan);
                                                        });


                                                    let user_tjabatan = (user_gakot - tlainlain) * (identity_persentjabatan / 100);
                                                    // alert(identity_persentjabatan);
                                                    $("#user_tjabatan").val(user_tjabatan);
                                                    let user_gapok = user_gakot - (tlainlain + user_tjabatan);
                                                    $("#user_gapok").val(user_gapok);
                                                }
                                            }
                                        </script>

                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Tunjangan Transport" data-bs-toggle="tooltip" data-bs-placement="top" type="text" class="form-control" id="user_ttransport" name="user_ttransport" placeholder="Tunjangan Transport" value="<?= $user_ttransport; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Tunjangan Kehadiran" data-bs-toggle="tooltip" data-bs-placement="top" type="text" class="form-control" id="user_thadir" name="user_thadir" placeholder="Tunjangan Kehadiran" value="<?= $user_thadir; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Tunjangan Makan" data-bs-toggle="tooltip" data-bs-placement="top" type="text" class="form-control" id="user_tmakan" name="user_tmakan" placeholder="Tunjangan Makan" value="<?= $user_tmakan; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Gaji Pokok" data-bs-toggle="tooltip" data-bs-placement="top" onchange="rgapok()" type="text" class="form-control" id="user_gapok" name="user_gapok" placeholder="Gaji Pokok" value="<?= $user_gapok; ?>">
                                            </div>
                                            <script>
                                                function rgapok() {
                                                    let user_payrolltype = $("#user_payrolltype").val();
                                                    if (user_payrolltype == "bulanan") {
                                                        let user_gapok = $("#user_gapok").val();
                                                        let user_tjabatan = $("#user_tjabatan").val();
                                                        let user_ttransport = $("#user_ttransport").val();
                                                        let user_thadir = $("#user_thadir").val();
                                                        let user_tmakan = $("#user_tmakan").val();
                                                        let user_insentif = $("#user_insentif").val();
                                                        let user_gakot = parseFloat(user_gapok) + parseFloat(user_tjabatan) + parseFloat(user_ttransport) + parseFloat(user_thadir) + parseFloat(user_tmakan) + parseFloat(user_insentif);
                                                        $("#user_gakot").val(user_gakot);
                                                    }
                                                }
                                            </script>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Tunjangan Jabatan" data-bs-toggle="tooltip" data-bs-placement="top" type="text" class="form-control" id="user_tjabatan" name="user_tjabatan" placeholder="Tunjangan Jabatan" value="<?= $user_tjabatan; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Insentif" data-bs-toggle="tooltip" data-bs-placement="top" type="text" class="form-control" id="user_insentif" name="user_insentif" placeholder="Insentif" value="<?= $user_insentif; ?>">
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <input type="hidden" name="user_temp" value="<?= $user_temp; ?>" />
                                <input type="hidden" name="user_id" value="<?= $user_id; ?>" />

                                <div class="row pl-4 pr-4 mb-4 mt-3">
                                    <button type="submit" id="submit" class="btn btn-primary " <?= $user_namabutton; ?> value="OK">Submit</button>
                                    <a class="btn btn-warning ml-2" href="<?= base_url("muser"); ?>">Back</a>
                                </div>

                            </form>

                            <?php if (session()->get("position_id") == "111" || session()->get("position_id") == "112" || session()->get("position_id") == "1") { ?>
                                <div class="blok " style="margin-top: 50px;">
                                    <div class="sub-title col-12">* Data Kontrak</div>
                                    <form class="form-horizontal row" id="formKontrak">
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Nama Kontrak" data-bs-toggle="tooltip" data-bs-placement="top" required type="text" class="form-control" placeholder="Nama Kontrak" id="kontrak_name" name="kontrak_name">
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Awal Kontrak" data-bs-toggle="tooltip" data-bs-placement="top" required type="date" class="form-control" placeholder="Awal Kontrak" id="kontrak_from" name="kontrak_from">
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-12">
                                                <input title="Akhir Kontrak" data-bs-toggle="tooltip" data-bs-placement="top" required type="date" class="form-control" placeholder="Akhir Kontrak" id="kontrak_to" name="kontrak_to">
                                            </div>
                                        </div>
                                        <div class="form-group col-3 ">
                                            <div class="col-sm-offset-2 col-12">
                                                <button onclick="datakontrak()" type="button" class="btn btn-primary col-12">Submit</button>
                                            </div>
                                        </div>
                                        <script>
                                            function clearForm(formId) {
                                                const form = document.getElementById(formId);
                                                if (!form) return;

                                                const inputs = form.querySelectorAll("input, textarea, select");

                                                inputs.forEach(input => {
                                                    if (input.type === "checkbox" || input.type === "radio") {
                                                        input.checked = false;
                                                    } else if (input.tagName.toLowerCase() === "select") {
                                                        input.selectedIndex = 0; // pilih opsi pertama
                                                    } else {
                                                        input.value = "";
                                                    }
                                                });
                                            }

                                            function datakontrak() {
                                                let kontrak_name = $("#kontrak_name").val();
                                                let kontrak_from = $("#kontrak_from").val();
                                                let kontrak_to = $("#kontrak_to").val();
                                                let user_id = '<?= $user_id; ?>';
                                                let user_temp = '<?= $user_temp; ?>';
                                                $("#test").val("<?= base_url("api/datakontrak"); ?>?kontrak_name=" + kontrak_name + "&kontrak_from=" + kontrak_from + "&kontrak_to=" + kontrak_to + "&user_temp=" + user_temp);
                                                $.get("<?= base_url("api/datakontrak"); ?>", {
                                                        kontrak_name: kontrak_name,
                                                        kontrak_from: kontrak_from,
                                                        kontrak_to: kontrak_to,
                                                        user_temp: user_temp,
                                                        user_id: user_id
                                                    })
                                                    .done(function(data) {
                                                        listkontrak();
                                                    });
                                            }

                                            function listkontrak() {
                                                let user_temp = <?= $user_temp; ?>;
                                                $("#test").val("<?= base_url("api/listkontrak"); ?>?user_temp=" + user_temp);
                                                $.get("<?= base_url("api/listkontrak"); ?>", {
                                                        user_temp: user_temp
                                                    })
                                                    .done(function(data) {
                                                        $("#listkontrak").html(data);
                                                        clearForm('formKontrak');
                                                    });
                                            }
                                            $().ready(function() {
                                                listkontrak();
                                            });
                                        </script>
                                    </form>
                                    <div id="listkontrak" class="table-responsive m-t-0"></div>
                                </div>
                                <input id="test" type="hidden" />
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <?php if ($message != "") { ?>
                            <div class="alert alert-info alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong><?= $message; ?></strong>
                            </div>
                        <?php } ?>

                        <!-- Export Excel Data Karyawan -->
                        <div class="row" id="dimport">
                            <form method="post" class="form-inline col-3" action="" enctype="multipart/form-data">
                                <div class=" mb-1">
                                    <label class="text-left" for="excelkaryawan">Master Karyawan:&nbsp;</label>
                                    <input type="file" class="" name="excelkaryawan">
                                </div>
                                &nbsp;<button type="submit" class="btn btn-success fa fa-file-excel-o"> Import</button>
                                &nbsp;<a href="<?= base_url("karyawan1.xls"); ?>" class="btn btn-warning fa fa-download"> Template</a>

                            </form>

                            <form method="post" class="form-inline col-3" action="" enctype="multipart/form-data">
                                <div class=" mb-1">
                                    <label class="text-left" for="excelcuti">Sisa Cuti:&nbsp;</label>
                                    <input type="file" class="" name="excelcuti">
                                </div>
                                &nbsp;<button type="submit" class="btn btn-success fa fa-file-excel-o"> Import</button>
                                &nbsp;<a href="<?= base_url("sisacuti.xlsx"); ?>" class="btn btn-warning fa fa-download"> Template</a>
                            </form>

                            <form method="post" class="form-inline col-3" action="" enctype="multipart/form-data">
                                <div class=" mb-1">
                                    <label class="text-left" for="excelgaji">Update Gaji:&nbsp;</label>
                                    <input type="file" class="" name="excelgaji">
                                </div>
                                &nbsp;<button type="submit" class="btn btn-success fa fa-file-excel-o"> Import</button>
                                &nbsp;<a href="<?= base_url("datagaji1.xlsx"); ?>" class="btn btn-warning fa fa-download"> Template</a>
                            </form>

                            <form method="post" class="form-inline col-3" action="" enctype="multipart/form-data">
                                <div class="">
                                    <label for="excelkaryawan">Revisi Cuti:&nbsp;</label>
                                </div>
                                &nbsp;<button type="submit" name="revisicuti" value="OK" class="btn btn-warning fa fa-flag-o"> Revisi</button>
                            </form>
                        </div>
                        <div class="row" id="dcari">
                            <?php
                            $position_id = 0;
                            $departemen_id = 0;
                            $user_nik = "";
                            $user_ktp = "";
                            if (isset($_GET["position_id"]) && $_GET["position_id"] != "") {
                                $position_id = $_GET["position_id"];
                            }
                            if (isset($_GET["departemen_id"]) && $_GET["departemen_id"] != "") {
                                $departemen_id = $_GET["departemen_id"];
                            }
                            if (isset($_GET["user_nik"]) && $_GET["user_nik"] != "") {
                                $user_nik = $_GET["user_nik"];
                            }
                            if (isset($_GET["user_ktp"]) && $_GET["user_ktp"] != "") {
                                $user_ktp = $_GET["user_ktp"];
                            }
                            ?>
                            <form>
                                <div class="row">
                                    <div class="col">
                                        <select class="form-control" name="departemen_id">
                                            <option value="" <?= ($departemen_id == "") ? "selected" : ""; ?>>All Departement</option>
                                            <?php $departemen = $this->db->table("departemen")->orderBy("departemen_name", "ASC")->get();
                                            foreach ($departemen->getResult() as $row) { ?>
                                                <option value="<?= $row->departemen_id; ?>" <?= ($departemen_id == $row->departemen_id) ? "selected" : ""; ?>><?= $row->departemen_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control" name="position_id">
                                            <option value="" <?= ($position_id == "") ? "selected" : ""; ?>>All Position</option>
                                            <?php $position = $this->db->table("position")->orderBy("position_name", "ASC")->get();
                                            foreach ($position->getResult() as $row) { ?>
                                                <option value="<?= $row->position_id; ?>" <?= ($position_id == $row->position_id) ? "selected" : ""; ?>><?= $row->position_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="NIK" name="user_nik" value="<?= $user_nik; ?>">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="KTP" name="user_ktp" value="<?= $user_ktp; ?>">
                                    </div>
                                    <button name="cari" type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Cari</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">Data Kontrak <span id="modalUserName"></span></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="modalUserId">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive m-t-0">
                            <?php
                            $build = $this->db->table("kontrak")
                                ->join("user", "user.user_id=kontrak.user_id", "left")
                                ->join("position", "position.position_id=user.position_id", "left")
                                ->join("departemen", "departemen.departemen_id=user.departemen_id", "left")
                                ->where("user.user_id !=", "10");

                            $build->where("position.position_id !=", "1");

                            $usr = $build->orderBy("departemen_name", "ASC")
                                ->orderBy("position_name", "ASC")
                                ->orderBy("user_nama", "ASC")
                                ->get();
                            $arkontrak = array();
                            foreach ($usr->getResult() as $row) {
                                $arkontrak[$row->user_id][] = [
                                    "name" => $row->kontrak_name,
                                    "from" => $row->kontrak_from,
                                    "to" => $row->kontrak_to
                                ];
                            }
                            // dd($arkontrak);
                            ?>
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead class="">
                                    <tr>
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <th>Action</th>
                                        <?php } ?>
                                        <th>No.</th>
                                        <?php if (session()->get("position_id") == "110" || session()->get("position_id") == "112" || session()->get("position_id") == "1") { ?>
                                            <th>Status BPJS TK</th>
                                            <th>Status BPJS Kes</th>
                                        <?php } ?>
                                        <?php if (session()->get("position_id") == "109" || session()->get("position_id") == "112" || session()->get("position_id") == "1") { ?>
                                            <th>Sisa Cuti</th>
                                        <?php } ?>
                                        <th>Tgl.Masuk</th>
                                        <?php if (session()->get("position_id") == "111" || session()->get("position_id") == "112" || session()->get("position_id") == "1") { ?>
                                            <th>Masa Kontrak</th>
                                            <th>Tgl.Retire</th>
                                        <?php } ?>
                                        <th>Departemen</th>
                                        <th>Posisi</th>
                                        <th>NIK</th>
                                        <th>KTP</th>
                                        <th>ETAG</th>
                                        <!-- <th>Username</th> -->
                                        <th>Name</th>
                                        <th>Alamat</th>
                                        <th>Email</th>
                                        <th>Whatsapp</th>
                                        <th>NPWP</th>
                                        <th>Status</th>
                                        <th>BPJS TK</th>
                                        <th>BPJS Kesehatan</th>
                                        <th>Kartu Keluarga</th>
                                        <th>Bank</th>
                                        <th>No Rek:</th>
                                        <th>Nama Ibu</th>
                                        <th>Pendidikan</th>
                                        <th style="white-space: nowrap;">Tgl Lahir </th>
                                        <th>Tempat Lahir</th>
                                        <th>L/P</th>
                                        <th>Status Tanggungan</th>
                                        <th>Tipe Penggajian</th>
                                        <?php if (session()->get("position_id") == "109" || session()->get("position_id") == "112" || session()->get("position_id") == "1") { ?>
                                            <th>Lembur</th>
                                            <th>Gapok</th>
                                            <th>Gakot</th>
                                            <th>T.Transport</th>
                                            <th>T.Kehadiran</th>
                                            <th>T.Makan</th>
                                            <th>T.Jabatan</th>
                                            <th>Insentif</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $build = $this->db
                                        ->table("user")
                                        ->select("*, user.user_id as user_id")
                                        ->join("(SELECT *, ROW_NUMBER() OVER (PARTITION BY user_id ORDER BY kontrak_from DESC) AS rn
    FROM kontrak)kontrak_terbaru", "user.user_id = kontrak_terbaru.user_id AND kontrak_terbaru.rn = 1", "left")
                                        ->join("position", "position.position_id=user.position_id", "left")
                                        ->join("departemen", "departemen.departemen_id=user.departemen_id", "left")
                                        ->where("position.position_id !=", "1");
                                    if (!isset($_GET["cari"])) {
                                        $build->where("user.user_id", "0");
                                    }
                                    if (isset($_GET["user_nik"]) && $_GET["user_nik"] != "") {
                                        $build->where("user.user_nik", $_GET["user_nik"]);
                                    }
                                    if (isset($_GET["user_ktp"]) && $_GET["user_ktp"] != "") {
                                        $build->where("user.user_ktp", $_GET["user_ktp"]);
                                    }
                                    if (isset($_GET["departemen_id"]) && $_GET["departemen_id"] != "") {
                                        $build->where("user.departemen_id", $_GET["departemen_id"]);
                                    }
                                    if (isset($_GET["position_id"]) && $_GET["position_id"] != "") {
                                        $build->where("user.position_id", $_GET["position_id"]);
                                    }
                                    $usr = $build->orderBy("position_name", "asc")
                                        ->orderBy("user_nik", "asc")
                                        ->get();
                                    // echo $this->db->getLastquery();
                                    $no = 1;
                                    $aktif = ["Tidak Aktif", "Aktif"];
                                    $lembur = ["Tidak", "Perjam", "Insentif"];
                                    $statusbpjs = ["Non Aktif", "Aktif"];
                                    foreach ($usr->getResult() as $usr) {
                                    ?>
                                        <tr>
                                            <?php if (!isset($_GET["report"])) { ?>
                                                <td style="padding-left:0px; padding-right:0px; white-space: nowrap;">
                                                    <!-- <?php
                                                            if (
                                                                (
                                                                    isset(session()->get("position_id")[0][0])
                                                                    && (
                                                                        session()->get("position_id") == "1"
                                                                        || session()->get("position_id") == "2"
                                                                    )
                                                                ) ||
                                                                (
                                                                    isset(session()->get("halaman")['5']['act_read'])
                                                                    && session()->get("halaman")['5']['act_read'] == "1"
                                                                )
                                                            ) { ?>
                                                    <form method="get" class="btn-action" style="" action="<?= base_url("muserposition"); ?>">
                                                        <button class="btn btn-sm btn-primary "><span class="fa fa-users" style="color:white;"></span> </button>
                                                        <input type="hidden" name="user_id" value="<?= $usr->user_id; ?>" />
                                                    </form>
                                                    <?php } ?> -->




                                                    <form method="post" class="btn-action" style="">
                                                        <button title="Kontrak" data-bs-toggle="tooltip" data-bs-placement="top" type="button" onclick="kontrak(<?= $usr->user_id; ?>)" class="btn btn-sm btn-info show-modal" data-userid="<?= $usr->user_id; ?>">
                                                            <span class="fa fa-address-book-o" style="color:white;"></span>
                                                        </button>
                                                        <input type="hidden" id="kontn<?= $usr->user_id; ?>" value="<?= $usr->user_nama; ?>" />
                                                        <div id="kont<?= $usr->user_id; ?>" class="hide">
                                                            <?php
                                                            if (isset($arkontrak[$usr->user_id])) {
                                                                foreach ($arkontrak[$usr->user_id] as $row) { ?>
                                                                    <div class="mb-3"><span class="alert alert-success text-white mr-2 p-1"><?= $row["name"]; ?></span> <?= $row["from"]; ?> s/d <?= $row["to"]; ?></div>
                                                            <?php }
                                                            }
                                                            ?>
                                                        </div>
                                                    </form>



                                                    <?php
                                                    if (
                                                        (
                                                            isset(session()->get("position_id")[0][0])
                                                            && (
                                                                session()->get("position_id") == "1"
                                                                || session()->get("position_id") == "2"
                                                            )
                                                        ) ||
                                                        (
                                                            isset(session()->get("halaman")['5']['act_update'])
                                                            && session()->get("halaman")['5']['act_update'] == "1"
                                                        )
                                                    ) { ?>
                                                        <form method="post" class="btn-action" style="">
                                                            <button title="Edit" data-bs-toggle="tooltip" data-bs-placement="top" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                            <input type="hidden" name="user_id" value="<?= $usr->user_id; ?>" />
                                                        </form>
                                                    <?php } ?>

                                                    <?php
                                                    if (
                                                        (
                                                            isset(session()->get("position_id")[0][0])
                                                            && (
                                                                session()->get("position_id") == "1"
                                                                || session()->get("position_id") == "2"
                                                            )
                                                        ) ||
                                                        (
                                                            isset(session()->get("halaman")['5']['act_delete'])
                                                            && session()->get("halaman")['5']['act_delete'] == "1"
                                                        )
                                                    ) { ?>
                                                        <form method="post" class="btn-action" style="">
                                                            <button title="Delete" data-bs-toggle="tooltip" data-bs-placement="top" class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                            <input type="hidden" name="user_id" value="<?= $usr->user_id; ?>" />
                                                        </form>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>
                                            <td><?= $no++; ?></td>

                                            <?php if (session()->get("position_id") == "110" || session()->get("position_id") == "112" || session()->get("position_id") == "1") { ?>
                                                <?php
                                                if ($usr->user_bpjsstatustk == 0) {
                                                    $bgtd = "danger";
                                                    $colotd = "white";
                                                } else {
                                                    $bgtd = "success";
                                                    $colotd = "white";
                                                } ?>
                                                <td style="white-space: nowrap;" class="bg-<?= $bgtd; ?> text-<?= $colotd; ?>">
                                                    <?= $statusbpjs[$usr->user_bpjsstatustk]; ?>
                                                    <?php
                                                    if ($usr->user_bpjsstatustk == 0) {
                                                        $colo = "success";
                                                        $fa = "check";
                                                        $sbpjs = 1;
                                                    } else {
                                                        $colo = "danger";
                                                        $fa = "times";
                                                        $sbpjs = 0;
                                                    }
                                                    if (
                                                        (
                                                            isset(session()->get("position_id")[0][0])
                                                            && (
                                                                session()->get("position_id") == "1"
                                                                || session()->get("position_id") == "2"
                                                            )
                                                        ) ||
                                                        (
                                                            isset(session()->get("halaman")['88']['act_update'])
                                                            && session()->get("halaman")['88']['act_update'] == "1"
                                                        )
                                                    ) { ?>
                                                        <form method="post" class="btn-action" style="">
                                                            <button class="btn btn-sm btn-<?= $colo; ?> " name="bpjsstatustk" value="OK"><span class="fa fa-<?= $fa; ?>" style="color:white;"></span> </button>
                                                            <input type="hidden" name="user_id" value="<?= $usr->user_id; ?>" />
                                                            <input type="hidden" name="user_bpjsstatustk" value="<?= $sbpjs; ?>" />
                                                        </form>
                                                    <?php } ?>
                                                </td>
                                                <?php
                                                if ($usr->user_bpjsstatusk == 0) {
                                                    $bgtd = "danger";
                                                    $colotd = "white";
                                                } else {
                                                    $bgtd = "success";
                                                    $colotd = "white";
                                                } ?>
                                                <td style="white-space: nowrap;" class="bg-<?= $bgtd; ?> text-<?= $colotd; ?>">
                                                    <?= $statusbpjs[$usr->user_bpjsstatusk]; ?>
                                                    <?php
                                                    if ($usr->user_bpjsstatusk == 0) {
                                                        $colo = "success";
                                                        $fa = "check";
                                                        $sbpjs = 1;
                                                    } else {
                                                        $colo = "danger";
                                                        $fa = "times";
                                                        $sbpjs = 0;
                                                    }
                                                    if (
                                                        (
                                                            isset(session()->get("position_id")[0][0])
                                                            && (
                                                                session()->get("position_id") == "1"
                                                                || session()->get("position_id") == "2"
                                                            )
                                                        ) ||
                                                        (
                                                            isset(session()->get("halaman")['88']['act_update'])
                                                            && session()->get("halaman")['88']['act_update'] == "1"
                                                        )
                                                    ) { ?>
                                                        <form method="post" class="btn-action" style="">
                                                            <button class="btn btn-sm btn-<?= $colo; ?> " name="bpjsstatusk" value="OK"><span class="fa fa-<?= $fa; ?>" style="color:white;"></span> </button>
                                                            <input type="hidden" name="user_id" value="<?= $usr->user_id; ?>" />
                                                            <input type="hidden" name="user_bpjsstatusk" value="<?= $sbpjs; ?>" />
                                                        </form>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>
                                            <?php if (session()->get("position_id") == "109" || session()->get("position_id") == "112" || session()->get("position_id") == "1") { ?>
                                                <td><?= $usr->user_cuti; ?></td>
                                            <?php } ?>
                                            <td style="white-space: nowrap;"><?= $usr->user_masuk; ?></td>
                                            <?php if (session()->get("position_id") == "111" || session()->get("position_id") == "112" || session()->get("position_id") == "1") { ?>
                                                <td style="white-space: nowrap;"><?= $usr->kontrak_to; ?></td>
                                                <td style="white-space: nowrap;"><?= $usr->user_keluar; ?></td>
                                            <?php } ?>
                                            <td class="text-left"><?= str_replace(' ', '&nbsp;', $usr->departemen_name); ?></td>
                                            <td class="text-left"><?= str_replace(' ', '&nbsp;', $usr->position_name); ?></td>
                                            <td><?= $usr->user_nik; ?></td>
                                            <td><?= $usr->user_ktp; ?></td>
                                            <td><?= $usr->user_etag; ?></td>
                                            <!-- <td><?= $usr->user_name; ?></td> -->
                                            <td class="text-left"><?= str_replace(' ', '&nbsp;', $usr->user_nama); ?></td>
                                            <td class="text-left"><?= str_replace(' ', '&nbsp;', $usr->user_address); ?></td>
                                            <td class="text-left"><?= $usr->user_email; ?></td>
                                            <td><?= $usr->user_wa; ?></td>
                                            <td><?= $usr->user_npwp; ?></td>
                                            <td><?= $aktif[$usr->user_status]; ?></td>
                                            <td><?= $usr->user_bpjstk; ?></td>
                                            <td><?= $usr->user_bpjskesehatan; ?></td>
                                            <td><?= $usr->user_kk; ?></td>
                                            <td><?= $usr->user_bank; ?></td>
                                            <td><?= $usr->user_norek; ?></td>
                                            <td class="text-left"><?= str_replace(' ', '&nbsp;', $usr->user_ibu); ?></td>
                                            <td><?= $usr->user_pendidikan; ?></td>
                                            <td><?= $usr->user_borndate; ?></td>
                                            <td><?= $usr->user_borncity; ?></td>
                                            <td><?= $usr->user_gender; ?></td>
                                            <td><?= $usr->user_tanggungan; ?></td>
                                            <td><?= $usr->user_payrolltype; ?></td>
                                            <?php if (session()->get("position_id") == "109" || session()->get("position_id") == "112" || session()->get("position_id") == "1") { ?>
                                                <td><?= $lembur[$usr->user_lembur]; ?></td>
                                                <td class="text-right"><?= number_format($usr->user_gapok, 0, ",", "."); ?></td>
                                                <td class="text-right"><?= number_format($usr->user_gakot, 0, ",", "."); ?></td>
                                                <td class="text-right"><?= number_format($usr->user_ttransport, 0, ",", "."); ?></td>
                                                <td class="text-right"><?= number_format($usr->user_thadir, 0, ",", "."); ?></td>
                                                <td class="text-right"><?= number_format($usr->user_tmakan, 0, ",", "."); ?></td>
                                                <td class="text-right"><?= number_format($usr->user_tjabatan, 0, ",", "."); ?></td>
                                                <td class="text-right"><?= number_format($usr->user_insentif, 0, ",", "."); ?></td>
                                            <?php } ?>
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
    function kontrak(id) {
        var userId = $("#kont" + id).html();
        var userName = $("#kontn" + id).val();
        $('#modalUserName').html(userName);
        $('#modalUserId').html(userId);
        $('#userModal').modal('show'); // tampilkan modal
    }
    $('.select').select2();
    <?php if (isset($_POST['new']) || isset($_POST['edit'])) {
        if (isset($_POST['edit'])) {
            $judul = "Update Karyawan";
        } else {
            $judul = "Tambah Karyawan";
        }
    } else {
        $judul = "Master Karyawan";
    } ?>
    var title = "<?= $judul; ?>";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
    $('#myTable22').DataTable({
        columnDefs: [{
                width: "400px",
                targets: 17
            }, // Kolom pertama
            {
                width: "400px",
                targets: 16
            } // Kolom kedua
        ]
    });
</script>

<?php echo  $this->include("template/footer_v"); ?>