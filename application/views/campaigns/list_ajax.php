<!-- Crowdfunding campaigns list using Ajax
================================================== -->


<!-- Wrap the rest of the page in another container to center all the content. -->
<div class="container campaigns campaign-details">
  <h1>Listado de Presentes</h1>

  <!-- Title / description separation line -->
  <hr class="grey-line">

  <div id ="campaign-result-1" class="row">
    <div class="col-md-3 campaign-list">
      <div class="thumbnail">
        <h3>João Oliveira</h3>
        <img class="img-gift" src="<?php echo base_url('assets/uploads/joaozinho/PlayStation-4.jpg');?>" alt="Playstation 4">
        <h4><a class = "campaign-name" href="<?php echo base_url('campaigns/details/1');?>">Playstation 4</a></h4>
        <p>Vai pessoal ajuda ae! Faltam bem pouquinhoooo!!!!<br>
        Partiu aniversário de João!</p>
        <div class = "campaign-values">
          <p>R$ 3.540,00</p>
          <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
              <span class="sr-only">60% Complete</span>
            </div>
          </div>
          <p>60%</p>
        </div>
      </div>
    </div><!-- /.col-md-3 -->
    <div class="col-md-3 campaign-list">
      <div class="thumbnail">
        <h3>Cláudio Alves</h3>
        <img class="img-gift" src="<?php echo base_url('assets/uploads/joaozinho/nike-air-max.jpg');?>" alt="Playstation 4">
        <h4><a class = "campaign-name" href="<?php echo base_url('campaigns/details/2');?>">Nike Air Max</a></h4>
        <p>Vale todo mundo que contribuiu! Já comprei e ficou sensacional :)))
        </p>
        <div class = "campaign-values">
          <p>R$ 3.540,00</p>
          <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
              <span class="sr-only">60% Complete</span>
            </div>
          </div>
          <p>60%</p>
        </div>
      </div>
    </div><!-- /.col-md-3 -->
    <div class="col-md-3 campaign-list">
      <div class="thumbnail">
        <h3>Mari Junqueira</h3>
          <img class="img-gift" src="<?php echo base_url('assets/uploads/joaozinho/iphone-6-plus.jpg');?>" alt="Playstation 4">
          <h4><a class = "campaign-name" href="<?php echo base_url('campaigns/details/3');?>">iPhone 6 plus</a></h4>
          <p>Meu aniversário é no dia 18 e vou ficar muito feliz se vocês me ajudarem a comprar um iphone 6 novinho.
          </p>
        <div class = "campaign-values">
          <p>R$ 3.540,00</p>
          <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
              <span class="sr-only">60% Complete</span>
            </div>
          </div>
          <p>60%</p>
        </div>
      </div>
    </div><!-- /.col-md-3 -->
    <div class="col-md-3 campaign-list">
      <div class="thumbnail">
        <h3>Carol Battis</h3>
        <img class="img-gift" src="<?php echo base_url('assets/uploads/joaozinho/samsung-smart-tv.jpg');?>" alt="Playstation 4">
        <h4><a class = "campaign-name" href="<?php echo base_url('campaigns/details/4');?>">Smart TV 55'</a></h4>
        <p>MUITO OBRIGADO A TODO MUNDO QUE ME AJUDOU A COMPRAR UMA TV NOVA PRO MEU QUARTO! DEUS É PAI!
        </p>
        <div class = "campaign-values">
          <p>R$ 3.540,00</p>
          <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
              <span class="sr-only">60% Complete</span>
            </div>
          </div>
          <p>60%</p>
        </div>
      </div>
    </div><!-- /.col-md-3 -->

  </div><!-- /.row -->

  <div id="lastCampaign"></div>

  <div class="row show-more-area"><!-- Button Show More -->
    <div class="col-md-offset-4 col-md-4 col-md-offset-4">
      <a id ="btnShowMore" class="btn btn-lg btn-header-options centered" href="#" role="button">Mostrar Mais...</a>

    </div>

  </div>
</div><!-- /.container -->