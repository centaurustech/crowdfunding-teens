<!-- Carousel
================================================== -->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
  </ol>
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img class="first-slide" src="assets/img/slide-01.jpg" alt="First slide">
      <div class="container carousel-box">
        <div class="carousel-caption">
          <h1>O presente sonhado.</h1>
          <p>Nunca foi tão facil falar para teu pais, tios, familiares e amigos sobre esse presente que voce adoraria ganhar.</p>
          <p><a class="btn btn-lg btn-carousel" href="#" role="button">Saiba como...</a></p>
        </div>
      </div>
    </div>
    <div class="item">
      <img class="second-slide" src="assets/img/slide-02.jpg" alt="Second slide">
      <div class="container carousel-box">
        <div class="carousel-caption">
          <h1>Faça parte.</h1>
          <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
          <p><a class="btn btn-lg btn-carousel" href="#" role="button">Quero contribuir</a></p>
        </div>
      </div>
    </div>
    <div class="item">
      <img class="third-slide" src="assets/img/slide-03.jpg" alt="Third slide">
      <div class="container carousel-box">
        <div class="carousel-caption ">
          <h1>Vamos lá!</h1>
          <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
          <p><a class="btn btn-lg btn-carousel" href="#" role="button">Crie sua campanha</a></p>
        </div>
      </div>
    </div>
    <div class="item">
      <img class="third-slide" src="assets/img/slide-04.jpg" alt="Third slide">
      <div class="container carousel-box">
        <div class="carousel-caption ">
          <h1>Vamos lá!</h1>
          <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
          <p><a class="btn btn-lg btn-carousel" href="#" role="button">Crie sua campanha</a></p>
        </div>
      </div>
    </div>
  </div>
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
  </div><!-- /.carousel -->
  <!-- Buttonset for create campaign or contribute...
  ================================================== -->
  <div class="container home-header-buttons">
    <div class="row">
      <div class="col-sm-6">
        <a class="btn btn-lg btn-header-options centered" href="<?php echo base_url('campaigns');?>" role="button">Quero presentear</a>
      </div>
      <div class="col-sm-6">
        <a class="btn btn-lg btn-header-options centered" href="<?php echo (base_url('campaigns/add-new'));?>" role="button">Quero ganhar um presente</a>
      </div>
    </div>
  </div>
  <!-- Crowdfunding campaigns
  ================================================== -->
  <!-- Wrap the rest of the page in another container to center all the content. -->
  <div class="container campaigns">
    <h2>Presentes em destaque</h2>
    <!-- Three columns of text below the carousel -->
    <hr>
    <div class="row">
<?php foreach ($rs_camp_highlighted as $camp) {
	?>
										      <div class="col-md-3 campaign-list">
										        <div class="thumbnail">
										          <h3><?php echo $camp->camp_owner;?></h3>
										          <div class="img-gift-box">
					                      <img class="img-gift" src="<?php echo $camp->imgurl;?>">
					                    </div>
										          <h4><a class = "campaign-name" href="campaigns/details/<?php echo $camp->idcampaign;?>"><?php echo $camp->camp_name;
	?></a></h4>
										          <p><?php echo $camp->camp_description;?></p>
										          <div class = "campaign-values">
										            <p><span class="currency"><?php echo $camp->camp_goal;?></span></p>
										            <div class="progress">
										              <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $camp->camp_completed;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $camp->camp_completed;?>%;">
										                <span class="sr-only"><?php echo $camp->camp_completed;?>% Complete</span>
										              </div>
										            </div>
										            <p><?php echo $camp->camp_completed;?>%</p>
										          </div>
										        </div>
										      </div><!-- /.col-md-3 -->
	<?php }
?>
    </div><!-- /.row -->
  </div><!-- /.campaign container -->