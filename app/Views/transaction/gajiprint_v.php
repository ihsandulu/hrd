<?php echo $this->include("template/headersaja_v"); ?>
<style>
    html,
    body {
        margin: 0px 10px 0px 10px;
        padding: 0px 5px 0px 5px;
    }

    .border {
        border: black solid 1px;
        padding: 5px;
    }

    .bold {
        font-weight: bold;
    }

    .border-top {
        border-top: black solid 1px !important;
    }

    .p-0 {
        padding: 0px !important;
    }

    .m-0 {
        margin: 0px !important;
    }
</style>

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
    if (isset($_GET["departemen"])) {
        $idepartemen = $_GET["departemen"];
    }
    ?>


    <?php
    $gaji_id = $this->request->getGet("gaji_id");
    $build = $this->db
        ->table("gaji");
    if (isset($_GET["gaji_id"])) {
        $build->where("gaji.gaji_id", $gaji_id);
    }
    $usr = $build->orderBy("gaji_print", "ASC")
        ->orderBy("departemen_name", "ASC")
        ->orderBy("position_name", "ASC")
        ->orderBy("user_name", "ASC")
        ->get();
    //echo $this->db->getLastquery();
    $no = 1;
    foreach ($usr->getResult() as $usr) {

    ?><div class="col-md-6 p-2">
            <div class="row border m-2">
                <div class="col-md-12 bold text-center"><?= strtoupper($this->session->get("identity_company")); ?></div>
                <div class="col-md-12 border bold text-center">Salary Slip</div>
                <div class="col-md-4">Periode</div>
                <div class="col-md-8">: <?= $usr->gaji_print; ?></div>
                <div class="col-md-4">Bagian</div>
                <div class="col-md-8">: <?= $usr->departemen_name; ?></div>
                <div class="col-md-4">Jabatan</div>
                <div class="col-md-8">: <?= $usr->position_name; ?></div>
                <div class="col-md-4">Nama</div>
                <div class="col-md-8">: <?= $usr->user_name; ?></div>
                <div class="col-md-4">Tgl Masuk</div>
                <div class="col-md-8">: <?= $usr->user_masuk; ?></div>
                <div class="col-md-4">Absensi</div>
                <div class="col-md-8">: H:<?= $usr->gaji_hadir; ?>|C:<?= $usr->gaji_cuti; ?>|S:<?= $usr->gaji_sakit; ?>|I:<?= $usr->gaji_izin; ?>|A: <?= $usr->gaji_alpha; ?></div>
                <div class="col-md-12 border-top p-0 m-0"></div>

                <div class="col-md-12 bold mt-2">UPAH TETAP</div>
                <div class="col-md-4">Gaji Pokok</div>
                <div class="col-md-2">: Rp </div>
                <div class="col-md-6 text-right"><?= number_format($usr->gaji_pokok, 0, ",", "."); ?></div>
                <div class="col-md-4">T. Jabatan</div>
                <div class="col-md-2">: Rp </div>
                <div class="col-md-6 text-right"><?= number_format($usr->gaji_tjabatan, 0, ",", "."); ?></div>

                <div class="col-md-12 bold  mt-2">UPAH TDK TETAP</div>
                <div class="col-md-4">T.Transport</div>
                <div class="col-md-2">: Rp </div>
                <div class="col-md-6 text-right"><?= number_format($usr->gaji_ttransport, 0, ",", "."); ?></div>

                <div class="col-md-4">T.Kehadiran</div>
                <div class="col-md-2">: Rp </div>
                <div class="col-md-6 text-right"><?= number_format($usr->gaji_tkehadiran, 0, ",", "."); ?></div>
                <div class="col-md-4">T.Makan</div>
                <div class="col-md-2">: Rp </div>
                <div class="col-md-6 text-right"><?= number_format($usr->gaji_tmakan, 0, ",", "."); ?></div>


                <?php if ($usr->user_payrolltype == "harian") { ?>
                    <div class="col-md-4">Lembur OT1</div>
                    <div class="col-md-2">: Rp </div>
                    <div class="col-md-6 text-right"><?= number_format($usr->gaji_ot1nominal, 0, ",", "."); ?></div>
                    <div class="col-md-4">Lembur OT2</div>
                    <div class="col-md-2">: Rp </div>
                    <div class="col-md-6 text-right"><?= number_format($usr->gaji_ot2nominal, 0, ",", "."); ?></div>
                    <div class="col-md-4">Lembur OT3</div>
                    <div class="col-md-2">: Rp </div>
                    <div class="col-md-6 text-right"><?= number_format($usr->gaji_ot3nominal, 0, ",", "."); ?></div>
                    <div class="col-md-4">Lembur OT4</div>
                    <div class="col-md-2">: Rp </div>
                    <div class="col-md-6 text-right"><?= number_format($usr->gaji_ot4nominal, 0, ",", "."); ?></div>
                <?php } ?>

                <div class="col-md-4">Insentif</div>
                <div class="col-md-2">: Rp </div>
                <div class="col-md-6 text-right"><?= number_format($usr->gaji_insentive1, 0, ",", "."); ?></div>
                <!-- <div class="col-md-4">Uang Libur</div>
            <div class="col-md-2">: Rp </div>
            <div class="col-md-6 text-right"><?= number_format(0, 0, ",", "."); ?></div> -->
                <div class="col-md-4">Lain-lain</div>
                <div class="col-md-2">: Rp </div>
                <div class="col-md-6 text-right"><?= number_format($usr->gaji_lain, 0, ",", "."); ?></div>
                <div class="col-md-12 border-top"></div>


                <div class="col-md-4">Gaji Kotor</div>
                <div class="col-md-2">: Rp </div>
                <div class="col-md-6 text-right"><?= number_format($usr->gaji_kotor, 0, ",", "."); ?></div>

                <div class="col-md-12 bold mt-2">POTONGAN</div>
                <div class="col-md-4">Absence</div>
                <div class="col-md-2">: Rp </div>
                <div class="col-md-6 text-right"><?= number_format($usr->gaji_alphanominal, 0, ",", "."); ?></div>

                <?php if ($usr->user_payrolltype == "bulanan") { ?>
                    <div class="col-md-4">T.Transport</div>
                    <div class="col-md-2">: Rp </div>
                    <div class="col-md-6 text-right"><?= number_format($usr->gaji_ptransportasi, 0, ",", "."); ?></div>
                    <div class="col-md-4">T.Kehadiran</div>
                    <div class="col-md-2">: Rp </div>
                    <div class="col-md-6 text-right"><?= number_format($usr->gaji_pkehadiran, 0, ",", "."); ?></div>
                    <div class="col-md-4">T.Makan</div>
                    <div class="col-md-2">: Rp </div>
                    <div class="col-md-6 text-right"><?= number_format($usr->gaji_pmakan, 0, ",", "."); ?></div>
                <?php } ?>

                <div class="col-md-4">Inventaris</div>
                <div class="col-md-2">: Rp </div>
                <div class="col-md-6 text-right"><?= number_format($usr->gaji_inventaris, 0, ",", "."); ?></div>

                <div class="col-md-4">BPJS Kesehatan</div>
                <div class="col-md-2">: Rp </div>
                <div class="col-md-6 text-right"><?= number_format($usr->gaji_bpjskesehatan, 0, ",", "."); ?></div>
                <div class="col-md-4">BPJS JHT</div>
                <div class="col-md-2">: Rp </div>
                <div class="col-md-6 text-right"><?= number_format($usr->gaji_bpjsjht, 0, ",", "."); ?></div>
                <div class="col-md-4">BPJS Pensiun</div>
                <div class="col-md-2">: Rp </div>
                <div class="col-md-6 text-right"><?= number_format($usr->gaji_bpjspensiun, 0, ",", "."); ?></div>
                <div class="col-md-4">PPH21</div>
                <div class="col-md-2">: Rp </div>
                <div class="col-md-6 text-right"><?= number_format($usr->gaji_pph21, 0, ",", "."); ?></div>
                <div class="col-md-4">Lain-lain</div>
                <div class="col-md-2">: Rp </div>
                <div class="col-md-6 text-right"><?= number_format($usr->gaji_plain, 0, ",", "."); ?></div>
                <div class="col-md-12 border-top"></div>


                <div class="col-md-4">Potongan Total</div>
                <div class="col-md-2">: Rp </div>
                <div class="col-md-6 text-right"><?= number_format($usr->gaji_potongantotal, 0, ",", "."); ?></div>
                <div class="col-md-12 border-top"></div>

                <div class="col-md-4 bold">GAJI TOTAL</div>
                <div class="col-md-2 bold">: Rp </div>
                <div class="col-md-6 text-right bold"><?= number_format($usr->gaji_total, 0, ",", "."); ?></div>
            </div>
        </div>
    <?php } ?>
    <script>
        $('.select').select2();
        var title = "Potongan Inventaris";
        $("title").text(title);
        $(".card-title").text(title);
        $("#page-title").text(title);
        $("#page-title-link").text(title);
    </script>
</div>
<?php echo  $this->include("template/footersaja_v"); ?>