var DEBUG = true;
var TIK_PAGE_RESPONSE = {};


function makeReportPage(element, path, options, cb) {


	/**
	 * Returns datatable config to be used.
	 * @param override
	 * @return {any}
	 */
	function getDatatableConfig(override) {
		return Object.assign({
			dom: 'Bfrtip',
			buttons: [
				'copyHtml5',
				'excelHtml5',
				'csvHtml5',
				'pdfHtml5',
				'pageLength',
				{
					text: 'Columns',
					extend: 'collection',
					buttons: [
						'columnsToggle',
						{
							extend: 'columnVisibility',
							text: 'Show all',
							visibility: true
						},
					]
				},
			],
			paging: true,
			lengthMenu: [
				[10, 25, 50, 100, -1],
				['10 rows', '25 rows', '50 rows', '100 rows', 'All Rows']
			],
			responsive: true,
			"pageLength": 10,
			"scrollX": true,
		}, override);
	}


	function _makeChart(options, data) {

	}

	function _makeServerFilter(filterElement, options, data) {
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
				if (val['enum']) {
					fields[key]['optionLabels'] = Object.keys(val['enum']);
					val["enum"] = Object.values(val['enum']);

				}
			}
			schema[key] = val;
		});

		if (Object.keys(fields).length === 0)
			return filterElement.html('');

		var alOptions = {
			"schema": {
				"type": "object",
				"properties": schema,
				"required": false
			},
			options: {
				fields: fields,
				form: {
					"buttons": {
						"submit": {
							"title": "<i class='fa fa-filter'></i> Apply filter",
							"click": function () {
								this.refreshValidationState(true);
								if (!this.isValid(true)) {
									this.focus();
									return;
								}
								var value = this.getValue();
								options.setFilters(value);
								options.dt.ajax.reload();
							}
						}
					}
				},
				"hideInitValidationError": true,
			}
		};
		if (DEBUG) console.log(alOptions);
		$(filterElement).alpaca(alOptions);
	}

	function _makeClientFilter() {
		console.warn("Data is loaded on frontend, hence filters are not being rendered. Some functionality can be limited or might not behave properly.");
		return false;
	}

	function _makeServerTable(element, path, options, data) {

		var dtOptions = Object.assign(getDatatableConfig({
			"processing": true,
			"serverSide": true,
			"ajax": {
				"type": 'POST',
				"url": path,
				"data": options.getFilters,
				"dataSrc": function (json) {
					if (DEBUG && json.data.dev) {
						console.log(json.data.dev);
					}
					json.draw = json.data.draw;
					json.recordsTotal = json.data.recordsTotal;
					json.recordsFiltered = json.data.recordsFiltered;
					return json.data.data;
				}
			},
		}),options.datatable );
		// console.log(JSON.stringify(dtOptions))

		return element.DataTable(dtOptions);
	}

	function _makeClientTable(element, path, options, data) {
		var dtOptions = Object.assign(getDatatableConfig({
			// "bSort": false,//disable sorting
			data: data.tableData
		}), options.datatable);
		console.log(dtOptions);
		return element.DataTable(dtOptions);
	}

	function _getPageInformation(path, cb) {
		return $.get(path, function (data) {
			if (data.data) {
				return cb(null, data.data);
			} else {
				console.log("Page information doesn't have data key in response.", path);
				return cb(true, data);
			}
		});
	}

	function _makeAPage(element, path, options) {
		var RESPONSE = {};
		path = BASE_URL + "tabler/" + path;
		element.html("<div style='text-align:center;'>Loading information, Hold tight....</div><br/>");
		_getPageInformation(path, function (err, data) {
			if (err || !data) {
				return element.html("Some issue loading page information. Aborting loading page.");
			}

			console.log(data);
			RESPONSE['page'] = data;
			//if tableData is provided, turn off server side processing.
			if (data.tableData) {
				options.serverSide = false;
			} else {
				options.serverSide = true;
			}

			var rnd= Math.random().toString(32).substr(3,5);
			//Set page for filter erc.
			var html = '<div class="row">' +
				'<div class="col-md-12"> <div class="tik-filter-'+rnd+' horizontal-alpaca col-md-12"></div></div>' +
				'<hr><br/>' +
				'<div class="col-md-12"> <table class="tik-datatable-'+rnd+' table dataTable nowrap" style="width:100%;"></table></div>' +
				'</div>';
			element.html(html);
			var tableElement = $(element).find('.tik-datatable-'+rnd);
			var tableFilter = $(element).find('.tik-filter-'+rnd);

			//Get and set filters method.
			options._filters = {};
			options.getFilters = (function (d) {
				d['filtersData'] = this._filters;
			}).bind(options);
			options.setFilters = (function (filt) {
				return this._filters = filt;
			}).bind(options);

			var table = null;
			
			if (options.serverSide) {
				table = _makeServerTable(tableElement, path, options, data);
				options.dt = table;
				_makeServerFilter(tableFilter, options, data);
			} else {
				table = _makeClientTable(tableElement, path, options, data);
				options.dt = table;
				_makeClientFilter(tableFilter, options, data);
			}
			RESPONSE['table'] = table;
			cb && cb(null, RESPONSE);
		});
	}

	//call makeReportPage;
	return _makeAPage(element, path, options);
}
