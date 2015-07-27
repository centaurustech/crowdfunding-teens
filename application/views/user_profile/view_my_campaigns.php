<!-- Custom styles for this template -->
<link href="<?php echo base_url('assets/css/login.css');?>" rel="stylesheet">
<script src="<?php echo base_url('assets/js/user-profile/my-campaign.js');?>"></script>
<div class="container profile-area white-background">
	<h3>Minhas campanhas de presentes</h3>
	<div class="col-sm-11">
<?php foreach ($my_campaigns as $campaign) {?>
			<div class="row">
				<hr class="grey-color">
				<div class="col-sm-3">
					<img class="img-responsive" src="<?php echo $campaign->imgurl;?>">
				</div>
				<div class="col-sm-6">
					<h3> <?php echo $campaign->camp_name;?></h3>
					<p class=""><?php echo $campaign->camp_description;?></p>
					<div class="row">
						<div class="col-xs-6">
							Preço Presente: <span class="currency"><?php echo $campaign->camp_goal;?></span>
						</div>
						<div class="col-xs-6">
	<?php echo $campaign->camp_completed;?>% Completado
						</div>
						<div class="col-xs-6">
							Recebido: <span class="currency"><?php echo $campaign->camp_collected;?></span>
						</div>
					</div>
				</div>
				<div class="col-sm-3 list-group">
					<a class="list-group-item btn btn-lg btn-block" href="<?php echo base_url('campaigns/details/'.$campaign->idcampaign);?>">
						<i class="fa fa-info-circle fa-fw"></i> Ver Detalhe
					</a>
					<a class="list-group-item btn btn-lg btn-block" href="<?php echo base_url('campaigns/edit/'.$campaign->idcampaign);?>?from_my_account">
						<i class="fa fa-edit fa-fw"></i> Alterar
					</a>
					<a class="list-group-item btn btn-lg btn-block btn-delete-camp doDelete" href="<?php echo base_url('campaigns/delete/'.$campaign->idcampaign);?>">
						<i class="fa fa-trash-o fa-fw"></i> Apagar
					</a>
				</div>
			</div>
	<?php }
?>
	</div>
	</div> <!-- /container -->