<div class="col-12 row" style=" border-bottom:black solid 1px; padding-top:5px; ">	
    <div class="col-1 p-0 p-b-5">
        <?php if(session()->get("store_picture")==""){
            $gambar="logo.png";
        }else{
            $gambar=session()->get("store_picture");
        } ?>
        <img src="<?=base_url("images/store_picture/".$gambar);?>" style="width:30px; height:auto; max-height:30px;  max-width:50px; "/>  
    </div>
    <div class="col-11 p-0">  
        <div style="font-weight:bold; padding:0px; font-size:10px;"><?=session()->get("store_name");?></div>
        <div style="font-weight:bold; padding:0px; font-size:10px;"><?=session()->get("store_address");?></div>
        <div style="font-weight:bold; padding:0px; font-size:10px;">Phone : <?=session()->get("store_phone");?></div> 
    </div>
</div>