<?php 
    if(!isset($_SESSION["usuario_validado"])){
    
        echo "<script> window.location.href = 'login' </script>";
    
        exit();
    }

    if (!isset($_GET["id"]) || $_GET["id"] == "" ) {
        echo "<script> window.location.href = 'products' </script>";
    
        exit();
    }
    $id_producto = $_GET["id"];

    $info = GestorProductosController::ver_info_producto($id_producto);

    if (count($info) == 0) {
        echo "<script> window.location.href = 'products' </script>";
    }

    $galeria = $info["galeria"];
    $caracteristicas = $info["caracteristicas"];

    $id_empresa = 0;//$info["id_empresa"];
    $rl = "products" ;

?>

<input type="hidden" value="<?php echo $id_producto  ?>" id="id_producto_hidden">

<div class="kt-content kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    <a href="<?php echo $rl ?>" class="mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect id="bound" x="0" y="0" width="24" height="24" />
                                <path d="M21.4451171,17.7910156 C21.4451171,16.9707031 21.6208984,13.7333984 19.0671874,11.1650391 C17.3484374,9.43652344 14.7761718,9.13671875 11.6999999,9 L11.6999999,4.69307548 C11.6999999,4.27886191 11.3642135,3.94307548 10.9499999,3.94307548 C10.7636897,3.94307548 10.584049,4.01242035 10.4460626,4.13760526 L3.30599678,10.6152626 C2.99921905,10.8935795 2.976147,11.3678924 3.2544639,11.6746702 C3.26907199,11.6907721 3.28437331,11.7062312 3.30032452,11.7210037 L10.4403903,18.333467 C10.7442966,18.6149166 11.2188212,18.596712 11.5002708,18.2928057 C11.628669,18.1541628 11.6999999,17.9721616 11.6999999,17.7831961 L11.6999999,13.5 C13.6531249,13.5537109 15.0443703,13.6779456 16.3083984,14.0800781 C18.1284272,14.6590944 19.5349747,16.3018455 20.5280411,19.0083314 L20.5280247,19.0083374 C20.6363903,19.3036749 20.9175496,19.5 21.2321404,19.5 L21.4499999,19.5 C21.4499999,19.0068359 21.4451171,18.2255859 21.4451171,17.7910156 Z" id="Shape" fill="#000000" fill-rule="nonzero" />
                            </g>
                        </svg>
                    </a>
                    Detalles del producto                    
                </h3>

                <span class="kt-subheader__separator kt-subheader__separator--v"
                ></span>
    
            </div>
            <div class="kt-subheader__toolbar">

            </div>
        </div>
    </div>
    <!-- end:: Content Head -->
    <!-- begin:: Content -->
    <div
        class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__body kt-portlet__body--fit p-2">
                <div class="row">
                    <div class="col-md-6 border-bottom">
                        <div class="reveal" >
                            <div class="slides">
                                
                                <?php foreach ($galeria as $file) { ?>

                                    <section style="background-image: url(<?php echo $file['path_media'] ?>);" class="s-slide" data-transition="slide"></section>

                                <?php } ?>
                               
                               
                            </div>
                            <button class="verSlide btn btn-label-brand btn-bold" data-id="<?php echo $id_producto ?>">all</button>
                        </div>
                    </div>
                    <div class="col-md-6 border-bottom">
                        <div class="p-3">
                            <h3 class="kt-infobox__title text-center"><?php echo $info["nombre"] ?></h3>
                            <div class="kt-notes">
                                <div class="kt-notes__items">
                                   
                                    <div class="kt-notes__item kt-notes__item--clean"> 
                                        <div class="kt-notes__media">
                                            <span class="kt-notes__circle"></span>                                
                                        </div>                              
                                        <div class="kt-notes__content"> 
                                            <div class="kt-notes__section">     
                                                <div class="kt-notes__info">
                                                    <a href="#" class="kt-notes__title">
                                                        Precio                                                         
                                                    </a>
                                                </div>
                                            </div>
                                            <span class="kt-notes__body">                                        
                                                <?php echo $info["precio"] ?>
                                            </span>  
                                        </div>                           
                                    </div> 
                                    <div class="kt-notes__item kt-notes__item--clean"> 
                                        <div class="kt-notes__media">
                                            <span class="kt-notes__circle"></span>                                
                                        </div>                              
                                        <div class="kt-notes__content"> 
                                            <div class="kt-notes__section">     
                                                <div class="kt-notes__info">
                                                    <a href="#" class="kt-notes__title">
                                                        Oferta                                                          
                                                    </a>
                                                </div>
                                            </div>
                                            <span class="kt-notes__body"><?php echo $info["oferta"] ?></span>  
                                        </div>                           
                                    </div> 
                                    <div class="kt-notes__item kt-notes__item--clean"> 
                                        <div class="kt-notes__media">
                                            <span class="kt-notes__circle"></span>                                
                                        </div>                              
                                        <div class="kt-notes__content"> 
                                            <div class="kt-notes__section">     
                                                <div class="kt-notes__info">
                                                    <a href="#" class="kt-notes__title">
                                                        Descripción                                                          
                                                    </a>
                                                </div>
                                            </div>
                                            <span class="kt-notes__body"><?php echo $info["descripcion"] ?></span>  
                                        </div>                           
                                    </div> 
                                </div>
                            </div>

                            
                        </div>
                    </div>
                </div>

             
                <div class="p-5 mt-2">
                    <h3 class="mb-3">Características</h3>
                    <div class="row f-18">
                                
                        <?php foreach ($caracteristicas as $item) { ?>
                            <div class="col-md-4 py-3 border">
                                <span class="text-muted-2"><?php echo $item["nombre"] ?>:</span>

                                <?php foreach ($item["childs"] as $child) { ?>
                                    <div class="row">
                                        <div class="col ml-4">
                                            <span><?php echo $child["nombre"] ?></span>
                                        </div>
                                        <div class="col ml-4">
                                            <span><?php echo $child["valor_agregado"] ?></span>
                                        </div>
                                    </div>

                                <?php } ?>

                               
                            </div>

                        <?php } ?>
                                    
                        
                    </div>
                                        
                </div>
               

                
                
            </div>
        </div>
        <!--end::Portlet-->

        
    </div>
    <!-- end:: Content -->
</div>
