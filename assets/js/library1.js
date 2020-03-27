$(document).ready(function () {

	var lastTimeout = null;
	$('.user-existance-validation').on('input', function (e) {
		if (lastTimeout) clearTimeout(lastTimeout);
		lastTimeout = setTimeout(function () {
			var target = $(e.target);
			var targetResult = $('#' + target.attr('name') + "_error");
			var val = target.val();
			if (!val) {
				targetResult.html("");
				return;
			}
			$.get(BASE_URL + "/API/User/Basic/check?query=" + val, function (data) {
				console.log(data.data);
				if (data.data === null) {
					targetResult.html("");
				} else
					targetResult.html(val + " is already being used.")

			})
		}, 1000)
	});


	//State and city dropdowns.
	if ($('#dropdown-state').length) {
		$.get(BASE_URL + '/API/User/Locations/states', function (data) {
			console.log(data);
			console.log("dafaf");
			$('#dropdown-state').select2({
				data: data.data.map(function (item) {
					return {id: item.id, text: item.name}
				})
			}).on('select2:select', function (e) {
				var data = e.params.data;
				console.log(data);
				if ($('#dropdown-city')) {
					$.get(BASE_URL + '/API/User/Locations/cities?state=' + data.id, function (data) {
						$('#dropdown-city').empty().select2({
							data: data.data.map(function (item) {
								return {id: item.id, text: item.name}
							})
						});
					});
				}
			})


		});

	}

	if ($('#banks').length) {
		$.get(BASE_URL + '/API/User/Banks/banks', function (data) {
			console.log(data);
			$('#banks').select2({
				data: data.data.map(function (item) {
					return {id: item.id, text: item.name}
				})
			})
		});

	}

	// fetch referrer details in case from url
	fetchReferrerDetails($('#referrer_id').val());

	$('#referrer_id').on('input', function (e) {
		if (lastTimeout) clearTimeout(lastTimeout);
		lastTimeout = setTimeout(function () {
			var ref_id = $(e.target).val();
			fetchReferrerDetails(ref_id);
		}, 1000)
	});

});

function fetchReferrerDetails(id){
	var referrer_name = $('#referrer_name');
	var referrer_mobile = $('#referrer_mobile');
	if(id)
		$.get(BASE_URL + "/API/User/Basic/getUserDetails?username=" + id, function (data) {
			if (data.data === null) {
				referrer_name.val("");
				referrer_mobile.val("");
			} else
			{
				var mobile = data.data.mobile
				referrer_name.val(data.data.name);
				referrer_mobile.val('*******'+mobile.substring(mobile.length-3, mobile.length));
			}


		})
}


var TIK_PAGE_RESPONSE = {};

function makeChart(options, data) {

}

function getFiltersFromSchema(options) {

}

function makeFilter(element, options, data) {
	// get all fields which are of type array, fetch data using API.

	var filters = data.filters;
	var schema = {};
	var fields = {};

	Object.keys(filters).forEach(function (key) {
		var val = filters[key];

		if (!fields[key]) fields[key] = {};

		//if enum force dropdown
		if (val['enum']) {
			fields[key]["type"] = "select";

			//if object
			if (!Array.isArray(val['enum'])) {
				fields[key]["optionLabels"] = Object.values(val['enum']);
				val['enum'] = Object.keys(val['enum']);
			}
		}
		schema[key] = val;
	});
	var options = {
		"schema": {
			"type": "object",
			"properties": schema,
			"required": false
		},
		options: {
			fields: fields
		}
	}
	console.log(options);

	element.find('#filter').alpaca(options);

}

function makeTikTable(element, path, options, data) {
	$('.tik-datatable').DataTable(Object.assign({
		"processing": true,
		"serverSide": true,
		dom: 'Bfrtip',
		buttons: [
			'copyHtml5',
			'excelHtml5',
			'csvHtml5',
			'pdfHtml5'
		],
		// paging: true,
		"pageLength": 100,
		"ajax": {
			"type": 'POST',
			"url": path,
			"dataSrc": function (json) {
				json.draw = json.data.draw;
				json.recordsTotal = json.data.recordsTotal;
				json.recordsFiltered = json.data.recordsFiltered;

				return json.data.data;
			}
		}
	}, options.datatable));
}

function getPageInformation(path, cb) {
	$.get(path, function (data) {
		if (data.data) {
			return cb(null, data.data);
		} else {
			console.log("Page information doesn't have data key in response.", path);
			return cb(true, data);
		}
	});
}

function makeReportPage(element, path, options) {
	path = BASE_URL + "tabler/" + path;
	getPageInformation(path, function (err, data) {
		TIK_PAGE_RESPONSE = data;

		var html = '<div class="row">' +
			'<div class="col-md-12"> <div id="filter" class="horizontal-alpaca col-md-12"></div></div>' +
			'<br/>' +
			'<div class="col-md-12"> <table class="table  dataTable tik-datatable " style="width: 100%"></table></div>' +
			'</div>';
		element.html(html);

		makeFilter(element, options, data);
		makeTikTable(element, path, options, data)
	});

	//PARALLEL
	//TODO: makeTable with options and data.
	//TODO: get required filters from the PAGE Schema.
	//TODO: Show loading while page API is executing.
	//TODO: makeFilter with options and data.
	//TODO: Populate div with the dummy structure
}

function getDateTime(timestampInSeconds){
	return new Date(timestampInSeconds*1000).toLocaleString()
}

function getDate(timestampInSeconds){
	var time = new Date(timestampInSeconds*1000);
	var month = time .getMonth() + 1;
	var day = time .getDate();
	var year = time .getFullYear();
	return year+ "/" + month + "/" + day;
}


