<?php echo $this->include("template/header_v"); ?>
<style>
    .color-green {
        color: green;
    }

    .color-red {
        color: red;
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
                    </div>

                    <div class="">
                        <?php
                        $namabutton = 'name="change"';
                        $judul = "Update Rubah Password";
                        ?>
                        <div class="lead">
                            <h3><?= $judul; ?></h3>
                        </div>
                        <?php if ($message != "") { ?>
                            <div class="alert alert-info alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong><?= $message; ?></strong>
                            </div>
                        <?php } ?>
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label class="control-label col-sm-2" for="user_password">Password:</label>
                                <div class="col-sm-10">
                                    <input required onkeyup="cek()" type="text" autocomplete="off" autofocus class="form-control pass" id="user_password" name="user_password" placeholder="" value="">

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2" for="user_confirm">Konfirmasi Password:</label>
                                <div class="col-sm-10">
                                    <input required onkeyup="cek()" type="password" class="form-control pass" id="user_confirm" placeholder="" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-12" id="warning"></label>
                            </div>

                            <script>
                                function cek() {
                                    const a = $("#user_password").val();
                                    const b = $("#user_confirm").val();
                                    if (a === b && a != "") {
                                        $("#submit").removeAttr("disabled");
                                        $("#warning").html('<span class="color-green">Matched!</span>');
                                    } else {
                                        $("#submit").attr("disabled", "disabled");
                                        if (a != "") {
                                            $("#warning").html('<span class="color-red">No Matched!</span>');
                                        }
                                    }
                                }
                                $(document).ready(function() {
                                    cek();
                                    setTimeout(() => {
                                        $(".pass").val("");
                                    }, 1000);
                                    
                                });
                            </script>


                            <input type="hidden" name="user_id" value="<?= $this->session->get("user_id"); ?>" />
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                    <button type="button" class="btn btn-warning col-md-offset-1 col-md-5" onClick="javascript:location.href='<?= base_url(); ?>'">Dashboard</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.select').select2();
    var title = "Rubah Password";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo  $this->include("template/footer_v"); ?>