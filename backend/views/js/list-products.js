"use strict";

$.ajax({
    url:"views/ajax/jsonProducts.php",
    type: "POST",
    dataType: "JSON"
})
.done((res)=>{
    console.log(res);
})
.fail((error)=>{
    console.log(error);
})

var KTUserListDatatable = (function() {
    var t;
    return {
        init: function() {
            (t = $("#kt_apps_products_list_datatable").KTDatatable({
                data: {
                    type: "remote",
                    source: {
                        read: {
                            url: "views/ajax/jsonProducts.php"
                        }
                    },
                    pageSize: 10,
                    serverPaging: !1,
                    serverFiltering: !0,
                    serverSorting: !0
                },
                layout: { scroll: !1, footer: !1 },
                sortable: !0,
                pagination: !0,
                search: {  },
                columns: [
                    {
                        field: "id",
                        title: "#",
                        sortable: !1,
                        width: 20,
                        selector: { class: "kt-checkbox--solid" },
                        textAlign: "center"
                    },
                    {
                        field: "imagen",
                        title: "Imagen",
                        width: 115,
                        template: function(t, e) {
                            var strP = ""
                            if (t.oferta != 0.00) {
                                strP  = `<span class="line-th">$${t.precio}</span> - <span>$${t.oferta}</span>`
                            }else{
                                strP  = `<span>$${t.precio}</span>`
                            }

                            var n = (t.CompanyAgent.length > 10) ? t.CompanyAgent.slice(0,10) + ".." : t.CompanyAgent

                            return `
                                <div class="kt-user-card-v2 phone-list">  
                                    <a href="detailsProduct_${t.id}">
                                        <img src="${t.imagen}" alt="photo">
                                        <div class="phone-list-item">
                                            <div class="hide-name"><b>${n}</b></div>
                                            <div class="hide-price">${strP}</div>
                                        </div>
                                    </a>
                                </div>
                            `;
                        }
                    },
                    {
                        field: "CompanyAgent",
                        title: "Nombre",
                        width: 150,
                        template: function(t, e) {
                            for (var a = 4 + e; a > 12; ) a -= 3;

                            return `
                                <div class="kt-user-card-v2"> 
                                    <div class="kt-user-card-v2__details">
                                        <a href="detailsProduct_${t.id}" class="kt-user-card-v2__name">
                                            ${t.CompanyAgent}
                                        </a>
                                        <span class="kt-user-card-v2__desc"></span>
                                    </div>
                                </div>
                            `;
                        }
                    },
                    {
                        field: "precio",
                        title: "Precio",
                        width: 60,
                        template: function(t) {
                            return "$" + t.precio;
                        }
                    },
                    {
                        field: "oferta",
                        title: "Oferta",
                        width: 60,
                        template: function(t) {
                            return "$" + t.oferta;
                        }
                    },
                    {
                        field: "codigo",
                        title: "Código",
                        width: 60,
                        template: function(t) {
                            return t.codigo;
                        }
                    },
                    {
                        field: "inventario",
                        title: "Inventario",
                        width: 60,
                        template: function(t) {
                            if (t.inventario > 0) {
                                return  `
                                    <span class="btn btn-bold btn-sm btn-font-sm  btn-label-success">
                                        ${t.inventario}
                                    </span>
                                `
                            }else{
                                return  `
                                <span class="btn btn-bold btn-sm btn-font-sm  btn-label-danger">
                                    ${t.inventario}
                                </span>
                            `
                            }
                        }
                    },
                    {
                        field: "estado",
                        title: "Estado",
                        width: 100,
                        template: function(t) {
                            var e = {
                                1: {
                                    title: "Activo",
                                    class: " btn-label-brand"
                                },
                                0: {
                                    title: "Bloqueado",
                                    class: " btn-label-danger"
                                }
                            };
                            return (
                                '<span class="btn btn-bold btn-sm btn-font-sm ' +
                                e[t.estado].class +
                                '">' +
                                e[t.estado].title +
                                "</span>"
                            );
                        }
                    },
                    
                    {
                        field: "descripcion",
                        title: "Descripción",
                        template: function(t) {
                            return t.descripcion;
                        }
                    },
                    {
                        field: "Actions",
                        width: 80,
                        title: "Acciones",
                        sortable: !1,
                        autoHide: !1,
                        overflow: "visible",
                        template: function(t) {
                            return `
                            <div class="dropdown">
                                <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">
                                    <i class="flaticon-more-1"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="kt-nav">
                                        <li class="kt-nav__item">
                                            <a href="detailsProduct_${t.id}" class="kt-nav__link">
                                                <i class="kt-nav__link-icon flaticon-eye"></i>
                                                <span class="kt-nav__link-text">Ver detalles</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="editProduct_${t.id}" class="kt-nav__link">
                                                <i class="kt-nav__link-icon flaticon2-contract"></i>
                                                <span class="kt-nav__link-text">Editar</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link borrarProducto" data-id="${t.id}">
                                                <i class="kt-nav__link-icon flaticon2-trash"></i>
                                                <span class="kt-nav__link-text">Borrar</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            `;
                        }
                    }
                ]
            })),
                $("#kt_form_status").on("change", function() {
                    t.search(
                        $(this)
                            .val()
                            .toLowerCase(),
                        "Status"
                    );
                }),
                t.on(
                    "kt-datatable--on-check kt-datatable--on-uncheck kt-datatable--on-layout-updated",
                    function(e) {
                        var a = t.rows(".kt-datatable__row--active").nodes()
                            .length;
                        var x = t.rows(".kt-datatable__row").nodes().length
                        $("#kt_subheader_total").html(x + " Total")
                        $("#kt_subheader_group_selected_rows").html(a),
                            a > 0
                                ? ($("#kt_subheader_search").addClass(
                                      "kt-hidden"
                                  ),
                                  $("#kt_subheader_group_actions").removeClass(
                                      "kt-hidden"
                                  ))
                                : ($("#kt_subheader_search").removeClass(
                                      "kt-hidden"
                                  ),
                                  $("#kt_subheader_group_actions").addClass(
                                      "kt-hidden"
                                  ));
                    }
                ),
                $("#kt_datatable_records_fetch_modal")
                    .on("show.bs.modal", function(e) {
                        var a = new KTDialog({
                            type: "loader",
                            placement: "top center",
                            message: "Loading ..."
                        });
                        a.show(),
                            setTimeout(function() {
                                a.hide();
                            }, 1e3);
                        for (
                            var n = t
                                    .rows(".kt-datatable__row--active")
                                    .nodes()
                                    .find(
                                        '.kt-checkbox--single > [type="checkbox"]'
                                    )
                                    .map(function(t, e) {
                                        return $(e).val();
                                    }),
                                s = document.createDocumentFragment(),
                                l = 0;
                            l < n.length;
                            l++
                        ) {
                            var i = document.createElement("li");
                            i.setAttribute("data-id", n[l]),
                                (i.innerHTML = "Selected record ID: " + n[l]),
                                s.appendChild(i);
                        }
                        $(e.target)
                            .find("#kt_apps_user_fetch_records_selected")
                            .append(s);
                    })
                    .on("hide.bs.modal", function(t) {
                        $(t.target)
                            .find("#kt_apps_user_fetch_records_selected")
                            .empty();
                    }),

                // actualizar estado
                $("#kt_subheader_group_actions_status_change").on(
                    "click",
                    "[data-toggle='status-change']",
                    function() {
                        var e = $(this)
                                .find(".kt-nav__link-text")
                                .attr("data-change")
                        var eType = $(this)
                            .find(".kt-nav__link-text")
                            .attr("data-inputT")
                        var eText = $(this)
                            .find(".kt-nav__link-text")
                            .attr("data-text")
                        var a = t
                                .rows(".kt-datatable__row--active")
                                .nodes()
                                .find(
                                    '.kt-checkbox--single > [type="checkbox"]'
                                )
                                .map(function(t, e) {
                                    return $(e).val();
                                });
                        var text = eType != undefined ? "Tipo" : "Estado"
                        
                        a.length > 0 &&
                            swal
                                .fire({
                                    buttonsStyling: !1,
                                    html:
                                        `
                                        ¿Estás seguro de actualizar ${a.length} productos/s a el ${text} de ${eText}?`,
                                    type: "info",
                                    confirmButtonText: "¡Sí, Actualizar!",
                                    confirmButtonClass:
                                        "btn btn-sm btn-bold btn-brand",
                                    showCancelButton: !0,
                                    cancelButtonText: "No, cancelar",
                                    cancelButtonClass:
                                        "btn btn-sm btn-bold btn-default"
                                })
                                .then(function(t) {

                                    if (t.value) {

                                      
                                        var datos = {
                                            actualizar_estados: true,
                                            estado: e,
                                            lista: a.toArray()
                                        }

                                        ajax.peticion("normal",datos,"views/ajax/gestorProductos.php")
                                            .then((res)=>{
                                                console.log(res)
                                                if (res.status == "ok") {
                                                    util.alertSuccess("¡Actualizado!", "¡Se ha cambiado el estado a los productos seleccionados!", "products")
                                                    
                                                }else{
                                                    util.alertError("Error", res.message)
                                                }
                                            },(error)=>{
                                                console.log(error)
                                            })

                                        
                                    }else{
                                        swal.fire({
                                            title: "Cancelado",
                                            text:
                                                "¡No se ha actualizado el estado!",
                                            type: "error",
                                            buttonsStyling: !1,
                                            confirmButtonText: "OK",
                                            confirmButtonClass:
                                                "btn btn-sm btn-bold btn-brand"
                                        });
                                    }
                                          
                                });
                    }
                ),
                // Borrar selección
                $("#kt_subheader_group_actions_delete_all").on(
                    "click",
                    function() {
                        var e = t
                            .rows(".kt-datatable__row--active")
                            .nodes()
                            .find('.kt-checkbox--single > [type="checkbox"]')
                            .map(function(t, e) {
                                return $(e).val();
                            });
                        e.length > 0 &&
                            swal
                                .fire({
                                    buttonsStyling: !1,
                                    text:
                                        "¿Estás seguro de borrar " +
                                        e.length +
                                        " producto/s seleccionado/s? Esto afectará los pedidos donde estén los productos.",
                                    type: "error",
                                    confirmButtonText: "Sí, borrar!",
                                    confirmButtonClass:
                                        "btn btn-sm btn-bold btn-danger",
                                    showCancelButton: !0,
                                    cancelButtonText: "No, cancelar",
                                    cancelButtonClass:
                                        "btn btn-sm btn-bold btn-brand"
                                })
                                .then(function(t) {
                                    if (t.value) {

                                        var datos = {
                                            borrar_lista_productos: true,
                                            lista: e.toArray()
                                        }

                                        ajax.peticion("normal",datos,"views/ajax/gestorProductos.php")
                                            .then((res)=>{                                                
                                                console.log(res)
                                                if (res.status == "ok") {
                                                    swal.fire({
                                                        title: "¡Borrado!",
                                                        text:
                                                            "¡Los productos seleccionados han sido borrados! :(",
                                                        type: "success",
                                                        buttonsStyling: !1,
                                                        confirmButtonText: "OK",
                                                        confirmButtonClass:
                                                            "btn btn-sm btn-bold btn-brand"
                                                    }).then(()=>{
                                                        window.location.reload()
                                                    })
                                                }else{
                                                    util.alertError("Error", res.message)
                                                }
                                                
                                            },(error)=>{
                                                console.log(error)
                                            })

                                        
                                    }else{
                                        swal.fire({
                                            title: "Cancelado",
                                            text:
                                                "¡Los productos seleccionados no han sido borrados! :)",
                                            type: "error",
                                            buttonsStyling: !1,
                                            confirmButtonText: "OK",
                                            confirmButtonClass:
                                                "btn btn-sm btn-bold btn-brand"
                                        })
                                    }
                                });
                    }
                ),
                // Agregar al pedido
                $("#agregar_a_pedido").on(
                    "click",
                    function() {
                        var e = t
                            .rows(".kt-datatable__row--active")
                            .nodes()
                            .find('.kt-checkbox--single > [type="checkbox"]')
                            .map(function(t, e) {
                                return $(e).val();
                            });

                        var datos = {
                            agregar_lista_pedido: true,
                            lista: e.toArray()
                        }

                        console.log(datos);

                        ajax.peticion("normal",datos,"views/ajax/gestorPedidos.php")
                            .then((res)=>{                                                
                                console.log(res)
                                if (res.status == "ok") {
                                    util.alertSuccess("Realizado", "Agregado al pedido")
                                }else{
                                    util.alertError("Error", res.message)
                                }
                                
                            },(error)=>{
                                console.log(error)
                            })
                        
                    }
                ),
                t.on("kt-datatable--on-layout-updated", function() {
                    console.log("EVENTO");
                    $(".borrarProducto").unbind()
                    $(".borrarProducto").bind("click",function(e){
                        e.preventDefault()
                        var idBorrar = $(this).attr("data-id")
                        swal.fire({
                                buttonsStyling: !1,
                                text:
                                    "¿Estás seguro de borrar a este producto? Esto afectará los pedidos donde estén los productos.",
                                type: "error",
                                confirmButtonText: "Sí, borrar!",
                                confirmButtonClass:
                                    "btn btn-sm btn-bold btn-danger",
                                showCancelButton: !0,
                                cancelButtonText: "No, cancelar",
                                cancelButtonClass:
                                    "btn btn-sm btn-bold btn-brand"
                            })
                            .then(function(t) {
                                if (t.value) {
                
                                    var datos = {
                                        borrar_lista_productos: true,
                                        lista: [idBorrar]
                                    }
                
                                    console.log(datos)
                
                                    ajax.peticion("normal",datos,"views/ajax/gestorProductos.php")
                                        .then((res)=>{
                                            console.log(res)
                                            if(res.status == "ok"){
                                                swal.fire({
                                                    title: "¡Borrado!",
                                                    text:
                                                        "¡El producto ha sido borrado! :(",
                                                    type: "success",
                                                    buttonsStyling: !1,
                                                    confirmButtonText: "OK",
                                                    confirmButtonClass:
                                                        "btn btn-sm btn-bold btn-brand"
                                                }).then(()=>{
                                                    window.location.reload()
                                                })
                                            }else{
                                                util.alertError("Error", res.message)
                                            }
                                            
                                        },(error)=>{
                                            console.log(error)
                                        })
                
                                    
                                }else{
                                    swal.fire({
                                        title: "Cancelado",
                                        text:
                                            "¡El producto no ha sido borrado! :)",
                                        type: "error",
                                        buttonsStyling: !1,
                                        confirmButtonText: "OK",
                                        confirmButtonClass:
                                            "btn btn-sm btn-bold btn-brand"
                                    })
                                }
                            });
                    })
                });

                
        }
    };
})();
KTUtil.ready(function() {
    KTUserListDatatable.init();
    
});

function establecerEventos() {}
