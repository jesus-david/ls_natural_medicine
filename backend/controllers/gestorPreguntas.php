<?php 
if(!isset($_SESSION)){ 
    session_start(); 
} 
class GestorPreguntasController{

	public static function jsonPreguntas(){

        $preguntas = GestorPreguntasModel::jsonPreguntas();
     
		return $preguntas;

    }
    
    public static function clientes(){

        $clientes = GestorPreguntasModel::clientes();
     
		return $clientes;

    }


    public static function borrar_lista(){
        $lista = $_POST["lista"];
        return GestorPreguntasModel::borrar_lista($lista);
    
    }

    //sin uso
    public static function actualizar_estados(){
        $lista = $_POST["lista"];
        $estado = $_POST["estado"];
        return GestorProductosModel::actualizar_estados($lista, $estado);
    
    }

    public static function answer(){

		$info = GestorPreguntasModel::answer();
		$id_p = $info["id_producto"];
		$info_x = GestorProductosController::ver_info_producto($id_p);
		$host = $_SERVER['HTTP_HOST'];

		$temp2 = '
			<div style="width:100%; background:rgb(1, 174, 146); position:relative; font-family:sans-serif; padding-bottom:40px">

				<div style="position:relative; margin:auto; width:600px; background:white; padding:20px">
				
					<center>
					
						<h3 style="font-weight:100; color:#999">¡Respuesetas!</h3>
				
						<hr style="border:1px solid #ccc; width:80%">
				
						<h4 style="font-weight:100; color:#999; padding:0 20px">se ha respondido a tu pregunta.</h4>

						<div>
							<a href="'.$host.'/'.$info_x["slug"].'" target="_blank">Ver respuesta</a>
						</div>
						
						<br>
				
						<hr style="border:1px solid #ccc; width:80%">
			
					</center>
			
				</div>
			
			</div>
		';


		Email::sendMail($info["cliente"]["email"], $info["cliente"]["nombre"], "Respuesta sobre un producto", $temp2);

		return array("status" => true);
	}
    
}
