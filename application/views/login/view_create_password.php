<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Crowdfunding adolescente | Criar nova senha</title>

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
	<script src="<?php echo asset_url();?>js/validator.js"></script>


    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?php echo asset_url();?>js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<?php
if ($this->session->userdata('user') != '') {
	$user_session = $this->session->userdata('user');
	$current_user = $user_session['fullname'];
} else {
	$current_user = "";
}?>
  <body>

    <div class="container">

      <form class="form-login" id="frmLogin" role="form" action="<?php echo goto_url('login/changepassword');?>" method="post">

        <div class="form-login-heading">
		</div>
		<p class="info-recovery">
			O usuario <b><?php echo $current_user;?></b> ou <b>Administrador</b> efetuou o procedimento de criação de senha.
		</p>
		<div class="form-group">
			<label for="inputNewPassword" class="sr-only">Digite Nova Senha</label>
	        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Digite Nova Senha" autofocus>
        </div>
        <div class="form-group">
	        <label for="inputConfirmPassword" class="sr-only">Confirme Nova Senha</label>
	        <input type="password" id="inputConfirmPassword" name="inputConfirmPassword" class="form-control" placeholder="Confirme Nova Senha">
        </div>
        <button class="btn btn-lg btn-block" type="submit">Gravar Senha</button>
        <p class="password-recovery">
        	<a href="<?php echo goto_url('login');?>">Voltar</a>
        </p>
      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo asset_url();?>js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
