let chart

am4core.ready(function() {
	
	// Themes begin
	am4core.useTheme(am4themes_animated);
	// Themes end
	
	// Create chart instance
	chart = am4core.create("chartdiv", am4charts.XYChart);
	
	// Add data
	// chart.data = [{
	// 	"nombre": "USA",
	// 	"cantidad": 2025
	// }, {
	// 	"nombre": "China",
	// 	"cantidad": 1882
	// }, {
	// 	"nombre": "Japan",
	// 	"cantidad": 1809
	// }];
	
	// Create axes
	
	var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
	categoryAxis.dataFields.category = "nombre";
	categoryAxis.renderer.grid.template.location = 0;
	categoryAxis.renderer.minGridDistance = 30;
	
	categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
		if (target.dataItem && target.dataItem.index & 2 == 2) {
			return dy + 25;
		}
		return dy;
	});
	
	var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
	
	// Create series
	var series = chart.series.push(new am4charts.ColumnSeries());
	series.dataFields.valueY = "cantidad";
	series.dataFields.categoryX = "nombre";
	series.name = "Cantidad";
	series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
	series.columns.template.fillOpacity = .8;
	
	var columnTemplate = series.columns.template;
	columnTemplate.strokeWidth = 2;
	columnTemplate.strokeOpacity = 1;
	
}); // end am4core.ready()


$(".productosMasVendidos").on("click",function(e){
	e.preventDefault()
	
	var data = new FormData(document.getElementById("formEstadisticas"))
	toggleTable(false)
	data.append("productosMasVendidos", true)
	ajax.peticion("FormData", data, "views/ajax/gestorEstadistica.php")
	.then((res)=>{
		console.log(res)

		$(".nameStatistics").html("Productos más vendidos")
		var ordenados = ordenar2(res)
		console.log(ordenados);
		chart.data = ordenados
	},(error)=>{
		console.log(error)
	})
})

$(".vendedoresMasVentas").on("click",function(e){
	e.preventDefault()
	
	var data = new FormData(document.getElementById("formEstadisticas"))
	toggleTable(false)
	data.append("vendedoresMasVentas", true)
	ajax.peticion("FormData", data, "views/ajax/gestorEstadistica.php")
	.then((res)=>{
		console.log(res)
		$(".nameStatistics").html("Vendedores con más ventas")

		chart.data = ordenar1(res)
	},(error)=>{
		console.log(error)
	})
})

$(".clientesMasPedidos").on("click",function(e){
	e.preventDefault()
	
	var data = new FormData(document.getElementById("formEstadisticas"))
	toggleTable(false)
	data.append("clientesMasPedidos", true)
	ajax.peticion("FormData", data, "views/ajax/gestorEstadistica.php")
	.then((res)=>{
		console.log(res)
		$(".nameStatistics").html("Clientes con más pedidos")

		chart.data = ordenar1(res)
	},(error)=>{
		console.log(error)
	})
})


$(".inventarioMinimo").on("click",function(e){
	e.preventDefault()

	toggleTable(true)
	$(".nameStatistics").html("Productos con inventario mínimo")
})	

setTimeout(()=>{
	$(".tableStockMinimo").addClass("hidden")
	$(".tableStockMinimo").removeClass("opacity-0")
},4000)

function toggleTable(bool){
	if(bool){
		$("#chartdiv").hide()
		$(".tableStockMinimo").removeClass("hidden")
	}else{
		$("#chartdiv").show()
		$(".tableStockMinimo").addClass("hidden")
	}
}

function ordenar1(items){
	items = items.sort(function (a, b) {
		if (a.total < b.total) {
		  return 1;
		}
		if (a.total > b.total) {
		  return -1;
		}
		return 0;
	});

	var limite = $("#limite").val()
	resp = []
	for(var i = 0; i < items.length; i++){
		if (i < limite) {
			resp.push(items[i])
		}else{
			break;
		}
		
	}

	return resp
}
function ordenar2(items){
	items = items.sort(function (a, b) {
		if (Number(a.cantidad) < Number(b.cantidad)) {
		  return 1;
		}
		if (Number(a.cantidad) > Number(b.cantidad)) {
		  return -1;
		}
		return 0;
	});

	var limite = $("#limite").val()
	resp = []
	for(var i = 0; i < items.length; i++){
		if (i < limite) {
			resp.push(items[i])
		}else{
			break;
		}
		
	}

	return resp
}