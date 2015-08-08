<!-- Custom styles for this template -->
<link href="<?php echo base_url('assets/css/login.css');?>" rel="stylesheet">
<script src="<?php echo base_url('assets/js/user-profile/my-contributions.js');?>"></script>
<div class="container profile-area white-background">
  <h3 class="profile-search-title">Busca de Cotas Recebidas</h3>
  <div class="col-xs-11">
    <form class="form-horizontal" id = "formFilterContribReceived" action="<?php echo base_url('profile/my-received-contributions/');?>" method="post" accept-charset="utf-8">
      <div class="col-md-10">
        <div class="form-group">
          <label for="inputCampName" class="col-sm-3 control-label">Nome Campanha:</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="inputCampName" name="inputCampName" placeholder="Insira o nome da campanha...">
          </div>
        </div>
        <div class="form-group">
          <label for="inputSignature" class="col-sm-3 control-label">Assinatura:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="inputSignature" name="inputSignature" placeholder="Quem mandou contribuições...">
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
<?php if ($my_contrib_received !== false):?>
    <div class="col-sm-6">
      <h3>Minhas Cotas Recebidas</h3>
    </div>
    <div class="col-sm-6 text-right">
      <p>
        Total Recebido: <span class="currency"><?php echo $sum_contrib_received;?></span>
      </p>
<?php if ($filtered):?>
      <p>
        Registros encontrados: <?php echo $count_contrib_received;?>
</p>
<?php endif;?>
</div>
    <table class="table table-condensed">
      <thead>
        <th>&nbsp;</th>
        <th>Data Contribuição</th>
        <th>Campanha Presente</th>
        <th>Monto Recebido</th>
        <th>Assinatura</th>
        <th>Mensagem</th>
        <th></th>
      </thead>
      <tbody>
<?php
foreach ($my_contrib_received as $contrib):?>
        <tr>
          <td><input type="checkbox" class ="check-select-withdrawals" id="contrib<?php echo $contrib->idcontribution;?>" name="" value=""></td>
          <td><?php echo $contrib->payment_date;?></td>
          <td>
            <a href="<?php echo base_url('campaigns/details'.$contrib->idcampaign)?>">
<?php echo $contrib->camp_name;?>
            </a>
          </td>
          <td class="currency"><?php echo $contrib->amount;?></td>
          <td><?php echo $contrib->nickname;?></td>
          <td><?php echo $contrib->short_notes;?></td>
          <td>
            <a href="<?php echo base_url('withdraw/'.$contrib->idcontribution)?>" class="btn btn-block btn-default btn-withdrawal" id="popoverOption" data-content="Solicitar Resgate desta contribuição" rel="popover" data-placement="bottom"data-trigger="hover">
              <i class="fa fa-money fa-fw"></i>
            </a>
          </td>
        </tr>
<?php endforeach;
?>
</tbody>
    </table>
<?php  else :?>
<div class="col-sm-6">
      <h3>Sem resultados para esta busca...</h3>
    </div>
<?php endif;?>
  </div>
  </div> <!-- /container -->