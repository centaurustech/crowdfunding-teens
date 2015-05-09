<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Crowdfunding adolescentes | Recuperação de Senha</title>

    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="<?php echo asset_url();?>css/login.css" rel="stylesheet">


	<!-- Bootstrap validator -->
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"/>
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/language/pt_BR.js"></script>
      <script src="<?php echo asset_url();?>js/bootbox.min.js"></script>
      <script src="<?php echo asset_url();?>js/dialogs.js"></script>
      <!--script src="<?php echo asset_url();?>js/validator.js"></script-->
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?php echo asset_url();?>js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->
  </head>

  <body>

    <div class="container">

      <form class="form-login" id="frmRecover" name="frmRecover" role="form" action="<?php echo goto_url('login/create_password');?>" method="post">
        <div class="form-login-heading">
		    </div>

<?php
if (isset($error_recovery) && $error_recovery != '') {
	?>
	<p class="info-recovery" style="color:red">
	<?php echo $error_recovery;?>
	</p>
	<?php
} else if (isset($error_email) && $error_email != '') {
	?>
	<p class="info-recovery" style="color:red">
	<?php echo $error_email;?>
	</p>
	<?php
} else {
	?>
	<p class="info-recovery">
				              Caso tinha esquecido sua senha, prencher o campo e-mail para enviar procedimento de alteração de senha.
				          </p>
	<?php
}
?>
		<div class="form-group">
			<label for="inputEmail" class="sr-only">E-Mail</label>
	        <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="E-Mail" autocomplete="off" autofocus>
        </div>

        <button class="btn btn-lg btn-block" type="submit" id="alterarsenha">Solicitar alteração de senha</button>
        <p class="password-recovery">
        	<a href="<?php echo base_url();?>login/">Voltar</a>
        </p>
      </form>


    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo asset_url();?>js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
