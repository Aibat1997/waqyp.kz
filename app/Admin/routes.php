<?php

Route::get('', ['as' => 'admin.dashboard', function () {
	$content = 'Добро пожаловать';
	return AdminSection::view($content, 'Админка');
}]);

Route::get('information', ['as' => 'admin.information', function () {
	$content = 'BG PRO company';
	return AdminSection::view($content, 'Иняормация');
}]);
