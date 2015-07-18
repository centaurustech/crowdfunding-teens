<!-- Custom styles for this template -->
<link href="<?php echo base_url('assets/css/login.css');?>" rel="stylesheet">
<script src="<?php echo base_url('assets/js/user-profile/edit-profile.js');?>"></script>
<div class="container profile-area white-background">
  <div class="row ">
    <div class="col-md-4">
      <img src="<?php echo $people->full_picture_url;?>" id = "imgProfilePicture" class="img-responsive account-profile-picture img-rounded">
    </div>
    <div class="col-md-8">
      <div class="row">
        <h2>Sobre mim...</h2>
        <ul class="account-about-me">
          <li>Apelido / Login: <?php echo $user->username;?> </li>
          <li>Gênero: <?php echo $people->gender_text;?> </li>
          <li>Data de Nascimento: <?php echo $people->dateofbirth;?> </li>
          <li>E-Mail: <?php echo $people->email;?> </li>
        </ul>
      </div>
      <div class="row">
        <h2>Posição consolidada</h2>
        <ul class="account-info">
          <li>
            <span class="badge"><?php echo $num_campaign;?></span>
            Campanhas lançadas para arrecadar
            <span class="label label-success currency">
<?php echo $sum_camp_goal;?>
            </span>
          </li>
          <li>
            <span class="badge"><?php echo $num_contrib_received;?></span>
            Contribuições Recebedas. Monto Arrecadado
            <span class="label label-success currency">
<?php echo $sum_camp_collected;?>
            </span>
          </li>
          <li>
            <span class="badge"><?php echo $num_contrib_sent;?></span>
            Contribuições Feitas no total de
            <span class="label label-success currency">
<?php echo $sum_contrib_sent;?>
            </span>
          </li>
        </ul>
      </div>
    </div>
  </div>
  </div> <!-- /container -->