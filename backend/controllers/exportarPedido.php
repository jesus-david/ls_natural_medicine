<?php 

class ExportarPedidoController{
    public static function exportar(){
        require_once 'views/vendor/PHPExcel-1.8/Classes/PHPExcel.php';

        $info = GestorPedidosModel::verPedidoExportar();

        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("GROUP IRON ADMINISTRADOR")
                    ->setLastModifiedBy("GROUP IRON")
                    ->setTitle("Office 2007 XLSX Test Document")
                    ->setSubject("Office 2007 XLSX Test Document")
                    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                    ->setKeywords("office 2007 openxml php")
                    ->setCategory("Test result file");


        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)                    
                    ->setCellValue('A1', 'Cliente')
                    ->setCellValue('B1', 'Usuario')
                    ->setCellValue('C1', 'Pedido')
                    ->setCellValue('D1', 'Fecha')
                    ->setCellValue('E1', 'Factura')
                    ->setCellValue('F1', 'Productos')    
                    ->setCellValue('G1', 'Empresa')                    
                    ->setCellValue('H1', 'Cógido producto')                   
                    ->setCellValue('I1', 'Precio de venta')
                    ->setCellValue('J1', 'Cantidad')
                    ->setCellValue('K1', 'Total');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);  
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15); 


        if ($info["only"]) {
            $cliente = $info["pedido"]["cliente"];

            $numeroPedido = $info["pedido"]["numero_pedido"];

            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A2", $cliente["nombre"])
                        ->setCellValue("A3", "Descuento 1: " . $info["pedido"]["descuento1"] . "%")
                        ->setCellValue("B2", $numeroPedido)
                        ->setCellValue("C2", $info["pedido"]["fecha"]);
            $fila = 2;
            for ($i=0; $i < count($info["pedido"]["items"]); $i++) { 
                $item = $info["pedido"]["items"][$i];
                $producto = GestorPedidosModel::verProducto($item["id_producto"]);

                // echo "EL NOMBRE " . $item["nombre"];
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("D$fila", $item["nombre"])                        
                        ->setCellValue("E$fila", $producto["codigo"])
                        ->setCellValue("F$fila", $item["text_precio_actual"])
                        ->setCellValue("G$fila", $item["precio_actual"])
                        ->setCellValue("H$fila", $item["cantidad"])
                        ->setCellValue("I$fila", $producto["descripcion"])
                        ->setCellValue("J$fila", $item["precio_total"]);

                $fila++;
            }

            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("J$fila", $info["pedido"]["total"]);

            $title = "Pedido #$numeroPedido " . substr($cliente["nombre"],0,15) . "...";
            // echo $title;
            $objPHPExcel->getActiveSheet()->setTitle($title);

        }else{

            $pedidos = $info["pedidos"];
            $linea1 = 2;
            $fila = 2;

            // var_dump($pedidos);
            // echo "<pre>";
            // echo json_encode($pedidos);
            // echo "</pre>";
            for ($j=0; $j < count($pedidos); $j++) { 
                $pedido = $pedidos[$j];

                $cliente = $pedido["cliente"];
                $usuario = $pedido["usuario"];

                $numeroPedido = "#" . $pedido["id"];

                $aMas = $fila + 1;

                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue("A$fila", $cliente["nombre"])
                            ->setCellValue("B$fila", $usuario["usuario"])
                            ->setCellValue("C$fila", $numeroPedido)
                            ->setCellValue("D$fila", $pedido["fecha"])
                            ->setCellValue("E$fila", $pedido["num_factura"]);
                
                for ($i=0; $i < count($pedido["items"]); $i++) { 
                    $item = $pedido["items"][$i];

                    $producto = GestorProductosController::ver_info_producto($item["id_producto"]);

                    // var_dump($producto);

                    if (isset($producto["codigo"])) {
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue("F$fila", $item["nombre"])                        
                            ->setCellValue("G$fila", $producto["empresa"]["nombre"])
                            ->setCellValue("H$fila", $producto["codigo"])
                            ->setCellValue("I$fila", $item["precio_actual"])
                            ->setCellValue("J$fila", $item["cantidad"])
                            ->setCellValue("K$fila",  $item["precio_total"]);
                    }else{
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue("F$fila", "No se ha encontrado el producto, puede que se haya borrado.");    
                    }
                    

                    $fila++;
                }

                if (count($pedido["items"]) == 0) {
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue("F$fila", "No se han encontrado productos para este pedido.");
                }else{
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue("K$fila", $pedido["total"]);
                }

                

                if (count($pedidos) == 1) {
                    $title = "$numeroPedido Pedidos Grupo Iron";
                }else {
                    $title = "Pedidos Grupo Iron";
                }
                
                $objPHPExcel->getActiveSheet()->setTitle($title);

                $fila = $fila + 2;

                $linea1++;
            }

        }

        


        $objPHPExcel->setActiveSheetIndex(0);


        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$title.'.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); 
        header ('Cache-Control: cache, must-revalidate'); 
        header ('Pragma: public'); 


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');



    }
}
