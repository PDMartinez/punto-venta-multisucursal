<?php

// CONTROLADORES
// =======================================================
require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/ciudades.controlador.php";
require_once "controladores/proveedores.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/ventas.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/subcategorias.controlador.php";
require_once "controladores/marcas.controlador.php";
require_once "controladores/perfiles.controlador.php";
require_once "controladores/sucursales.controlador.php";
require_once "controladores/formapagos.controlador.php";
require_once "controladores/funcionarios.controlador.php";
require_once "controladores/remision.controlador.php";
require_once "controladores/cajas.controlador.php";
require_once "controladores/canales.controlador.php";
require_once "controladores/apertura.controlador.php";
require_once "controladores/canalesProductos.controlador.php";
require_once "controladores/descuentosProductos.controlador.php";
require_once "controladores/cuotas.controlador.php";
require_once "controladores/cuentasPagar.controlador.php";
require_once "controladores/gastos.controlador.php";
require_once "controladores/preventas.controlador.php";
require_once "controladores/cuentasCobrar.controlador.php";
require_once "controladores/generarToken.controlador.php";

// ======================================================

// MODELOS

require_once "modelos/usuarios.modelo.php";
require_once "modelos/actualizarVarios.modelo.php";
require_once "modelos/ciudades.modelo.php";
require_once "modelos/proveedores.modelo.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/categorias.modelo.php";
require_once "modelos/subcategorias.modelo.php";
require_once "modelos/marcas.modelo.php";
require_once "modelos/ventas.modelo.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/perfiles.modelo.php";
require_once "modelos/sucursales.modelo.php";
require_once "modelos/formapagos.modelo.php";
require_once "modelos/funcionarios.modelo.php";
require_once "modelos/remision.modelo.php";
require_once "modelos/cajas.modelo.php";
require_once "modelos/canales.modelo.php";
require_once "modelos/apertura.modelo.php";
require_once "modelos/canalesProductos.modelo.php";
require_once "modelos/descuentosProductos.modelo.php";
require_once "modelos/cuotas.modelo.php";
require_once "modelos/cuentasPagar.modelo.php";
require_once "modelos/gastos.modelo.php";
require_once "modelos/preventas.modelo.php";
require_once "modelos/cuentasCobrar.modelo.php";
require_once "modelos/generarToken.modelo.php";
// ================================================
$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();