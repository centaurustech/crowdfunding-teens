<!-- Custom styles for this template -->
<link href="<?php echo base_url('assets/css/login.css');?>" rel="stylesheet">
<script src="<?php echo base_url('assets/js/user-profile/edit-profile.js');?>"></script>
<div class="container profile-area white-background">
  <div class="col-xs-11">
    <h3>Cotas Enviadas para outras Campanhas de Presentes</h3>
    <p>
      Total Enviado: <span class="currency"><?php echo $sum_contrib_sent;?></span>
    </p>
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
if ($my_contrib_sent !== false) {
	foreach ($my_contrib_sent as $contrib) {?>
				        <tr>
				          <td><?php echo $contrib->payment_date;?></td>
				          <td>
				            <a href="<?php echo base_url('campaigns/details'.$contrib->idcampaign)?>">
		<?php echo $contrib->camp_name;?>
				            </a>
				          </td>
				          <td><?php echo $contrib->camp_owner_nickname;?></td>
				          <td><?php echo $contrib->camp_owner;?></td>
				          <td class="currency"><?php echo $contrib->amount;?></td>
				          <td class="currency"><?php echo $contrib->service_fee;?></td>
				          <td class="currency"><?php echo $contrib->total_payment;?></td>
				        </tr>
		<?php }
}
?>
      </tbody>
    </table>
  </div>
  </div> <!-- /container -->