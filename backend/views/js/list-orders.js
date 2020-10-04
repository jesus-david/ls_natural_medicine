"use strict";

$.ajax({
    url:"views/ajax/jsonOrders.php",
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
            (t = $("#kt_apps_orders_list_datatable").KTDatatable({
                data: {
                    type: "remote",
                    source: {
                        read: {
                            url: "views/ajax/jsonOrders.php"
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
                        field: "numero",
                        title: "Número",
                        width: 35,
                        template: function(t, e) {
                            return `#${t.id}`;
                        }
                    },
                    {
                        field: "cliente",
                        title: "Cliente",
                        width: 250,
                        template: function(t, e) {
                            return `
                                ${t.cliente.nombre} <br>
                                ${t.cliente.telefono} <br>
                                ${t.cliente.email} <br>
                                ${t.cliente.direccion} <br>
                            `;
                        }
                    },
                    {
                        field: "estado",
                        title: "Estado",
                        width: 100,
                        template: function(t) {
                           
                            var e = {
                                2: {
                                    title: "Rechazado",
                                    class: " btn-label-danger"
                                },
                                1: {
                                    title: `Procesado`,
                                    class: " btn-label-brand"
                                },
                                0: {
                                    title: "En espera",
                                    class: " btn-label-warning"
                                },
                                "-1": {
                                    title: "Cancelado",
                                    class: " btn-label-danger"
                                },
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
                        field: "total",
                        title: "Total",
                        width: 60,
                        template: function(t, e) {
                            return "$" + t.total;
                        }
                    },
                    {
                        field: "fecha",
                        title: "Fecha",
                        width: 100,
                        template: function(t, e) {
                            return `${t.fecha}`;
                        }
                    },
                    
                    // {
                    //     field: "num_factura",
                    //     title: "Factura",
                    //     width: 60,
                    //     template: function(t, e) {
                    //         return t.num_factura;
                    //     }
                    // },
                    {
                        field: "productos",
                        width: 150,
                        title: "Productos",
                        template: function(t) {

                            // console.log(t.productos);

                            var str_c = ""
                            for(var c_i = 0; c_i < t.productos.length; c_i++){
                                
                                var item = t.productos[c_i]
                              
                                var skus = ""

                                if (item.skus != "" && item.skus != null) {
                    
                                    for(var j = 0;  j < item.skus.length; j++){
                    
                                        skus += `
                                            <dt>
                                                ${item.skus[j].name}:
                                            </dt>
                                            <dd>
                                                <span>${item.skus[j].value}</span>
                                            </dd>
                        
                                        `
                    
                                    }
                                    
                                }

                                str_c += `
                                    <tr><td>${t.productos[c_i].nombre} x ${t.productos[c_i].cantidad} <br> ${skus}</td></tr>
                                `
                            }


                            return `
                                <div>
                                    <table class="table table-hover">  

                                        <tbody>
                                            ${str_c}
                                        </tbody>
                                            
                                    </table>
                                </div>  
                                
                            `;
                        }
                    },
                    // {
                    //     field: "mensaje",
                    //     title: "Mensaje",
                    //     width: 200,
                    //     template: function(t, e) {
                    //         return `<span class="btn btn-bold btn-sm btn-font-sm btn-label-danger" >${t.mensaje}</span>`;
                    //     }
                    // }
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
                                        ¿Estás seguro de actualizar ${a.length} pedido/s a el ${text} de ${eText}?`,
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

                                        console.log(a.toArray());
                                        console.log(e);
                                        // if (e == "1") {
                                        //     if (a.toArray().length == 1) {
                                        //         var id = a.toArray()
                                        //         console.log(id);
                                        //         $("#idOrder").val(id[0])
                                        //         $("#modalStateOrder").modal("show")
                                        //     }else{
                                        //         util.alertError("Error", "No puedes procesar varios pedidos a la vez")
                                        //     }
                                            
                                        // }

                                        var datos = {
                                            actualizar_estados: true,
                                            estado: e,
                                            lista: a.toArray()
                                        }

                                        ajax.peticion("normal",datos,"views/ajax/gestorPedidos.php")
                                            .then((res)=>{
                                                console.log(res)
                                                if (res.status == "ok") {
                                                    util.alertSuccess("¡Actualizado!", "¡Se ha cambiado el estado a los pedidos seleccionados!", "orders")
                                                    
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
                                        " pedido/s seleccionado/s ?",
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
                                            borrar_lista_pedidos: true,
                                            lista: e.toArray()
                                        }

                                        ajax.peticion("normal",datos,"views/ajax/gestorPedidos.php")
                                            .then((res)=>{                                                
                                                console.log(res)
                                                if (res.status == "ok") {
                                                    swal.fire({
                                                        title: "¡Borrado!",
                                                        text:
                                                            "¡Los pedidos seleccionados han sido borrados! :(",
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
                                                "¡Los pedidos seleccionados no han sido borrados! :)",
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
                 // Exportar selección
                 $("#kt_subheader_group_actions_export").on(
                    "click",
                    function() {
                        var e = t
                        .rows(".kt-datatable__row--active")
                        .nodes()
                        .find('.kt-checkbox--single > [type="checkbox"]')
                        .map(function(t, e) {
                            return $(e).val();
                        });

                        $.ajax({
                            url: "views/ajax/gestorPedidos.php",
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                guardarIdsExportarPedido: true,
                                list: e.toArray()
                            }
                        })
                        .done((res)=>{
                            console.log(res);
                            var a = $(".aHidden")
                            $(".aHidden").click()
                            a[0].click()
                        })
                        .fail((error)=>{
                            console.log(error);
                        })

                        console.log(e);
                    }
                ),
                t.on("kt-datatable--on-layout-updated", function() {
                    $(".borrarPedido").unbind()
                    $(".borrarPedido").bind("click",function(e){
                        e.preventDefault()
                        var idBorrar = $(this).attr("data-id")
                        swal.fire({
                                buttonsStyling: !1,
                                text:
                                    "¿Estás seguro de borrar a este pedido?",
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
                                        borrar_lista_pedidos: true,
                                        lista: [idBorrar]
                                    }
                
                                    console.log(datos)
                
                                    ajax.peticion("normal",datos,"views/ajax/gestorPedidos.php")
                                        .then((res)=>{
                                            console.log(res)
                                            if(res.status == "ok"){
                                                swal.fire({
                                                    title: "¡Borrado!",
                                                    text:
                                                        "¡El pedido ha sido borrado! :(",
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
                                            "¡El pedido no ha sido borrado! :)",
                                        type: "error",
                                        buttonsStyling: !1,
                                        confirmButtonText: "OK",
                                        confirmButtonClass:
                                            "btn btn-sm btn-bold btn-brand"
                                    })
                                }
                            });
                    })

                    $(".exportProductOnly").unbind().bind("click",function(e){
                        e.preventDefault()
                    
                        var id = $(this).attr("data-id")
                    
                        $.ajax({
                            url: "views/ajax/gestorPedidos.php",
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                guardarIdsExportarPedido: true,
                                list: [id]
                            }
                        })
                        .done((res)=>{
                            console.log(res);
                            var a = $(".aHidden")
                            $(".aHidden").click()
                            a[0].click()
                        })
                        .fail((error)=>{
                            console.log(error);
                        })
                    })
                });

                
        }
    };
})();
KTUtil.ready(function() {
    KTUserListDatatable.init();
    
});

function establecerEventos() {}
