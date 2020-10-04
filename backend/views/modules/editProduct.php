<?php 
    if(!isset($_SESSION["usuario_validado"])){
        echo "<script> window.location.href = 'login' </script>";
        exit();
    }

    $id = $_GET["id"];

    if ($_SESSION["tipo"] != 0) {
        $resp = GestorConfigController::verficar_usuario("editProduct");
    } 


    $info = GestorProductosController::ver_info_producto($id);

    if (count($info) == 0) {
        echo "<script> window.location.href = 'products' </script>";
    }

    $categorias = GestorCategoriasController::categorias();

    $selectE1 = ($info["estado"] == '1') ? "selected" : "";
    $selectE2 = ($info["estado"] == '0') ? "selected" : "";

    $json_features = json_encode($info["caracteristicas"]);


?>

<span id="features_saved" class="hidden"><?php echo $json_features; ?></span>

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    <a href="products" class="mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect id="bound" x="0" y="0" width="24" height="24" />
                                <path d="M21.4451171,17.7910156 C21.4451171,16.9707031 21.6208984,13.7333984 19.0671874,11.1650391 C17.3484374,9.43652344 14.7761718,9.13671875 11.6999999,9 L11.6999999,4.69307548 C11.6999999,4.27886191 11.3642135,3.94307548 10.9499999,3.94307548 C10.7636897,3.94307548 10.584049,4.01242035 10.4460626,4.13760526 L3.30599678,10.6152626 C2.99921905,10.8935795 2.976147,11.3678924 3.2544639,11.6746702 C3.26907199,11.6907721 3.28437331,11.7062312 3.30032452,11.7210037 L10.4403903,18.333467 C10.7442966,18.6149166 11.2188212,18.596712 11.5002708,18.2928057 C11.628669,18.1541628 11.6999999,17.9721616 11.6999999,17.7831961 L11.6999999,13.5 C13.6531249,13.5537109 15.0443703,13.6779456 16.3083984,14.0800781 C18.1284272,14.6590944 19.5349747,16.3018455 20.5280411,19.0083314 L20.5280247,19.0083374 C20.6363903,19.3036749 20.9175496,19.5 21.2321404,19.5 L21.4499999,19.5 C21.4499999,19.0068359 21.4451171,18.2255859 21.4451171,17.7910156 Z" id="Shape" fill="#000000" fill-rule="nonzero" />
                            </g>
                        </svg>
                    </a>
                    Editar Producto #<?php echo $id;  ?>
                </h3>

                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
    
                
            </div>
            <div class="kt-subheader__toolbar">

                <a href="galery_<?php echo $info['id'] ?>" class="btn btn-label-brand btn-bold">
                    GALERIA
                </a>


            </div>
            
        </div>
    </div>
    <!-- end:: Content Head -->

    <!-- begin:: Content -->
    <div
        class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid"
    >
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__body kt-portlet__body--fit p-2">
                <!--begin::Form-->
                <form class="kt-form" id="actualizarInfoProducto-form">
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Nombre:</label>
                                    <input type="text" class="form-control" name="nombre" value="<?php echo $info["nombre"] ?>">
                                    <input type="hidden" name="id" value="<?php echo $info["id"] ?>">
                                    <span class="form-text text-muted">Por favor agrega el nombre del producto</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Imagen del producto:</label>
                                    <div class="custom-file">
                                        <input type="file" name="imagen" class="custom-file-input" id="">
                                        <label for="" class="custom-file-label">Selecciona una imagen</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Precio:</label>
                                    <input type="text" class="form-control" name="precio" value="<?php echo $info["precio"] ?>">
                                    <span class="form-text text-muted">Por favor agrega el precio del producto</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Oferta:</label>
                                    <input type="text" class="form-control" name="oferta" value="<?php echo $info["oferta"] ?>">
                                    <span class="form-text text-muted">(Opcional)</span>
                                </div>
                            </div>
                            

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label >Fecha final de la oferta</label>
                                    <div class="">
                                        <input type="date" class="form-control"  placeholder="Selecciona la fecha" name="fechaLimiteOferta" value="<?php echo $info["fechaLimiteOferta"] ?>" />
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Inventario:</label>
                                    <input type="text" class="form-control" name="inventario" value="<?php echo $info["inventario"] ?>">
                                    <span class="form-text text-muted">Por favor agrega el inventario del producto</span>
                                </div>
                            </div>


                             <div class="form-group">
                                <button class="btn btn-primary addFeature">Agregar característica</button>

                                <div class="p-3">
                                    <div class="kt-list-timeline__items content_feaures"></div>
                                </div>
                            </div>


                            <div class="form-group p-1">
                                
                                <?php if (count($info["variantes"])) { ?>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h2>Variantes</h2>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="input-group mb-3">
                                                <input type="text" placeholder="Inventario" id="global_stock" class="form-control" aria-describedby="aply_all">
                                        
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button"  id="aply_all" data-id="<?php echo $id ?>">Aplicar a todos</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    

                                    <table id="variantes" class="ui celled table responsive nowrap unstackable" 	style="width:100%">
                                        <thead>
                                            <tr>
                                                <?php foreach ($info["caracteristicas"] as $h) { ?>
                                                    <th><?php echo $h["nombre"] ?></th>
                                                <?php } ?>
                                                <th>Inventario</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($info["variantes"] as $item) { ?>
                                                <tr>
                                                    <?php foreach ($item["values"] as $v) { ?>
                                                        <td>
                                                            <?php echo $v["nombre"] ?>
                                                        </td>
                                                    <?php } ?>
                                                    <td>
                                                        <input type="text" class="form-control mx200 sku_update" data-sku="<?php echo $item['sku'] ?>" value="<?php echo $item['inventario'] ?>">
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            
                                            
                                        </tbody>
                                    </table>
                                <?php } ?>

                            </div>
                           


                            <div class="form-group">
                                <select class="form-control m-select2 kt_select2" id="categorias" multiple="true">
                                    <?php foreach ($categorias as $item): ?>
                                        <option value="<?php echo $item['id'] ?>" <?php echo GestorCategoriasController::selectedC($item, explode(",",$info["categorias"])) ?>>
                                            <?php echo $item['nombre'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="form-text text-muted">Por favor las categorías</span>
                            </div>



                     
                            <div class="form-group">
                                <label>Descripción:</label>
                                <textarea name="descripcion" id="" max="250" class="form-control"><?php echo $info["descripcion"] ?></textarea>
                                <span class="form-text text-muted">(Opcional)</span>
                            </div>
                           
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Código:</label>
                                    <input type="text" class="form-control" name="codigo" value="<?php echo $info["codigo"] ?>">
                                    <span class="form-text text-muted">(Opcional)</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Estado</label>
                                    <select class="form-control m-select2 kt_select2"  name="estado">
                                        <option value="1" <?php echo $selectE1; ?>>Activo</option>
                                        <option value="0" <?php echo $selectE2; ?>>Bloqueado</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <button class="btn btn-primary" id="actualizarInfoProducto">ACTUALIZAR</button>

                            <span class="px-2 message"></span>
                        </div>
                    </div>
                </form>

                <!--end::Form-->
            </div>
        </div>
        <!--end::Portlet-->

        
    </div>
    <!-- end:: Content -->
</div>
