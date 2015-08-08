<!-- Custom styles for this template -->
<link href="<?php echo base_url('assets/css/login.css');?>" rel="stylesheet">
<script src="<?php echo base_url('assets/js/user-profile/my-campaign.js');?>"></script>
<div class="container profile-area white-background">
	<h3 class="profile-search-title">Busca de Campanhas</h3>
	<form class="form-horizontal" id = "formFilterCamp" action="<?php echo base_url('profile/my-campaigns/');?>" method="post" accept-charset="utf-8">
		<div class="col-md-9">
			<div class="form-group">
				<label for="inputCampName" class="col-sm-3 control-label">Nome Campanha:</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="inputCampName" name="inputCampName" placeholder="Insira o nome da campanha...">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Preço Presente:</label>
				<div class="col-sm-2">
					<input type="text" class="form-control currency number_hidden" id="inputGoalMin" name="inputGoalMin" placeholder="De...">
					<input type="hidden" id="inputGoalMinVal" name="inputGoalMinVal" value="">
				</div>
				<div class="col-sm-2">
					<input type="text" class="form-control currency number_hidden" id="inputGoalMax" name="inputGoalMax" placeholder="Até...">
					<input type="hidden" id="inputGoalMaxVal" name="inputGoalMaxVal" value="">
				</div>
				<label for="inputCreationDate" class="col-sm-2 control-label">Data Criação:</label>
				<div class='col-sm-3'>
					<div class='input-group date' id='inputCreationDate'>
						<input type="text" class="form-control" placeholder="dd/mm/aaaa" name = "inputCreationDate" value="" />
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Monto Recebido:</label>
				<div class="col-sm-2">
					<input type="text" class="form-control currency number_hidden" id="inputCollectedMin" name="inputCollectedMin" placeholder="De...">
					<input type="hidden" id="inputCollectedMinVal" name="inputCollectedMinVal" value="">
				</div>
				<div class="col-sm-2">
					<input type="text" class="form-control currency number_hidden" id="inputCollectedMax" name="inputCollectedMax" placeholder="Até...">
					<input type="hidden" id="inputCollectedMaxVal" name="inputCollectedMaxVal" value="">
				</div>
				<label for="inputCompleted" class="col-sm-2 control-label">Completado:</label>
				<div class="col-sm-3">
					<input type="text" class="form-control number_hidden" id="inputCompleted" name="inputCompleted" placeholder="% Completado">
					<input type="hidden" id="inputCompletedVal" name="inputCompletedVal" value="">
				</div>
			</div>
		</div>
		<div class="col-md-1">
			<div class="form-group">
				<button type="submit" class="btn btn-default btn-block">
				<i class="fa fa-search fa-fw"></i> Buscar
				</button>
			</div>
		</div>
	</form>
	<div class="col-sm-11">
		<hr class="grey-color">
	</div>
<?php if ($num_campaign > 0):?>
<div class="col-sm-6">
		<h3>Minhas campanhas de presentes</h3>
	</div>
<?php if ($filtered):?>
	<div class="col-sm-5 text-right">
		<h4>Registros encontrados: <?php echo $num_campaign;?></h4>
	</div>
<?php endif?>
<div class="col-sm-11">
<?php foreach ($my_campaigns as $campaign):?>
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
					<div class="col-xs-6">
						Data Criação: <?php echo $campaign->creationdate;?>
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
<?php endforeach;
 else :?>
<div class="col-sm-6">
			<h3>Sem resultados para esta busca...</h3>
		</div>
<?php endif;
?>
	</div>
	</div> <!-- /container -->