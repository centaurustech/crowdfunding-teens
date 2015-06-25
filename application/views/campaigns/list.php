<!-- Crowdfunding campaigns list
================================================== -->
<script src="<?php echo base_url('assets/js/campaigns/campaigns-list.js');?>"></script>
<!-- Wrap the rest of the page in another container to center all the content. -->
<div class="container campaigns campaign-details">
	<h1><?php echo $list_title;?></h1>
	<input type="hidden" name="search_text" value="<?php echo $criteria_text?>">
	<!-- Title / description separation line -->
	<hr class="grey-line">
	<div id ="campaign-result-1" class="row">
<?php foreach ($rs_camp as $camp) {
	?>
									<div class="col-md-3 campaign-list">
										<div class="thumbnail">
											<h3><a class = "campaign-owner" href="<?php echo base_url("campaigns/details/".$camp->idcampaign);?>"><?php echo $camp->camp_owner;
	?></a></h3>
											<div class="img-gift-box">
												<img class="img-gift" src="<?php echo $camp->imgurl;?>">
											</div>
											<h4><a class = "campaign-name" href="<?php echo base_url("campaigns/details/".$camp->idcampaign);?>"><?php echo $camp->camp_name;
	?></a></h4>
											<p><?php echo $camp->camp_description;?></p>
											<div class = "campaign-values">
												<p><span class="currency"><?php echo $camp->camp_goal;?></span></p>
												<div class="progress">
													<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $camp->camp_completed;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $camp->camp_completed;?>%;">
														<span class="sr-only"><?php echo $camp->camp_completed;?>% Complete</span>
													</div>
												</div>
												<p><?php echo $camp->camp_completed;?>%</p>
											</div>
										</div>
										</div><!-- /.col-md-3 -->
	<?php }
?>
			</div><!-- /.row -->
			<div id="lastCampaign"></div>
			<div class="row show-more-area"><!-- Button Show More -->
			<div class="col-md-offset-4 col-md-4 col-md-offset-4">
				<a id ="btnShowMore" class="btn btn-lg btn-header-options centered" href="#" role="button">Mostrar Mais...</a>
			</div>
		</div>
		</div><!-- /.container -->