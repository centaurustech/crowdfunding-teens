<!-- Custom styles for this template -->
<link href="<?php echo base_url('assets/css/login.css');?>" rel="stylesheet">
<script src="<?php echo base_url('assets/js/user-profile/edit-profile.js');?>"></script>
<div class="container login-area">
  <form id="frmSignUp" class="form-horizontal" role="form" action="<?php echo base_url('profile/save');?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="inputIdPeople" value="<?php echo $people->idpeople;?>">
    <h1 class="account-profile-title"><?php echo $people->fullname;?></h1>
    <div class="row white-background rounded-box">
      <div class="col-md-10">
        <h2>Dados Básicos</h2>
      </div>
<?php if (isset($msg)) {?>
			      <div class="col-md-10">
			        <div class="alert alert-<?php echo $label_type;?>alert-dismissible" role="alert">
			          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<?php echo $msg;?>
	</div>
			      </div>
	<?php }
?>
      <div class="col-md-4">
        <input type="hidden" id="imgNoProfilePictMale" value="<?php echo base_url("assets/img/no-profile-picture-male.jpg");?>">
        <input type="hidden" id="imgNoProfilePictFemale" value="<?php echo base_url("assets/img/no-profile-picture-female.jpg");?>">
        <input type="hidden" id="imgNoProfilePictNeutral" value="<?php echo base_url("assets/img/no-profile-picture-neutral.jpg");?>">
        <input type="hidden" id="emptyPicture" name="emptyPicture" value="0">
        <img src="<?php echo $people->full_picture_url;?>" id = "imgProfilePicture" class="img-responsive account-profile-picture">
        <input type="file" class="fileUploader hide" id="fileProfilePhoto" name="fileProfilePhoto" value="" data-img="imgProfilePicture">
        <button class="btn btn-upload upload" type="button"><i class="fa fa-camera"></i></button>
        <button class="btn btn-clear-picture clear-profile-picture" data-img="imgProfilePicture" type="button"><i class="fa fa-times"></i></button>
      </div>
      <div class="col-md-8">
        <div class="row">
          <div class="form-group col-md-10">
            <label for="inputFullName" class="control-label">Nome Completo</label>
            <input type="text" id="inputFullName" name="inputFullName" value = "<?php echo $people->fullname;?>" class="form-control" placeholder="Nome Completo" autocomplete="off" autofocus="on" autofocus>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-10">
            <label for="inputEmail" class="">E-Mail</label>
            <input type="email" id="inputEmail" name="inputEmail" value = "<?php echo $people->email;?>" class="form-control control-margin-top control-margin-bottom" placeholder="E-Mail" autocomplete="off" autofocus="on" autofocus>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="inputGender" class="control-label">Gênero</label>
              <select class = "form-control" id="inputGender" name="inputGender">
                <option value="">|== Selecione seu gênero ==|</option>
                <option value="M" <?php echo $people->gender == "M"?"selected":"";?>>Masculino</option>
                <option value="F" <?php echo $people->gender == "F"?"selected":"";?>>Feminino</option>
                <option value="U" <?php echo $people->gender == "U"?"selected":"";?>>Prefero não informar</option>
              </select>
            </div>
          </div>
          <div class="col-md-offset-1 col-md-4">
            <div class="form-group">
              <label for="inputGender" class="control-label">Data de Nascimento</label>
              <div class='input-group date' id='inputDateOfBirth'>
                <input type="text" class="form-control" placeholder="dd/mm/aaaa" name = "inputDateOfBirth" value="<?php echo $people->dateofbirth;?>" />
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-5">
            <label for="inputUser" class="control-label">Apelido / Login</label>
            <input type="text" id="inputUser" name="inputUser" value = "<?php echo $user->username;?>" class="form-control control-margin-bottom" placeholder="Apelido / Login" autocomplete="off" autofocus="on" autofocus>
          </div>
        </div>
        <div class="row form-group">
          <div class="row col-md-5">
            <label for="inputPassword" class="control-label">Senha</label>
            <input type="password" id="inputPassword" name="inputPassword" value = "" class="form-control control-margin-bottom" placeholder="Senha">
          </div>
          <div class="col-md-5">
            <label for="inputConfirmPassword" class="control-label">Confirmar Senha</label>
            <input type="password" id="inputConfirmPassword" name="inputConfirmPassword" value = "" class="form-control control-margin-bottom" placeholder="Confirmar Senha">
          </div>
        </div>
      </div>
    </div>
    <div class="row white-background rounded-box">
      <div class="col-md-10">
        <h2>Dados para Resgate</h2>
      </div>
      <div class="row">
        <div class="col-md-offset-1 col-md-3">
          <div class="form-group">
            <label for="inputGender" class="control-label sr-only">Tipo Documento</label>
            <select class = "form-control" name="inputDocType">
              <option value="">|== Selecione Tipo Documento ==|</option>
<?php foreach ($doc_type_list as $doc_type) {
	?>
			              <option value="<?php echo $doc_type->doctype_id;?>" <?php echo $people->doctype_id == $doc_type->doctype_id?"selected":"";
	?>>
	<?php echo $doc_type->doctype_name;?>
	</option>
	<?php }
?>
            </select>
          </div>
        </div>
        <div class="col-md-offset-1 col-md-5">
          <div class="form-group">
            <label for="inputNumDoc" class="control-label sr-only">Número Documento</label>
            <input type="text" class="form-control" placeholder="Digite Número Documento..." name = "inputNumDoc"  id='inputNumDoc' value="<?php echo $people->docnum;?>" />
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-offset-1 col-md-9">
          <div class="form-group">
            <label for="inputAddress" class="control-label">Endereço</label>
            <input type="text" class="form-control" placeholder="Digite seu Endereço..." name = "inputAddress"  id='inputAddress' value="<?php echo $people->address;?>" />
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-offset-1 col-md-4">
          <div class="form-group">
            <label for="inputAddress" class="control-label">Telefone</label>
            <input type="text" class="form-control" placeholder="Digite seu Telefone..." name = "inputPhone"  id='inputPhone' value="<?php echo $people->phone;?>" />
          </div>
        </div>
        <div class="col-md-offset-1 col-md-4">
          <div class="form-group">
            <label for="inputAddress" class="control-label">CEP</label>
            <input type="text" class="form-control" placeholder="Digite seu CEP..." name = "inputZipCode"  id='inputZipCode' value="<?php echo $people->zipcode;?>" />
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-offset-7 col-md-5 text-right">
      <button class="btn btn-login btn-block" type="submit">Atualizar Perfil</button>
    </div>
  </form>
  </div> <!-- /container -->
  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <script src="<?php echo base_url('assets/js/ie10-viewport-bug-workaround.js');?>"></script>
</body>
</html>