<?php 

class ExportarProductosController{
    public static function exportar_minimo(){
        require_once 'views/vendor/PHPExcel-1.8/Classes/PHPExcel.php';

        $productos = GestorProductosModel::jsonProductsMinim();

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
                    ->setCellValue('A1', 'Producto')
                    ->setCellValue('B1', 'Código')
                    ->setCellValue('C1', 'Inventario')
                    ->setCellValue('D1', 'Inventario mínimo');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);  


        $linea1 = 2;
        $fila = 2;

        // var_dump($pedidos);
        // echo "<pre>";
        // echo json_encode($pedidos);
        // echo "</pre>";
        $title = "Productos inventario minimo";
        for ($j=0; $j < count($productos); $j++) { 
            $producto = $productos[$j];



            $aMas = $fila + 1;

            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A$fila", $producto["nombre"])
                        ->setCellValue("B$fila", $producto["codigo"])
                        ->setCellValue("C$fila", $producto["inventario"])
                        ->setCellValue("D$fila", $producto["inventario_minimo"]);

            
            $objPHPExcel->getActiveSheet()->setTitle($title);

            $fila = $fila + 1;

            $linea1++;
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
