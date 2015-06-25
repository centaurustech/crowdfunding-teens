<!-- Custom styles for this template -->
<link href="<?php echo base_url('assets/css/login.css');?>" rel="stylesheet">
<script src="<?php echo base_url('assets/js/validator.js');?>"></script>
<div class="container login-area">
	<form class="form-login" id="frmLogin" name="frmLogin" role="form" action="<?php echo base_url('login/create-password');?>" method="post">
<?php
if (isset($msg) && $msg != '') {
	?>
			<div class="alert alert-<?php echo $alert_type;?>
	alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<?php echo $msg;?>
	</div>
	<?php
}
?>
		<div class="form-login-head">
			Esqueceu sua senha?
		</div>
		<p>
			Informe-nos seu e-mail para assim enviar o procedimento de alteração de senha.
		</p>
		<div class="form-group">
			<label for="inputEmail" class="sr-only">E-Mail</label>
			<input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Insira seu E-Mail..." autocomplete="off" autofocus>
		</div>
		<button class="btn btn-login btn-block" type="submit" id="alterarsenha">Solicitar alteração de senha</button>
		<p class="password-recovery">
			<a href="<?php echo base_url();?>login/">Voltar</a>
		</p>
	</form>
	</div> <!-- /container -->
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="<?php echo base_url('assets/js/ie10-viewport-bug-workaround.js');?>"></script>
</body>
</html>