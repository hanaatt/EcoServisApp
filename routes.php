<?php
require_once 'controllers/AuthController.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/DeviceController.php';
require_once 'controllers/ServisiController.php';

$page = $_GET['page'] ?? 'home';

switch ($page) {

    // AUTH
    case 'login':
        (new AuthController())->login();
        break;

    case 'register':
        (new AuthController())->register();
        break;

    case 'logout':
        (new AuthController())->logout();
        break;

    // UREĐAJI
    case 'uredjaji':
        (new DeviceController())->index();
        break;

    case 'dodaj-uredjaj':
        (new DeviceController())->create();
        break;

    // SERVISI – korisnički deo
    case 'prijavi-problem':
        (new ServisiController())->prijavaProblema();
        break;

    case 'moje-prijave':
        (new ServisiController())->userList();
        break;

    // SERVISI – admin deo
    case 'admin-prijave':
        (new ServisiController())->adminList();
        break;

    case 'izmeni-status':
        (new ServisiController())->azurirajStatus();
        break;

    case 'statistika':
        (new ServisiController())->statistika();
        break;

    // ISTORIJA prijave (za korisnika i admina)
    case 'istorija':
        (new ServisiController())->prikaziIstoriju();
        break;

    // DEFAULT - početna strana
    default:
        (new HomeController())->index();
        break;
}
