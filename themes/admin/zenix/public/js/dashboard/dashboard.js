(function($) {
    "use strict";


 var dzChartlist = function(){
	
	var screenWidth = $(window).width();
	
	var currentChart = function(){
		 var options = {
	          	series: catagory_counts,
	          	chart: {
		         	height: 315,
		          	type: 'radialBar',
		        },
		        plotOptions: {
		          	radialBar: {
						startAngle:-90,
					   	endAngle: 90,
			            dataLabels: {
			              	name: {
			                	fontSize: '22px',
			              	},
			              	value: {
			                	fontSize: '16px',
		              		},
		            	}
		          	},
		        },
				stroke:{
					 lineCap: 'round',
				},
		        labels: catagory_labels,
				 	colors:['#ec8153', '#70b944','#498bd9','#6647bf'],
		        };

        var chart = new ApexCharts(document.querySelector("#currentChart"), options);
        chart.render();
	}
	
	
	
	var revenueMap = function(){
		  var options = {
			  	series: [
					{
						name: 'Users',
						data: users_count,
					}, 				
				],
				chart: {
					type: 'line',
					height: 300,
					toolbar: {
						show: false,
					},
				},
				plotOptions: {
				  	bar: {
						horizontal: false,
						columnWidth: '70%',
						endingShape: 'rounded'
				  	},
				},
				colors:['#886CC0'],
				dataLabels: {
				  enabled: false,
				},
				markers: {
					shape: "circle",
				},
				legend: {
					show: false,
				},
				stroke: {
				  	show: true,
				  	width: 5,
				  	curve:'smooth',
				  	colors:['var(--primary)'],
				},
			
				grid: {
					borderColor: '#eee',
					show: true,
					 xaxis: {
						lines: {
							show: true,
						}
					},  
					yaxis: {
						lines: {
							show: false,
						}
					},  
				},
				xaxis: {
					
				  	categories: users_monthyear,
				  	labels: {
						style: {
							colors: '#7E7F80',
							fontSize: '13px',
							fontFamily: 'Poppins',
							fontWeight: 100,
							cssClass: 'apexcharts-xaxis-label',
						},
				  	},
				  	crosshairs: {
				  		show: false,
				  	}
				},
				yaxis: {
					show:true,	
					forceNiceScale: true,
					min: 1,
					max: max_user_count,
					labels: {
						offsetX: -1,
					   	style: {
						  colors: '#7E7F80',
						  fontSize: '14px',
						   fontFamily: 'Poppins',
						  fontWeight: 100,
						  
						},
						formatter: function (y) {
						  	return Math.round(y);
						}
					},
				},
				fill: {
				  	opacity: 1,
				  	colors:'#FAC7B6'
				},
				tooltip: {
				  	y: {
						formatter: function (val) {
						  	return val + " Users Added"
						}
				  	}
				}
			};

			var chartBar1 = new ApexCharts(document.querySelector("#revenueMap"), options);
			chartBar1.render();
		 
		 
	 }
	
		/* Function ============ */
		return {
			init:function(){
			},
			
			
			load:function(){
				currentChart();
				revenueMap();
					
			},
			
			resize:function(){
			}
		}
	
	}();
		
	jQuery(window).on('load',function(){
		setTimeout(function(){
			dzChartlist.load();
		}, 1000); 
		
	});

})(jQuery);