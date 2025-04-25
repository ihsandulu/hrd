<?php echo $this->include("template/header_v"); ?>
<style>
    th,
    td {
        padding: 5px !important;
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
                            <form method="post" class="col-md-2">
                                <h1 class="page-header col-md-12">
                                    <button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
                                    <input type="hidden" name="user_id" />
                                </h1>
                            </form>
                        <?php } ?>
                    </div>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $user_namabutton = 'name="change"';
                                $judul = "Update Karyawan";
                                $ketuser_password = "Kosongkan jika tidak ingin merubah user_password!";
                            } else {
                                $user_namabutton = 'name="create"';
                                $judul = "Tambah Karyawan";
                                $ketuser_password = "Jangan dikosongkan!";
                            } ?>
                            <div class="lead">
                                <h3><?= $judul; ?></h3>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_status">Status:</label>
                                    <div class="col-sm-10">
                                        <select required class="form-control" id="user_status" name="user_status">
                                            <option value="1" <?= ($user_status == 1) ? "selected" : ""; ?>>Aktif</option>
                                            <option value="0" <?= ($user_status == 0) ? "selected" : ""; ?>>Tidak Aktif</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="position_id">Departemen:</label>
                                    <div class="col-sm-10">
                                        <?php
                                        $departemen = $this->db->table("departemen")->orderBy("departemen_name", "ASC")
                                            ->get();
                                        //echo $this->db->getLastQuery();
                                        ?>
                                        <select autofocus required class="form-control select" id="departemen_id" name="departemen_id">
                                            <option value="" <?= ($departemen_id == "") ? "selected" : ""; ?>>Pilih Departemen</option>
                                            <?php
                                            foreach ($departemen->getResult() as $departemen) { ?>
                                                <option value="<?= $departemen->departemen_id; ?>" <?= ($departemen_id == $departemen->departemen_id) ? "selected" : ""; ?>><?= $departemen->departemen_name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="position_id">Jabatan:</label>
                                    <div class="col-sm-10">
                                        <?php
                                        $base = $this->db->table("position");
                                        if (session()->get("position_id") != "1") {
                                            $base->where("position_id!=", "1");
                                        }
                                        $position = $base->orderBy("position_name", "ASC")
                                            ->get();
                                        //echo $this->db->getLastQuery();
                                        ?>
                                        <select required class="form-control select" id="position_id" name="position_id">
                                            <option value="" <?= ($position_id == "") ? "selected" : ""; ?>>Pilih Jabatan</option>
                                            <?php
                                            foreach ($position->getResult() as $position) { ?>
                                                <option value="<?= $position->position_id; ?>" <?= ($position_id == $position->position_id) ? "selected" : ""; ?>><?= $position->position_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_nama">Nama Lengkap:</label>
                                    <div class="col-sm-10">
                                        <input required type="text" class="form-control" id="user_nama" name="user_nama" placeholder="" value="<?= $user_nama; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_nik">NIK:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="user_nik" name="user_nik" placeholder="" value="<?= $user_nik; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_ktp">KTP:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="user_ktp" name="user_ktp" placeholder="" value="<?= $user_ktp; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_etag">ETAG:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="user_etag" name="user_etag" placeholder="" value="<?= $user_etag; ?>">
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_password">Password:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="user_password" name="user_password" placeholder="<?= $ketuser_password; ?>" value="<?= $user_password; ?>">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_masuk">Tgl Masuk:</label>
                                    <div class="col-sm-10">
                                        <input required type="date" class="form-control" id="user_masuk" name="user_masuk" placeholder="" value="<?= $user_masuk; ?>">

                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_keluar">Tgl Keluar:</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="user_keluar" name="user_keluar" placeholder="" value="<?= $user_keluar; ?>">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_email">Email:</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="user_email" name="user_email" placeholder="" value="<?= $user_email; ?>">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_cuti">Sisa Cuti:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="user_cuti" name="user_cuti" placeholder="" value="<?= $user_cuti; ?>">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_wa">Whatsapp:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="user_wa" name="user_wa" placeholder="" value="<?= $user_wa; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_npwp">NPWP:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="user_npwp" name="user_npwp" placeholder="" value="<?= $user_npwp; ?>">

                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_bpjstk">Nomor BPJS TK:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="user_bpjstk" name="user_bpjstk" placeholder="" value="<?= $user_bpjstk; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_bpjskesehatan">Nomor BPJS Kesehatan:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="user_bpjskesehatan" name="user_bpjskesehatan" placeholder="" value="<?= $user_bpjskesehatan; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_address">Alamat:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="user_address" name="user_address" placeholder="" value="<?= $user_address; ?>">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_kk">Kartu Keluarga:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="user_kk" name="user_kk" placeholder="" value="<?= $user_kk; ?>">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_bank">Bank:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="user_bank" name="user_bank">
                                            <option value="MANDIRI" <?= ($user_bank == "MANDIRI") ? "selected" : ""; ?>>MANDIRI</option>
                                            <option value="BCA" <?= ($user_bank == "BCA") ? "selected" : ""; ?>>BCA</option>
                                            <option value="BNI" <?= ($user_bank == "BNI") ? "selected" : ""; ?>>BNI</option>
                                            <option value="BRI" <?= ($user_bank == "BRI") ? "selected" : ""; ?>>BRI</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_norek">No Rek:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="user_norek" name="user_norek" placeholder="" value="<?= $user_norek; ?>">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_ibu">Nama Ibu:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="user_ibu" name="user_ibu" placeholder="" value="<?= $user_ibu; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_pendidikan">Pendidikan:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="user_pendidikan" name="user_pendidikan">
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

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_borndate">Tgl Lahir:</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="user_borndate" name="user_borndate" placeholder="" value="<?= $user_borndate; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_borncity">Tempat Lahir:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="user_borncity" name="user_borncity" placeholder="" value="<?= $user_borncity; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_gender">L/P:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="user_gender" name="user_gender">
                                            <option value="" <?= ($user_gender == "") ? "selected" : ""; ?>>Pilih Gender</option>
                                            <option value="L" <?= ($user_gender == "L") ? "selected" : ""; ?>>L</option>
                                            <option value="P" <?= ($user_gender == "P") ? "selected" : ""; ?>>P</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_tanggungan">Status Tanggungan:</label>
                                    <div class="col-sm-10">
                                        <select onchange="pph()" class="form-control" id="user_tanggungan" name="user_tanggungan">
                                            <option value="" <?= ($user_tanggungan == "") ? "selected" : ""; ?>>Pilih Status</option>
                                            <?php $tanggungan = $this->db->table("tanggungan")->get();
                                            foreach ($tanggungan->getResult() as $tanggungan) { ?>
                                                <option value="<?= $tanggungan->tanggungan_id; ?>" data-ter="<?= $tanggungan->tanggungan_ter; ?>" <?= ($user_tanggungan == $tanggungan->tanggungan_id) ? "selected" : ""; ?>><?= $tanggungan->tanggungan_jenis; ?></option>
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

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_tanggunganjenis">Jenis Tanggungan:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="user_tanggunganjenis" name="user_tanggunganjenis" placeholder="" value="<?= $user_tanggunganjenis; ?>">
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_payrolltype">Tipe Penggajian:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="user_payrolltype" name="user_payrolltype">
                                            <option value="bulanan" <?= ($user_payrolltype == "bulanan") ? "selected" : ""; ?>>Bulanan</option>
                                            <option value="harian" <?= ($user_payrolltype == "harian") ? "selected" : ""; ?>>Harian</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_lembur">Lembur:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="user_lembur" name="user_lembur">
                                            <option value="0" <?= ($user_lembur == "0") ? "selected" : ""; ?>>Tidak</option>
                                            <option value="1" <?= ($user_lembur == "1") ? "selected" : ""; ?>>Perjam</option>
                                            <option value="2" <?= ($user_lembur == "2") ? "selected" : ""; ?>>Insentif</option>
                                        </select>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_gakot">Gaji Kotor:</label>
                                    <div class="col-sm-10">
                                        <input onchange="tlain()" type="number" class="form-control" id="user_gakot" name="user_gakot" placeholder="" value="<?= $user_gakot; ?>">
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

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_ttransport">Tunjangan Transport:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="user_ttransport" name="user_ttransport" placeholder="" value="<?= $user_ttransport; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_thadir">Tunjangan Kehadiran:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="user_thadir" name="user_thadir" placeholder="" value="<?= $user_thadir; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_tmakan">Tunjangan Makan:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="user_tmakan" name="user_tmakan" placeholder="" value="<?= $user_tmakan; ?>">
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_gapok">Gaji Pokok:</label>
                                    <div class="col-sm-10">
                                        <input onchange="tjabatan()" type="number" class="form-control" id="user_gapok" name="user_gapok" placeholder="" value="<?= $user_gapok; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_tjabatan">Tunjangan Jabatan:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="user_tjabatan" name="user_tjabatan" placeholder="" value="<?= $user_tjabatan; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_insentif">Insentif:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="user_insentif" name="user_insentif" placeholder="" value="<?= $user_insentif; ?>">
                                    </div>
                                </div>

                                <input type="hidden" name="user_id" value="<?= $user_id; ?>" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $user_namabutton; ?> value="OK">Submit</button>
                                        <a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= base_url("muser"); ?>">Back</a>
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

                        <!-- Export Excel Data Karyawan -->
                        <div class="row">
                            <form method="post" class="form-inline col-4" action="" enctype="multipart/form-data">
                                <div class="form-group mb-1">
                                    <label for="excelkaryawan">Master Karyawan:&nbsp;</label>
                                    <input type="file" class="" name="excelkaryawan">
                                </div>
                                &nbsp;<button type="submit" class="btn btn-success fa fa-file-excel-o"> Import</button>
                                &nbsp;<a href="<?=base_url("karyawan.xls");?>" class="btn btn-warning fa fa-download"> Download Template</a>
                            
                            </form>

                            <form method="post" class="form-inline col-4" action="" enctype="multipart/form-data">
                                <div class="form-group mb-1">
                                    <label for="excelkaryawan">Sisa Cuti:&nbsp;</label>
                                    <input type="file" class="" name="excelcuti">
                                </div>
                                &nbsp;<button type="submit" class="btn btn-success fa fa-file-excel-o"> Import</button>
                                &nbsp;<a href="<?=base_url("sisacuti.xlsx");?>" class="btn btn-warning fa fa-download"> Download Template</a>
                            </form>

                            <form method="post" class="form-inline col-4" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="excelkaryawan">Revisi Cuti:&nbsp;</label>
                                </div>
                                &nbsp;<button type="submit" name="revisicuti" value="OK" class="btn btn-warning fa fa-flag-o"> Revisi</button>
                            </form>
                        </div>

                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead class="">
                                    <tr>
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <th>__Action__</th>
                                        <?php } ?>
                                        <th>No.</th>
                                        <th>Sisa Cuti</th>
                                        <th>Tgl.Masuk</th>
                                        <th>Departemen</th>
                                        <th>Posisi</th>
                                        <th>NIK</th>
                                        <th>ETAG</th>
                                        <!-- <th>Username</th> -->
                                        <th>Name</th>
                                        <th>Alamat</th>
                                        <th>Email</th>
                                        <th>Sisa Cuti</th>
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
                                        <th>&nbsp;&nbsp;&nbsp;Tgl&nbsp;Lahir&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Tempat Lahir</th>
                                        <th>L/P</th>
                                        <th>Status Tanggungan</th>
                                        <th>Tipe Penggajian</th>
                                        <th>Lembur</th>
                                        <th>Gapok</th>
                                        <th>Gakot</th>
                                        <th>T.Transport</th>
                                        <th>T.Kehadiran</th>
                                        <th>T.Makan</th>
                                        <th>T.Jabatan</th>
                                        <th>Insentif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $usr = $this->db
                                        ->table("user")
                                        ->join("position", "position.position_id=user.position_id", "left")
                                        ->join("departemen", "departemen.departemen_id=user.departemen_id", "left")
                                        ->where("position.position_id !=", "1")
                                        ->orderBy("position_name", "asc")
                                        ->orderBy("user_nik", "asc")
                                        ->get();
                                    //echo $this->db->getLastquery();
                                    $no = 1;
                                    $aktif = ["Tidak Aktif", "Aktif"];
                                    $lembur = ["Tidak", "Perjam", "Insentif"];
                                    foreach ($usr->getResult() as $usr) {
                                    ?>
                                        <tr>
                                            <?php if (!isset($_GET["report"])) { ?>
                                                <td style="padding-left:0px; padding-right:0px;">
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
                                                            <button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
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
                                                            <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                            <input type="hidden" name="user_id" value="<?= $usr->user_id; ?>" />
                                                        </form>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>
                                            <td><?= $no++; ?></td>
                                            <td><?= $usr->user_cuti; ?></td>
                                            <td><?= $usr->user_masuk; ?></td>
                                            <td class="text-left"><?= str_replace(' ', '&nbsp;', $usr->departemen_name); ?></td>
                                            <td class="text-left"><?= str_replace(' ', '&nbsp;', $usr->position_name); ?></td>
                                            <td><?= $usr->user_nik; ?></td>
                                            <td><?= $usr->user_etag; ?></td>
                                            <!-- <td><?= $usr->user_name; ?></td> -->
                                            <td class="text-left"><?= str_replace(' ', '&nbsp;', $usr->user_nama); ?></td>
                                            <td class="text-left"><?= str_replace(' ', '&nbsp;', $usr->user_address); ?></td>
                                            <td class="text-left"><?= $usr->user_email; ?></td>
                                            <td><?= $usr->user_cuti; ?></td>
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
                                            <td><?= $lembur[$usr->user_lembur]; ?></td>
                                            <td class="text-right"><?= number_format($usr->user_gapok, 0, ",", "."); ?></td>
                                            <td class="text-right"><?= number_format($usr->user_gakot, 0, ",", "."); ?></td>
                                            <td class="text-right"><?= number_format($usr->user_ttransport, 0, ",", "."); ?></td>
                                            <td class="text-right"><?= number_format($usr->user_thadir, 0, ",", "."); ?></td>
                                            <td class="text-right"><?= number_format($usr->user_tmakan, 0, ",", "."); ?></td>
                                            <td class="text-right"><?= number_format($usr->user_tjabatan, 0, ",", "."); ?></td>
                                            <td class="text-right"><?= number_format($usr->user_insentif, 0, ",", "."); ?></td>
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
    var title = "Master Karyawan";
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