<!-- Custom styles for this template -->
<link href="<?php echo base_url('assets/css/login.css');?>" rel="stylesheet">
<script src="<?php echo base_url('assets/js/user-profile/edit-profile.js');?>"></script>
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
	      </div>
	      <div class="col-sm-3">
	        <a class="btn btn-info btn-lg btn-block" href="<?php echo base_url('campaigns/details/'.$campaign->idcampaign);?>">Ver Detalhe</a>
	      </div>
	    </div>
	<?php }
?>
  </div>
  </div> <!-- /container -->