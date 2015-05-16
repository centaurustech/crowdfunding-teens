
<script src="<?php echo base_url('assets/js/campaigns.js');?>"></script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s);
 js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.3&appId=349895105208448";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="container campaign-details">

	<h1>
		<?php echo $rs->camp_owner;?>
		<span class="cyan-title">quer ganhar un...</span>
	</h1>
	<hr class="grey-line">

	<form  id="form-campaign" action="edit-campaign" method="post"> <!-- Campaign data -->

		<div class="row"> <!-- Campaign Name -->
		  	<div class="col-md-7">
			  	<div class = "col-xs-10">
					<h2 id="current-CampName"><?php echo $rs->camp_name;?></h2>
			  	</div>
			  	<div class = "col-xs-2 edit-campaign-name">
					<a id="edit-CampName" class="link-edit edit-area" href="#">Alterar</a>
			  	</div>

				<div id="form-edit-CampName" class="col-md-12 form-edit hide">

					<div class="form-group">
						<label for="inputCampName" class="sr-only">Nome Presente</label>
						<input type="text" id = "inputCampName" name = "inputCampName"  class="form-control" placeholder="Insira o Nome do seu Presente..." value="">
						<div class="btn-group pull-right" role="group">
							<button id="save-CampName" class="btn btn-success" type="button">
								<i class="fa fa-check"></i>
							</button>
							<button id="cancel-edit-CampName" class="btn btn-default btn-cancel-edit" type="button">
								<i class="fa fa-times"></i>
							</button>
						</div>
					</div><!-- /form-group -->

				</div>
			</div>
		</div> <!-- /Campaign Name -->

		<div class="row">	<!-- Basic Info Pane -->
			<div class="col-md-7">

				<img class="campaign-full-picture" src="<?php echo $rs->imgurl;?>" alt="Playstation 4">

				<div class="row bubble-description">

					<div id="current-CampDescription"><?php echo $rs->camp_description;?></div>

					<span class="pull-right"><a id="edit-CampDescription" class="link-edit edit-area" href="#">Alterar</a></span>

					<div id="form-edit-CampDescription" class="form-group edit-campaign hide">

						<label for="inputCampDescription" class="sr-only">Descrição Presente</label>
						<div class="text-area-box">
							<textarea id = "inputCampDescription" name = "inputCampDescription" class="form-control" placeholder="Escreva em poucas palavras porque você merece ganhar esse presente. Seja convincente!"></textarea>
						</div>

					    <div class="btn-group pull-right" role="group">
					        <button id="save-CampDescription" class="btn btn-success" type="button">
					        	<i class="fa fa-check"></i>
					        </button>
					        <button id="cancel-edit-CampDescription" class="btn btn-default btn-cancel-edit" type="button">
					        	<i class="fa fa-times"></i>
					        </button>
					    </div>
				  	</div>


				</div>

				<div class="row campaign-owner">
					<div class="col-xs-4">
						<div class="row">
							<img id="current-CampOwnerPhoto" class="img-circle profile-picture" src="<?php echo $rs->camp_owner_picture;?>">

							<div id="form-edit-CampOwnerPhoto" class="form-group edit-campaign hide">
								<div>
									<img id="inputCampOwnerPhoto" class="img-circle profile-picture" src="">
								</div>

								<div class="btn-group btn-group-edit-photo" role="group">
							        <button id="save-CampOwnerPhoto" class="btn btn-success" type="button">
							        	<i class="fa fa-check"></i>
							        </button>
							        <button id="cancel-edit-CampOwnerPhoto" class="btn btn-default btn-cancel-edit" type="button">
							        	<i class="fa fa-times"></i>
							        </button>
							    </div>
							</div>

							<p id="current-CampOwnerName"><?php echo $rs->camp_owner;?></p>
							<p>
								<a id="edit-CampOwnerName" class="link-edit edit-area" href="#">Alterar Nome</a>
							</p>

							<div id="form-edit-CampOwnerName" class="form-group edit-campaign hide" action="edit-campaign" method="post">
								<label for="inputCampOwnerName" class="sr-only">Nome Receptor</label>
								<div class="text-area-box">
							      <input id = "inputCampOwnerName" name = "inputCampOwnerName" type="text" class="form-control" placeholder="Insira seu Nome..." value="João Oliveira Neto" autocomplete="off">
							    </div><!-- /input-group -->

								<div class="btn-group pull-right" role="group">
							        <button id="save-CampOwnerName" class="btn btn-success" type="button">
							        	<i class="fa fa-check"></i>
							        </button>
							        <button id="cancel-edit-CampOwnerName" class="btn btn-default btn-cancel-edit" type="button">
							        	<i class="fa fa-times"></i>
							        </button>
							    </div>
						  	</div>

							<p class="edit-area">
								<small>
									Alterar Foto de Perfil
								</small>
								<small><input id="edit-CampOwnerPhoto" type="file"></small>
							</p>
						</div>
					</div>



					<div class="col-xs-8 share-campaign-area">
						<div class="row">
							<div class="col-sm-4 share-campaign-element">
								<div class="fb-share-button" data-href="<?php tiny_site_url();?>" data-layout="box_count">

								</div>
							</div>
							<div class="col-sm-2 share-campaign-element">
								<a
									class="twitter-share-button"
								  	href="https://twitter.com/share"
								  	data-text="Gostaria de ganhar este presente."
								  	data-count="vertical"
								  	data-lang="pt-BR"
								  	data-url=  <?php tiny_site_url();?>
								  >
								Tweet
								</a>
								<script>
								window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return t;js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,"script","twitter-wjs"));
								</script>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4 share-campaign-element">
								<!-- Place this tag in your head or just before your close body tag. -->
								<script src="https://apis.google.com/js/platform.js" async defer>
								  {lang: 'pt-BR'}
								</script>

								<!-- Place this tag where you want the share button to render. -->
								<div class="g-plus" data-action="share" data-annotation="vertical-bubble" data-height="60" data-href="<?php tiny_site_url();?>">
								</div>


							</div>
							<div class="col-sm-7 share-campaign-element">
								<div  id = "short-url-text" class="row bubble-short-link"><?php tiny_site_url();?></div>
								<div class="row short-link-badge">
									<a id = "select-short-url" href="#" class="label label-default" title="Click para selecionar Link Curto. Após seleçao, usar Ctrl + C para copiar o link no portapapel.">
										<i class="fa fa-link"></i> Link Curto
									</a>
								</div>
							</div>
						</div>


					</div>
				</div>

			</div>
			<div class="col-md-5"> <!-- Right Pane -->
				<div class="row campaign-list-right">
					<div class="thumbnail">
			          <div class = "campaign-values">
			          	<div class="row">
				          	<div class = "col-xs-6 price-title">
								<h4>Preço</h4>
				          	</div>
				          	<div class = "col-xs-6 edit-price">
								<a id="edit-CampPriceAmount" class="link-edit edit-area" href="#">Alterar</a>
				          	</div>
				        </div>
			            <div class="form-edit">
				            <div id="current-CampPriceAmount" class="price-amount">
				            	<span class="currency" data-a-sign="R$ " data-aSep ="." data-aDec =","><?php echo $rs->camp_goal;?></span>
				            </div>

							<div id="form-edit-CampPriceAmount" class="form-group edit-campaign hide">
								<div class="input-group">
							      <label for="inputCampPriceAmount" class="sr-only">Preço</label>
							      <input id = "inputCampPriceAmount" name = "inputCampPriceAmount" type="text" class="form-control currency" placeholder="Insira um valor..." value="">
							      <span id="buttonsetCampPriceAmount" class="input-group-btn">
							        <button id="save-CampPriceAmount" class="btn btn-success" type="button">
							        	<i class="fa fa-check"></i>
							        </button>
							        <button id="cancel-edit-CampPriceAmount" class="btn btn-default btn-cancel-edit" type="button">
							        	<i class="fa fa-times"></i>
							        </button>
							      </span>
							    </div><!-- /input-group -->
						  	</div>
						</div>


			            <div class="progress campaign-progress">
			              <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $rs->camp_completed;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $rs->camp_completed;?>%;">
			                <span class="sr-only"><?php echo $rs->camp_completed;?>% Completo</span>
			              </div>
			            </div>
			            <div class="campaign-progress-info-area">
				            <div class="campaign-progress-info"><?php echo $rs->camp_completed;?>% completo com</div>
				            <div class="campaign-progress-info">
				            	<span class="cyan-title currency" data-a-sign="R$ " data-aSep ="." data-aDec =","><?php echo $rs->camp_collected;?></span> presenteados
				            </div>

				            </span>
			            </div>
			        </div>
	            </div>

				</div>
				<div class="row campaign-list-right">
					<div class="thumbnail">
						<div class = "campaign-values">
			              <p>Presentei com</p>

			              	<form class="" role="form">
				                <div class="contribute-form-area">
				                    <div class="form-group">
					                    <div class="input-group text-area-box">
											<input type="text" class="form-control currency" id="inputContribute" name = "inputContribute" placeholder="R$50, R$ 100, R$ 200" value="">
					              		</div><!-- /input-group -->
				              		</div>
				                </div>
				            </form>

			              <a class="btn btn-header-options btn-contribute-now" href="#">Presentear Agora!</a>
			        	</div>
		            </div>
				</div>
			</div>
		</div>

	</form>

	<div class="row">	<!-- Alert Pane -->
		<div class="col-md-7 contribution-log"> <!-- Right Pane -->


			<hr class="grey-line">

			<div class="row alert alert-default" role="alert">
				Um presente de <span class="hightlight-red">R$ 100,00</span> foi adicionado por Vô Antonio
			</div>
			<div class="row alert alert-default" role="alert">
				Um presente de <span class="hightlight-red">R$ 200,00</span> foi adicionado por Mamãe
			</div>
			<div class="row alert alert-default" role="alert">
				Um presente de <span class="hightlight-red">R$ 300,00</span> foi adicionado por Carlinho
			</div>
			<div class="row alert alert-default" role="alert">
				Um presente de <span class="hightlight-red">R$ 50,00</span> foi adicionado por Anônimo
			</div>
			<div class="row alert alert-default" role="alert">
				Um presente de <span class="hightlight-red">R$ 20,00</span> foi adicionado por Anônimo
			</div>
			<div class="row alert alert-default" role="alert">
				Um presente de <span class="hightlight-red">R$ 300,00</span> foi adicionado por Tia Clô
			</div>
			<div class="row alert alert-default" role="alert">
				Um presente de <span class="hightlight-red">R$ 300,00</span> foi adicionado por Tia Zefa
			</div>

		</div>	<!-- Left Pane -->

		<div class="col-md-5 comments-area"> <!-- Right Pane -->

			<div class="row">
				<div class="row alert alert-hightlight hightlight-red alert-dismissible alert-comments" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<button type="button" class="close next" aria-label="Seguinte">
						<span aria-hidden="true">+</span>
					</button>
					<p align="justify">
						Parabéns anticipado, man!
						Dei uma forcinha aí e espero que você alcance o PS4!!
						Abraço!!!
					</p>
					<p align="right">
						Cadu
					</p>
				</div>


			</div>

			<div class="row next-campaign-comment">
				<p align="justify">
					João meu sobrinho querido.
					Nem acredito que você está fazendo 15 anos.
					Como o tempo passa!
					Estou morrendo de saudade de você e quero te desejar um excelente aniversário e que você alcance tudo o que sempre sonhou.
					Um beijo de sua tia que te ama muito!
				</p>
				<p align="right">
					Tia Zefa.
				</p>
			</div>


		</div>
	</div> <!-- Right Pane -->


</div>