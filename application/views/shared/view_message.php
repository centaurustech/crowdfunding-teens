<div class="container campaign-details">
	<h1 class="">Aviso</h1>
	<div class="row">
		<img class="center-block" src="<?php echo base_url('assets/img/'.$msg_img);?>">
	</div>
	<div class="row warning-msg">
<?php foreach ($message as $line) {?>
				<p class="text-center"><?php echo $line;?></p>
	<?php }
?>
		<p class="text-center"><a href="<?php echo $previous_url;?>">Voltar</a></p>
	</div>
</div>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?php echo base_url('assets/js/ie10-viewport-bug-workaround.js');?>"></script>
</body>
</html>