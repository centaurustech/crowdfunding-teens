<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Crowdfunding adolescentes | Login</title>

    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

	<!-- Awesomefonts -->
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

  <!-- Latest compiled and minified JavaScript -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="<?php echo asset_url();?>css/login.css" rel="stylesheet">

	<!-- Bootstrap validator -->
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"/>
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/language/pt_BR.js"></script>
	<script src="<?php echo base_url('assets/js/validator.js');?>"></script>


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
      <form id="frmLogin" class="form-login" role="form" action="<?php echo goto_url('login/auth');?>" method="post">
        <div class="form-login-heading">
        	Accesar sua conta com:<br>
          <a href="<?php echo base_url('/login/facebook');?>" class="btn btn-block btn-facebook">
            <i class="fa fa-facebook"></i>
            <span class="facebook-text">Facebook</span>
          </a>
          <hr>
		</div>

<?php
if (isset($error_login) && $error_login != '') {
	?>
																																				<div id="error"><p><b style=color:red><?php echo $error_login;?></b></p></div>
	<?php
}
?>

		<div class="form-group">
			<label for="inputUser" class="sr-only">Usuário</label>
	        <input type="text" id="inputUser" name="inputUser" class="form-control" placeholder="Usuário" autocomplete="off" autofocus="on" autofocus>
	    </div>
	    <div class="form-group">
	        <label for="inputPassword" class="sr-only">Senha</label>
	        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Senha">
        </div>
        <button class="btn btn-lg btn-block" type="submit">Log in</button>
        <p class="password-recovery">
        	<a href="<?php echo goto_url('login/password_recovery');?>">Esquecí minha senha</a>
        </p>
        <p class="password-recovery">
          <a href="<?php echo goto_url('signup');?>">Cadastrar Usuário</a>
        </p>
      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo asset_url();?>js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
