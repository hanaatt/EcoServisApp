<?php
require_once 'models/Device.php';

class DeviceController {
    public function index() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit();
        }
        $devices = Device::getByUser($_SESSION['user']['id']);
        include 'views/devices/list.php';
    }

    public function create() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $naziv = $_POST['naziv'];
            $model = $_POST['model'];
            $serijski = $_POST['serijski_broj'];
            $korisnik_id = $_SESSION['user']['id'];
            Device::create($naziv, $model, $serijski, $korisnik_id);
            header("Location: index.php?page=uredjaji");
        } else {
            include 'views/devices/add.php';
        }
    }
}
