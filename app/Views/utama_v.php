<?php echo $this->include("template/header_v"); ?>

<div class='container'>
	<div class='row'>
		<div class='col'>
			<div class="row">
				<!-- Column -->
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<div class="card-two">
								<header>
									<div class="avatar">
										<img src="images/global/user.png" alt="<?= session()->get("user_name"); ?>" />
									</div>
								</header>
								<h3><?= ucfirst(session()->get("position_name")); ?></h3>
								<div class="desc">
									<?= ucfirst(session()->get("nama")); ?>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php //print_r(session()->get("position_administrator"));?>
			<!-- <div class="row">
				
				<?php
				$from = date("Y-m-d");
				$to = date("Y-m-d");
				$builder = $this->db
					->table("user");
				$builder->where("user.user_masuk >=", $from);
				$builder->where("user.user_masuk <=", $to);
				$harian = $builder->get();
				$tpemesananharian = $harian->getNumRows();
				// echo $this->db->getLastquery();
				$ttbsharian=0;
				foreach($harian->getResult() as $value){
					
				}
				?>
				<div class="col-lg-4">
					<div class="card">
						<div class="card-title">
							<h4>SPTBS Hari Ini</h4>
						</div>
						<div class="todo-list">
							<div class="tdl-holder">
								<div class="tdl-content">
									<ul>
										<li class="color-default">
											<label>
												<?= number_format($tpemesananharian,0,",","."); ?> SPTBS
											</label>
										</li>
										<li class="color-info">
											<label>
												<i class="fa fa-building"></i> <?=number_format($ttbsharian,0,",",".");?> TBS
											</label>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				
				<?php
				$from = date("Y-m-01");
				$to = date("Y-m-t");
				$builder = $this->db
					->table("user");
				$builder->where("user.user_masuk >=", $from);
				$builder->where("user.user_masuk <=", $to);
				$bulanan = $builder->get();
				$tpemesananbulanan = $bulanan->getNumRows();
				// echo $this->db->getLastquery();
				$troombulanan=0;
				foreach($bulanan->getResult() as $value){
					
				}
				?>
				<div class="col-lg-4">
					<div class="card">
						<div class="card-title">
							<h4>SPTBS Bulan Ini</h4>
						</div>
						<div class="todo-list">
							<div class="tdl-holder">
								<div class="tdl-content">
									<ul>
										<li class="color-default">
											<label>
												<?= number_format($tpemesananbulanan,0,",","."); ?> SPTBS
											</label>
										</li>
										<li class="color-warning">
											<label>
												<i class="fa fa-building"></i> <?=number_format($troombulanan,0,",",".");?> TBS
											</label>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				
				<?php
				$from = date("Y-01-01");
				$to = date("Y-12-31");
				$builder = $this->db
					->table("user");
				$builder->where("user.user_masuk >=", $from);
				$builder->where("user.user_masuk <=", $to);
				$tahunan = $builder->get();
				$tpemesanantahunan = $tahunan->getNumRows();
				// echo $this->db->getLastquery();
				$troomtahunan=0;
				foreach($tahunan->getResult() as $value){
					
				}
				?>
				<div class="col-lg-4">
					<div class="card">
						<div class="card-title">
							<h4>SPTBS Tahun Ini</h4>
						</div>
						<div class="todo-list">
							<div class="tdl-holder">
								<div class="tdl-content">
									<ul>
										<li class="color-default">
											<label>
												<?= number_format($tpemesanantahunan,0,",","."); ?> SPTBS
											</label>
										</li>
										<li class="color-primary">
											<label>
												<i class="fa fa-building"></i> <?=number_format($troomtahunan,0,",",".");?> TBS
											</label>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> -->
			<!-- <div class="row">
				<canvas id="hariantbs" style="width:100%;"></canvas>				
				
				<script>
				const dataharianroom = [
					<?php	
					$from = date("Y-01-01");
					$to = date("Y-12-31");
					$builder = $this->db
						->table("user");
					$builder->select("user_masuk");
					$builder->where("user.user_masuk <=", $to);
					$builder->groupBy("user.user_masuk");
					$tahunanroom = $builder->get();
					// echo $this->db->getLastquery();
					$no=0;
					foreach($tahunanroom->getResult() as $bulan){
					?>
					<?php if($no==0){?>						
						{ hari: '<?=date("Y-m-d",strtotime("-1 days", strtotime($bulan->user_masuk)));?>', count: 0 },
					<?php }?>
					{ hari: '<?=$bulan->user_masuk;?>', count: <?=number_format(0,0,",",".");?> },
					<?php 
					$no++;
					}?>
				];

				new Chart("hariantbs", {
				type: "line",
				data: {
					labels: dataharianroom.map(row => row.hari),
					datasets: [{
						label: 'Acquisitions by month',
            			data: dataharianroom.map(row => row.count),
						borderColor: "#8B93DA",
						fill: false
					}]
				},
				options: {
					legend: {display: false},
					title: {
					display: true,
					text: "Jumlah TBS Tahun <?=date("Y");?>"
					}
				}
				});
				</script>
			</div> -->
			
		</div>
	</div>
</div>

<?php echo  $this->include("template/footer_v"); ?>

<?php //echo $this->endSection(); 
?>