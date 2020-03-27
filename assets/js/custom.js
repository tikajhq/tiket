/* ------------------------------------------------------------------------------
 *
 *  # Form validation
 *
 *  Demo JS code for form_validation.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var FormValidation = function () {

	// Validation config
	var _componentMemberRegistrationValidation = function () {
		if (!$().validate) {
			console.warn('Warning - validate.min.js is not loaded.');
			return;
		}

		// Initialize
		var validator = $('.form-validate-jquery').validate({
			ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
			errorClass: 'validation-invalid-label',
			successClass: 'validation-valid-label',
			validClass: 'validation-valid-label',
			highlight: function (element, errorClass) {
				$(element).removeClass(errorClass);
			},
			unhighlight: function (element, errorClass) {
				$(element).removeClass(errorClass);
			},
			success: function (label) {
				label.addClass('validation-valid-label').text('Success.'); // remove to hide Success message
			},

			// Different components require proper error label placement
			errorPlacement: function (error, element) {

				// Unstyled checkboxes, radios
				if (element.parents().hasClass('form-check')) {
					error.appendTo(element.parents('.form-check').parent());
				}

				// Input with icons and Select2
				else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
					error.appendTo(element.parent());
				}

				// Input group, styled file input
				else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
					error.appendTo(element.parent().parent());
				}

				// Other elements
				else {
					error.insertAfter(element);
				}
			},
			rules: {
				password: {
					minlength: 5
				},
				repeat_password: {
					equalTo: '#password'
				},
				email: {
					email: true
				},
				repeat_email: {
					equalTo: '#email'
				},
				minimum_characters: {
					minlength: 10
				},
				maximum_characters: {
					maxlength: 10
				},
				minimum_number: {
					min: 10
				},
				maximum_number: {
					max: 10
				},
				number_range: {
					range: [10, 20]
				},
				url: {
					url: true
				},
				date: {
					date: true
				},
				date_iso: {
					dateISO: true
				},
				numbers: {
					number: true
				},
				digits: {
					digits: true
				},
				creditcard: {
					creditcard: true
				},
				basic_checkbox: {
					minlength: 2
				},
				styled_checkbox: {
					minlength: 2
				},
				switchery_group: {
					minlength: 2
				},
				switch_group: {
					minlength: 2
				}
			},
			messages: {
				custom: {
					required: 'This is a custom error message'
				},
				basic_checkbox: {
					minlength: 'Please select at least {0} checkboxes'
				},
				styled_checkbox: {
					minlength: 'Please select at least {0} checkboxes'
				},
				switchery_group: {
					minlength: 'Please select at least {0} switches'
				},
				switch_group: {
					minlength: 'Please select at least {0} switches'
				},
				agree: 'Please accept our policy'
			}
		});

		// Reset form
		$('#reset').on('click', function () {
			validator.resetForm();
		});
	};

	// Return objects assigned to module

	return {
		init: function () {
			_componentValidation();
		}
	}
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function () {
	FormValidation.init();
});
