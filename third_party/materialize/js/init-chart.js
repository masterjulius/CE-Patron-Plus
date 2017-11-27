(function($){
	
	$(function(e){

		chartDatas = JSON.stringify(chartDatas);
		chartDatas = JSON.parse(chartDatas);
		// var script = document.currentScript;
		// var fullUrl = script.src;
		var public = httpLocation.protocol + "//" + httpLocation.host + "/" + httpLocation.pathname.split('/')[1] + '/' + 'third_party/materialize';
		var orgchart = new getOrgChart(document.getElementById("chart-container"), chartDatas);

	});

})(jQuery);