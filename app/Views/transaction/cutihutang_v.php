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
                        <!-- <div class="<?= $coltitle; ?>">
                            <h4 class="card-title"></h4>
                        </div> -->
                        <!--  <?php if (!isset($_POST['new']) && !isset($_POST['edit']) && !isset($_GET['report'])) { ?>
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
                        <?php } ?> -->
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


                                <!-- <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_bpjstk">BPJS TK:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="user_bpjstk" name="user_bpjstk" placeholder="" value="<?= $user_bpjstk; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_bpjskesehatan">BPJS Kesehatan:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="user_bpjskesehatan" name="user_bpjskesehatan" placeholder="" value="<?= $user_bpjskesehatan; ?>">
                                    </div>
                                </div> -->

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

                        <?php
                        function accordionState($active = false)
                        {
                            return [
                                'buttonClass' => $active ? '' : 'collapsed',
                                'ariaExpanded' => $active ? 'true' : 'false',
                                'collapseClass' => $active ? 'collapse show' : 'collapse',
                            ];
                        }
                        if (isset($_GET["dari"])) {
                            $panel1 = accordionState(true);
                            $panel2 = accordionState(false);
                        } else {
                            $panel1 = accordionState(false);
                            $panel2 = accordionState(true);
                        }

                        ?>



                        <div class="accordion" id="faqAccordion">
                            <div class="card">
                                <div class="card-header card-success" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left text-white bold <?= $panel1['buttonClass'] ?>" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="<?= $panel1['ariaExpanded'] ?>" aria-controls="collapseOne">
                                            <i class="fa fa-arrow-down"></i> History Hutang Cuti
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseOne" class="collapse <?= $panel1['collapseClass'] ?>" aria-labelledby="headingOne" data-parent="#faqAccordion">
                                    <div class="card-body">
                                        <div class="alert alert-dark">
                                            <form method="get">
                                                <div class="row">
                                                    <?php
                                                    $dari = date("Y-m-d");
                                                    $ke = date("Y-m-d");
                                                    $idepartemen = 0;
                                                    if (isset($_GET["dari"])) {
                                                        $dari = $_GET["dari"];
                                                    }
                                                    if (isset($_GET["ke"])) {
                                                        $ke = $_GET["ke"];
                                                    }
                                                    if (isset($_GET["departemen_id"])) {
                                                        $idepartemen = $_GET["departemen_id"];
                                                    }
                                                    ?>
                                                    <?php
                                                    if (isset($_GET["departemen_id"])) {
                                                        $idepartemen = $_GET["departemen_id"];
                                                    } else {
                                                        $idepartemen = "";
                                                    }
                                                    if (isset($_GET["position_id"])) {
                                                        $iposition = $_GET["position_id"];
                                                    } else {
                                                        $iposition = "";
                                                    }
                                                    ?>
                                                    <div class="col-3 row mb-2">
                                                        <div class="col-12">
                                                            <select class="form-control " name="departemen_id">
                                                                <option value="">Departemen</option>
                                                                <?php $departemen = $this->db->table("departemen")->orderBy("departemen_name")->get();
                                                                foreach ($departemen->getResult() as $departemen) { ?>
                                                                    <option value="<?= $departemen->departemen_id; ?>" <?= ($idepartemen == $departemen->departemen_id) ? "selected" : ""; ?>><?= $departemen->departemen_name; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-3 row mb-2">
                                                        <div class="col-12">
                                                            <select class="form-control " name="position_id">
                                                                <option value="">Position</option>
                                                                <?php $position = $this->db->table("position")->orderBy("position_name")->get();
                                                                foreach ($position->getResult() as $position) { ?>
                                                                    <option value="<?= $position->position_id; ?>" <?= ($iposition == $position->position_id) ? "selected" : ""; ?>><?= $position->position_name; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-3 row mb-2">
                                                        <div class="col-4">
                                                            <label class="text-dark">Dari :</label>
                                                        </div>
                                                        <div class="col-8">
                                                            <input type="date" class="form-control" placeholder="Dari" name="dari" value="<?= $dari; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-3 row mb-2">
                                                        <div class="col-4">
                                                            <label class="text-dark">Ke :</label>
                                                        </div>
                                                        <div class="col-8">
                                                            <input type="date" class="form-control" placeholder="Ke" name="ke" value="<?= $ke; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12  mb-2 mt-2">
                                                        <button type="submit" class="btn btn-block btn-primary">Search</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <form method="post">
                                            <div class="row">
                                                <div class="offset-10 col-2">
                                                    <input type="hidden" name="dari" value="<?= $dari; ?>" />
                                                    <input type="hidden" name="ke" value="<?= $ke; ?>" />
                                                    <input type="hidden" name="departemen_id" value="<?= $idepartemen; ?>" />
                                                    <input type="hidden" name="position_id" value="<?= $iposition; ?>" />
                                                    <button type="submit" name="delete" value="OK" class="btn btn-block btn-danger">Delete Semua</button>
                                                </div>
                                            </div>
                                        </form>


                                        <div class="table-responsive m-t-40">
                                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead class="">
                                                    <tr>
                                                        <?php if (!isset($_GET["report"])) { ?>
                                                            <th>Action</th>
                                                        <?php } ?>
                                                        <!-- <th>No.</th> -->
                                                        <th>Departemen</th>
                                                        <th>Posisi</th>
                                                        <th>NIK</th>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                        <th>Date</th>
                                                        <th>Hari</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (isset($_GET["dari"])) {
                                                        $dari = $_GET["dari"];
                                                        $ke = $_GET["ke"];
                                                    } else {
                                                        $dari = date("Y-m-d");
                                                        $ke = date("Y-m-d");
                                                    }
                                                    $build = $this->db->table("cutihutang")
                                                        ->join("user", "user.user_id=cutihutang.user_id", "left")
                                                        ->join("position", "position.position_id=user.position_id", "left")
                                                        ->join("departemen", "departemen.departemen_id=user.departemen_id", "left");

                                                    if (isset($_GET["departemen_id"]) && $_GET["departemen_id"] != "") {
                                                        $departemen_id = $_GET["departemen_id"];
                                                        $build->where("user.departemen_id", $departemen_id);
                                                    }
                                                    if (isset($_GET["position_id"]) && $_GET["position_id"] != "") {
                                                        $position_id = $_GET["position_id"];
                                                        $build->where("user.position_id", $position_id);
                                                    }
                                                    if (!isset($_GET["departemen_id"]) && !isset($_GET["position_id"])) {
                                                        $build->where("user.position_id", "0");
                                                    }
                                                    if ((isset($_GET["departemen_id"]) && $_GET["departemen_id"] == "") && (isset($_GET["position_id"]) && $_GET["position_id"] == "")) {
                                                        $build->where("user.position_id", "0");
                                                    }
                                                    $build->where("cutihutang_date >=", $dari);
                                                    $build->where("cutihutang_date <=", $ke);
                                                    $usr = $build->orderBy("departemen_name", "ASC")
                                                        ->orderBy("position_name", "ASC")
                                                        ->orderBy("user_nama", "ASC")
                                                        ->get();
                                                    //echo $this->db->getLastquery();
                                                    $no = 1;
                                                    $aktif = ["Tidak Aktif", "Aktif"];
                                                    $lembur = ["Tidak", "Perjam", "Insentif"];
                                                    foreach ($usr->getResult() as $usr) { ?>
                                                        <tr>
                                                            <?php if (!isset($_GET["report"])) { ?>
                                                                <td style="padding-left:0px; padding-right:0px;">
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
                                                                            <input type="hidden" name="cutihutang_id" value="<?= $usr->cutihutang_id; ?>" />
                                                                        </form>
                                                                    <?php } ?>
                                                                </td>
                                                            <?php } ?>
                                                            <!-- <td><?= $no++; ?></td> -->
                                                            <td><?= $usr->departemen_name; ?></td>
                                                            <td><?= $usr->position_name; ?></td>
                                                            <td><?= $usr->user_nik; ?></td>
                                                            <td><?= $usr->user_nama; ?></td>
                                                            <td><?= $aktif[$usr->user_status]; ?></td>
                                                            <td><?= $usr->cutihutang_date; ?></td>
                                                            <td><?= $usr->cutihutang_nominal; ?></td>
                                                            <td><?= $usr->cutihutang_keterangan; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header card-success" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left text-white bold <?= $panel2['buttonClass'] ?>" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="<?= $panel2['ariaExpanded'] ?>" aria-controls="collapseTwo">
                                            <i class="fa fa-arrow-down"></i> Pilih Hutang Cuti
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse <?= $panel2['collapseClass'] ?>" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                                    <div class="card-body">


                                        <div class="alert alert-info">
                                            <form method="post" action="<?= base_url("cutihutang"); ?>">
                                                <div class="row">
                                                    <?php
                                                    if (isset($_POST["departemen_id"])) {
                                                        $idepartemen = $_POST["departemen_id"];
                                                    } else {
                                                        $idepartemen = "";
                                                    }
                                                    if (isset($_POST["position_id"])) {
                                                        $iposition = $_POST["position_id"];
                                                    } else {
                                                        $iposition = "";
                                                    }
                                                    ?>
                                                    <div class="col-4 row mb-2">
                                                        <div class="col-3">
                                                            <label class="text-dark">Dept. :</label>
                                                        </div>
                                                        <div class="col-9">
                                                            <select class="form-control select" name="departemen_id">
                                                                <option value="">Departemen</option>
                                                                <?php $departemen = $this->db->table("departemen")->orderBy("departemen_name")->get();
                                                                foreach ($departemen->getResult() as $departemen) { ?>
                                                                    <option value="<?= $departemen->departemen_id; ?>" <?= ($idepartemen == $departemen->departemen_id) ? "selected" : ""; ?>><?= $departemen->departemen_name; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 row mb-2">
                                                        <div class="col-3">
                                                            <label class="text-dark">Posisi :</label>
                                                        </div>
                                                        <div class="col-9">
                                                            <select class="form-control select" name="position_id">
                                                                <option value="">Position</option>
                                                                <?php $position = $this->db->table("position")->orderBy("position_name")->get();
                                                                foreach ($position->getResult() as $position) { ?>
                                                                    <option value="<?= $position->position_id; ?>" <?= ($iposition == $position->position_id) ? "selected" : ""; ?>><?= $position->position_name; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 mb-2">
                                                        <button type="submit" class="btn btn-block btn-primary">Search</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>






                                    </div>

                                    <form method="post" action="<?= base_url("cutihutang"); ?>">
                                        <div class="alert alert-info">
                                            <div class="row">

                                                <div class="col-12 mb-3">
                                                    <button type="button" id="togglePilih" class="btn btn-block btn-info">Pilih Semua</button>
                                                </div>
                                                <div class="col-3 row mb-2">
                                                    <div class="col-3">
                                                        <label class="text-dark">Tanggal Mulai</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <input type="date" class="form-control" placeholder="Tanggal Mulai" name="cutihutang_date">
                                                    </div>
                                                </div>
                                                <div class="col-2 row mb-2">
                                                    <div class="col-3">
                                                        <label class="text-dark">Hari</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <input type="number" class="form-control" placeholder="" name="cutihutang_nominal">
                                                    </div>
                                                </div>
                                                <div class="col-6 row mb-2">
                                                    <div class="col-1">
                                                        <label class="text-dark">Ket.</label>
                                                    </div>
                                                    <div class="col-11">
                                                        <input type="text" class="form-control" placeholder="" name="cutihutang_keterangan">
                                                    </div>
                                                </div>
                                                <div class="col-1 mb-2">
                                                    <button name="create" type="submit" class="btn btn-block btn-success" value="OK">Save</button>
                                                </div>
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    let semuaTerpilih = false;

                                                    $('#togglePilih').click(function() {
                                                        semuaTerpilih = !semuaTerpilih;
                                                        $('.cpilih').prop('checked', semuaTerpilih);

                                                        if (semuaTerpilih) {
                                                            $(this).text('Hapus Semua Pilihan');
                                                            $(this).removeClass('btn-info').addClass('btn-warning');
                                                        } else {
                                                            $(this).text('Pilih Semua');
                                                            $(this).removeClass('btn-warning').addClass('btn-info');
                                                        }
                                                    });
                                                });
                                            </script>
                                            <?php if (session()->getFlashdata('success')): ?>
                                                <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
                                            <?php endif; ?>
                                            <?php if (session()->getFlashdata('error')): ?>
                                                <div class="alert alert-warning"><?= session()->getFlashdata('error'); ?></div>
                                            <?php endif; ?>
                                            <div class="table-responsive m-t-40">
                                                <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead class="">
                                                        <tr>
                                                            <th>Pilih</th>
                                                            <th>Sisa Cuti</th>
                                                            <th>Departemen</th>
                                                            <th>Posisi</th>
                                                            <th>NIK</th>
                                                            <th>Name</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $build = $this->db->table("user")
                                                            ->join("position", "position.position_id=user.position_id", "left")
                                                            ->join("departemen", "departemen.departemen_id=user.departemen_id", "left");
                                                        if (isset($_POST["departemen_id"]) && $_POST["departemen_id"] != "") {
                                                            $departemen_id = $_POST["departemen_id"];
                                                            $build->where("user.departemen_id", $departemen_id);
                                                        }
                                                        if (isset($_POST["position_id"]) && $_POST["position_id"] != "") {
                                                            $position_id = $_POST["position_id"];
                                                            $build->where("user.position_id", $position_id);
                                                        }
                                                        if (!isset($_POST["departemen_id"]) && !isset($_POST["position_id"])) {
                                                            $build->where("user.position_id", "0");
                                                        }
                                                        if ((isset($_POST["departemen_id"]) && $_POST["departemen_id"] == "") && (isset($_POST["position_id"]) && $_POST["position_id"] == "")) {
                                                            $build->where("user.position_id", "0");
                                                        }
                                                        $usr = $build->orderBy("departemen_name", "ASC")
                                                            ->orderBy("position_name", "ASC")
                                                            ->orderBy("user_nama", "ASC")
                                                            ->get();
                                                        // echo $this->db->getLastquery();
                                                        $no = 1;
                                                        $aktif = ["Tidak Aktif", "Aktif"];
                                                        $lembur = ["Tidak", "Perjam", "Insentif"];
                                                        foreach ($usr->getResult() as $usr) { ?>
                                                            <td><input class="cpilih" type="checkbox" id="p<?= $usr->user_id; ?>" name="user_id[]" value="<?= $usr->user_id; ?>" /></td>
                                                            <td><?= $usr->user_cuti; ?></td>
                                                            <td><?= $usr->departemen_name; ?></td>
                                                            <td><?= $usr->position_name; ?></td>
                                                            <td><?= $usr->user_nik; ?></td>
                                                            <td><?= $usr->user_nama; ?></td>
                                                            <td><?= $aktif[$usr->user_status]; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                </div>


            <?php } ?>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    $('.select').select2();
    var title = "Hutang Cuti";
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