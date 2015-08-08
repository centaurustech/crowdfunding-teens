<!-- Custom styles for this template -->
<link href="<?php echo base_url('assets/css/login.css');?>" rel="stylesheet">
<script src="<?php echo base_url('assets/js/user-profile/my-contributions.js');?>"></script>
<div class="container profile-area white-background">
  <div class="col-xs-11">
    <h3>Busca de Cotas Enviadas</h3>
    <form class="form-horizontal" id = "formFilterContribReceived" action="<?php echo base_url('profile/my-sent-contributions/');?>" method="post" accept-charset="utf-8">
      <div class="col-md-10">
        <div class="form-group">
          <label for="inputCampName" class="col-sm-3 control-label">Nome Campanha:</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="inputCampName" name="inputCampName" placeholder="Insira o nome da campanha...">
          </div>
        </div>
        <div class="form-group">
          <label for="inputSignature" class="col-sm-3 control-label">Dono Campanha:</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="inputCampOwner" name="inputCampOwner" placeholder="Coloque nome completo ou apelido do dono da campanha...">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label">Monto recebido:</label>
          <div class="col-sm-2">
            <input type="text" class="form-control currency number_hidden" id="inputContribFrom" name="inputContribFrom" placeholder="De...">
            <input type="hidden" id="inputContribFromVal" name="inputContribFromVal" placeholder="De...">
          </div>
          <div class="col-sm-2">
            <input type="text" class="form-control currency number_hidden" id="inputContribTo" name="inputContribTo" id="inputContribTo" placeholder="Até...">
            <input type="hidden" id="inputContribToVal" name="inputContribToVal" placeholder="Até...">
          </div>
          <label for="inputContribDate" class="col-sm-2 control-label">Data Contrib:</label>
          <div class='col-sm-3'>
            <div class='input-group date' id='inputContribDate'>
              <input type="text" class="form-control" placeholder="dd/mm/aaaa" name = "inputContribDate" value="" />
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-default btn-block">
        <i class="fa fa-search fa-fw"></i> Buscar
        </button>
      </div>
    </form>
    <div class="col-sm-12">
      <hr class="grey-color">
    </div>
    <div class="col-sm-12">
      <h3>Cotas Enviadas para outras Campanhas de Presentes</h3>
    </div>
    <div class="col-sm-6">
      Total Enviado: <span class="currency"><?php echo $sum_contrib_sent;?></span>
    </div>
    <table class="table table-condensed">
      <thead>
        <th>Data Contribuição</th>
        <th>Campanha Presente</th>
        <th>Apelido Autor</th>
        <th>Nome Completo Autor</th>
        <th>Monto Enviado</th>
        <th>Taxa</th>
        <th>Monto Total</th>
      </thead>
      <tbody>
<?php
if ($my_contrib_sent !== false):
foreach ($my_contrib_sent as $contrib):?>
		        <tr>
		          <td><?php echo $contrib->payment_date;?></td>
		          <td>
		            <a href="<?php echo base_url('campaigns/details/'.$contrib->idcampaign)?>">
<?php echo $contrib->camp_name;?>
		            </a>
		          </td>
		          <td><?php echo $contrib->camp_owner_nickname;?></td>
		          <td><?php echo $contrib->camp_owner;?></td>
		          <td class="currency"><?php echo $contrib->amount;?></td>
		          <td class="currency"><?php echo $contrib->service_fee;?></td>
		          <td class="currency"><?php echo $contrib->total_payment;?></td>
		        </tr>
<?php endforeach;
endif;
?>
      </tbody>
    </table>
  </div>
  </div> <!-- /container -->