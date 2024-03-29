<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>Crowdfunding para presente | Testing </title>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the header of the document so we can load jquery libs -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap-3.3.4-dist/css/bootstrap.min.css');?>">
    <script src="<?php echo base_url('assets/bootstrap-3.3.4-dist/js/bootstrap.min.js');?>"></script>
    <!-- Awesomefonts -->
    <link href="<?php echo base_url('assets/font-awesome-4.3.0/css/font-awesome.min.css');?>" rel="stylesheet">
    <!-- Optional theme -->
    <!-- link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css" -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('assets/css/website.css');?>" rel="stylesheet">
    <!-- Bootstrap validator -->
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"/>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/language/pt_BR.js"></script>
    <!-- Datetime Picker library -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('assets/css/bootstrap-datetimepicker.min.css');?>">
    <script src="<?php echo base_url('assets/js/moment.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-datetimepicker.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/dtpicker-setup.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootbox.min.js');?>"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <!-- script src="assets/js/vendor/holder.js"></script -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo base_url('assets/js/website.js');?>"></script>
    <script src="<?php echo base_url('assets/js/ie10-viewport-bug-workaround.js');?>"></script>
    <!-- Autonumeric library -->
    <script src="<?php echo base_url('assets/js/autonumeric.js');?>"></script>
    <!-- Custom Fonts library -->
    <link href="http://fonts.googleapis.com/css?family=Dosis:400|Oswald:400|Droid+Serif:400,700,italic|Lato:400,normal|Open+Sans" rel="stylesheet" type="text/css" />
  </head>
  <!-- NAVBAR
  ================================================== -->
  <body>
    <div class="navbar-wrapper">
      <div class="container">
        <nav class="navbar navbar-default navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="<?php echo base_url();?>" title="Crowdfunding Site">
                <img class="featurette-image img-logo-responsive center-block" src="<?php echo base_url('assets/img/logo.png');?>" alt="Presente Top">
              </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse menuset">
              <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo base_url('browse');?>">Conheça</a></li>
                <li><a href="<?php echo base_url('lets-go');?>">Comece</a></li>
                <li class = "search-campaign last-element">
                  <div class ="search-form">
                    <form id="frmHeaderSearch" class="" method="post" action="<?php echo base_url('campaigns/search/')?>" role="search">
                      <div class="form-group search-form-area">
                        <div class="input-group">
                          <span class="input-group-btn">
                            <a href = "<?php echo base_url('campaigns/search/')?>" data-search-url="<?php echo base_url('campaigns/search/')?>" id = "btnHeaderSearch" class="btn btn-default" type="button">
                              <i class="fa fa-search"></i>
                            </a>
                          </span>
                          <input type="text" class="form-control" id="inputSearch" name = "inputSearch" placeholder="Busque alguém pelo nome ou código">
                          </div><!-- /input-group -->
                        </div>
                      </form>
                    </div>
                  </li>
<?php if (isset($current_user)) {?>
		                  <li class="menu-sign-up last-element-mobile">
		                    <div class="profile-info">
		                      <img class="img-rounded" src="<?php echo $user_pic;?>">
		                      <small class="user-logged">
		                      <a class="white-underline" href="<?php echo base_url('profile/my-account')?>" title="Minha Conta"><?php echo $current_user;?></a>
		                      </small>
		                    </div>
		                  </li>
		                  <li class = "menu-login last-element">
		                    <a href="<?php echo base_url('logout');?>">Logout</a>
		                  </li>
	<?php } else {?>
		                  <li class="menu-sign-up last-element-mobile">
		                    <a href="<?php echo base_url('signup');?>">Registre-se</a>
		                  </li>
		                  <li class = "menu-login last-element">
		                    <a href="<?php echo base_url('login');?>">Login</a>
		                  </li>
	<?php }
?>
                </ul>
              </div>
            </div>
          </nav>
        </div>
      </div>
      <!-- HEADER END -->