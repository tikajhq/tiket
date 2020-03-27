/* ------------------------------------------------------------------------------
 *
 *  # Date and time pickers
 *
 *  Demo JS code for picker_date.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var DateTimePickers = function() {


	//
	// Setup module components
	//

	// Daterange picker
	var _componentDaterange = function() {
		if (!$().daterangepicker) {
			console.warn('Warning - daterangepicker.js is not loaded.');
			return;
		}

		// Basic initialization
		$('.daterange-basic').daterangepicker({
			applyClass: 'bg-slate-600',
			cancelClass: 'btn-light'
		});

		// Display week numbers
		$('.daterange-weeknumbers').daterangepicker({
			showWeekNumbers: true,
			applyClass: 'bg-slate-600',
			cancelClass: 'btn-light'
		});

		// Button class options
		$('.daterange-buttons').daterangepicker({
			applyClass: 'btn-success',
			cancelClass: 'btn-danger'
		});

		// Display time picker
		$('.daterange-time').daterangepicker({
			timePicker: true,
			applyClass: 'bg-slate-600',
			cancelClass: 'btn-light',
			locale: {
				format: 'MM/DD/YYYY h:mm a'
			}
		});

		// Show calendars on left
		$('.daterange-left').daterangepicker({
			opens: 'left',
			applyClass: 'bg-slate-600',
			cancelClass: 'btn-light'
		});

		// Single picker
		$('.daterange-single').daterangepicker({
			singleDatePicker: true,
			//singleDatePicker: true,
			//showDropdowns: true,

			locale: {
				format: 'DD/MM/YYYY'
			}

		});


		if(typeof minDateStart==="undefined") {
			minDateStart = new Date();
			console.warn("minDateStart not specified, using current date.")
		}
		if(typeof maxDateStart==="undefined") {
			maxDateStart = new Date(new Date().setFullYear(new Date().getFullYear() + 1));
			console.warn("maxDateStart not specified, using next year date.")
		}

			// Single picker
			$('.daterange-plan').daterangepicker({
				singleDatePicker: true,
				//singleDatePicker: true,
				//showDropdowns: true,

				locale: {
					format: 'YYYY-MM-DD'
				},
				minDate: minDateStart,
				maxDate: maxDateStart ,
			});



		// Display date dropdowns
		$('.daterange-date').daterangepicker({
			showDropdowns: true,
			opens: 'left',
			applyClass: 'bg-slate-600',
			cancelClass: 'btn-light'
		});

		// 10 minute increments
		$('.daterange-increments').daterangepicker({
			timePicker: true,
			opens: 'left',
			applyClass: 'bg-slate-600',
			cancelClass: 'btn-light',
			timePickerIncrement: 10,
			locale: {
				format: 'MM/DD/YYYY h:mm a'
			}
		});

		// Localization
		$('.daterange-locale').daterangepicker({
			applyClass: 'bg-slate-600',
			cancelClass: 'btn-light',
			opens: 'left',
			ranges: {
				'Сегодня': [moment(), moment()],
				'Вчера': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Последние 7 дней': [moment().subtract(6, 'days'), moment()],
				'Последние 30 дней': [moment().subtract(29, 'days'), moment()],
				'Этот месяц': [moment().startOf('month'), moment().endOf('month')],
				'Прошедший месяц': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			},
			locale: {
				applyLabel: 'Вперед',
				cancelLabel: 'Отмена',
				startLabel: 'Начальная дата',
				endLabel: 'Конечная дата',
				customRangeLabel: 'Выбрать дату',
				daysOfWeek: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт','Сб'],
				monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
				firstDay: 1
			}
		});


		//
		// Pre-defined ranges and callback
		//

		// Initialize with options
		$('.daterange-predefined').daterangepicker(
			{
				startDate: moment().subtract(29, 'days'),
				endDate: moment(),
				minDate: '01/01/2014',
				maxDate: '12/31/2019',
				dateLimit: { days: 60 },
				ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				},
				opens: 'left',
				applyClass: 'btn-sm bg-slate',
				cancelClass: 'btn-sm btn-light'
			},
			function(start, end) {
				$('.daterange-predefined span').html(start.format('MMMM D, YYYY') + ' &nbsp; - &nbsp; ' + end.format('MMMM D, YYYY'));
				$.jGrowl('Date range has been changed', { header: 'Update', theme: 'bg-primary', position: 'center', life: 1500 });
			}
		);

		// Display date format
		$('.daterange-predefined span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' &nbsp; - &nbsp; ' + moment().format('MMMM D, YYYY'));


		//
		// Inside button
		//

		// Initialize with options
		$('.daterange-ranges').daterangepicker(
			{
				startDate: moment().subtract(29, 'days'),
				endDate: moment(),
				minDate: '01/01/2012',
				maxDate: '12/31/2019',
				dateLimit: { days: 60 },
				ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				},
				opens: 'left',
				applyClass: 'btn-sm bg-slate-600',
				cancelClass: 'btn-sm btn-light'
			},
			function(start, end) {
				$('.daterange-ranges span').html(start.format('MMMM D, YYYY') + ' &nbsp; - &nbsp; ' + end.format('MMMM D, YYYY'));
			}
		);

		// Display date format
		$('.daterange-ranges span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' &nbsp; - &nbsp; ' + moment().format('MMMM D, YYYY'));
	};

	// Pickadate picker
	var _componentPickadate = function() {
		if (!$().pickadate) {
			console.warn('Warning - picker.js and/or picker.date.js is not loaded.');
			return;
		}

		// Basic options
		$('.pickadate').pickadate();

		// Change day names
		$('.pickadate-strings').pickadate({
			weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
			showMonthsShort: true
		});

		// Button options
		$('.pickadate-buttons').pickadate({
			today: '',
			close: '',
			clear: 'Clear selection'
		});

		// Accessibility labels
		$('.pickadate-accessibility').pickadate({
			labelMonthNext: 'Go to the next month',
			labelMonthPrev: 'Go to the previous month',
			labelMonthSelect: 'Pick a month from the dropdown',
			labelYearSelect: 'Pick a year from the dropdown',
			selectMonths: true,
			selectYears: true
		});

		// Localization
		$('.pickadate-translated').pickadate({
			monthsFull: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
			weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
			today: 'aujourd\'hui',
			clear: 'effacer',
			formatSubmit: 'yyyy/mm/dd'
		});

		// Format options
		$('.pickadate-format').pickadate({

			// Escape any “rule” characters with an exclamation mark (!).
			format: 'You selecte!d: dddd, dd mmm, yyyy',
			formatSubmit: 'yyyy/mm/dd',
			hiddenPrefix: 'prefix__',
			hiddenSuffix: '__suffix'
		});

		// Editable input
		var $input_date = $('.pickadate-editable').pickadate({
			editable: true,
			onClose: function() {
				$('.datepicker').focus();
			}
		});
		var picker_date = $input_date.pickadate('picker');
		$input_date.on('click', function(event) {
			if (picker_date.get('open')) {
				picker_date.close();
			} else {
				picker_date.open();
			}
			event.stopPropagation();
		});

		// Dropdown selectors
		$('.pickadate-selectors').pickadate({
			selectYears: true,
			selectMonths: true
		});

		// Year selector
		$('.pickadate-year').pickadate({
			selectYears: 4
		});

		// Set first weekday
		$('.pickadate-weekday').pickadate({
			firstDay: 1
		});

		// Date limits
		$('.pickadate-limits').pickadate({
			min: [2014,3,20],
			max: [2014,7,14]
		});

		// Disable certain dates
		$('.pickadate-disable').pickadate({
			disable: [
				[2015,8,3],
				[2015,8,12],
				[2015,8,20]
			]
		});

		// Disable date range
		$('.pickadate-disable-range').pickadate({
			disable: [
				5,
				[2013, 10, 21, 'inverted'],
				{ from: [2014, 3, 15], to: [2014, 3, 25] },
				[2014, 3, 20, 'inverted'],
				{ from: [2014, 3, 17], to: [2014, 3, 18], inverted: true }
			]
		});

		// Events
		$('.pickadate-events').pickadate({
			onStart: function() {
				console.log('Hello there :)')
			},
			onRender: function() {
				console.log('Whoa.. rendered anew')
			},
			onOpen: function() {
				console.log('Opened up')
			},
			onClose: function() {
				console.log('Closed now')
			},
			onStop: function() {
				console.log('See ya.')
			},
			onSet: function(context) {
				console.log('Just set stuff:', context)
			}
		});
	};

	// Pickatime picker
	var _componentPickatime = function() {
		if (!$().pickatime) {
			console.warn('Warning - picker.js and/or picker.time.js is not loaded.');
			return;
		}

		// Default functionality
		$('.pickatime').pickatime();

		// Clear button
		$('.pickatime-clear').pickatime({
			clear: ''
		});

		// Time formats
		$('.pickatime-format').pickatime({

			// Escape any “rule” characters with an exclamation mark (!).
			format: 'T!ime selected: h:i a',
			formatLabel: '<b>h</b>:i <!i>a</!i>',
			formatSubmit: 'HH:i',
			hiddenPrefix: 'prefix__',
			hiddenSuffix: '__suffix'
		});

		// Send hidden value
		$('.pickatime-hidden').pickatime({
			formatSubmit: 'HH:i',
			hiddenName: true
		});

		// Editable input
		var $input_time = $('.pickatime-editable').pickatime({
			editable: true,
			onClose: function() {
				$('.datepicker').focus();
			}
		});
		var picker_time = $input_time.pickatime('picker');
		$input_time.on('click', function(event) {
			if (picker_time.get('open')) {
				picker_time.close();
			} else {
				picker_time.open();
			}
			event.stopPropagation();
		});

		// Time intervals
		$('.pickatime-intervals').pickatime({
			interval: 150
		});


		// Time limits
		$('.pickatime-limits').pickatime({
			min: [7,30],
			max: [14,0]
		});

		// Using integers as hours
		$('.pickatime-limits-integers').pickatime({
			disable: [
				3, 5, 7
			]
		});

		// Disable times
		$('.pickatime-disabled').pickatime({
			disable: [
				[0,30],
				[2,0],
				[8,30],
				[9,0]
			]
		});

		// Disabling ranges
		$('.pickatime-range').pickatime({
			disable: [
				1,
				[1, 30, 'inverted'],
				{ from: [4, 30], to: [10, 30] },
				[6, 30, 'inverted'],
				{ from: [8, 0], to: [9, 0], inverted: true }
			]
		});

		// Disable all with exeption
		$('.pickatime-disableall').pickatime({
			disable: [
				true,
				3, 5, 7,
				[0,30],
				[2,0],
				[8,30],
				[9,0]
			]
		});

		// Events
		$('.pickatime-events').pickatime({
			onStart: function() {
				console.log('Hello there :)')
			},
			onRender: function() {
				console.log('Whoa.. rendered anew')
			},
			onOpen: function() {
				console.log('Opened up')
			},
			onClose: function() {
				console.log('Closed now')
			},
			onStop: function() {
				console.log('See ya.')
			},
			onSet: function(context) {
				console.log('Just set stuff:', context)
			}
		});
	};

	// Anytime picker
	var _componentAnytime = function() {
		if (!$().AnyTime_picker) {
			console.warn('Warning - anytime.min.js is not loaded.');
			return;
		}

		// Basic usage
		$('#anytime-date').AnyTime_picker({
			format: '%W, %M %D in the Year %z %E',
			firstDOW: 1
		});

		// Time picker
		$('#anytime-time').AnyTime_picker({
			format: '%H:%i'
		});

		// Display hours only
		$('#anytime-time-hours').AnyTime_picker({
			format: '%l %p'
		});

		// Date and time
		$('#anytime-both').AnyTime_picker({
			format: '%M %D %H:%i',
		});

		// Custom display format
		$('#anytime-weekday').AnyTime_picker({
			format: '%W, %D of %M, %Z'
		});

		// Numeric date
		$('#anytime-month-numeric').AnyTime_picker({
			format: '%d/%m/%Z'
		});

		// Month and day
		$('#anytime-month-day').AnyTime_picker({
			format: '%D of %M'
		});

		// On demand picker
		$('#ButtonCreationDemoButton').on('click', function (e) {
			$('#ButtonCreationDemoInput').AnyTime_noPicker().AnyTime_picker().focus();
			e.preventDefault();
		});


		//
		// Date range
		//

		// Options
		var oneDay = 24*60*60*1000;
		var rangeDemoFormat = '%e-%b-%Y';
		var rangeDemoConv = new AnyTime.Converter({format:rangeDemoFormat});

		// Set today's date
		$('#rangeDemoToday').on('click', function (e) {
			$('#rangeDemoStart').val(rangeDemoConv.format(new Date())).trigger('change');
		});

		// Clear dates
		$('#rangeDemoClear').on('click', function (e) {
			$('#rangeDemoStart').val('').trigger('change');
		});

		// Start date
		$('#rangeDemoStart').AnyTime_picker({
			format: rangeDemoFormat
		});

		// On value change
		$('#rangeDemoStart').on('change', function(e) {
			try {
				var fromDay = rangeDemoConv.parse($('#rangeDemoStart').val()).getTime();

				var dayLater = new Date(fromDay+oneDay);
				dayLater.setHours(0,0,0,0);

				var ninetyDaysLater = new Date(fromDay+(90*oneDay));
				ninetyDaysLater.setHours(23,59,59,999);

				// End date
				$('#rangeDemoFinish')
					.AnyTime_noPicker()
					.removeAttr('disabled')
					.val(rangeDemoConv.format(dayLater))
					.AnyTime_picker({
						earliest: dayLater,
						format: rangeDemoFormat,
						latest: ninetyDaysLater
					});
			}

			catch(e) {

				// Disable End date field
				$('#rangeDemoFinish').val('').attr('disabled', 'disabled');
			}
		});
	};


	//
	// Return objects assigned to module
	//

	return {
		init: function() {
			_componentDaterange();
			_componentPickadate();
			_componentPickatime();
			_componentAnytime();
		}
	}
}();




/* ------------------------------------------------------------------------------
 *
 *  # Checkboxes and radios
 *
 *  Demo JS code for form_checkboxes_radios.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var InputsCheckboxesRadios = function () {


	//
	// Setup components
	//

	// Uniform
	var _componentUniform = function() {
		if (!$().uniform) {
			console.warn('Warning - uniform.min.js is not loaded.');
			return;
		}

		// Default initialization
		$('.form-check-input-styled').uniform();


		//
		// Contextual colors
		//

		// Primary
		$('.form-check-input-styled-primary').uniform({
			wrapperClass: 'border-primary-600 text-primary-800'
		});

		// Danger
		$('.form-check-input-styled-danger').uniform({
			wrapperClass: 'border-danger-600 text-danger-800'
		});

		// Success
		$('.form-check-input-styled-success').uniform({
			wrapperClass: 'border-success-600 text-success-800'
		});

		// Warning
		$('.form-check-input-styled-warning').uniform({
			wrapperClass: 'border-warning-600 text-warning-800'
		});

		// Info
		$('.form-check-input-styled-info').uniform({
			wrapperClass: 'border-info-600 text-info-800'
		});

		// Custom color
		$('.form-check-input-styled-custom').uniform({
			wrapperClass: 'border-indigo-600 text-indigo-800'
		});
	};

	// Switchery
	var _componentSwitchery = function() {
		if (typeof Switchery == 'undefined') {
			console.warn('Warning - switchery.min.js is not loaded.');
			return;
		}

		// Initialize multiple switches
		var elems = Array.prototype.slice.call(document.querySelectorAll('.form-check-input-switchery'));
		elems.forEach(function(html) {
			var switchery = new Switchery(html);
		});

		// Colored switches
		var primary = document.querySelector('.form-check-input-switchery-primary');
		var switchery = new Switchery(primary, { color: '#2196F3' });

		var danger = document.querySelector('.form-check-input-switchery-danger');
		var switchery = new Switchery(danger, { color: '#EF5350' });

		var warning = document.querySelector('.form-check-input-switchery-warning');
		var switchery = new Switchery(warning, { color: '#FF7043' });

		var info = document.querySelector('.form-check-input-switchery-info');
		var switchery = new Switchery(info, { color: '#00BCD4'});
	};

	// Bootstrap switch
	var _componentBootstrapSwitch = function() {
		if (!$().bootstrapSwitch) {
			console.warn('Warning - switch.min.js is not loaded.');
			return;
		}

		// Initialize
		$('.form-check-input-switch').bootstrapSwitch();
	};


	//
	// Return objects assigned to module
	//

	return {
		init: function() {
			_componentUniform();
			_componentSwitchery();
			_componentBootstrapSwitch();
		}
	}
}();






/* ------------------------------------------------------------------------------
 *
 *  # Select2 selects
 *
 *
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var Select2Selects = function() {


	//
	// Setup module components
	//

	// Select2 examples
	var _componentSelect2 = function() {
		if (!$().select2) {
			console.warn('Warning - select2.min.js is not loaded.');
			return;
		}


		//
		// Basic examples
		//

		// Default initialization
		$('.select').select2({
			minimumResultsForSearch: Infinity
		});

		// Select with search
		$('.select-search').select2();

		// Fixed width. Single select
		$('.select-fixed-single').select2({
			minimumResultsForSearch: Infinity,
			width: 250
		});

		// Fixed width. Multiple selects
		$('.select-fixed-multiple').select2({
			minimumResultsForSearch: Infinity,
			width: 400
		});


		//
		// Advanced examples
		//

		// Minimum input length
		$('.select-minimum').select2({
			minimumInputLength: 2,
			minimumResultsForSearch: Infinity
		});

		// Allow clear selection
		$('.select-clear').select2({
			placeholder: 'Select a State',
			allowClear: true
		});

		// Tagging support
		$('.select-multiple-tags').select2({
			tags: true
		});

		// Maximum input length
		$('.select-multiple-maximum-length').select2({
			tags: true,
			maximumInputLength: 5
		});

		// Tokenization
		$('.select-multiple-tokenization').select2({
			tags: true,
			tokenSeparators: [',', ' ']
		});

		// Maximum selection
		$('.select-multiple-limited').select2({
			maximumSelectionLength: 3
		});

		// Maximum selections allowed
		$('.select-multiple-maximum').select2({
			maximumSelectionSize: 3
		});


		//
		// Drag and drop selected items
		//

		// Initialize with tags
		$('.select-multiple-drag').select2({
			containerCssClass: 'sortable-target'
		});

		// Add jQuery UI Sortable support
		// $('.sortable-target .select2-selection__rendered').sortable({
		// 	containment: '.sortable-target',
		// 	items: '.select2-selection__choice:not(.select2-search--inline)'
		// });


		//
		// Single select with icons
		//

		// Format icon
		function iconFormat(icon) {
			var originalOption = icon.element;
			if (!icon.id) { return icon.text; }
			var $icon = '<i class="icon-' + $(icon.element).data('icon') + '"></i>' + icon.text;

			return $icon;
		}

		// Initialize with options
		$('.select-icons').select2({
			templateResult: iconFormat,
			minimumResultsForSearch: Infinity,
			templateSelection: iconFormat,
			escapeMarkup: function(m) { return m; }
		});


		//
		// Customize matched results
		//

		// Setup matcher
		function matchStart (term, text) {
			if (text.toUpperCase().indexOf(term.toUpperCase()) == 0) {
				return true;
			}

			return false;
		}

		// Initialize
		$.fn.select2.amd.require(['select2/compat/matcher'], function (oldMatcher) {
			$('.select-matched-customize').select2({
				minimumResultsForSearch: Infinity,
				placeholder: 'Select a State',
				matcher: oldMatcher(matchStart)
			});
		});


		//
		// Loading arrays of data
		//

		// Data
		var array_data = [
			{id: 0, text: 'enhancement'},
			{id: 1, text: 'bug'},
			{id: 2, text: 'duplicate'},
			{id: 3, text: 'invalid'},
			{id: 4, text: 'wontfix'}
		];

		// Loading array data
		$('.select-data-array').select2({
			placeholder: 'Click to load data',
			minimumResultsForSearch: Infinity,
			data: array_data
		});


		//
		// Loading remote data
		//

		// Format displayed data
		function formatRepo (repo) {
			if (repo.loading) return repo.text;

			var markup = '<div class="select2-result-repository clearfix">' +
				'<div class="select2-result-repository__avatar"><img src="' + repo.owner.avatar_url + '" /></div>' +
				'<div class="select2-result-repository__meta">' +
				'<div class="select2-result-repository__title">' + repo.full_name + '</div>';

			if (repo.description) {
				markup += '<div class="select2-result-repository__description">' + repo.description + '</div>';
			}

			markup += '<div class="select2-result-repository__statistics">' +
				'<div class="select2-result-repository__forks">' + repo.forks_count + ' Forks</div>' +
				'<div class="select2-result-repository__stargazers">' + repo.stargazers_count + ' Stars</div>' +
				'<div class="select2-result-repository__watchers">' + repo.watchers_count + ' Watchers</div>' +
				'</div>' +
				'</div></div>';

			return markup;
		}

		// Format selection
		function formatRepoSelection (repo) {
			return repo.full_name || repo.text;
		}

		// Initialize
		$('.select-remote-data').select2({
			ajax: {
				url: 'https://api.github.com/search/repositories',
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
						q: params.term, // search term
						page: params.page
					};
				},
				processResults: function (data, params) {

					// parse the results into the format expected by Select2
					// since we are using custom formatting functions we do not need to
					// alter the remote JSON data, except to indicate that infinite
					// scrolling can be used
					params.page = params.page || 1;

					return {
						results: data.items,
						pagination: {
							more: (params.page * 30) < data.total_count
						}
					};
				},
				cache: true
			},
			escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
			minimumInputLength: 1,
			templateResult: formatRepo, // omitted for brevity, see the source of this page
			templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
		});


		//
		// Programmatic access (single)
		//

		// Set/get value
		$('.select-access-value').select2({
			minimumResultsForSearch: Infinity,
			placeholder: 'Select State...'
		});
		$('.access-get').on('click', function () { alert('Selected value is: '+$('.select-access-value').val()); });
		$('.access-set').on('click', function () { $('.select-access-value').val('CA').trigger('change'); });


		// Open/close menu
		$('.select-access-open').select2({
			minimumResultsForSearch: Infinity,
			placeholder: 'Select State...'
		});
		$('.access-open').on('click', function () { $('.select-access-open').select2('open'); });
		$('.access-close').on('click', function () { $('.select-access-open').select2('close'); });


		// Enable/disable menu
		$('.select-access-enable').select2({
			minimumResultsForSearch: Infinity,
			placeholder: 'Select State...'
		});
		$('.access-disable').on('click', function () { $('.select-access-enable').prop('disabled', true); });
		$('.access-enable').on('click', function () { $('.select-access-enable').prop('disabled', false); });


		// Destroy/create menu
		function create_menu() {
			$('.select-access-create').select2({
				minimumResultsForSearch: Infinity,
				placeholder: 'Select State...'
			});
		}
		create_menu();
		$('.access-create').on('click', function () { return create_menu()});
		$('.access-destroy').on('click', function () { $('.select-access-create').select2('destroy'); });


		//
		// Programmatic access (multiple)
		//

		// Reacting to external value changes
		$('.select-access-multiple-value').select2();
		$('.change-to-ca').on('click', function() { $('.select-access-multiple-value').val('CA').trigger('change'); });
		$('.change-to-ak-co').on('click', function() { $('.select-access-multiple-value').val(['AK','CO']).trigger('change'); });


		// Open/close menu
		$('.select-access-multiple-open').select2({
			minimumResultsForSearch: Infinity
		});
		$('.access-multiple-open').on('click', function () { $('.select-access-multiple-open').select2('open'); });
		$('.access-multiple-close').on('click', function () { $('.select-access-multiple-open').select2('close'); });


		// Enable/disable menu
		$('.select-access-multiple-enable').select2({
			minimumResultsForSearch: Infinity
		});
		$('.access-multiple-disable').on('click', function () { $('.select-access-multiple-enable').prop('disabled', true); });
		$('.access-multiple-enable').on('click', function () { $('.select-access-multiple-enable').prop('disabled', false); });


		// Destroy/create menu
		function create_menu_multiple() {
			$('.select-access-multiple-create').select2({
				minimumResultsForSearch: Infinity
			});
		}
		create_menu_multiple();
		$('.access-multiple-create').on('click', function () { return create_menu_multiple()});
		$('.access-multiple-destroy').on('click', function () { $('.select-access-multiple-create').select2('destroy'); });


		// Clear selection
		$('.select-access-multiple-clear').select2({
			minimumResultsForSearch: Infinity
		});
		$('.access-multiple-clear').on('click', function () { $('.select-access-multiple-clear').val(null).trigger('change'); });
	};


	//
	// Return objects assigned to module
	//

	return {
		init: function() {
			_componentSelect2();
		}
	}
}();

/* ------------------------------------------------------------------------------
 *
 *  # Datatable sorting
 *
 *  Demo JS code for datatable_sorting.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var DatatableSorting = function () {


	//
	// Setup module components
	//

	// Basic Datatable examples
	var _componentDatatableSorting = function () {
		if (!$().DataTable) {
			console.warn('Warning - datatables.min.js is not loaded.');
			return;
		}

		// Default ordering example
		$('.datatable-calcun').DataTable({
			aLengthMenu: [
				[50, 100, 200, -1],
				[50, 100, 200, "All"]
			],

			iDisplayLength: 50,
			"scrollX": true,
			autoWidth: false,
			columnDefs: [{}],
			dom: 'Bfrtip',
			language: {
				search: '<span>Filter:</span> _INPUT_',
				searchPlaceholder: 'Type to filter...',
				lengthMenu: '<span>Show:</span> _MENU_',
				paginate: {
					'first': 'First',
					'last': 'Last',
					'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
					'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
				}
			},
			buttons: [
				'copy',
				'csv',
				'excel',
				{
					text: 'PDF',
					extend: 'pdfHtml5',
					orientation: 'portrait',
					pageSize: 'A4',
					exportOptions: {
						page: 'current'
					}
				},
				// {
				//     text: 'PDF-L',
				//     extend: 'pdfHtml5',
				//     orientation: 'landscape',
				//     pageSize: 'A4',
				//     exportOptions: {
				//         columns: ':visible:not(.not-export-col)'
				//     }
				// },
				'colvis'
			]
		});


	};

	// Select2 for length menu styling
	var _componentSelect2 = function () {
		if (!$().select2) {
			console.warn('Warning - select2.min.js is not loaded.');
			return;
		}

		// Initialize
		$('.dataTables_length select').select2({
			minimumResultsForSearch: Infinity,
			dropdownAutoWidth: true,
			width: 'auto'
		});
	};


	//
	// Return objects assigned to module
	//

	return {
		init: function () {
			_componentDatatableSorting();
			_componentSelect2();
		}
	}
}();



var UniformComponent = function () {


	//
	// Setup module components
	//

	// Uniform
	var _componentUniform = function() {
		if (!$().uniform) {
			console.warn('Warning - uniform.min.js is not loaded.');
			return;
		}

		// Initialize
		$('.form-input-styled').uniform();
	};


	//
	// Return objects assigned to module
	//

	return {
		initComponents: function() {
			_componentUniform();
		}
	}
}();




// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
	Select2Selects.init();
	DateTimePickers.init();
	InputsCheckboxesRadios.init();
	DatatableSorting.init();
	UniformComponent.initComponents();
});
