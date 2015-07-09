<!-- Custom styles for this template -->
<link href="<?php echo base_url('assets/css/login.css');?>" rel="stylesheet">
<script src="<?php echo base_url('assets/js/user-profile/login.js');?>"></script>
<div class="container login-area">
  <form id="frmLogin" class="form-login" role="form" action="<?php echo base_url('login/auth');?>" method="post">
<?php if (isset($error_login) && $error_login != '') {?>
	<div class="alert alert-danger alert-dismissible" role="alert">
																																											      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<?php echo $error_login;?>
	</div>
	<?php }
?>
    <div class="form-login-head">
      Ainda não está cadastrado? <a href="<?php echo base_url('signup/');?>">Registre-se</a>
    </div>
    <div class="form-login-head">
      Accesar sua conta com:<br>
      <div class="row">
        <div class="col-md-4">
          <a href="<?php echo base_url('/login/facebook/');?>" class="btn btn-block btn-social-media facebook-color">
            <i class="fa fa-facebook fa-2x pull-left fa-fw separator-line"></i>
            <span class="social-media-text">Facebook</span>
          </a>
        </div>
        <div class="col-md-4">
          <a href="<?php echo base_url('/login/google-plus/');?>" class="btn btn-block btn-social-media google-plus-color">
            <i class="fa fa-google-plus fa-2x pull-left fa-fw separator-line"></i>
            <span class="social-media-text">Google</span>
          </a>
        </div>

        <div class="col-md-4">
          <a href="<?php echo base_url('/login/twitter/');?>" class="btn btn-block btn-social-media twitter-color">
            <i class="fa fa-twitter fa-2x pull-left fa-fw separator-line"></i>
            <span class="social-media-text">Twitter</span>
          </a>
        </div>
      </div>
    </div>

    <p>Ou com seu nome de usuário e senha:</p>
    <div class="form-group">
      <label for="inputUser" class="sr-only">Apelido / Login</label>
      <input type="text" id="inputUser" name="inputUser" class="form-control control-margin-bottom" placeholder="Apelido / Login" autocomplete="off" autofocus="on" autofocus>

      <label for="inputPassword" class="sr-only">Senha</label>
      <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Senha">
    </div>
    <button class="btn btn-login btn-block" type="submit">Log in</button>
    <p class="password-recovery">
      <a href="<?php echo base_url('login/password-recovery');?>">Esquecí minha senha</a>
    </p>
  </form>
  </div> <!-- /container -->
  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <script src="<?php echo base_url('assets/js/ie10-viewport-bug-workaround.js');?>"></script>
</body>
</html>