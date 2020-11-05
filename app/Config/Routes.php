<?php namespace Config;

use CodeIgniter\Debug\Toolbar\Collectors\Routes;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
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

// =============== ATUR CONTROLLER / AKSES URL ===============
// -----------------------------------------------------------
// $routes->MethodRequest('/urlcontroller','namaController::NamaMethod');

$routes->get('/', 'Pages::index');
$routes->get('/coba','Coba::index');

// === ROUTE Modification ====
// syaratnya harus diperhatikan method controller index dan lainnya
$routes->get('/coba/index','Coba::index');
$routes->get('/coba/about','Coba::about');

// ==================== INFO ROUTE ==========================
// (:num) = angka
// (:alpha) = abcde
// (:alphanum) = abcde+angka
// (:segment) = apapun + /
// (:any) = apapun tnp /
// $routes->get('/coba/(:any)/(:num)', 'Coba::about/$1/$2');
// ==========================================================
$routes->get('/coba/(:any)', 'Coba::about/$1');
$routes->get('/coba/(:any)/(:num)', 'Coba::about/$1/$2');

$routes->get('/users','Admin\Users::index');

$routes->get('/komik/create','Komik::create');
$routes->get('/komik/edit','Komik::edit');
$routes->delete('/komik/(:num)', 'Komik::delete/$1');
$routes->get('/komik/(:any)','Komik::detail/$1');


// ========= ROUTE anon function =======
$routes->get('/test', function (){
	echo "anonymous function ";
});
// _____________________________________
// =====================================


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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
