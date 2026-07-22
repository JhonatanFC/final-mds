<?php

declare(strict_types=1);

$router->get('/', [HomeController::class, 'index']);

$router->get('/reservar', [ReservaController::class, 'create']);
$router->post('/reservar', [ReservaController::class, 'store']);
$router->get(
    '/reservar/confirmacion',
    [ReservaController::class, 'confirmation']
);

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/dashboard', [HomeController::class, 'dashboard']);

$router->get('/recepcion', [RecepcionController::class, 'index']);
$router->post(
    '/recepcion/revisar-pago',
    [RecepcionController::class, 'reviewPayment']
);
$router->post(
    '/recepcion/confirmar-llegada',
    [RecepcionController::class, 'confirmArrival']
);
$router->get(
    '/recepcion/voucher',
    [RecepcionController::class, 'downloadVoucher']
);

$router->get(
    '/recepcion/solicitudes',
    [RecepcionController::class, 'requests']
);

$router->post(
    '/recepcion/solicitudes/revisar',
    [RecepcionController::class, 'reviewPayment']
);

$router->get('/mesas', [MesaController::class, 'index']);
$router->post('/mesas/guardar', [MesaController::class, 'save']);
$router->post('/mesas/eliminar', [MesaController::class, 'delete']);

$router->get('/productos', [ProductoController::class, 'index']);
$router->post('/productos/guardar', [ProductoController::class, 'saveProduct']);
$router->post('/productos/eliminar', [ProductoController::class, 'deleteProduct']);
$router->post('/categorias/guardar', [ProductoController::class, 'saveCategory']);

$router->get('/pedidos', [PedidoController::class, 'index']);
$router->post('/pedidos/guardar', [PedidoController::class, 'store']);
$router->post('/pedidos/estado', [PedidoController::class, 'updateStatus']);

$router->get('/caja', [CajaController::class, 'index']);
$router->post('/caja/cobrar', [CajaController::class, 'charge']);

$router->get('/gerencia', [GerenciaController::class, 'index']);

$router->get('/reportes', [ReporteController::class, 'index']);

$router->get('/usuarios', [EmpleadoController::class, 'index']);
$router->post('/usuarios/guardar', [EmpleadoController::class, 'store']);
$router->post('/usuarios/estado', [EmpleadoController::class, 'toggleStatus']);

$router->get('/lista-espera', [ListaEsperaController::class, 'index']);
$router->post('/lista-espera/guardar', [ListaEsperaController::class, 'store']);
$router->post('/lista-espera/asignar', [ListaEsperaController::class, 'assign']);
$router->post('/lista-espera/cancelar', [ListaEsperaController::class, 'cancel']);

$router->post('/recepcion/confirmar-llegada', [RecepcionController::class, 'confirmArrival']);
$router->get('/recepcion/solicitudes', [RecepcionController::class, 'requests']);
$router->post('/recepcion/revisar-pago', [RecepcionController::class, 'reviewPayment']);
$router->get('/recepcion/voucher', [RecepcionController::class, 'downloadVoucher']);