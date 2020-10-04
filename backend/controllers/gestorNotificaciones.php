<?php 
if(!isset($_SESSION)){ 
    session_start(); 
} 
class GestorNotificacionesController{

    public static function crear_notificacion($usuario, $tipo, $titulo, $link){
        $base_url = "https://consultpro.com.ve/routes.app/";
        $resp = GestorNotificacionesModel::crear_notificacion($usuario, $tipo, $titulo, $link);
        $tag_db = $resp["tag"];
        if (isset($tag_db[0])) {

            $info = array(
                "titulo" => "",
                "mensaje" => $titulo,
                "link" => $base_url . $link,
                'link_short' => $link,
                "id" => $resp["id"],
                "fecha" => GestorNotificacionesController::ago(date("Y-m-d H:i:s"))

            );
            
            $tag_ = $tag_db[0]["tag_on_signal"];
            if ($tag_ != "") {

                $sres = GestorNotificacionesController::mandar_notificacion($info, $tag_);

                // var_dump($sres);
            }
            
        }
        

        return true;

    }

    public static function mandar_notificacion($info, $tag_){
                
        $response = GestorNotificacionesController::sendMessage($info, $tag_);
        
        
        return $response;
    }

    public static function sendMessage($info, $tag_) {
        $content      = array(
            "en" => $info["mensaje"]
        );
        $heading  = array(
            "en" => $info["titulo"]
        );
    
        $fields = array(
            'app_id' => "70e58c09-5c91-45be-9fc8-76d6208998de",
            'filters' => array(
                array("field" => "tag", "key" => "tag_n", "relation" => "=", "value" => $tag_)
            ),
            'data' => $info,
            'contents' => $content,
            'heading' => $heading,
            'url' => $info["link"]
            
        );
        
        $fields = json_encode($fields);
   
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic NWJiYmZlYzItM2ZlOS00ZTExLTgwN2EtNDUyOTFlZTZlZTJk'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        
        return array("resp" => $response, "json" => $fields);
    }


    public static function notificaciones_sin_ver(){
        $notificaciones = GestorNotificacionesModel::notificaciones_sin_ver();

        return $notificaciones;
    }
    public static function notificaciones_vistas(){
        $notificaciones = GestorNotificacionesModel::notificaciones_vistas();

        return $notificaciones;
    }

    public static function notificaciones(){
        $notificaciones = GestorNotificacionesModel::notificaciones();

        return $notificaciones;
    }
    public static function notificacion_vista(){
        $resp = GestorNotificacionesModel::notificacion_vista();

        return $resp;
    }
    public static function guardar_tag(){
        $resp = GestorNotificacionesModel::guardar_tag();

        return $resp;
    }

    public static function borrar_revisadas(){
        $resp = GestorNotificacionesModel::borrar_revisadas();

        return $resp;
    }
    
    public static function ago($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'año',
            'm' => 'mes',
            'w' => 'semana',
            'd' => 'día',
            'h' => 'hora',
            'i' => 'minuto',
            's' => 'segundo',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ?  'Hace ' . implode(', ', $string) : 'justo ahora';
    }
    

}

