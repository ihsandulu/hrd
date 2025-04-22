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
                                        <i class="fa fa-arrow-down"></i> History Absen
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
                                                $build = $this->db->table("absen")
                                                    ->join("user", "user.user_id=absen.user_id", "left")
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
                                                $build->where("absen_date >=", $dari);
                                                $build->where("absen_date <=", $ke);
                                                $usr = $build->orderBy("departemen_name", "ASC")
                                                    ->orderBy("position_name", "ASC")
                                                    ->orderBy("user_nama", "ASC")
                                                    ->get();
                                                //echo $this->db->getLastquery();
                                                $no = 1;
                                                $aktif = ["Tidak Aktif", "Aktif"];
                                                $absen = ["Tidak", "Perjam", "Insentif"];
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
                                                                        <input type="hidden" name="absen_id" value="<?= $usr->absen_id; ?>" />
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
                                                        <td><?= $usr->absen_date; ?></td>
                                                        <td><?= $usr->absen_jam; ?></td>
                                                        <td><?= $usr->absen_type; ?></td>
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
                                        <i class="fa fa-arrow-down"></i> Pilih Absen
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse <?= $panel2['collapseClass'] ?>" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                                <div class="card-body">


                                    <div class="alert alert-info">
                                        <form method="post" action="<?= base_url("absen"); ?>">
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
                                                        <select class="form-control " name="departemen_id">
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
                                                        <select class="form-control " name="position_id">
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

                                <form method="post" action="<?= base_url("absen"); ?>">
                                    <div class="alert alert-info">
                                        <div class="row">

                                            <div class="col-12 mb-3">
                                                <button type="button" id="togglePilih" class="btn btn-block btn-info">Pilih Semua</button>
                                            </div>
                                            <div class="col-3 row mb-2">
                                                <div class="col-3">
                                                    <label class="text-dark">Type</label>
                                                </div>
                                                <div class="col-9">
                                                    <select onchange="pilihtipe()" autofocus required class="form-control select" id="absen_type" name="absen_type">
                                                        <option value="">Pilih Type</option>
                                                        <option value="Masuk">Masuk</option>
                                                        <option value="Sakit">Sakit</option>
                                                        <option value="Izin">Izin</option>
                                                        <option value="Cuti">Cuti</option>
                                                        <option value="Alpha">Alpha</option>
                                                    </select>
                                                    <script>
                                                        function pilihtipeori() {
                                                            var absen_type = $("#absen_type").val();
                                                            if (absen_type == "Sakit") {
                                                                $(".sakit").show();
                                                            } else {
                                                                $(".sakit").hide();
                                                            }
                                                            if (absen_type == "Cuti") {
                                                                $(".cuti").show();
                                                            } else {
                                                                $(".cuti").hide();
                                                            }
                                                            if (absen_type == "Masuk") {
                                                                $(".cmasuk").show();
                                                            } else {
                                                                $(".cmasuk").hide();
                                                            }
                                                        }

                                                        function pilihtipe() {
                                                            var absen_type = $("#absen_type").val();
                                                            if (absen_type == "Sakit") {
                                                                $(".sakit").show();
                                                            } else {
                                                                $(".sakit").hide();
                                                                $("#absen_skd").val(0);
                                                            }
                                                            if (absen_type == "Cuti") {
                                                                $(".cuti").show();
                                                            } else {
                                                                $(".cuti").hide();
                                                                $("#cuti_id").val(0);
                                                            }
                                                            if (absen_type == "Masuk") {
                                                                $(".cmasuk").show();
                                                            } else {
                                                                $(".cmasuk").hide();
                                                                $(".imasuk").prop("value", "");
                                                            }
                                                        }
                                                        $(document).ready(function() {
                                                            $(".sakit").hide();
                                                            $(".cuti").hide();
                                                            $(".cmasuk").hide();
                                                            pilihtipeori();
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                            <div class="col-2 row mb-2">
                                                <div class="col-3">
                                                    <label class="text-dark">Date</label>
                                                </div>
                                                <div class="col-9">
                                                    <input required type="date" class="form-control" id="absen_date" name="absen_date" placeholder="" value="<?= $absen_date; ?>">
                                                </div>
                                            </div>
                                            <div class="col-3 row mb-2">
                                                <div class="col-3">
                                                    <label class="text-dark">SKD</label>
                                                </div>
                                                <div class="col-9">
                                                    <select class="form-control" id="absen_skd" name="absen_skd">
                                                        <option value="0" <?= ($absen_skd == "0") ? "selected" : ""; ?>>Tidak</option>
                                                        <option value="1" <?= ($absen_skd == "1") ? "selected" : ""; ?>>Ya</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-3 row mb-2">
                                                <div class="col-3">
                                                    <label class="text-dark">Cuti</label>
                                                </div>
                                                <div class="col-9">
                                                    <select class="form-control" id="cuti_id" name="cuti_id">
                                                        <option value="0" <?= ($cuti_id == "0") ? "selected" : ""; ?>>Pilih Cuti</option>
                                                        <?php $cuti = $this->db->table("cuti")->orderBy("cuti_name", "ASC")->get(); ?>
                                                        <?php foreach ($cuti->getResult() as $cuti) { ?>
                                                            <option value="<?= $cuti->cuti_id; ?>" <?= ($cuti_id == $cuti->cuti_id) ? "selected" : ""; ?>><?= $cuti->cuti_name; ?></option>
                                                        <?php } ?>
                                                    </select>
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
                                                    $absen = ["Tidak", "Perjam", "Insentif"];
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



            </div>
        </div>
    </div>
</div>
</div>
<script>
    $('.select').select2();
    var title = "Absen";
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