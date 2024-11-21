<?php

require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";

require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

// Requerir Dompdf
require_once '../../../dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class imprimirFactura
{

  public $codigo;

  public function traerImpresionFactura()
  {

    // TRAEMOS LA INFORMACIÓN DE LA VENTA

    $itemVenta = "codigo";
    $valorVenta = $this->codigo;

    $respuestaVenta = ControladorVentas::ctrMostrarVentas($itemVenta, $valorVenta);

    $fecha = substr($respuestaVenta["fecha"], 0, -8);
    $productos = json_decode($respuestaVenta["productos"], true);
    // $neto = number_format($respuestaVenta["neto"], 2);
    // $impuesto = number_format($respuestaVenta["impuesto"], 2);
    // $total = number_format($respuestaVenta["total"], 2);

    // TRAEMOS LA INFORMACIÓN DEL CLIENTE

    $itemCliente = "id";
    $valorCliente = $respuestaVenta["id_cliente"];

    $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

    // TRAEMOS LA INFORMACIÓN DEL VENDEDOR

    $itemVendedor = "id";
    $valorVendedor = $respuestaVenta["id_vendedor"];

    $respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);

    // Convertir la imagen a base64
    $path = 'images/SVM.png'; // Ruta de la imagen
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

    // Cargamos el contenido del archivo CSS
    $css = file_get_contents('./sty.css'); // Ruta al archivo CSS

    // Creamos un objeto Dompdf
    $dompdf = new Dompdf();
    $dompdf->set_option('isHtml5ParserEnabled', true);
    $dompdf->set_option('isPhpEnabled', true);

    // Construimos el HTML de la factura
    $html = '
        <html>
        <head>
		<title>Factura de ' . $respuestaCliente["nombre"] . ' ' . $fecha . '</title>
            <style>
                ' . $css . '
            </style>
        </head>
        <body>
        <div class="py-4">
      <div class="px-14 py-6">
        <table class="w-full border-collapse border-spacing-0">
          <tbody>
            <tr>
              <td class="w-full align-top">
                <div>
                  <img src="' . $base64 . '" class="h-10" />
                </div>
              </td>

              <td class="align-top">
                <div class="text-sm">
                  <table class="border-collapse border-spacing-0">
                    <tbody>
                      <tr>
                        <td class="border-r pr-4">
                          <div>
                            <p class="whitespace-nowrap text-slate-400 text-right">Fecha</p>
                            <p class="whitespace-nowrap font-bold text-main text-right">' . $fecha . '</p>
                          </div>
                        </td>
                        <td class="pl-4">
                          <div>
                            <p class="whitespace-nowrap text-slate-400 text-right">Nota  #</p>
                            <p class="whitespace-nowrap font-bold text-main text-right">' . $valorVenta . '</p>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
	  <div class="bg-slate-100 px-14 py-6 text-sm">
        <table class="w-full border-collapse border-spacing-0">
          <tbody>
            <tr>
              <td class="w-1/2 align-top">
                <div class="text-sm text-neutral-600">
                  <p class="font-bold">SVM Protección corporativa</p>
                  <p>Tel: (999) 924 8698</p>
                  <p>RFC: CCA110114KB7</p>
                  <p>Calle 35 #354 entre 26 y 28.</p>
                  <p>Col. Emiliano Zapata norte, 97129</p>
                  <p>Mérida, Yucatán, México</p>
                </div>
              </td>
              <td class="w-1/2 align-top text-right">
                <div class="text-sm text-neutral-600">
                <p class = "font-bold"> Cliente</p>
                  <p class="font-bold">' . $respuestaCliente["nombre"] . '</p>
                  <p>E-mail: ' . $respuestaCliente["email"] . '</p>
                  <p>Tel: ' . $respuestaCliente["telefono"] . '</p>
                  <p>RFC: '.$respuestaCliente["documento"].'</p>
                  <p>Dirección: ' . $respuestaCliente["direccion"] . '</p>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
	  <div class="px-14 py-10 text-sm text-neutral-700">
        <table class="w-full border-collapse border-spacing-0">
          <thead>
            <tr>
              <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main" style="width: 100px;">Cantidad</td>
              <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main" style="width: 100px;">Unidad</td>   
              <td class="border-b-2 border-main pb-3 pl-2 font-bold text-main">Descripción</td>
                        
            </tr>
          </thead>
		  <tbody>';
      /*<td class="border-b-2 border-main pb-3 pl-2 text-right font-bold text-main">Precio unitario</td>
			  <td class="border-b-2 border-main pb-3 pl-2 text-right font-bold text-main">Precio</td>
              <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">IVA</td>
              <td class="border-b-2 border-main pb-3 pl-2 text-right font-bold text-main">Subtotal</td>*/

    foreach ($productos as $producto) {
      $html .= '
            <tr>
				<td class="border-b py-3 pl-3 text-center">' . $producto["cantidad"] . '</td>
        <td class="border-b py-3 pl-3 text-center">' . $producto["unidad"] . '</td>
				<td class="border-b py-3 pl-2">' . $producto["descripcion"] . '</td>
       ';
        
            /*<td class="border-b py-3 pl-2 text-right">$' . $producto["precio"] . '</td>
                <td class="border-b py-3 pl-2 text-center">$' . ($producto["precio"] * $producto["cantidad"]) . '</td>
				<td class="border-b py-3 pl-2 text-right">$' . (($producto["precio"] * $producto["cantidad"]) * 0.16) . '</td>
				</td>
              	<td class="border-b py-3 pl-2 text-right">$' . (($producto["precio"] * $producto["cantidad"]) * 1.16) . '</td>
            </tr>*/
    }

    $html .= '
		
			</div>
			

        <footer class="fixed bottom-0 left-0 bg-slate-100 w-full text-neutral-600 text-center text-xs py-3">
          Grupo SVM
          <span class="text-slate-300 px-2">|</span>
          sistemas@gruposvm.com
          <span class="text-slate-300 px-2">|</span>
          <a href="tel:+529992207019">(999) 220 7019</a>
        </footer>
      </div>';

      /*<tr>
              <td colspan="7">
                <table class="w-full border-collapse border-spacing-0">
                  <tbody>
                    <tr>
                      <td class="w-full"></td>
                      <td>
                        <table class="w-full border-collapse border-spacing-0">
                          <tbody>
                            <tr>
                              <td class="border-b p-3">
                                <div class="whitespace-nowrap text-slate-400">Total:</div>
                              </td>
                              <td class="border-b p-3 text-right">
                                <div class="whitespace-nowrap font-bold text-main">$' . $neto . '</div>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-3">
                                <div class="whitespace-nowrap text-slate-400">IVA total:</div>
                              </td>
                              <td class="p-3 text-right">
                                <div class="whitespace-nowrap font-bold text-main">$' . $impuesto . '</div>
                              </td>
                            </tr>
                            <tr>
                              <td class="bg-main p-3">
                                <div class="whitespace-nowrap font-bold text-white">Total:</div>
                              </td>
                              <td class="bg-main p-3 text-right">
                                <div class="whitespace-nowrap font-bold text-white">$' . $total . '</div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr> */

    // Cargar el HTML en Dompdf
    $dompdf->loadHtml($html);

    // (Opcional) Configurar el tamaño del papel y la orientación
    $dompdf->setPaper('A4', 'portrait');

    // Renderizar el PDF
    $dompdf->render();

    // Enviar el PDF al navegador
    $dompdf->stream('Factura '.$respuestaCliente["nombre"].' '.$fecha.'.pdf', array('Attachment' => 0));
  }
}

// Crear una instancia de la clase e imprimir la factura
$factura = new imprimirFactura();
$factura->codigo = $_GET["codigo"];
$factura->traerImpresionFactura();
