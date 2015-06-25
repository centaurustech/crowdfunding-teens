
<?php
if ($this->session->userdata('user') != '') {
	$user_session = $this->session->userdata('user');
	$current_user = $user_session['fullname'];
} else {
	$current_user = "";
}
?>

<!-- Custom styles for this template -->
<link href="<?php echo base_url('assets/css/login.css');?>" rel="stylesheet">
<script src="<?php echo base_url('assets/js/validator.js');?>"></script>
<div class="container login-area">

      <form class="form-login" id="frmLogin" role="form" action="<?php echo base_url('login/changepassword');?>" method="post">

        <div class="form-login-head">
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
        <button class="btn btn-login btn-block" type="submit">Gravar Senha</button>
        <p class="password-recovery">
        	<a href="<?php echo base_url('login');?>">Voltar</a>
        </p>
      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo base_url('assets/js/ie10-viewport-bug-workaround.js');?>"></script>
  </body>
</html>
