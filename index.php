<?php

require_once 'model/MP3StreamTitle/Mp3StreamTitle.php';

require_once 'model/entities/entity.m.php';
require_once 'model/entities/song.m.php';
require_once 'model/entities/event.m.php';

require_once 'controller/controller.php';

require_once 'model/functions.m.php';
require_once 'model/config.m.php';

if (file_exists('install')) {
        header('Location: install/');
}


$action = isset($_GET['a']) ? $_GET['a'] : 'history';

$controller = new Controller();

if (method_exists($controller, $action)) {
        $controller->run($action);
}
