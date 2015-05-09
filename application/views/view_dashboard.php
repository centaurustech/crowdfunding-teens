
<h1 class="page-header">Usuario Autenticado</h1>

<div>
Ben-vindo, <?php echo ($current_user);?>
</div>
<div>
<img src="<?php echo ($user_pic);?>" alt="">
</div>

<div>
Clic para <a href="<?php echo base_url('login/logout');?>">sair do sistema</a>
</div>
