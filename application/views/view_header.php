<?php

if (!$this->users_model->isLogged()) {
	redirect('/login');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Radar System | Gerenciamento de Imagens</title>

    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link href="<?php echo asset_url(); ?>css/dashboard.css" rel="stylesheet">

    <!-- Latest compiled and minified JavaScript -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    
    <!-- Include Bootstrap-select CSS, JS -->
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css" />
	<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js"></script>
    
    <!-- Bootstrap validator -->
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"/>
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/language/pt_BR.js"></script>

	<!-- Datetime Picker library -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url(); ?>css/bootstrap-datetimepicker.min.css">
    <script src="<?php echo asset_url(); ?>js/moment.js"></script>
    <script src="<?php echo asset_url(); ?>js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?php echo asset_url(); ?>js/dtpicker-setup.js"></script>
      <script src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>
    <script src="<?php echo asset_url(); ?>js/dialogs.js"></script>
    
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    
	<script src="<?php echo asset_url(); ?>js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="<?php echo(goto_url('dashboard/')); ?>">
		  	<img class="logo" src="<?php echo asset_url(); ?>img/logo-radar.png" />
		  </a>
          
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>          
        </div>
        
        <div id="navbar" class="navbar-collapse collapse">
          
          <ul class="nav navbar-nav navbar-right menu-desktop">
            <li><a href="<?php echo(goto_url('dashboard/logout/')); ?>">Sair</a></li>
          </ul>
          
          
          <div class="navbar-text navbar-right">
              <?php
              
              if ($this->session->userdata('user') != '') {
                  $user_session = $this->session->userdata('user');
                  $current_user = $user_session['firtsname'].' '.$user_session['lastname'];
              } else {
                  $current_user = "";
              } ?>
          	    Bem-vindo <?php echo $current_user; ?>
          </div>
          
          <div class="menu-mobile">
          	
	        <ul class="nav navbar-nav navbar-right">
	          <li class="divider"><hr /></li>
			  
				  <?php 
		          $prev_top_menu = "";
		          
		          foreach ($permission_session as $row) {
		          	if($prev_top_menu != $row->id_parent){
		          		
		          		$prev_top_menu = $row->id_parent;
					}
					else 
					?>
		          		<li>
							<?php echo(print_url_module_mobile($row->url, $row->modulename)); ?>
		          		</li>
		          	<?php } ?>  			  
	          <li class="divider"><hr /></li>
	          <li><a href="<?php echo(goto_url('dashboard/logout/')); ?>">Sair</a></li>         
	        </ul>

          </div>
          
      
        </div>
      </div>
    </nav>
    