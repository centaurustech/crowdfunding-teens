<script src="<?php echo base_url('assets/js/checkout/checkout-confirm.js');?>"></script>
<div class="checkout-contribution-area">
  <form class= "checkout-contribution-form" method="post" action = "<?php echo base_url('checkout/payment-method/')?>">

      <div class="form-group contrib-value">

        <label for="inputContribValue" class="col-sm-4 control-label">Presentar com</label>

        <div class="col-sm-offset-5 col-sm-3 input-group confirm-contrib-area">
          <input type="text" class="form-control currency" id="inputContribAmount" id="inputContribAmount" placeholder="Insira monto a contribuir..." id="inputContribValue" name="inputContribValue" value="<?php echo $inputValContribute;?>">
          <div class="input-group-addon checkout-right-currency-symbol">BRL</div>
          <input type="hidden" name="inputValContribute" id="inputValContribute" value="<?php echo $inputValContribute;?>">
          <input type="hidden" name="idCampaignContrib" id="idCampaignContrib" value="<?php echo $idCampaignContrib;?>">
        </div>

      </div>


      <div class="form-group contrib-value">
        <label for="inputContribMsg" class="col-sm-4 control-label">Mensagem</label>
        <div class="col-sm-8">
          <textarea id="inputContribMsg" name="inputContribMsg" placeholder="Deixe uma mensagem. Todo mundo gosta de um recado, mesmo seja curto. ;)"></textarea>
        </div>
      </div>


      <div class="form-group">
        <label for="inputSignature" class="col-sm-4 control-label">Assinatura</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" id="inputSignature" name = "inputSignature" placeholder="Assine com seu nome ou apelido">
        </div>
      </div>


      <div class="checkout-contribution-summary">
        <hr class="grey-line">

        <div class="row checkout-contribution-summary-info">

          <div class="col-sm-offset-1 col-sm-3 control-label">
            Total Presenteado:
          </div>
          <div class="col-sm-2">
            <span class="currency contribAmount" data-a-sign="R$ " data-aSep ="." data-aDec =","><?php echo $inputValContribute;?></span>
          </div>
          <div class="col-sm-offset-2 col-sm-2 btn-pay-area">
            <button type="submit" class="btn btn-header-options">Pagar</button>
          </div>
          <div class="col-sm-2">
            <a href="<?php echo base_url('campaigns/details/'.$idCampaignContrib);?>">Voltar</a>
          </div>
        </div>

        <hr class="grey-line">

        <div class="checkbox checkout-options">
          <label>
            <input type="checkbox" id = "chkHideContribValue" name = "chkHideContribValue"> Ocultar valor contribuído para outros usuários
          </label>
        </div>

        <div class="checkbox checkout-options">
          <label>
            <input type="checkbox" id = "chkHideContribName" name = "chkHideContribName"> Ocultar meu nome para outros usuários
          </label>
        </div>

        <div class="col-sm-offset-1 col-sm-10 col-sm-offset-1">
          <div class="preview-label">
              Pevisualização
          </div>

          <div class="row alert alert-default" role="alert">
            Um presente de <span id = "lblContribAmount" class="hightlight-dark-red currency contribAmount" data-a-sign="R$ " data-aSep ="." data-aDec =","><?php echo $inputValContribute;?>"</span> foi adicionado por <span id="lblContribName">Anônimo</span>
          </div>
        </div>

      </div>

  </form>
</div>
