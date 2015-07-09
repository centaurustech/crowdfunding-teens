<!-- Custom styles for this template -->
<link href="<?php echo base_url('assets/css/login.css');?>" rel="stylesheet">
<script src="<?php echo base_url('assets/js/profile-user/sign-up.js');?>"></script>
<div class="container login-area">
  <form id="frmSignUp" class="form-login" role="form" action="<?php echo base_url('signup/create_user');?>" method="post">
    <div class="form-login-head">
      Já está cadastrado? <a href="<?php echo base_url('login/');?>">Login</a>
    </div>
    <div class="form-login-head">
      Cadastrar-se com:<br>
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
    <p>Ou preencher os seguintes campos:</p>
    <div class="form-group">

      <label for="inputFullName" class="sr-only">Nome Completo</label>
      <input type="text" id="inputFullName" name="inputFullName" class="form-control control-margin-bottom" placeholder="Nome Completo" autocomplete="off" autofocus="on" autofocus>

      <label for="inputGender" class="sr-only">Gênero</label>
      <select class = "form-control control-margin-bottom" name="inputGender">
        <option value="">|== Selecione seu gênero ==|</option>
        <option value="M">Masculino</option>
        <option value="F">Feminino</option>
        <option value="U">Prefero não informar</option>
      </select>

      <div class="input-group date" id='inputDateOfBirth'>
        <label for="inputDateOfBirth" class="sr-only">Data de Nascimento</label>
        <input type="text" class="form-control control-date-picker" placeholder="Data de Nascimento dd/mm/aaaa" name = "inputDateOfBirth">
        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
      </div>

      <label for="inputEmail" class="sr-only">E-Mail</label>
      <input type="email" id="inputEmail" name="inputEmail" class="form-control control-margin-top control-margin-bottom" placeholder="E-Mail" autocomplete="off" autofocus="on" autofocus>

      <label for="inputUser" class="sr-only">Apelido / (Login)</label>
      <input type="text" id="inputUser" name="inputUser" class="form-control control-margin-bottom" placeholder="Apelido / Login" autocomplete="off" autofocus="on" autofocus>


      <label for="inputPassword" class="sr-only">Senha</label>
      <input type="password" id="inputPassword" name="inputPassword" class="form-control control-margin-bottom" placeholder="Senha">

      <label for="inputConfirmPassword" class="sr-only">Confirmar Senha</label>
      <input type="password" id="inputConfirmPassword" name="inputConfirmPassword" class="form-control control-margin-bottom" placeholder="Confirmar Senha">

    </div>
    <button class="btn btn-login btn-block" type="submit">Efetuar Cadastro</button>
  </form>
  </div> <!-- /container -->
  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <script src="<?php echo base_url('assets/js/ie10-viewport-bug-workaround.js');?>"></script>
</body>
</html>