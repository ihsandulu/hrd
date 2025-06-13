<?php echo $this->include("template/header_v"); ?>
<style>
    .modal-content {
        background-color: transparent;
        /* Membuat latar belakang modal menjadi transparan */
        border: none;
    }

    .modal-body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80vh;
        /* Mengatur tinggi modal menjadi 80% tinggi layar */
    }

    .modal-body .gambar {
        max-height: 100%;
        /* Membuat gambar tidak melebihi tinggi modal */
        width: auto;
        height: auto;
    }

    .text-success {
        color: cadetblue !important;
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

                        <!-- <?php if (!isset($_POST['new']) && !isset($_POST['edit']) && !isset($_GET['report'])) { ?>
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
                                            isset(session()->get("halaman")['50']['act_create'])
                                            && session()->get("halaman")['50']['act_create'] == "1"
                                        )
                                    ) { ?>
                                <form method="post" class="col-md-2">
                                    <h1 class="page-header col-md-12">
                                        <button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
                                        <input type="hidden" name="gaji_id" />
                                    </h1>
                                </form>
                            <?php } ?>
                        <?php } ?> -->
                    </div>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $namabutton = 'name="change"';
                                $judul = "Update Penggajian";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Tambah Penggajian";
                            } ?>
                            <div class="lead">
                                <h3><?= $judul; ?></h3>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">


                                <input type="hidden" name="gaji_id" value="<?= $gaji_id; ?>" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= base_url("gaji"); ?>">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php } else { ?>
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
                                <div class="card-header card-success" id="headingThree">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left text-white bold <?= $panel1['buttonClass'] ?>" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="<?= $panel1['ariaExpanded'] ?>" aria-controls="collapseThree">
                                            <i class="fa fa-arrow-down"></i> Simulasi Penggajian
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseThree" class="collapse <?= $panel1['collapseClass'] ?>" aria-labelledby="headingThree" data-parent="#faqAccordion">
                                    <div class="card-body">
                                        <div class="alert alert-dark">
                                            <form method="get">
                                                <div class="row">
                                                    <div class="col-4 row mb-2">
                                                        <div class="col-4">
                                                            <label class="text-dark">Priode :</label>
                                                        </div>
                                                        <?php
                                                        if (isset($_GET["dari"])) {
                                                            $dari = $_GET["dari"];
                                                        } else {
                                                            $dari = date("Y-m-01");
                                                        }
                                                        if (isset($_GET["ke"])) {
                                                            $ke = $_GET["ke"];
                                                        } else {
                                                            $ke = date("Y-m-t");
                                                        }
                                                        ?>
                                                        <div class="col-4">
                                                            <input type="date" class="form-control" placeholder="Dari" id="dari" name="dari" value="<?= $dari; ?>">
                                                        </div>
                                                        <div class="col-4">
                                                            <input type="date" class="form-control" placeholder="Ke" id="ke" name="ke" value="<?= $ke; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-4 row mb-2">
                                                        <div class="col-3">
                                                            <label class="text-dark">User : </label>
                                                        </div>
                                                        <div class="col-9">
                                                            <select class="form-control select" id="user_ids" name="user_id" style="width: 500px;">
                                                                <?php
                                                                $user = $this->db->table("user")
                                                                    ->join("departemen", "departemen.departemen_id = user.departemen_id", "left")
                                                                    ->join("position", "position.position_id = user.position_id", "left")
                                                                    ->where("user_status", "1")
                                                                    ->orderBy("user_nama")->get(); ?>
                                                                <option value="">Semua User</option>
                                                                <?php foreach ($user->getResult() as $user) { ?>
                                                                    <option value="<?= $user->user_id; ?>" <?= ($user_id == $user->user_id) ? "selected" : ""; ?>><?= $user->user_nama; ?> (<?= $user->departemen_name; ?> - <?= $user->position_name; ?>)</option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 row">
                                                        <div class="col-12">
                                                            <button type="button" name="generate" value="OK" class="btn btn-block btn-primary" onclick="return simulasi()">Simulasi</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <script>
                                                function formatRupiah(angka) {
                                                    return new Intl.NumberFormat('id-ID').format(angka);
                                                }

                                                function simulasi() {
                                                    let dari = $("#dari").val();
                                                    let ke = $("#ke").val();
                                                    let user = $("#user_ids").val();
                                                    // alert("<?= base_url("api/simulasi"); ?>?dari=" + dari + "&ke=" + ke + "&user_id=" + user);
                                                    $.get("<?= base_url("api/simulasi"); ?>", {
                                                        dari: dari,
                                                        ke: ke,
                                                        user_id: user
                                                    }).done(function(data) {
                                                        $("#gaji_pokok").html(formatRupiah(data.gaji_pokok));
                                                        $("#gaji_tjabatan").html(formatRupiah(data.gaji_tjabatan));

                                                        $("#petetap").html(formatRupiah(data.gaji_petetap));

                                                        $("#gaji_tmakan").html(formatRupiah(data.gaji_tmakan));
                                                        $("#gaji_tkehadiran").html(formatRupiah(data.gaji_tkehadiran));
                                                        $("#gaji_ttransport").html(formatRupiah(data.gaji_ttransport));
                                                        $("#gaji_lain").html(formatRupiah(data.gaji_lain));


                                                        $("#pettetap").html(formatRupiah(data.gaji_pettetap));


                                                        $("#gaji_kotor").html(formatRupiah(data.gaji_kotor));
                                                        $("#totalpenghasilan").html(formatRupiah(data.gaji_kotor));



                                                        // potongan
                                                        $("#gaji_alphanominal").html(formatRupiah(data.gaji_alphanominal));
                                                        $("#gaji_ptransportasi").html(formatRupiah(data.gaji_ptransportasi));
                                                        $("#gaji_pkehadiran").html(formatRupiah(data.gaji_pkehadiran));
                                                        $("#gaji_pmakan").html(formatRupiah(data.gaji_pmakan));
                                                        $("#gaji_inventaris").html(formatRupiah(data.gaji_inventaris));
                                                        $("#gaji_plain").html(formatRupiah(data.gaji_plain));


                                                        $("#potongan").html(formatRupiah(data.gaji_potonganasli));

                                                        //potongan + penghasilan tetap
                                                        let pottetap = parseFloat(data.gaji_petetap) + parseFloat(data.gaji_potonganasli);
                                                        $("#pottetap").html(formatRupiah(pottetap));


                                                        let bpjs = data.masterbpjs;

                                                        //Premi Asuransi Pemberi Kerja
                                                        $("#gaji_pbpjskesehatan").html(formatRupiah(data.gaji_pbpjskesehatan));
                                                        $("#gaji_pbpjsjht").html(formatRupiah(data.gaji_pbpjsjht));
                                                        $("#gaji_pbpjsjkk").html(formatRupiah(data.gaji_pbpjsjkk));
                                                        $("#gaji_pbpjsjkm").html(formatRupiah(data.gaji_pbpjsjkm));
                                                        $("#gaji_pbpjspensiun").html(formatRupiah(data.gaji_pbpjspensiun));

                                                        let pbpjs = parseFloat(data.gaji_pbpjskesehatan) + parseFloat(data.gaji_pbpjsjht) + parseFloat(data.gaji_pbpjsjkk) + parseFloat(data.gaji_pbpjsjkm) + parseFloat(data.gaji_pbpjspensiun);
                                                        $("#pbpjs").html(formatRupiah(pbpjs));

                                                        $("#rKesehatan").html(formatRupiah(bpjs.Kesehatan.perusahaan));
                                                        $("#drKesehatan").html(formatRupiah(bpjs.Kesehatan.perdiskon));
                                                        $("#rJHT").html(formatRupiah(bpjs.JHT.perusahaan));
                                                        $("#drJHT").html(formatRupiah(bpjs.JHT.perdiskon));
                                                        $("#rJKK").html(formatRupiah(bpjs.JKK.perusahaan));
                                                        $("#drJKK").html(formatRupiah(bpjs.JKK.perdiskon));
                                                        $("#rJKM").html(formatRupiah(bpjs.JKM.perusahaan));
                                                        $("#drJKM").html(formatRupiah(bpjs.JKM.perdiskon));
                                                        $("#rJP").html(formatRupiah(bpjs.JP.perusahaan));
                                                        $("#drJP").html(formatRupiah(bpjs.JP.perdiskon));

                                                        //Premi Asuransi Pekerja
                                                        $("#gaji_bpjskesehatan").html(formatRupiah(data.gaji_bpjskesehatan));
                                                        $("#gaji_bpjsjht").html(formatRupiah(data.gaji_bpjsjht));
                                                        $("#gaji_bpjsjkk").html(formatRupiah(data.gaji_bpjsjkk));
                                                        $("#gaji_bpjsjkm").html(formatRupiah(data.gaji_bpjsjkm));
                                                        $("#gaji_bpjspensiun").html(formatRupiah(data.gaji_bpjspensiun));

                                                        let tbpjs = parseFloat(data.gaji_bpjskesehatan) + parseFloat(data.gaji_bpjsjht) + parseFloat(data.gaji_bpjsjkk) + parseFloat(data.gaji_bpjsjkm) + parseFloat(data.gaji_bpjspensiun);
                                                        $("#tbpjs").html(formatRupiah(tbpjs));

                                                        $("#kKesehatan").html(formatRupiah(bpjs.Kesehatan.pekerja));
                                                        $("#dkKesehatan").html(formatRupiah(bpjs.Kesehatan.pekdiskon));
                                                        $("#kJHT").html(formatRupiah(bpjs.JHT.pekerja));
                                                        $("#dkJHT").html(formatRupiah(bpjs.JHT.pekdiskon));
                                                        $("#kJKK").html(formatRupiah(bpjs.JKK.pekerja));
                                                        $("#dkJKK").html(formatRupiah(bpjs.JKK.pekdiskon));
                                                        $("#kJKM").html(formatRupiah(bpjs.JKM.pekerja));
                                                        $("#dkJKM").html(formatRupiah(bpjs.JKM.pekdiskon));
                                                        $("#kJP").html(formatRupiah(bpjs.JP.pekerja));
                                                        $("#dkJP").html(formatRupiah(bpjs.JP.pekdiskon));

                                                        $("#bruto").html(formatRupiah(data.gaji_bruto));
                                                        $("#gaji_pph21").html(formatRupiah(data.gaji_pph21));
                                                        $("#gaji_ter").html(formatRupiah(data.gaji_ter));

                                                        $("#gaji_potongantotal").html(formatRupiah(data.gaji_potongantotal));
                                                        $("#gaji_total").html(formatRupiah(data.gaji_total));
                                                        $("#gaji_thp").html(formatRupiah(data.gaji_thp));

                                                    }).fail(function(xhr, status, error) {
                                                        alert("Gagal: " + xhr.responseText + " " + status + " " + error);
                                                        console.log(xhr.responseText);
                                                    });
                                                }
                                            </script>


                                        </div>
                                        <div class="row">
                                            <div class="col-4">Gaji Pokok: </div>
                                            <div class="col-1">Rp. </div>
                                            <div class="col-2 text-right"><span id="gaji_pokok"></span> </div>
                                            <div class="col-5"></div>

                                            <div class="col-4">Tunjangan Jabatan: </div>
                                            <div class="col-1">Rp. </div>
                                            <div class="col-2 text-right"><span id="gaji_tjabatan"></span> </div>
                                            <div class="col-5"></div>

                                            <hr />
                                            <div class="col-4 text-info"><b>Penghasilan Tetap:</b> </div>
                                            <div class="col-1">Rp. </div>
                                            <div class="col-2 text-right text-info"><b><span id="petetap"></span></b> </div>
                                            <div class="col-5"></div>
                                            <hr />

                                            <hr />
                                            <div class="col-4">Tunjangan Makan: </div>
                                            <div class="col-1">Rp. </div>
                                            <div class="col-2 text-right"><span id="gaji_tmakan"></span> </div>
                                            <div class="col-5"></div>

                                            <div class="col-4">Tunjangan Kehadiran: </div>
                                            <div class="col-1">Rp. </div>
                                            <div class="col-2 text-right"><span id="gaji_tkehadiran"></span> </div>
                                            <div class="col-5"></div>

                                            <div class="col-4">Tunjangan Transport: </div>
                                            <div class="col-1">Rp. </div>
                                            <div class="col-2 text-right"><span id="gaji_ttransport"></span> </div>
                                            <div class="col-5"></div>

                                            <div class="col-4">Lain-lain: </div>
                                            <div class="col-1">Rp. </div>
                                            <div class="col-2 text-right"><span id="gaji_lain"></span> </div>
                                            <div class="col-5"></div>

                                            <hr />
                                            <div class="col-4 text-info"><b>Penghasilan Tidak Tetap:</b> </div>
                                            <div class="col-1">Rp. </div>
                                            <div class="col-2 text-right text-info"><b><span id="pettetap"></span></b></div>
                                            <div class="col-5"></div>

                                            <hr />
                                            <div class="col-4 text-primary"><b>Gaji Kotor:</b> </div>
                                            <div class="col-1">Rp. </div>
                                            <div class="col-2 text-right text-primary"><b><span id="gaji_kotor"></span></b></div>
                                            <div class="col-5"></div>
                                            <hr />

                                            <!-- BPJS Perusahaan-->
                                            <div class="col-4 text-success">Kesehatan: </div>
                                            <div class="col-1 text-success">Rp. </div>
                                            <div class="col-2 text-right text-success"><span id="gaji_pbpjskesehatan"></span> </div>
                                            <div class="col-5 text-success">(<span id="rKesehatan"></span>%, Disc.:<span id="drKesehatan"></span>%)</div>

                                            <div class="col-4 text-success">JHT: </div>
                                            <div class="col-1 text-success">Rp. </div>
                                            <div class="col-2 text-right text-success"><span id="gaji_pbpjsjht"></span> </div>
                                            <div class="col-5 text-success">(<span id="rJHT"></span>%, Disc.:<span id="drJHT"></span>%)</div>

                                            <div class="col-4 text-success">JKK: </div>
                                            <div class="col-1 text-success">Rp. </div>
                                            <div class="col-2 text-right text-success"><span id="gaji_pbpjsjkk"></span> </div>
                                            <div class="col-5 text-success">(<span id="rJKK"></span>%, Disc.:<span id="drJKK"></span>%)</div>

                                            <div class="col-4 text-success">JKM: </div>
                                            <div class="col-1 text-success">Rp. </div>
                                            <div class="col-2 text-right text-success"><span id="gaji_pbpjsjkm"></span> </div>
                                            <div class="col-5 text-success">(<span id="rJKM"></span>%, Disc.:<span id="drJKM"></span>%)</div>

                                            <div class="col-4 text-success">Pensiun: </div>
                                            <div class="col-1 text-success">Rp. </div>
                                            <div class="col-2 text-right text-success"><span id="gaji_pbpjspensiun"></span> </div>
                                            <div class="col-5 text-success">(<span id="rJP"></span>%, Disc.:<span id="drJP"></span>%)</div>

                                            <hr />
                                            <div class="col-4  text-primary"><b>Premi Asuransi Pemberi Kerja:</b> </div>
                                            <div class="col-1 text-primary">Rp. </div>
                                            <div class="col-2 text-right  text-primary"><b><span id="pbpjs"></span></b></div>
                                            <div class="col-5 text-primary"></div>
                                            <hr />

                                            <!-- potongan -->
                                            <div class="col-4">Pot. Absence: </div>
                                            <div class="col-1">Rp. </div>
                                            <div class="col-2 text-right"><span id="gaji_alphanominal"></span> </div>
                                            <div class="col-5"></div>


                                            <div class="col-4">Pot. Tunjangan Makan: </div>
                                            <div class="col-1">Rp. </div>
                                            <div class="col-2 text-right"><span id="gaji_pmakan"></span> </div>
                                            <div class="col-5"></div>

                                            <div class="col-4">Pot. Tunjangan Kehadiran: </div>
                                            <div class="col-1">Rp. </div>
                                            <div class="col-2 text-right"><span id="gaji_pkehadiran"></span> </div>
                                            <div class="col-5"></div>

                                            <div class="col-4">Pot. Tunjangan Transport: </div>
                                            <div class="col-1">Rp. </div>
                                            <div class="col-2 text-right"><span id="gaji_ptransportasi"></span> </div>
                                            <div class="col-5"></div>

                                            <div class="col-4">Pot. Inventaris: </div>
                                            <div class="col-1">Rp. </div>
                                            <div class="col-2 text-right"><span id="gaji_inventaris"></span> </div>
                                            <div class="col-5"></div>

                                            <div class="col-4">Pot. Lain-lain: </div>
                                            <div class="col-1">Rp. </div>
                                            <div class="col-2 text-right"><span id="gaji_plain"></span> </div>
                                            <div class="col-5"></div>

                                            <hr />
                                            <div class="col-4 text-danger"><b>Jumlah Potongan:</b> </div>
                                            <div class="col-1 text-danger">Rp. </div>
                                            <div class="col-2 text-right text-danger"><b><span id="potongan"></span></b></div>
                                            <div class="col-5 text-danger"></div>
                                            <hr />


                                            <hr />
                                            <div class="col-4 text-primary"><b>Penghasilan Tetap + Potongan:</b> </div>
                                            <div class="col-1">Rp. </div>
                                            <div class="col-2 text-right text-primary"><b><span id="pottetap"></span></b></div>
                                            <div class="col-5"></div>
                                            <hr />




                                            <!-- BPJS Pekerja-->
                                            <div class="col-4 text-success">Kesehatan: </div>
                                            <div class="col-1 text-success">Rp. </div>
                                            <div class="col-2 text-right text-success"><span id="gaji_bpjskesehatan"></span> </div>
                                            <div class="col-5 text-success">(<span id="kKesehatan"></span>%, Disc.:<span id="dkKesehatan"></span>%)</div>

                                            <div class="col-4 text-success">JHT: </div>
                                            <div class="col-1 text-success">Rp. </div>
                                            <div class="col-2 text-right text-success"><span id="gaji_bpjsjht"></span> </div>
                                            <div class="col-5 text-success">(<span id="kJHT"></span>%, Disc.:<span id="dkJHT"></span>%)</div>

                                            <div class="col-4 text-success">JKK: </div>
                                            <div class="col-1 text-success">Rp. </div>
                                            <div class="col-2 text-right text-success"><span id="gaji_bpjsjkk"></span> </div>
                                            <div class="col-5 text-success">(<span id="kJKK"></span>%, Disc.:<span id="dkJKK"></span>%)</div>

                                            <div class="col-4 text-success">JKM: </div>
                                            <div class="col-1 text-success">Rp. </div>
                                            <div class="col-2 text-right text-success"><span id="gaji_bpjsjkm"></span> </div>
                                            <div class="col-5 text-success">(<span id="kJKM"></span>%, Disc.:<span id="dkJKM"></span>%)</div>

                                            <div class="col-4 text-success">Pensiun: </div>
                                            <div class="col-1 text-success">Rp. </div>
                                            <div class="col-2 text-right text-success"><span id="gaji_bpjspensiun"></span> </div>
                                            <div class="col-5 text-success">(<span id="kJP"></span>%, Disc.:<span id="dkJP"></span>%)</div>

                                            <hr />
                                            <div class="col-4  text-primary"><b>Premi Asuransi Potong Karyawan:</b> </div>
                                            <div class="col-1 text-primary">Rp. </div>
                                            <div class="col-2 text-right  text-primary"><b><span id="tbpjs"></span></b></div>
                                            <div class="col-5 text-primary"></div>
                                            <hr />

                                            <hr />
                                            <div class="col-4  text-primary"><b>Bruto:</b> </div>
                                            <div class="col-1 text-primary">Rp. </div>
                                            <div class="col-2 text-right  text-primary"><b><span id="bruto"></span></b></div>
                                            <div class="col-5 text-primary"></div>
                                            <hr />

                                            <div class="col-4 text-success">PPH21: </div>
                                            <div class="col-1 text-success">Rp. </div>
                                            <div class="col-2 text-right text-success"><span id="gaji_pph21"></span> </div>
                                            <div class="col-5 text-success">(<span id="gaji_ter"></span>%)</div>



                                            <hr />
                                            <div class="col-4  text-primary"><b>Total Penghasilan:</b> </div>
                                            <div class="col-1 text-primary">Rp. </div>
                                            <div class="col-2 text-right  text-primary"><b><span id="totalpenghasilan"></span></b></div>
                                            <div class="col-5 text-primary"></div>
                                            <hr />

                                            <hr />
                                            <div class="col-4  text-danger"><b>Total Potongan:</b> </div>
                                            <div class="col-1 text-danger">Rp. </div>
                                            <div class="col-2 text-right  text-danger"><b><span id="gaji_potongantotal"></span></b></div>
                                            <div class="col-5 text-danger"></div>
                                            <hr />

                                            <hr />
                                            <div class="col-4  text-primary"><b>Total:</b> </div>
                                            <div class="col-1 text-primary">Rp. </div>
                                            <div class="col-2 text-right  text-primary"><b><span id="gaji_total"></span></b></div>
                                            <div class="col-5 text-primary"></div>
                                            <hr />



                                            <hr />
                                            <div class="col-4  text-primary"><b>THP:</b> </div>
                                            <div class="col-1 text-primary">Rp. </div>
                                            <div class="col-2 text-right  text-primary"><b><span id="gaji_thp"></span></b></div>
                                            <div class="col-5 text-primary"></div>
                                            <hr />

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($message != "") { ?>
                            <div class="alert alert-info alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong><?= $message; ?></strong>
                            </div>
                        <?php } ?>
                        <div class="alert alert-dark">
                            <form method="post">
                                <div class="row">
                                    <?php
                                    $gaji_bulan = date("m");
                                    $gaji_tahun = date("Y");
                                    $departemen_id = 0;
                                    $position_id = 0;
                                    $user_id = 0;
                                    $gaji_print = date("Y-m-05");
                                    if (isset($_POST["gaji_bulan"])) {
                                        $gaji_bulan = $_POST["gaji_bulan"];
                                    }
                                    if (isset($_POST["gaji_tahun"])) {
                                        $gaji_tahun = $_POST["gaji_tahun"];
                                    }
                                    if (isset($_POST["departemen_id"])) {
                                        $departemen_id = $_POST["departemen_id"];
                                    }
                                    if (isset($_POST["position_id"])) {
                                        $position_id = $_POST["position_id"];
                                    }
                                    if (isset($_POST["user_id"])) {
                                        $user_id = $_POST["user_id"];
                                    }
                                    if (isset($_POST["gaji_print"]) && $_POST["gaji_print"] != "") {
                                        $gaji_print = $_POST["gaji_print"];
                                    }
                                    // echo $gaji_print;
                                    ?>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Dep. : </label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control" id="departemen_id" name="departemen_id">
                                                <?php
                                                $departemen = $this->db->table("departemen")->orderBy("departemen_name")->get(); ?>
                                                <option value="">Semua Departemen</option>
                                                <?php foreach ($departemen->getResult() as $departemen) { ?>
                                                    <option value="<?= $departemen->departemen_id; ?>" <?= ($departemen_id == $departemen->departemen_id) ? "selected" : ""; ?>><?= $departemen->departemen_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Posisi : </label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control" id="position_id" name="position_id">
                                                <?php
                                                $position = $this->db->table("position")->orderBy("position_name")->get(); ?>
                                                <option value="">Semua Posisi</option>
                                                <?php foreach ($position->getResult() as $position) { ?>
                                                    <option value="<?= $position->position_id; ?>" <?= ($position_id == $position->position_id) ? "selected" : ""; ?>><?= $position->position_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">User : </label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control select" id="user_id" name="user_id">
                                                <?php
                                                $user = $this->db->table("user")->orderBy("user_nama")->get(); ?>
                                                <option value="">Semua User</option>
                                                <?php foreach ($user->getResult() as $user) { ?>
                                                    <option value="<?= $user->user_id; ?>" <?= ($user_id == $user->user_id) ? "selected" : ""; ?>><?= $user->user_nama; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Bulan :</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control" name="gaji_bulan">
                                                <option value="" <?= ($gaji_bulan == "") ? "selected" : ""; ?>>Pilih Bulan</option>
                                                <?php
                                                $bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                                                foreach ($bulan as $key => $value) { ?>
                                                    <option value="<?= str_pad($key + 1, 2, "0", STR_PAD_LEFT); ?>" <?= ($gaji_bulan == str_pad($key + 1, 2, "0", STR_PAD_LEFT)) ? "selected" : ""; ?>><?= $value; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Tahun :</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control" name="gaji_tahun">
                                                <option value="">Pilih Tahun</option>
                                                <?php
                                                for ($tahun = 2020; $tahun <= 2050; $tahun++) { ?>
                                                    <option value="<?= $tahun; ?>" <?= ($tahun == date("Y")) ? "selected" : ""; ?>><?= $tahun; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Print Date :</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="date" class="form-control" placeholder="Print Date" name="gaji_print" value="<?= $gaji_print; ?>">
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-4">
                                            <label class="text-dark">Priode :</label>
                                        </div>
                                        <?php
                                        if (isset($_GET["dari"])) {
                                            $dari = $_GET["dari"];
                                        } else {
                                            $dari = date("Y-m-01");
                                        }
                                        if (isset($_GET["ke"])) {
                                            $ke = $_GET["ke"];
                                        } else {
                                            $ke = date("Y-m-t");
                                        }
                                        ?>
                                        <div class="col-4">
                                            <input type="date" class="form-control" placeholder="Dari" name="dari" value="<?= $dari; ?>">
                                        </div>
                                        <div class="col-4">
                                            <input type="date" class="form-control" placeholder="Ke" name="ke" value="<?= $ke; ?>">
                                        </div>
                                    </div>
                                    <div class="col-12 row">
                                        <div class="col-12">
                                            <button name="generate" value="OK" type="submit" class="btn btn-block btn-primary" onclick="return confirmGenerate()">Generate</button>
                                        </div>
                                        <script>
                                            function confirmGenerate() {
                                                return confirm("Apakah Anda yakin ingin melanjutkan?");
                                            }
                                        </script>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="alert alert-dark">
                            <form>
                                <?php
                                $gaji_bulan = date("m");
                                $gaji_tahun = date("Y");
                                $departemen_id = 0;
                                $position_id = 0;
                                $user_id = 0;
                                $gaji_print = date("Y-m-05");
                                if (isset($_GET["gaji_bulan"])) {
                                    $gaji_bulan = $_GET["gaji_bulan"];
                                }
                                if (isset($_GET["gaji_tahun"])) {
                                    $gaji_tahun = $_GET["gaji_tahun"];
                                }
                                if (isset($_GET["departemen_id"])) {
                                    $departemen_id = $_GET["departemen_id"];
                                }
                                if (isset($_GET["position_id"])) {
                                    $position_id = $_GET["position_id"];
                                }
                                if (isset($_GET["user_id"])) {
                                    $user_id = $_GET["user_id"];
                                }
                                if (isset($_GET["gaji_print"]) && $_GET["gaji_print"] != "") {
                                    $gaji_print = $_GET["gaji_print"];
                                }
                                // echo $gaji_print;
                                ?>
                                <div class="row">
                                    <?php
                                    $gaji_bulan = date("m");
                                    $gaji_tahun = date("Y", strtotime("+1 years"));
                                    $departemen_id = 0;
                                    $position_id = 0;
                                    $user_id = 0;
                                    if (isset($_GET["gaji_bulan"])) {
                                        $gaji_bulan = $_GET["gaji_bulan"];
                                    }
                                    if (isset($_GET["gaji_tahun"])) {
                                        $gaji_tahun = $_GET["gaji_tahun"];
                                    }
                                    if (isset($_GET["departemen_id"])) {
                                        $departemen_id = $_GET["departemen_id"];
                                    }
                                    if (isset($_GET["position_id"])) {
                                        $position_id = $_GET["position_id"];
                                    }
                                    if (isset($_GET["user_id"])) {
                                        $user_id = $_GET["user_id"];
                                    }
                                    ?>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Dep. : </label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control" id="departemen_id" name="departemen_id">
                                                <?php
                                                $departemen = $this->db->table("departemen")->orderBy("departemen_name")->get(); ?>
                                                <option value="">Semua Departemen</option>
                                                <?php foreach ($departemen->getResult() as $departemen) { ?>
                                                    <option value="<?= $departemen->departemen_id; ?>" <?= ($departemen_id == $departemen->departemen_id) ? "selected" : ""; ?>><?= $departemen->departemen_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Posisi : </label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control" id="position_id" name="position_id">
                                                <?php
                                                $position = $this->db->table("position")->orderBy("position_name")->get(); ?>
                                                <option value="">Semua Posisi</option>
                                                <?php foreach ($position->getResult() as $position) { ?>
                                                    <option value="<?= $position->position_id; ?>" <?= ($position_id == $position->position_id) ? "selected" : ""; ?>><?= $position->position_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">User : </label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control select" id="user_id2" name="user_id">
                                                <?php
                                                $user = $this->db->table("user")->orderBy("user_nama")->get(); ?>
                                                <option value="">Semua User</option>
                                                <?php foreach ($user->getResult() as $user) { ?>
                                                    <option value="<?= $user->user_id; ?>" <?= ($user_id == $user->user_id) ? "selected" : ""; ?>><?= $user->user_nama; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Bulan :</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control" name="gaji_bulan">
                                                <option value="" <?= ($gaji_bulan == "") ? "selected" : ""; ?>>Pilih Bulan</option>
                                                <?php
                                                $bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                                                foreach ($bulan as $key => $value) { ?>
                                                    <option value="<?= str_pad($key + 1, 2, "0", STR_PAD_LEFT); ?>" <?= ($gaji_bulan == str_pad($key + 1, 2, "0", STR_PAD_LEFT)) ? "selected" : ""; ?>><?= $value; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Tahun :</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control" name="gaji_tahun">
                                                <option value="">Pilih Tahun</option>
                                                <?php
                                                for ($tahun = 2020; $tahun <= 2050; $tahun++) { ?>
                                                    <option value="<?= $tahun; ?>" <?= ($tahun == date("Y")) ? "selected" : ""; ?>><?= $tahun; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark"></label>
                                        </div>
                                        <div class="col-9">
                                            <button type="submit" class="btn btn-block btn-info">Cari</button>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                                <thead class="">
                                    <tr>
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <th>Action</th>
                                        <?php } ?>
                                        <!-- <th>No.</th> -->
                                        <!-- <th>Picture</th> -->
                                        <th>Print Date</th>
                                        <th>Departemen</th>
                                        <th>Posisi</th>
                                        <th>Nama</th>
                                        <th>Absensi</th>
                                        <th>Tgl Masuk</th>
                                        <th>Gapok</th>
                                        <th>T.Jabatan</th>
                                        <th>T.Transport</th>
                                        <th>T.Kehadiran</th>
                                        <th>T.Makan</th>
                                        <th>OT1</th>
                                        <th>OT2</th>
                                        <th>OT3</th>
                                        <th>OT4</th>
                                        <th>Pendapatan Lain-lain</th>
                                        <th>Gaji Kotor</th>
                                        <th>P.Absen</th>
                                        <th>P.Trans</th>
                                        <th>P.Hadir</th>
                                        <th>P.Makan</th>
                                        <th>P.Inventaris</th>
                                        <th>BPJS Kesehatan</th>
                                        <th>BPJS JHT</th>
                                        <th>BPJS Pensiun</th>
                                        <th>PPH21</th>
                                        <th>P.Lain</th>
                                        <th>P.Total</th>
                                        <th>Gaji Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $build = $this->db
                                        ->table("gaji")
                                        ->where("SUBSTR(gaji_print,1,7)", $gaji_tahun . "-" . $gaji_bulan);
                                    if ($departemen_id > 0) {
                                        $build->where("departemen_id", $departemen_id);
                                    }
                                    $usr = $build->orderBy("gaji_print", "ASC")
                                        ->orderBy("departemen_name", "ASC")
                                        ->orderBy("position_name", "ASC")
                                        ->orderBy("user_name", "ASC")
                                        ->get();
                                    // echo $this->db->getLastquery();
                                    $no = 1;
                                    foreach ($usr->getResult() as $usr) { ?>
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
                                                            isset(session()->get("halaman")['50']['act_update'])
                                                            && session()->get("halaman")['50']['act_update'] == "1"
                                                        )
                                                    ) { ?>
                                                        <form method="get" target="_blank" action="<?= base_url("gajiprint"); ?>" class="btn-action" style="">
                                                            <button class="btn btn-sm btn-info " name="print" value="OK"><span class="fa fa-print" style="color:white;"></span> </button>
                                                            <input type="hidden" name="gaji_id" value="<?= $usr->gaji_id; ?>" />
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
                                                            isset(session()->get("halaman")['50']['act_update'])
                                                            && session()->get("halaman")['50']['act_update'] == "1"
                                                        )
                                                    ) { ?>
                                                        <form method="post" class="btn-action" style="">
                                                            <button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                            <input type="hidden" name="gaji_id" value="<?= $usr->gaji_id; ?>" />
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
                                                            isset(session()->get("halaman")['50']['act_delete'])
                                                            && session()->get("halaman")['50']['act_delete'] == "1"
                                                        )
                                                    ) { ?>
                                                        <form method="post" class="btn-action" style="">
                                                            <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                            <input type="hidden" name="gaji_id" value="<?= $usr->gaji_id; ?>" />
                                                        </form>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>
                                            <!-- <td><?= $no++; ?></td> -->
                                            <!-- <td><i class="fa fa-camera tunjuk" onclick="tampilgambar('<?= $usr->gaji_id; ?>');"></i></td> -->
                                            <td><?= $usr->gaji_print; ?></td>
                                            <td><?= $usr->departemen_name; ?></td>
                                            <td><?= $usr->position_name; ?></td>
                                            <td><?= $usr->user_name; ?></td>
                                            <td><?= $usr->user_masuk; ?></td>
                                            <td>H:<?= $usr->gaji_hadir; ?>|C:<?= $usr->gaji_cuti; ?>|S:<?= $usr->gaji_sakit; ?>|I:<?= $usr->gaji_izin; ?>|A: <?= $usr->gaji_alpha; ?></td>
                                            <td><?= number_format($usr->gaji_pokok, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_tjabatan, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_ttransport, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_tkehadiran, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_tmakan, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_ot1nominal, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_ot2nominal, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_ot3nominal, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_ot4nominal, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_lain, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_kotor, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_alphanominal, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_ptransportasi, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_pkehadiran, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_pmakan, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_inventaris, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_bpjskesehatan, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_bpjsjht, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_bpjspensiun, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_pph21, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_plain, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_potongantotal, 0, ",", "."); ?></td>
                                            <td><?= number_format($usr->gaji_total, 0, ",", "."); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <script>
                                function tampilgambar(id) {
                                    $.get("<?= base_url("api/gambargaji"); ?>", {
                                            id: id
                                        })
                                        .done(function(data) {
                                            if (data != "") {
                                                $("#gambargaji").hide();
                                                $("#exampleModal").modal("show");
                                                $("#gambargaji").attr("src", data);
                                                $("#gambargaji").fadeIn();
                                            } else {
                                                toast("Loading Gambar", "Maaf, tidak ada gambar!");
                                            }
                                        });
                                }
                            </script>
                            <!-- Picture -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <img id="gambargaji" src="<?= base_url("images/picture.png"); ?>" class="gambar" style="width:100%; height:auto;" />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
        var title = "Penggajian";
        $("title").text(title);
        $(".card-title").text(title);
        $("#page-title").text(title);
        $("#page-title-link").text(title);
    </script>

    <?php echo  $this->include("template/footer_v"); ?>