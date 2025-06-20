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
                    if (isset($_GET["histori"])) {
                        $panel1 = accordionState(true);
                        $panel2 = accordionState(false);
                    } else {
                        $panel1 = accordionState(false);
                        $panel2 = accordionState(true);
                    }

                    ?>



                    <div class="accordion" id="faqAccordion">
                        <div class="card">
                            <div class="card-header card-success" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left text-white bold <?= $panel2['buttonClass'] ?>" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="<?= $panel2['ariaExpanded'] ?>" aria-controls="collapseTwo">
                                        <i class="fa fa-arrow-down"></i> <?= $title; ?>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse <?= $panel2['collapseClass'] ?>" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                                <div class="card-body">
                                    <div class="alert alert-info">
                                        <form class="form-inline" method="post" action="<?= base_url("bpjsdata"); ?>">
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
                                                if (isset($_POST["user_nik"])) {
                                                    $iuser = $_POST["user_nik"];
                                                } else {
                                                    $iuser = "";
                                                }
                                                ?>
                                                <div class="col mb-2">
                                                    <select class="form-control " name="departemen_id">
                                                        <option value="">Departemen</option>
                                                        <option value="all">All</option>
                                                        <?php $departemen = $this->db->table("departemen")->orderBy("departemen_name")->get();
                                                        foreach ($departemen->getResult() as $departemen) { ?>
                                                            <option value="<?= $departemen->departemen_id; ?>" <?= ($idepartemen == $departemen->departemen_id) ? "selected" : ""; ?>><?= $departemen->departemen_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col mb-2">
                                                    <select class="form-control " name="position_id">
                                                        <option value="">Position</option>
                                                        <option value="all">All</option>
                                                        <?php $position = $this->db->table("position")->orderBy("position_name")->get();
                                                        foreach ($position->getResult() as $position) { ?>
                                                            <option value="<?= $position->position_id; ?>" <?= ($iposition == $position->position_id) ? "selected" : ""; ?>><?= $position->position_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col mb-2">
                                                    <input class="form-control " name="user_nik" placeholder="NIK">
                                                </div>
                                                <div class="col mb-2">
                                                    <input class="form-control " name="user_ktp" placeholder="KTP">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                                <div class="">
                                    <form class="form-inline" method="post" action="<?= base_url("bpjsdata"); ?>">
                                        <div class="row">
                                            <div class="col mb-2">
                                                <input type="hidden" id="user_id" name="user_id">
                                                <input readonly placeholder="Nama" class="form-control" id="user_nama">
                                            </div>
                                            <div class="col mb-2">
                                                <input required placeholder="NIK" class="form-control" id="user_nik" name="user_nik">
                                            </div>
                                            <div class="col mb-2">
                                                <input required placeholder="KTP" class="form-control" id="user_ktp" name="user_ktp">
                                            </div>

                                            <div class="col mb-2">
                                                <button name="create" type="submit" class="btn btn-block btn-success" value="OK">Save</button>
                                            </div>
                                    </form>
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
                                <div class="table-responsive m-t-1">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead class="">
                                            <tr>
                                                <th>Pilih</th>
                                                <th>Posisi</th>
                                                <th>Name</th>
                                                <th>NIK</th>
                                                <th>KTP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $build = $this->db->table("user")
                                                ->join("position", "position.position_id=user.position_id", "left")
                                                ->join("departemen", "departemen.departemen_id=user.departemen_id", "left")
                                                ->where("user.user_id !=", "10");

                                            if (isset($_POST["departemen_id"]) && $_POST["departemen_id"] != "" && $_POST["departemen_id"] != "all") {
                                                $departemen_id = $_POST["departemen_id"];
                                                $build->where("user.departemen_id", $departemen_id);
                                            }
                                            if (isset($_POST["position_id"]) && $_POST["position_id"] != "" && $_POST["position_id"] != "all") {
                                                $position_id = $_POST["position_id"];
                                                $build->where("user.position_id", $position_id);
                                            }
                                            if (isset($_POST["user_nik"]) && $_POST["user_nik"] != "" && $_POST["user_nik"] != "all") {
                                                $user_nik = $_POST["user_nik"];
                                                $build->like("user.user_nik", $user_nik, "BOTH");
                                            }
                                            if (isset($_POST["user_ktp"]) && $_POST["user_ktp"] != "" && $_POST["user_ktp"] != "all") {
                                                $user_ktp = $_POST["user_ktp"];
                                                $build->like("user.user_ktp", $user_ktp, "BOTH");
                                            }
                                            if (!isset($_POST["departemen_id"]) && !isset($_POST["position_id"]) && !isset($_POST["user_nik"])) {
                                                $build->where("user.position_id", "0");
                                            }
                                            if ((isset($_POST["departemen_id"]) && $_POST["departemen_id"] == "") && (isset($_POST["position_id"]) && $_POST["position_id"] == "") && (isset($_POST["user_nik"]) && $_POST["user_nik"] == "")) {
                                                $build->where("user.position_id", "0");
                                            }
                                            $usr = $build->orderBy("departemen_name", "ASC")
                                                ->orderBy("position_name", "ASC")
                                                ->orderBy("user_nama", "ASC")
                                                ->get();
                                            // echo $this->db->getLastquery();
                                            $no = 1;
                                            $statusbpjs = ["Non Aktif", "Aktif"];
                                            foreach ($usr->getResult() as $usr) { ?>
                                                <td>
                                                    <button class="btn btn-success btn-xs" type="button" onclick="tampilnama('<?= $usr->user_id; ?>','<?= $usr->user_nama; ?>','<?= $usr->user_nik; ?>','<?= $usr->user_ktp; ?>')">
                                                        <span class="fa fa-arrow-up"></span>
                                                    </button>
                                                </td>
                                                <td><?= $usr->departemen_name; ?> - <?= $usr->position_name; ?></td>
                                                <td><?= $usr->user_nama; ?> (<?= $usr->user_nik; ?> | <?= $usr->user_ktp; ?>)</td>
                                                <td class=""><?= $usr->user_nik; ?></td>
                                                <td class=""><?= $usr->user_ktp; ?></td>
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
        </div>
    </div>
</div>
</div>
<script>
    function tampilnama(id, nama, nik, ktp) {
        $("#user_id").val(id);
        $("#user_nama").val(nama);
        $("#user_nik").val(nik);
        $("#user_ktp").val(ktp);
    }
    $('.select').select2();
    var title = "<?= $title; ?>";
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