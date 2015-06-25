<!-- Custom styles for this template -->
<link href="<?php echo base_url('assets/css/login.css');?>" rel="stylesheet">
<script src="<?php echo base_url('assets/js/validator.js');?>"></script>
<div class="container login-area">
  <form id="frmLogin" class="form-login" role="form" action="<?php echo base_url('signup/create_user');?>" method="post">

    <div class="form-login-head">
      Já está cadastrado? <a href="<?php echo base_url('login/');?>">Login</a>
    </div>

    <div class="form-login-head">
      Cadastrar-se com:<br>
      <a href="<?php echo base_url('/login/facebook');?>" class="btn btn-block btn-facebook">
        <i class="fa fa-facebook"></i>
        <span class="facebook-text">Facebook</span>
      </a>

    </div>


      <p>Ou preencher os seguintes campos:</p>

      <div class="form-group">
        <label for="inputFullName" class="sr-only">Nome Completo</label>
        <input type="text" id="inputFullName" name="inputFullName" class="form-control" placeholder="Nome Completo" autocomplete="off" autofocus="on" autofocus>
        <label for="inputEmail" class="sr-only">E-Mail</label>
        <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="E-Mail" autocomplete="off" autofocus="on" autofocus>

        <label for="inputUser" class="sr-only">Nome de Usuário (Login)</label>
        <input type="text" id="inputUser" name="inputUser" class="form-control" placeholder="Nome de Usuário (Login)" autocomplete="off" autofocus="on" autofocus>

        <label for="inputPassword" class="sr-only">Senha</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Senha">

        <label for="inputConfirmPassword" class="sr-only">Confirmar Senha</label>
        <input type="password" id="inputConfirmPassword" name="inputConfirmPassword" class="form-control" placeholder="Confirmar Senha">
      </div>

    <button class="btn btn-login btn-block" type="submit">Efetuar Cadastro</button>

  </form>
  </div> <!-- /container -->
  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <script src="<?php echo base_url('assets/js/ie10-viewport-bug-workaround.js');?>"></script>
</body>
</html>