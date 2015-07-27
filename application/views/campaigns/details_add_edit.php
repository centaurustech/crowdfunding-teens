<script src="<?php echo base_url('assets/js/campaigns/campaigns.js');?>"></script>
<script src="<?php echo base_url('assets/js/share-social-media.js');?>"></script>
<div class="container campaign-details">
	<h1>
<?php echo $msg_action;?>campanha de<br>
<?php echo $rs->camp_owner;?>
	</h1>
	<hr class="grey-line">
	<form id="form-campaigns" name="form-campaigns" action="<?php echo base_url("campaigns/save/");?>" method="post" enctype="multipart/form-data">
		<div class="row edit-all-campaign-inprogress">
			<div class="col-md-4">
				<button id="saveAllCampaign" class="btn btn-success btn-save-all btn-block" type="submit">
				<i class="fa fa-check"></i>
				Guardar</button>
			</div>
			<div class="col-md-3">
				<a href="<?php echo $previous_url;?>" class="btn btn-default btn-block">
					<i class="fa fa-times"></i>
					Voltar
				</a>
			</div>
		</div>
		<input type="hidden" name= "idcampaign" id="idcampaign" class="pk_field"value="<?php echo $rs->idcampaign;?>">
		<input type="hidden" name= "controllername" id="controllername" value="<?php echo $controller_name;?>">
		<input type="hidden" name= "hiddenCampPriceAmount" id="hiddenCampPriceAmount" value="">
		<div id="form-edit-CampName" class="form-group">
			<label for="inputCampName" class="">Nome Presente</label>
			<input type="text" id = "inputCampName" name = "inputCampName" data-controller="campaigns" data-db-field="camp_name"  class="form-control" placeholder="Insira o Nome do seu Presente..." value="<?php echo $rs->camp_name;?>">
			</div><!-- /form-group -->
			<div id="form-edit-CampDescription" class="form-group">
				<label for="inputCampDescription" class="">Descrição Presente</label>
				<div class="text-area-box">
					<textarea id = "inputCampDescription" name = "inputCampDescription" class="form-control" data-controller="campaigns" data-db-field="camp_description" placeholder="Escreva em poucas palavras porque você merece ganhar esse presente. Seja convincente!">
<?php echo $rs->camp_description;?>
					</textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="label-campaign-picture">Foto Campanha</label>
			</div>
			<div class="edit-campaign-full-picture-box">
				<input type="hidden" id="imgNoPicture" value="<?php echo base_url("assets/img/no-campaign-picture.png");?>">
				<input type="hidden" id="emptyPicture" name="emptyPicture" value="0">
				<img id="imgCampPic" class="campaign-full-picture centered" src="<?php echo $rs->imgurl;?>">
				<input type="file" class="fileUploader hide" id="uploadCampaignPict" name="uploadCampaignPict" value="" data-img="imgCampPic">
				<button class="btn btn-upload upload" type="button"><i class="fa fa-camera"></i></button>
				<button class="btn btn-clear-picture clear-picture" data-img="imgCampPic" type="button"><i class="fa fa-times"></i></button>
			</div>
			<div id="form-edit-CampPriceAmount" class="form-group">
				<div id = "CampPriceAmountGroup" class="input-group camp-price-amount-block">
					<label for="inputCampPriceAmount" class="">Preço</label>
					<input id = "inputCampPriceAmount" name = "inputCampPriceAmount" type="text" data-controller="campaigns" data-db-field="camp_goal" class="form-control <?php echo $rs->is_new_campaign?"":"camp-price-amount-inline ";?>currency currency-radius" placeholder="Insira um valor..." value="<?php echo $rs->camp_goal;?>">
					</div><!-- /input-group -->
				</div>
			</form>
		</div>