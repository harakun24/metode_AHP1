<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Admin::index');
$routes->group('Admin', function ($routes) {
	$routes->add('proses', 'Admin::prosesLogin', ['as' => 'proses_admin']);
	$routes->add('logout', 'Admin::logout', ['as' => 'logout_admin']);
});
$routes->group('ahp', function ($routes) {
	$routes->add('kriteria', 'Ahp::kriteria', ['as' => 'kriteria']);
	$routes->post('kriteria/tambah', 'Ahp::add_kriteria', ['as' => 'add_kriteria']);
	$routes->add('kriteria/cari/(:num)', 'Ahp::get_kriteria/$1');
	$routes->post('kriteria/edit/(:num)', 'Ahp::edit_kriteria/$1');
	$routes->add('kriteria/hapus/(:num)', 'Ahp::del_kriteria/$1');
	$routes->add('kriteria/nilai', 'Ahp::nilai_kriteria');
	$routes->add('kriteria/update/(:num)/(:any)', 'Ahp::update_nk/$1/$2');

	$routes->add('alternatif', 'Ahp::alternatif', ['as' => 'alternatif']);
	$routes->post('alternatif/tambah', 'Ahp::add_alternatif', ['as' => 'add_alternatif']);
	$routes->add('alternatif/cari/(:num)', 'Ahp::get_alternatif/$1');
	$routes->post('alternatif/edit/(:num)', 'Ahp::edit_alternatif/$1');
	$routes->add('alternatif/hapus/(:num)', 'Ahp::del_alternatif/$1');
	$routes->add('alternatif/nilai', 'Ahp::nilai_alternatif');
	$routes->add('alternatif/update/(:num)/(:any)', 'Ahp::update_na/$1/$2');

	$routes->add('cek_kriteria', 'Ahp::cek_kriteria');
	$routes->add('cek_alternatif', 'Ahp::cek_alter');
	$routes->add('get_nilai/(:num)', 'Ahp::get_nilaiA/$1');
});
/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}