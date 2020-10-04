<?php  

require_once 'models/conexion.php';
require_once 'models/consulta.php';
require_once 'models/enlaces.php';
require_once './models/gestorConfig.php';
require_once './models/gestorCategorias.php';
require_once './models/gestorUsuarios.php';
require_once './models/gestorProductos.php';
require_once './models/gestorClientes.php';
require_once './models/gestorPedidos.php';
require_once './models/gestorZonas.php';
require_once './models/gestorNotificaciones.php';
require_once './models/gestorEstadisticas.php';



require_once 'controllers/enlaces.php';
require_once 'controllers/template.php';
require_once './controllers/gestorConfig.php';
require_once './controllers/gestorCategorias.php';
require_once './controllers/gestorUsuarios.php';
require_once './controllers/gestorProductos.php';
require_once './controllers/gestorClientes.php';
require_once './controllers/gestorPedidos.php';
require_once './controllers/gestorZonas.php';
require_once './controllers/gestorNotificaciones.php';
require_once './controllers/exportarPedido.php';
require_once './controllers/exportarMinimo.php';




$template = new templateControllers();
$template -> template();
