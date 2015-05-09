<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

if (!function_exists('make_tiny()')) {

	function make_tiny($url) {
		$ch      = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, 'http://tinyurl.com/api-create.php?url='.$url);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

}

if (!function_exists('tiny_site_url()')) {

	function tiny_site_url() {
		return make_tiny(current_url());
	}

}

if (!function_exists('assets_url()')) {
	function asset_url() {
		return goto_url('/assets');
	}
}

if (!function_exists('goto_url()')) {
	function goto_url($url = '') {
		return base_url($url).'/';
	}
}

if (!function_exists('print_url_module()')) {
	function print_url_module($url, $display_name) {

		$html_url   = '';
		$uri_string = strtolower(uri_string().'/');

		$controller_name = substr($uri_string, 0, stripos($uri_string, '/'));
		$controller_url  = str_replace('dashboard/view/', '', $url);
		$controller_url  = substr($uri_string, 0, stripos($controller_url, '/'));

		if ($url == $uri_string || $controller_name == $controller_url) {
			$html_url = '<span class="menu-selected">'.$display_name.'</span>';
		} else {
			$html_url = '<a href="'.goto_url($url).'">'.$display_name.'</a>';
		}

		return $html_url;

	}
}

if (!function_exists('print_url_module_mobile()')) {
	function print_url_module_mobile($url, $display_name) {

		$html_url   = '';
		$uri_string = strtolower(uri_string().'/');

		$controller_name = substr($uri_string, 0, stripos($uri_string, '/'));
		$controller_url  = str_replace('dashboard/view/', '', $url);
		$controller_url  = substr($uri_string, 0, stripos($controller_url, '/'));

		$html_url = '<a href="'.goto_url($url).'">'.$display_name.'</a>';

		return $html_url;

	}
}

if (!function_exists('print_crud_button()')) {
	function print_crud_button($id, $canedit = true) {

		$html_permissions = '';
		$current_url      = current_url();
		$module           = strstr($current_url, 'dashboard/view/');
		$controller       = str_replace('dashboard/view/', '', $module);
		$edit             = $controller.'/edit/'.strval($id);
		$delete           = $controller.'/delete/'.strval($id);

		$html_permissions = $controller == 'users'?
		'<li><a href="'.goto_url($controller.'/permissions/'.strval($id)).'">Acessos</a></li>':'';

		$html_crud = $canedit?'
		      <li><a href="'.goto_url($edit).'">Alterar</a></li>
		      <li><a id="linkdelete" data-info="'.goto_url($delete).'" href="#" class = "delete-operation" data-backdrop="static" >Deletar</a></li>
		 ':'';

		if ($html_permissions == '' && $html_crud == '') {
			return '';
		} else {
			return
			'<div class="btn-group" role="group">
			    <button type="button" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			      <span class="caret"></span>
			    </button>
			    <ul class="dropdown-menu dropdown-menu-right" role="menu">
			      '.$html_crud.'
			      '.$html_permissions.'
			    </ul>
			 </div>
			 ';
		}

	}
}

if (!function_exists('load_view()')) {
	function load_view($controller, $view_name = '', $rs = null) {

		$view_name = strtolower($view_name);

		if (uri_string() == 'dashboard/view/dashboard') {
			redirect(goto_url($view_name));
		} else {

			if ($view_name == '' || $view_name == 'view_dashboard_' || $view_name == 'dashboard') {
				$view_name = 'view_dashboard';
			}

			$check_view_name = str_replace('view_dashboard_', '', $view_name);
			$check_view_name = str_replace('view_crud_', '', $check_view_name);
			$check_view_name = str_replace('users_access', 'users', $check_view_name);

			$check_crud = str_replace($check_view_name, '', $view_name);

			// Get a reference to the controller object
			$CI = get_instance();

			// You may need to load the model if it hasn't been pre-loaded
			$CI->load->model('permissions_model');

			// Call a function of the model
			$current_user = $CI->session->userdata('user');

			if ($current_user) {
				$permission_session = $CI->permissions_model->getPermissionsByUser($current_user["idusers"], true);
				$module_access      = $CI->permissions_model->checkModuleByUser($current_user["idusers"], $check_view_name.'/');
			}

			if (!$module_access && $view_name != 'view_dashboard' || ($check_crud == 'view_crud_' && $module_access[0]->user_role <= 1)) {
				redirect('/dashboard/logout/');
				return;
			}

			$uri_string = uri_string();
			$uri_string .= '/';

			if (count($permission_session) == 1 && $uri_string != $permission_session[0]->url) {
				//exit('ok');
				redirect(goto_url($permission_session[0]->url));
			}

			$controller->load->view('view_header', array('permission_session'  => $permission_session));
			$controller->load->view('view_sidebar', array('permission_session' => $permission_session));

			if ($rs != null) {
				$data = $view_name == 'view_dashboard'?
				array(
					'rs' => $rs,
				):
				array(
					'rs'      => $rs,
					'canedit' => $module_access[0]->user_role > 1,
				);

				$controller->load->view($view_name, $data);
			} else {
				$controller->load->view($view_name);
			}

			/*
			if(strpos($view_name, 'view_crud') !== false )
			$controller->load->view('view_modal_permissions');
			 */

			if (strpos($view_name, 'view_dashboard') !== false) {
				$controller->load->view('view_modal_delete');
			}

			$controller->load->view('view_footer');

		}

	}
}

if (!function_exists('load_modal_html()')) {
	function load_modal_html() {

		echo '
<!-- Modal Dialog -->
<div class="form-horizontal modal fade" id="modalPermissions" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modalTitle">Mercados Autorizadas</h4>
      </div>
      <div class="modal-body">
        <form class="form-inline" role="form">
          <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	            <div class="input-group">
		            <input type="text" class="form-control" id="filterDataPerm" placeholder="Filtrar Mercados">
		            <span class="input-group-btn">
		          		<button class="btn btn-success" type="button">Buscar</button>
		        	</span>
	        	</div>
        	</div>

          </div>

          <div class="form-group">
            <div class="col-md-offset-2 col-md-8" id = "dataPopulated">
	        <!-- Data popuplated here -->
        	</div>

          </div>

        </form>

		  <nav>
		    <ul class="pagination">
		      <li><a href="#"><span aria-hidden="true">«</span><span class="sr-only">Anterior</span></a></li>
		      <li class="active"><span>1 <span class="sr-only">(current)</span></span></li>
		      <li><a href="#">2</a></li>
		      <li><a href="#">3</a></li>
		      <li><a href="#">4</a></li>
		      <li><a href="#">5</a></li>
		      <li><a href="#"><span aria-hidden="true">»</span><span class="sr-only">Seguinte</span></a></li>
		    </ul>
		  </nav>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success">Ok</button>
      </div>
    </div>
  </div>
</div> <!-- Modal Markets-->


			';

	}
}
