<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->add('/', 'utama::login');
$routes->add('/api/(:any)', 'api::$1');
$routes->add('/utama', 'utama::index');
$routes->add('/login', 'utama::login');
$routes->add('/logout', 'utama::logout');
$routes->add('/mposition', 'master\mposition::index');
$routes->add('/mpositionpages', 'master\mpositionpages::index');
$routes->add('/muser', 'master\muser::index');
$routes->add('/muserposition', 'master\muserposition::index');
$routes->add('/mpassword', 'master\mpassword::index');
$routes->add('/midentity', 'master\midentity::index');
$routes->add('/mdepartemen', 'master\mdepartemen::index');
$routes->add('/mjamkerja', 'master\mjamkerja::index');
$routes->add('/mlibur', 'master\mlibur::index');
$routes->add('/mramadlan', 'master\mramadlan::index');
$routes->add('/mcuti', 'master\mcuti::index');
$routes->add('/mtunjangan', 'master\mtunjangan::index');
$routes->add('/mbpjs', 'master\mbpjs::index');
$routes->add('/minventaris', 'master\minventaris::index');
$routes->add('/synchron', 'transaction\synchron::index');
$routes->add('/absen', 'transaction\absen::index');
$routes->add('/gaji', 'transaction\gaji::index');
$routes->add('/lembur', 'transaction\lembur::index');
$routes->add('/mapk', 'master\mapk::index');
$routes->add('/mpositionandroid', 'master\mpositionandroid::index');
$routes->add('/rabsend', 'report\rabsend::index');
