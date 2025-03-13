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
                        <div class="<?= $coltitle; ?>">
                            <h4 class="card-title"></h4>
                            <!-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6> -->
                        </div>
                        <?php if (isset($_GET['report'])) { ?>
                            <form method="post" class="col-md-2">
                                <h1 class="page-header col-md-12">
                                    <a href="<?= base_url("saran"); ?>" class="btn btn-danger btn-block btn-lg" value="OK" style="">Suggestion</a>

                                </h1>
                            </form>
                        <?php } ?>
                        <form action="<?= base_url("mposition"); ?>" method="get" class="col-md-2">
                            <h1 class="page-header col-md-12">
                                <button class="btn btn-warning btn-block btn-lg" value="OK" style="">Back</button>
                            </h1>
                        </form>
                    </div>

                    <?php if ($message != "") { ?>
                        <div class="alert alert-info alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><?= $message; ?></strong>
                        </div>
                    <?php } ?>
                    <div class="row" style="font-size:15px;">
                        <div class="col-md-12 "><span class="font-weight-bold">Jabatan : </span><span class=""><?= ucwords($position_name); ?></span></div>
                    </div>
                </div>
                <div class="table-responsive m-t-40">
                    <table id="datatablenya" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                        <thead class="">
                            <tr>
                                <!-- <th>No.</th> -->
                                <th>ID.</th>
                                <th>Root</th>
                                <th>Menu</th>
                                <th>View</th>
                                <th>Create</th>
                                <th>Update</th>
                                <th>Delete</th>
                                <th>Approve</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <i class="fa fa-arrow-right text-success"></i>
                                    <i class="fa fa-arrow-right text-success"></i>
                                    <i class="fa fa-arrow-right text-success"></i>
                                </td>
                                <td class="text-center">0</td>
                                <td class="text-left">Isi Semua Field</td>
                                <td><input id="read0" onclick="isisemua('read')" value="1" type="checkbox" > Semua View</td>
                                <td><input id="create0" onclick="isisemua('create')" value="1" type="checkbox" > Semua Create</td>
                                <td><input id="update0" onclick="isisemua('update')" value="1" type="checkbox" > Semua Update</td>
                                <td><input id="delete0" onclick="isisemua('delete')" value="1" type="checkbox" > Semua Delete</td>
                                <td><input id="approve0" onclick="isisemua('approve')" value="1" type="checkbox" > Semua Approve</td>
                            </tr>
                            <script>
                                const pagesid = [];
                            </script>
                            <?php
                            $posid=$this->request->getGet("position_id");
                            $usr = $this->db
                                ->table("pages")
                                ->select("*,pages.pages_id AS pages_id")
                                ->join("(SELECT * FROM positionpages WHERE position_id = '".$posid."')positionpages","positionpages.pages_id=pages.pages_id","left")
                                ->orderBy("pages.pages_category", "ASC")
                                ->orderBy("pages.pages_name", "ASC")
                                 ->get();
                            // echo $this->db->getLastquery();
                            $no = 1;
                            foreach ($usr->getResult() as $usr) { ?>
                            <script>
                                pagesid.push("<?= $usr->pages_id; ?>");
                            </script>
                                <tr>
                                    <!-- <td><?= $no++; ?></td> -->
                                    <td><?= $usr->pages_id ?></td>
                                    <td><?= $usr->pages_category ?></td>
                                    <td class="text-left"><?= ucwords($usr->pages_name); ?></td>
                                    <td><input id="read<?= $usr->pages_id; ?>" onclick="isi(<?= $usr->pages_id; ?>,<?= $posid; ?>,'read')" value="1" type="checkbox" <?= ($usr->positionpages_read == "1") ? "checked" : ""; ?>> View</td>
                                    <td><input id="create<?= $usr->pages_id; ?>" onclick="isi(<?= $usr->pages_id; ?>,<?= $posid; ?>,'create')" value="1" type="checkbox" <?= ($usr->positionpages_create == "1") ? "checked" : ""; ?>> Create</td>
                                    <td><input id="update<?= $usr->pages_id; ?>" onclick="isi(<?= $usr->pages_id; ?>,<?= $posid; ?>,'update')" value="1" type="checkbox" <?= ($usr->positionpages_update == "1") ? "checked" : ""; ?>> Update</td>
                                    <td><input id="delete<?= $usr->pages_id; ?>" onclick="isi(<?= $usr->pages_id; ?>,<?= $posid; ?>,'delete')" value="1" type="checkbox" <?= ($usr->positionpages_delete == "1") ? "checked" : ""; ?>> Delete</td>
                                    <td><input id="approve<?= $usr->pages_id; ?>" onclick="isi(<?= $usr->pages_id; ?>,<?= $posid; ?>,'approve')" value="1" type="checkbox" <?= ($usr->positionpages_approve == "1") ? "checked" : ""; ?>> Approve</td>
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
<div id="testarray"></div>
<script>
    function isisemua(crud){
        let fieldarray='';
        let isiarray='';
        let no = <?=$no;?>;
        let val1 = $('#'+crud+'0').is(":checked");
        for(let x=0; x<no-1; x++){
            fieldarray=crud+pagesid[x];
            let val2 = $('#'+fieldarray).is(":checked");
            if(val1!=val2){
                $('#'+fieldarray).click();
            }
            // isiarray+=pagesid[x];
        }       
        // $("#testarray").html(isiarray);
    }
    function isi(pages_id, position_id, crud) {
        let val = $("#" + crud + pages_id).is(":checked");
        // alert('<?= base_url("api/hakakses"); ?>?pages_id='+pages_id+"&position_id="+position_id+"&crud=positionpages_"+crud+"&val="+val);
        $.get("<?= base_url("api/hakakses"); ?>", {
                pages_id: pages_id,
                position_id: position_id,
                crud: 'positionpages_'+crud,
                val: $("#" + crud + pages_id).is(":checked")
            })
            .done(function(data) {
                // alert(data);
                toast('Update Akses', 'Update Hak Akses Berhasil!');
            });
    }
    $(document).ready(function() {
        $('#datatablenya').DataTable({
            "paging": false,
            "order": [[ 1, "asc" ], [ 2, "asc" ]]
        });
    });
</script>
<script>
    $('.select').select2();
    var title = "Master Akses Web";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo  $this->include("template/footer_v"); ?>