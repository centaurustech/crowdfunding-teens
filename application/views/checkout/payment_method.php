<script src="<?php echo base_url('assets/js/checkout/payment-method.js');?>"></script>
<div class="checkout-contribution-area">
	<form class= "checkout-contribution-form" method="post" action = "<?php echo base_url('checkout/process-payment/')?>">
		<div class="contrib-value-info">
			<div class="row">
				<div class="col-md-4">
					<img class="img-responsive" src="<?php echo $rs->imgurl;?>" class="checkout-campaign-photo">
				</div>
				<div class="col-md-8 contrib-paymant-summary">
					<h3>Resumo do Presente</h3>
					<input type="hidden" name="idCampaignContrib" value="<?php echo $idCampaignContrib;?>">
					<p><?php echo $rs->camp_name;
?> do <?php echo $rs->camp_owner;
?></p>
					<div class="row contrib-payment-info">
						<div class="col-xs-7">
							Seu nome:
						</div>
						<div class="col-xs-4 text-right">
<?php echo $inputSignature;?>
							<input type="hidden" name="inputSignature" value="<?php echo $inputSignature;?>">
							<input type="hidden" name="chkHideContribName" value="<?php echo $chkHideContribName;?>">
							<input type="hidden" name="inputContribMsg" value="<?php echo $inputContribMsg;?>">
						</div>
						<div class="col-xs-7">
							Seu presente:
						</div>
						<div class="col-xs-4 text-right">
							<span><?php echo $inputContribValue;?></span>
							<input type="hidden" name="inputValContribute" value="<?php echo $inputValContribute;?>">
							<input type="hidden" name="chkHideContribValue" value="<?php echo $chkHideContribValue;?>">
						</div>
						<div class="col-xs-7">
							Taxa de conveniência:
						</div>
						<div class="col-xs-4 text-right">
							<span class="currency"><?php echo $payment_info->fee_campaign;?></span>
							<input type="hidden" name="inputFeeContribute" value="<?php echo $payment_info->fee_campaign;?>">
						</div>
					</div>
					<div class="contrib-total-payment hightlight-red">
						<div class="col-xs-7 contrib-total-payment-text">
							Presente Total:
						</div>
						<div class="col-xs-4 contrib-total-payment-value">
							<span class="currency"><?php echo $payment_info->total_payment;?></span>
							<input type="hidden" name="inputTotalPayment" value="<?php echo $payment_info->total_payment;?>">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row contrib-credit-card-info">
			<h2>Pagar com Cartão de Crédito</h2>
			<div class="row form-group">
				<div class="col-md-6 payment-fields-offset">
					<label for="exampleInputEmail1">Titular do Cartão</label>
					<input type="text" class="form-control" id="inputCardHolder" name="inputCardHolder" placeholder="Coloque o titular como aparece no seu cartão de crédito">
				</div>
			</div>
			<div class="row form-group">
				<div class="col-sm-6 payment-fields-offset">
					<label for="exampleInputEmail1">Número do Cartão</label>
					<input type="text" class="form-control" id="inputCreditCardNumber" name="inputCreditCardNumber" placeholder="Insira o número do seua cartão">
				</div>
				<div class="col-sm-6 payment-fields-offset">
					<label>Data de Vencimento</label>
					<div class="row">
						<label for="cboExpireMonth" class="sr-only">Mês Vencimento</label>
						<div class="col-sm-6 payment-fields-offset">
							<select name="cboExpireMonth" id="cboExpireMonth" class="form-control">
								<option value="">-: Mês :-</option>
<?php list_month_name();?>
</select>
						</div>
						<div class="col-sm-4 payment-fields-offset">
							<label for="cboExpireYear" class="sr-only">Ano Vencimento</label>
							<select name="cboExpireYear" id="cboExpireYear" class="form-control">
								<option value="">-: Ano :-</option>
<?php list_future_years();?>
</select>
						</div>
					</div>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-4 payment-fields-offset">
					<label for="exampleInputEmail1">
						CVV / CVC
						<i class="fa fa-question-circle text-info"></i>
					</label>
					<input type="text" class="form-control" id="inputSecurityCode" name="inputSecurityCode" placeholder="Código de Segurança ...">
				</div>
			</div>
			<h2>Endereço de Faturamento do Cartão</h2>
			<div class="row form-group">
				<div class="col-md-6 payment-fields-offset">
					<label for="exampleInputEmail1">País</label>
					<select name="cboCountries" id="cboCountries" class="form-control">
						<option value="">-: Selecione País :-</option>
<?php list_countries();?>
					</select>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-6 payment-fields-offset">
					<label for="inputAddress1">Endereço</label>
					<input type="text" class="form-control" id="inputAddress1" name="inputAddress1" placeholder="Insira Endereço...">
				</div>
				<div class="col-md-5 payment-fields-offset">
					<label for="inputAddress2">Complemento</label>
					<input type="text" class="form-control" id="inputAddress2" name="inputAddress2" placeholder="Insira complemento do endereço...">
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-6 payment-fields-offset">
					<label for="inputCity">Cidade</label>
					<input type="text" class="form-control" id="inputCity" name="inputCity" placeholder="Insira cidade...">
				</div>
				<div class="col-md-3 payment-fields-offset">
					<label for="cboState">Estado</label>
					<select name="cboState" id="cboState" class="form-control">
						<option value="">-: Selecione Estado :-</option>
						<option value="SP">São Paulo</option>
						<option value="RJ">Rio de Janeiro</option>
						<option value="PR">Paraná</option>
					</select>
				</div>
				<div class="col-md-2 payment-fields-offset">
					<label for="inputZipCode">CEP</label>
					<input type="text" class="form-control" id="inputZipCode" name="inputZipCode" placeholder="Insira CEP...">
				</div>
			</div>
		</div>
		<div class="row contrib-btn-pay-area">
			<div class="col-md-offset-7 col-md-5 text-right">
				<button type="submit" class="btn btn-header-options">Efetuar Pagamento</button>
			</div>
		</div>
	</form>
</div>