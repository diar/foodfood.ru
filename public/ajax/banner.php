<?php
	require_once ('../../core/engine.class.php');
	if (!empty($_GET['redirect']) && !empty($_GET['banner']) && is_numeric($_GET['banner'])) {
		if (DB::getCount('city_list','city_latin='.DB::quote($_GET['city']))!=0) {
			DB::update(
				$_GET['city'].'_banners',
				array('hits'=>'hits+1'),'id='.DB::quote($_GET['banner']),false
			);
			Router::setPage($_GET['redirect']);
		}
	}