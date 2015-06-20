<script src="<?php echo base_url('assets/js/checkout/payment-method.js');?>"></script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s);
js.id = id;
js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.3&appId=349895105208448";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="container confirmation-thanks">
	<h3 class="text-center">Obrigado, <?php echo $rs_contrib->nickname;?> por ajudar o <?php echo $rs_campaign->camp_owner_first_name?> a chegar mais perto do</h3>
	<h3 class="text-center"><span class="cyan-title"><?php echo $rs_campaign->camp_name;
?></span> com <span class="cyan-title currency"><?php echo $rs_contrib->amount;
?></span>!</h3>
</div>
<div class= "checkout-confirmation-form">
<div class="contrib-confirm-value-info">
	<div class="row">
		<div class="col-md-4">
			<img src="<?php echo $rs_campaign->imgurl;?>" class="checkout-campaign-photo">
		</div>
		<div class="col-md-8">
			<h3>Resumo do Presente</h3>
			<p><?php echo $rs_campaign->camp_name;
?> do <?php echo $rs_campaign->camp_owner;
?></p>
			<div class="row contrib-payment-info">
				<div class="col-xs-7">
					Mêtodo de Pagamento:
				</div>
				<div class="col-xs-5 text-right">
					Cartão de Crédito
				</div>
				<div class="col-xs-7">
					Valor Presenteado:
				</div>
				<div class="col-xs-5 text-right">
					<span class="currency"><?php echo $rs_contrib->amount;?></span>
				</div>
				<div class="col-xs-7">
					Taxa de conveniência:
				</div>
				<div class="col-xs-5 text-right">
					<span class="currency"><?php echo $rs_contrib->service_fee;?></span>
				</div>
			</div>
			<div class="contrib-total-payment">
				<div class="col-xs-7 contrib-total-payment-text">
					Presente Total:
				</div>
				<div class="col-xs-5 contrib-total-payment-value">
					<span class="currency"><?php echo $rs_contrib->total_payment;?></span>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div class= "clearfix confirmation-separator"></div>
<div class="checkout-confirmation-form">
<div class="text-center">
	<h4>Compartilhe com seus amigos que você colaborou</h4>
	Quanto mais gentes souber, mais gente ajuda e maior e a chance do <?php echo $rs_campaign->camp_owner;
?> conseguir o <?php echo $rs_campaign->camp_name;
?>
</div>
<div class="row contrib-share-box">
	<div class="col-sm-2 contrib-share-element contrib-share-facebook">
		<div class="fb-share-button" data-href="<?php tiny_site_url();?>" data-layout="button"></div>
	</div>
	<div class="col-sm-2 contrib-share-element contrib-share-twitter">
		<a
			class="twitter-share-button"
			href="https://twitter.com/share"
			data-text="Minha contribuição ṕara este presente."
			data-count="none"
			data-size="large"
			data-lang="pt-BR"
			data-url=  <?php tiny_site_url();?>
			>
			Tweet
		</a>
		<script>
		window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return t;js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,"script","twitter-wjs"));
		</script>
	</div>
	<div class="col-sm-2 contrib-share-element contrib-share-google-plus">
		<!-- Place this tag in your head or just before your close body tag. -->
		<script src="https://apis.google.com/js/platform.js" async defer>
		{lang: 'pt-BR'}
		</script>
		<!-- Place this tag where you want the share button to render. -->
		<div class="g-plus" data-action="share" data-annotation="none" data-height="40" data-href="<?php tiny_site_url();?>">
		</div>
	</div>
	<div class="col-sm-2 contrib-share-element">
		<a href="#" title="Enviar aviso de contribuição por E-Mail">
			<span class="fa-stack fa-lg">
			  <i class="fa fa-circle fa-stack-2x" style="color:#5a5a5a;"></i>
			  <i class="fa fa-envelope-o fa-stack-1x fa-inverse"></i>
			</span>
		</a>
	</div>
	<div class="col-sm-2 contrib-share-element contrib-share-short-link">
		<div  id = "short-url-text" class="row bubble-short-link"><?php tiny_site_url();?></div>
		<a id = "select-short-url" href="#" style="color:#5a5a5a;" title="Click para selecionar Link Curto. Após seleçao, usar Ctrl + C para copiar o link no portapapel.">
			<span class="fa-stack fa-lg">
			  <i class="fa fa-circle fa-stack-2x"></i>
			  <i class="fa fa-link fa-stack-1x fa-inverse"></i>
			</span>
		</a>
	</div>

</div>
</div>
<div class= "clearfix confirmation-bottom"></div>