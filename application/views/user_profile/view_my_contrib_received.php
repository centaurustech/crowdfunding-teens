<!-- Custom styles for this template -->
<link href="<?php echo base_url('assets/css/login.css');?>" rel="stylesheet">
<script src="<?php echo base_url('assets/js/user-profile/edit-profile.js');?>"></script>
<div class="container profile-area white-background">
  <div class="col-xs-11">
    <h3>Contribuições Recebidas da Minhas Campanhas de Presentes</h3>
    <p>
      Total Recebido: <span class="currency"><?php echo $sum_contrib_received;?></span>
    </p>
    <table class="table table-condensed">
      <thead>
        <th>Data Contribuição</th>
        <th>Campanha Presente</th>
        <th>Monto Recebido</th>
        <th>Assinatura</th>
        <th>Mensagem</th>
      </thead>
      <tbody>
<?php
if ($my_contrib_received !== false) {
	foreach ($my_contrib_received as $contrib) {?>
		        <tr>
		          <td><?php echo $contrib->payment_date;?></td>
		          <td>
		            <a href="<?php echo base_url('campaigns/details'.$contrib->idcampaign)?>">
		<?php echo $contrib->camp_name;?>
		            </a>
		          </td>
		          <td class="currency"><?php echo $contrib->amount;?></td>
		          <td><?php echo $contrib->nickname;?></td>
		          <td><?php echo $contrib->short_notes;?></td>
		        </tr>
		<?php }
}
?>
      </tbody>
    </table>
  </div>
  </div> <!-- /container -->