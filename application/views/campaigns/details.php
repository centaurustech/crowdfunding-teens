<script src="<?php echo base_url('assets/js/campaigns/campaigns.js');?>"></script>
<?php if ($promote) {?>
			<script src="<?php echo base_url('assets/js/campaigns/promote.js');?>"></script>
	<?php }
?>
<div class="container campaign-details">
<?php if ($rs->is_own_campaign) {?>
				<div class = "row edit-all-campaign-idle">
					<div class = "col-md-offset-3 col-md-3 edit-all-campaign">
						<a href="<?php echo base_url("campaigns/edit/".$rs->idcampaign);?>" class="btn btn-edit-camp btn-block">
							<i class="fa fa-edit"></i>
							Editar Campanha
						</a>
					</div>
					<div class = "col-md-3 edit-all-campaign">
						<a href="<?php echo base_url("/profile/my-received-contributions/".$rs->idcampaign);?>" class="btn btn-edit-camp btn-block">
							<i class="fa fa-money"></i>
							Resgatar Cotas
						</a>
					</div>
					<div class = "col-md-3 delete-campaign">
						<input type="hidden" name= "idcampaign" id="idcampaign" class="pk_field" value="<?php echo $rs->idcampaign;?>">
						<a href="<?php echo base_url("campaigns/delete/".$rs->idcampaign);?>" id="btnDelAllCampaign" class="btn btn-delete-camp btn-block">
							<i class="fa fa-trash-o"></i>
							Apagar Campanha
						</a>
					</div>
				</div>
				<hr class="grey-line">
	<?php }
?>
<h1>
<?php echo $rs->camp_owner;
?><span class="cyan-title">&nbsp;
	quer ganhar un...</span>
	</h1>
	<div class="row">
		<hr class="grey-line">
		<h2><?php echo $rs->camp_name;?></h2>
	</div>
	<div class="row">	<!-- Basic Info Pane -->
	<div class="col-md-9">
		<div id="boxCampaignFullPicture" class="campaign-full-picture-box">
			<img id="current-CampaignFullPicture" class="campaign-full-picture centered" src="<?php echo $rs->imgurl;?>">
		</div>
		<div class="row bubble-description">
			<div id="current-CampDescription" class="col-sm-10"><?php echo $rs->camp_description;?></div>
		</div>
		<div class="row campaign-owner">
			<div class="col-sm-3">
				<img id="current-CampOwnerPhoto" class="img-circle profile-picture" src="<?php echo $rs->camp_owner_picture;?>">
				<p class="campaign-owner-name"><?php echo $rs->camp_owner;?></p>
			</div>
			<div class="col-sm-9 share-campaign-area">
				<input type="hidden" id="msgPromoteCampaign" value="<?php echo $msg_promote;?>">
				<div class="row">
					<span>Pode-me dar uma força, compartilhando minha campanha nas redes sociais:</span>
				</div>
				<div class="share-buttons">
					<div class="row">
						<script src="<?php echo base_url('assets/js/share-social-media.js');?>"></script>
						<div class="col-sm-2 share-campaign-element">
							<span class="fa-stack fa-2x">
								<a href="https://www.facebook.com/sharer/sharer.php"
									class="share_popup facebook-color"
									data-social-media="facebook"
									data-app-id="349895105208448"
									data-url="<?php tiny_site_url();?>"
									title = "Compartilhar esta Campanha no Facebook"
									>
									<i class="fa fa-circle fa-stack-2x"></i>
									<i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
								</a>
							</span>
						</div>
						<div class="col-sm-2 share-campaign-element">
							<span class="fa-stack fa-2x">
								<a href="https://twitter.com/share"
									class="share_popup twitter-color"
									data-social-media="twitter"
									data-url="<?php tiny_site_url();?>"
									data-text="Gostaria de ganhar este presente."
									title = "Tweetar esta Campanha"
									>
									<i class="fa fa-circle fa-stack-2x"></i>
									<i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
								</a>
							</span>
						</div>
						<div class="col-sm-2 share-campaign-element">
							<span class="fa-stack fa-2x">
								<a href="https://plus.google.com/share"
									class="share_popup google-plus-color"
									data-social-media="google-plus"
									data-url="<?php tiny_site_url();?>"
									title = "Compartilhar esta Campanha no Google+"
									>
									<i class="fa fa-circle fa-stack-2x"></i>
									<i class="fa fa-google-plus fa-stack-1x fa-inverse"></i>
								</a>
							</span>
						</div>
						<div class="col-xs-2 share-campaign-element">
							<span class="fa-stack fa-2x">
								<a id = "link-get-short-url" class ="copy-link-color select-short-url" href="#" title="Click para selecionar Link Curto. Após seleçao, usar Ctrl + C para copiar o link no portapapel.">
									<i class="fa fa-circle fa-stack-2x"></i>
									<i class="fa fa-link fa-stack-1x fa-inverse"></i>
								</a>
							</span>
						</div>
					</div>
					<div class="row short-link-area" id="short-link-ballon">
						<span class="bubble-short-link">Link Curto:<span id = "short-url-text"><?php tiny_site_url();?></span></span>
					</div>
				</div>
			</div>
		</div>

		<div class="row">	<!-- Alert Pane -->
			<div class="col-md-9 contribution-log"> <!-- Right Pane -->
			<!-- hr class="grey-line" -->
