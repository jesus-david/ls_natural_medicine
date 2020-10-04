<?php  
	class Consulta extends Conexion{
		public function __construct(){
			parent::__construct();
		}

		public function ver_registros($sql){
			$consulta = $this->conexion->prepare($sql);
			$consulta->execute();
			$resultado = $consulta->fetchAll(PDO::FETCH_BOTH);
			return $resultado;
		}
		public function nuevo_registro($sql){
			try{
				$consulta = $this->conexion->prepare($sql);
				$resultado = $consulta->execute();
				return $resultado;
			}catch(Exception $e){
				die("Ha ocurrido un error al insertar un nuevo registro (" . $e->getLine() . ") " . $e->getMessage());
			}
		}
		public function borrar_registro($sql){
			try{
				$consulta = $this->conexion->prepare($sql);
				$resultado = $consulta->execute();
				return $resultado;
				
			}catch(Exception $e){
				die("Ha ocurrido un error al borrar el registro (" . $e->getLine() . ") " . $e->getMessage());
			}
		}
		public function actualizar_registro($sql){
			try{
				$consulta = $this->conexion->prepare($sql);
				$resultado = $consulta->execute();
				return $resultado;
			}catch(Execption $e){
				die("Ha ocurrido un error al actualizar el registro");
			}
		}
		public function actualizar_registro_bim_param($sql,$array){
			try{
				$consulta = $this->conexion->prepare($sql);
				$resultado = $consulta->execute();
				return $resultado;
			}catch(Execption $e){
				die("Ha ocurrido un error al actualizar el registro");
			}
		}
	}
