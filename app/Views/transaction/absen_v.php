<?php echo $this->include("template/header_v"); ?>
<link rel="stylesheet" href="<?= base_url("css/flatpickr.min.css"); ?>">
<script src="<?= base_url("js/flatpickr"); ?>"></script>

<style>
    .tdata {
        background-color: black;
        color: white !important;
        padding: 5px 5px 0 5px;
        margin-bottom: 5px;
        border-radius: 5px;
    }

    .float-left {
        float: left;
    }

    .w50 {
        width: 50px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .w70 {
        width: 70px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .w100 {
        width: 100px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .w150 {
        width: 150px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .w200 {
        width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .w220 {
        width: 220px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }


    input,
    select {
        border: none;
    }

    .bg-second {
        background-color: rgba(73, 72, 72, 0.17);
    }

    .bg-yellow {
        background-color: rgba(234, 234, 182, 0.73);
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
                    <div class="tdata">
                        <form method="get">
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
                            ?>
                            <label class="">Dari :</label>
                            <input type="date" class="" placeholder="Dari" id="dari" value="<?= $dari; ?>">

                            <label class="">Ke :</label>
                            <input type="date" class="" placeholder="Ke" id="ke" value="<?= $ke; ?>">

                            <button value="OK" id="cari2" name="cari2" type="button" class="btn btn-primary btn-sm" onclick="tarikdata()">Tarik Data</button>

                            <b class="ml-3">ETAG:</b> <span id="etag"></span> |
                            <b>EDATE:</b> <span id="edate"></span> |
                            <b>ETIME:</b> <span id="etime"></span> |
                            <b>Total:</b> <span id="etotal"></span> |
                            <b>Status:</b> <span id="eketerangan"></span>
                        </form>
                        <script>
                            let intervalId;
                            let lastTotal = null;
                            let stagnantCount = 0; // Berapa kali data tidak berubah
                            const threshold = 5; // Jumlah pengulangan (misal 5x = 500ms jika interval 100ms)

                            function tarikdata() {
                                let dari = $("#dari").val();
                                let ke = $("#ke").val();
                                // let host = window.location.hostname;
                                let port = '<?= $this->session->get("identity_port"); ?>';
                                let host = '<?= $this->session->get("identity_ip"); ?>';
                                // alert("http://" + host + ":"+port+"/tarikabsen?dari=" + dari + "&ke=" + ke);
                                $.get("http://" + host + ":" + port + "/tarikabsen", {
                                    dari: dari,
                                    ke: ke
                                }).done(function(data) {
                                    if (!intervalId) {
                                        intervalId = setInterval(() => {
                                            $.get("http://" + host + ":" + port + "/status")
                                                .done(function(data) {
                                                    $("#eketerangan").html("Berjalan");
                                                    const [etag, edate, etime, etotal] = data.split("|");
                                                    document.getElementById("etag").textContent = etag;
                                                    document.getElementById("edate").textContent = edate;
                                                    document.getElementById("etime").textContent = etime;
                                                    document.getElementById("etotal").textContent = etotal;

                                                    if (lastTotal === etotal) {
                                                        stagnantCount++;
                                                        if (stagnantCount >= threshold) {
                                                            clearInterval(intervalId);
                                                            intervalId = null;
                                                            $("#eketerangan").html("Selesai");
                                                        }
                                                    } else {
                                                        lastTotal = etotal;
                                                        stagnantCount = 0;
                                                    }
                                                })
                                                .fail(function() {
                                                    console.log("Gagal menghubungi server.");
                                                });
                                        }, 100);
                                    }
                                }).fail(function(xhr, status, error) {
                                    alert("Gagal: " + xhr.responseText + " " + status + " " + error);
                                    console.log(xhr.responseText);
                                });
                            }
                        </script>
                    </div>
                    <div class="accordion" id="faqAccordion">
                        <form method="post" action="<?= base_url("absen"); ?>">
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
                            if (isset($_POST["user_nama"])) {
                                $iuser_nama = $_POST["user_nama"];
                            } else {
                                $iuser_nama = "";
                            }
                            if (isset($_POST["user_nik"])) {
                                $iuser_nik = $_POST["user_nik"];
                            } else {
                                $iuser_nik = "";
                            }
                            if (isset($_POST["tanggal"])) {
                                $itanggal = $_POST["tanggal"];
                            } else {
                                $itanggal = date("Y-m-d");
                            }
                            ?>
                            <input type="date" class=" " id="tanggal" name="tanggal" value="<?= $itanggal; ?>">
                            <select class=" " name="departemen_id">
                                <option value="">Pilih Dept.</option>
                                <option value="all">All</option>
                                <?php $departemen = $this->db->table("departemen")->orderBy("departemen_name")->get();
                                foreach ($departemen->getResult() as $departemen) { ?>
                                    <option value="<?= $departemen->departemen_id; ?>" <?= ($idepartemen == $departemen->departemen_id) ? "selected" : ""; ?>><?= $departemen->departemen_name; ?></option>
                                <?php } ?>
                            </select>
                            <select class=" " name="position_id">
                                <option value="">Pilih Posisi</option>
                                <option value="all">All</option>
                                <?php $position = $this->db->table("position")->orderBy("position_name")->get();
                                foreach ($position->getResult() as $position) { ?>
                                    <option value="<?= $position->position_id; ?>" <?= ($iposition == $position->position_id) ? "selected" : ""; ?>><?= $position->position_name; ?></option>
                                <?php } ?>
                            </select>
                            <input type="text" class=" " style="width:150px;" name="user_nama" value="<?= $iuser_nama; ?>" placeholder="Nama">
                            <input type="text" class="" style="width:100px;" name="user_nik" value="<?= $iuser_nik; ?>" placeholder="NIK">
                            <button type="submit" name="submit" value="none" class="btn btn-sm btn-primary">None</button>
                            <button type="submit" name="submit" value="masuk" class="btn btn-sm btn-success">Masuk</button>
                            <button type="submit" name="submit" value="late" class="btn btn-sm btn-warning">Late</button>
                            <button type="submit" name="submit" value="absence" class="btn btn-sm btn-danger">Absence</button>
                            <button type="submit" name="submit" value="attend" class="btn btn-sm btn-info">Attend</button>
                            <button type="submit" name="submit" value="leave" class="btn btn-sm btn-dark">Leave</button>
                        </form>
                        <div class="pesan alert alert-info alert-dismissable" style="display:none; position:fixed; left:50%; top:50%; transform:translate(-50%,-50%);">
                            <strong id="pesan"></strong>
                        </div>
                        <table id="e23" class="display nowrap " cellspacing="0" border="1" width="100%">
                            <thead class="">
                                <tr>
                                    <th>Departemen</th>
                                    <th>Posisi</th>
                                    <th>NIK</th>
                                    <th>Name</th>
                                    <th>Attend Log.</th>
                                    <th>Masuk</th>
                                    <th>Pulang</th>
                                    <th>Sakit</th>
                                    <th>Cuti</th>
                                    <th>Izin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $join = "";
                                $table1 = "user";
                                if (isset($_POST["submit"])) {
                                    switch ($_POST["submit"]) {
                                        case "none":
                                            $table = "user";
                                            $build = $this->db->table($table);
                                            $build->join("absen", "absen.user_id=$table.user_id AND absen.absen_date ='" . $_POST["tanggal"] . "'", "left")
                                                ->join("position", "position.position_id=$table1.position_id", "left")
                                                ->join("departemen", "departemen.departemen_id=$table1.departemen_id", "left");
                                            break;
                                        case "masuk":
                                            $table = "absen";
                                            $table1 = "user";
                                            $build = $this->db->table($table);
                                            $build->join("user", "user.user_id=$table.user_id", "left")
                                                ->join("position", "position.position_id=$table1.position_id", "left")
                                                ->join("departemen", "departemen.departemen_id=$table1.departemen_id", "left");
                                            $build->where("$table.absen_date", $_POST["tanggal"]);
                                            $build->where("TIME($table.absen_masuk) !=", "00:00:00");
                                            break;
                                        case "late":
                                            //cek ramdlan bukan
                                            $rm = $this->db->table("ramadlan")->where("ramadlan_date", $_POST["tanggal"])->get()->getNumRows();
                                            
                                            //cari jadwal masuk
                                            $hari = date("w", strtotime($_POST["tanggal"]));
                                            $build = $this->db->table("jamkerja");
                                            if ($rm > 0) {
                                                $build->where("jamkerja_ramadlan", 1);
                                            }else{
                                                $build->where("jamkerja_ramadlan", 0);
                                            }
                                            $jamkerja = $build->where("jamkerja_type", "normal")
                                                ->where("FIND_IN_SET(" . $hari . ",jamkerja_hari) !=", "0")
                                                ->get();
                                            // echo $this->db->getlastQuery();
                                            $jamkerja_awal = "00:00:00";
                                            foreach ($jamkerja->getResult() as $row) {
                                                $jamkerja_awal = $row->jamkerja_awal;
                                            }

                                            $table = "absen";
                                            $table1 = "user";
                                            $build = $this->db->table($table);
                                            $build->join("user", "user.user_id=$table.user_id", "left")
                                                ->join("position", "position.position_id=$table1.position_id", "left")
                                                ->join("departemen", "departemen.departemen_id=$table1.departemen_id", "left");
                                            $build->where("$table.absen_date", $_POST["tanggal"]);
                                            $build->where("$table.absen_masuk >", $_POST["tanggal"] . " " . $jamkerja_awal);
                                            break;
                                        case "absence":
                                            $table = "user";
                                            $build = $this->db->table($table)
                                                ->select("*," . $table . ".user_id as user_id");
                                            $build->join("absen", "absen.user_id=$table.user_id AND absen.absen_date ='" . $_POST["tanggal"] . "'", "left")
                                                ->join("position", "position.position_id=$table1.position_id", "left")
                                                ->join("departemen", "departemen.departemen_id=$table1.departemen_id", "left")
                                                ->groupStart()
                                                ->groupStart()
                                                ->where("TIME(absen.absen_masuk)", "00:00:00")
                                                ->groupStart()
                                                ->where("absen_type", "Normal")
                                                ->orWhere("absen_type", "Alpha")
                                                ->groupEnd()
                                                ->groupEnd()
                                                ->orWhere("absen.user_id IS NULL")
                                                ->groupEnd();
                                            break;
                                        case "attend":
                                            $tanggal = $_POST["tanggal"];
                                            $table = "user";

                                            $build = $this->db->table($table)
                                                ->join("absen", "absen.user_id = $table.user_id AND absen.absen_date = '$tanggal'", "left")
                                                ->join("position", "position.position_id = $table.position_id", "left")
                                                ->join("departemen", "departemen.departemen_id = $table.departemen_id", "left")
                                                ->groupStart() // buka grup kondisi
                                                ->where("TIME(absen.absen_masuk)", "00:00:00")
                                                ->orWhere("absen.absen_masuk IS NULL")
                                                ->groupEnd(); // tutup grup kondisi

                                            break;
                                        case "leave":
                                            $table = "absen";
                                            $table1 = "user";
                                            $build = $this->db->table($table);
                                            $build->join("user", "user.user_id=$table.user_id", "left")
                                                ->join("position", "position.position_id=$table1.position_id", "left")
                                                ->join("departemen", "departemen.departemen_id=$table1.departemen_id", "left");
                                            $build->where("$table.absen_date", $_POST["tanggal"]);
                                            $build->where("TIME(absen.absen_keluar)", "00:00:00");
                                            $build->where("absen.absen_type", "Normal");
                                            break;
                                    }
                                } else {
                                    $table = "user";
                                    $build = $this->db->table($table);
                                    $build->join("absen", "absen.user_id=$table.user_id AND absen.absen_date ='" . date("Y-m-d") . "'", "left")
                                        ->join("position", "position.position_id=$table1.position_id", "left")
                                        ->join("departemen", "departemen.departemen_id=$table1.departemen_id", "left");
                                }

                                $build->where("$table1.user_id !=", "10");
                                // $build->where("absen.absen_date", $_POST["tanggal"]);
                                if (empty($_POST)) {
                                    $build->where("$table1.position_id", "0");
                                } else {
                                    if (isset($_POST["departemen_id"]) && $_POST["departemen_id"] != "" && $_POST["departemen_id"] != "all") {
                                        $departemen_id = $_POST["departemen_id"];
                                        $build->where("$table1.departemen_id", $departemen_id);
                                    }
                                    if (isset($_POST["position_id"]) && $_POST["position_id"] != "" && $_POST["position_id"] != "all") {
                                        $position_id = $_POST["position_id"];
                                        $build->where("$table1.position_id", $position_id);
                                    }
                                    if (isset($_POST["user_nama"]) && $_POST["user_nama"] != "" && $_POST["user_nama"] != "all") {
                                        $user_nama = $_POST["user_nama"];
                                        $build->like("$table1.user_nama", $user_nama, "both");
                                    }
                                    if (isset($_POST["user_nik"]) && $_POST["user_nik"] != "" && $_POST["user_nik"] != "all") {
                                        $user_nik = $_POST["user_nik"];
                                        $build->like("$table1.user_nik", $user_nik, "both");
                                    }
                                    if ((isset($_POST["departemen_id"]) && $_POST["departemen_id"] == "") && (isset($_POST["position_id"]) && $_POST["position_id"] == "") && (isset($_POST["user_nama"]) && $_POST["user_nama"] == "") && (isset($_POST["user_nik"]) && $_POST["user_nik"] == "")) {
                                        $build->where("$table1.position_id", "0");
                                    }
                                }

                                $usr = $build->orderBy("departemen.departemen_name", "ASC")
                                    ->orderBy("position.position_name", "ASC")
                                    ->orderBy("user.user_nama", "ASC")
                                    ->get();
                                // echo $this->db->getLastquery();
                                $no = 1;
                                $aktif = ["Tidak Aktif", "Aktif"];
                                $absen = ["Tidak", "Perjam", "Insentif"];
                                foreach ($usr->getResult() as $usr) { ?>
                                    <tr>
                                        <td class="w100 bg-second"><?= $usr->departemen_name; ?></td>
                                        <td class="w100 bg-second"><?= $usr->position_name; ?></td>
                                        <td class="w100 bg-second"><?= $usr->user_nik; ?></td>
                                        <td class="w150 text-left pl-1 bg-second"><?= $usr->user_nama; ?></td>
                                        <td class="w100 bg-yellow">
                                            <select id="absen_type<?= $usr->user_id; ?>" onchange="usertype(this.value,'<?= $usr->user_id; ?>',0)">
                                                <option value="Normal" <?= ($usr->absen_type == "Normal") ? "selected" : ""; ?>>Normal</option>
                                                <option value="Izin" <?= ($usr->absen_type == "Izin") ? "selected" : ""; ?>>Izin</option>
                                                <option value="Sakit" <?= ($usr->absen_type == "Sakit") ? "selected" : ""; ?>>Sakit</option>
                                                <option value="Alpha" <?= ($usr->absen_type == "Alpha") ? "selected" : ""; ?>>Alpha</option>
                                                <option value="Cuti" <?= ($usr->absen_type == "Cuti") ? "selected" : ""; ?>>Cuti</option>
                                            </select>
                                        </td>
                                        <td class="w50">
                                            <input id="absen_masuk<?= $usr->user_id; ?>" onchange="normal('<?= $usr->user_id; ?>',1)" type="time" class="w50 jam normal<?= $usr->user_id; ?>" placeholder="00:00" value="<?= !empty($usr->absen_masuk) ? date("H:i", strtotime($usr->absen_masuk)) : ''; ?>">
                                        </td>
                                        <td class="w50">
                                            <input id="absen_keluar<?= $usr->user_id; ?>" onchange="normal('<?= $usr->user_id; ?>',1)" type="time" class="w50 jam normal<?= $usr->user_id; ?>" placeholder="00:00" value="<?= !empty($usr->absen_keluar) ? date("H:i", strtotime($usr->absen_keluar)) : '-'; ?>">
                                        </td>
                                        <td class="w100">
                                            <select id="absen_skd<?= $usr->user_id; ?>" class="sakit<?= $usr->user_id; ?>" onchange="normal('<?= $usr->user_id; ?>',1)">
                                                <option value="0" <?= ($usr->absen_skd == 0) ? "selected" : ""; ?>>Non SKD</option>
                                                <option value="1" <?= ($usr->absen_skd == 1) ? "selected" : ""; ?>>SKD</option>
                                            </select>
                                        </td>
                                        <td class="w200">
                                            <select id="cuti_id<?= $usr->user_id; ?>" class="cuti<?= $usr->user_id; ?>" onchange="normal('<?= $usr->user_id; ?>',1)">
                                                <option value="0" <?= ($usr->cuti_id == 0) ? "selected" : ""; ?>>Pilih Cuti</option>
                                                <?php $cuti = $this->db->table("cuti")->orderBy("cuti_name", "ASC")->get();
                                                foreach ($cuti->getResult() as $row) { ?>
                                                    <option value="<?= $row->cuti_id; ?>" <?= ($usr->cuti_id == $row->cuti_id) ? "selected" : ""; ?>><?= str_replace('Cuti', '', $row->cuti_name); ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td class="w100">
                                            <div class="input-group izin<?= $usr->user_id; ?>"">
                                                <input onchange=" normal('<?= $usr->user_id; ?>',1)" type=" text" placeholder="Izin" id="izin<?= $usr->user_id; ?>" value="<?= $usr->absen_note; ?>">
                                            </div>
                                        </td>
                                    </tr>
                                    <script>
                                        $(document).ready(function() {
                                            usertype("<?= $usr->absen_type; ?>", '<?= $usr->user_id; ?>', 0);
                                        });
                                    </script>
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
<div id="test"></div>
<script>
    function pesannya(isi) {
        $("#pesan").html(isi);
        $(".pesan").fadeIn();
        setTimeout(function() {
            $(".pesan").fadeOut();
        }, 2000);
    }

    function normal(id, notif) {
        let absen_type = $("#absen_type" + id).val();
        let absen_date = $("#tanggal").val();
        let absen_masuk = $("#absen_masuk" + id).val();
        let absen_keluar = $("#absen_keluar" + id).val();
        let absen_note = $("#izin" + id).val();
        let absen_skd = $("#absen_skd" + id).val();
        let cuti_id = $("#cuti_id" + id).val();
        // $("#test").html("<?= base_url("api/inputabsenmanual"); ?>?absen_type=" + absen_type + "&absen_date=" + absen_date + "&absen_masuk=" + absen_masuk + "&absen_keluar=" + absen_keluar + "&absen_note=" + absen_note + "&absen_skd=" + absen_skd + "&cuti_id=" + cuti_id + "&create=" + "OK" + "&user_id=" + id);
        $.get("<?= base_url("api/inputabsenmanual"); ?>", {
                absen_type: absen_type,
                absen_date: absen_date,
                absen_masuk: absen_masuk,
                absen_keluar: absen_keluar,
                absen_note: absen_note,
                absen_skd: absen_skd,
                cuti_id: cuti_id,
                create: "OK",
                user_id: id,
            })
            .done(function(data) {
                if (notif == 1) {
                    pesannya(data);
                }
            });
    }

    function izin(id) {
        pesannya("Update Success!");
        let absen_note = $("#izin" + id).val();
        $.get("<?= base_url("api/izin"); ?>", {
                absen_note: absen_note
            })
            .done(function(data) {

            });
    }

    function usertype(tipe, id, notif) {
        if (tipe == "Normal" || tipe == "") {
            $(".normal" + id).show();
            $(".izin" + id).hide();
            $(".sakit" + id).hide();
            $(".alpha" + id).hide();
            $(".cuti" + id).hide();

            $("#sakit" + id).val(0);
            $("#izin" + id).val("");
        }
        if (tipe == "Izin") {
            $(".normal" + id).hide();
            $(".izin" + id).show();
            $(".sakit" + id).hide();
            $(".alpha" + id).hide();
            $(".cuti" + id).hide();

            $("#sakit" + id).val(0);
            $("#normal" + id).val("");
        }
        if (tipe == "Sakit") {
            $(".normal" + id).hide();
            $(".izin" + id).hide();
            $(".sakit" + id).show();
            $(".alpha" + id).hide();
            $(".cuti" + id).hide();

            $("#izin" + id).val("");
            $("#normal" + id).val("");
        }
        if (tipe == "Alpha") {
            $(".normal" + id).hide();
            $(".izin" + id).hide();
            $(".sakit" + id).hide();
            $(".alpha" + id).show();
            $(".cuti" + id).hide();

            $("#sakit" + id).val(0);
            $("#izin" + id).val("");
            $("#normal" + id).val("");
        }
        if (tipe == "Cuti") {
            $(".normal" + id).hide();
            $(".izin" + id).hide();
            $(".sakit" + id).hide();
            $(".alpha" + id).hide();
            $(".cuti" + id).show();

            $("#sakit" + id).val(0);
            $("#izin" + id).val("");
            $("#normal" + id).val("");
        }
        normal(id, notif);
    }
    $('.select').select2();
    var title = "Absen";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>
<script>
    $(document).ready(function() {
        flatpickr(".jam", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });

        $('#e23').DataTable({
            dom: 'Blfrtip',
            autoWidth: false,
            lengthMenu: [
                [50, 100, -1],
                [50, 100, "All"]
            ],
            buttons: [{
                    extend: 'print',
                    exportOptions: {
                        columns: ':not(:first-child)'
                    },
                    customize: function(win) {
                        // Tambahkan CSS langsung ke dokumen cetak
                        var css = `
                            .screen-only { display: none !important; }
                            .print-only { display: inline !important; }
                        `;
                        $(win.document.head).append('<style>' + css + '</style>');
                        $(win.document.body)
                            .find('td.text-left')
                            .css('text-align', 'left');
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':not(:first-child)'
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':not(:first-child)'
                    }
                }
            ],
            ordering: false // Mencegah DataTables mengatur order by
        });
    });
</script>

<?php echo  $this->include("template/footer_v"); ?>