<?php foreach ($rs_contrib_msg as $msg):?>
<div class="row alert alert-default" role="alert">
<?php echo ($msg);?>
</div>
<?php endforeach;
?>
			</div>	<!-- Left Pane -->
		</div> <!-- Right Pane -->




	</div>
	<div class="col-md-3">
		<div class="row campaign-list-right"><!-- Campaign Price -->
		<div class="thumbnail">
			<div class="campaign-values">
				<div class="row">
					<div class="col-xs-6 price-title">
						<h4>Preço</h4>
					</div>
				</div>
				<div id="current-CampPriceAmount" class="price-amount">
					<span class="currencyText" data-a-sign="R$ " data-asep="." data-adec="," data-bv-notempty="false"><?php echo $rs->camp_goal;?></span>
				</div>
				<div class="progress campaign-progress">
					<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $rs->camp_completed;?>%;">
						<span class="sr-only"><?php echo $rs->camp_completed;?>% Completo</span>
					</div>
				</div>
				<div class="campaign-progress-info-area">
					<div class="campaign-progress-info"><?php echo $rs->camp_completed;?>% completo com</div>
					<div class="campaign-progress-info">
						<span class="cyan-title currencyText" data-a-sign="R$ " data-asep="." data-adec="," data-bv-notempty="false"><?php echo $rs->camp_collected;?></span> presenteados
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="campaignContribArea" class="row campaign-list-right">
		<form id="frmContribute" name="frmContribute" method="post" action="<?php echo base_url('checkout/contribute');?>">
			<input type="hidden" name= "idcampaign" id="idcampaign" class="pk_field" value="<?php echo $rs->idcampaign;?>">
			<input type="hidden" name= "controllername" id="controllername" value="<?php echo $controller_name;?>">
			<input type="hidden" name= "hiddenCampPriceAmount" id="hiddenCampPriceAmount" value="">
			<div class="thumbnail">
				<div class="campaign-values">
					<p>Presentei com</p>
					<div class="contribute-form-area">
						<div class="form-group has-feedback">
							<div class="input-group text-area-box">
								<input type="text" class="form-control currency currency-radius" id="inputContribute" name="inputContribute" placeholder="R$50, R$ 100, R$ 200" value="" data-bv-field="currency">
								<input type="hidden" name="idCampaignContrib" id="idCampaignContrib" value="<?php echo $rs->idcampaign;?>">
								<input type="hidden" name="inputValContribute" id="inputValContribute" value="">
								</div><i class="form-control-feedback bv-no-label bv-icon-input-group" data-bv-icon-for="currency" style="display: none;"></i><!-- /input-group -->
							<small class="help-block" data-bv-validator="notEmpty" data-bv-for="currency" data-bv-result="NOT_VALIDATED" style="display: none;">Preço do presente não deve estar vazio</small><small class="help-block" data-bv-validator="callback" data-bv-for="currency" data-bv-result="NOT_VALIDATED" style="display: none;">Preço deve ser maior a zero</small></div>
						</div>
						<button type="submit" class="btn btn-header-options btn-contribute-now" href="#">Presentar Agora!</button>
					</div>
				</div>
			</form>
		</div>
		<div class="row campaign-comment-title">
			Mural de Recados
		</div>
<?php
foreach ($rs_notes as $msg):?>
		<div class="row comments-area"> <!-- Right Pane -->
		<div class="row next-campaign-comment">
			<p class="campaign-comment-text text-justify"><?php echo $msg->notes;?></p>
			<p class="campaign-comment-text text-right"><?php echo $msg->nickname;?></p>
		</div>
	</div>
<?php endforeach;?>
</div>
</div>
</div>