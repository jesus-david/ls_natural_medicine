<?php



/* CONTROLLERS */
require_once 'controllers/enlaces.php';
require_once 'controllers/template.php';
require_once 'controllers/gestorCategorias.php';
require_once 'controllers/gestorProductos.php';
require_once 'controllers/gestorPedidos.php';

/* MODELS */
require_once 'models/conexion.php';
require_once 'models/consulta.php';
require_once 'models/enlaces.php';
require_once 'models/gestorCategorias.php';
require_once 'models/gestorProductos.php';
require_once 'models/gestorPedidos.php';


/* OTHERS */



$template = new TemplateController();
$template -> template();