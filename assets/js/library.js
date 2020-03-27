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
				if (data.data === null) {
					targetResult.html("");
				} else
					targetResult.html(val + " is already being used.")

			})
		}, 1000)
	});

	renderCustomHTML();
	renderDropdowns();

	// refresh every timestamps 60s
	setInterval(function(){
		$('.rel-time').each(function(elem){
			var value = parseInt($(this).attr('data-value'));
			if(value)
				$(this).html('<span data-toggle="tooltip" data-placement="bottom"  data-html="true" title="" data-original-title="'+getDateTime(parseInt(value))+'">'+getRelativeTime($(this).attr('data-value'))+'</span>');
			else
				$(this).html('-');
		});
	}, 60000);
});

function renderDropdowns(){


	if ($('#status_dd').length) {
		$.get(BASE_URL + '/API/Ticket/getStatus', function (data) {
			
			$('#status_dd').select2({
				data: data.data.map(function (item) {
					return {id: item.value, text: item.label}
				})
			});


		});
	}
	if ($('#assign_to_dd').length) {
		$.get(BASE_URL + '/API/User/getAll?type=[60,80,100]', function (data) {
			
			$('#assign_to_dd').select2({
				data: data.data.map(function (item) {
					return {id: item.username, text: item.name}
				})
			});


		});
	}
	if ($('#category_dd').length) {
		$.get(BASE_URL + '/API/Ticket/getCategories', function (data) {
			
			$('#category_dd').select2({
				width: 'resolve',
				data: data.data.map(function (item, index) {
					return {id: index, text: item}
				})
			});


		});
	}
	if ($('#priority_dd').length) {
		$.get(BASE_URL + '/API/Ticket/getPriorities', function (data) {
			
			$('#priority_dd').select2({
				width: 'resolve',
				data: data.data.map(function (item, index) {
					return {id: item.value, text: item.label}
				})
			});


		});
	}
	if ($('#severity_dd').length) {
		$.get(BASE_URL + '/API/Ticket/getSeverities', function (data) {
			
			$('#severity_dd').select2({
				width: 'resolve',
				data: data.data.map(function (item, index) {
					return {id: item.value, text: item.label}
				})
			});


		});
	}

	if ($('#cc_dd').length) {
		$.get(BASE_URL + '/API/User/getAll', function (data) {
			
			$('#cc_dd').select2({
				width: 'resolve',
				data: data.data.map(function (item, index) {
					return {id: item.username, text: item.name}
				})
			});


		});
	}

}

function renderCustomHTML(){

	$('[data-toggle="tooltip"]').tooltip();

	$('.user-label').each(function(elem){
		var username = $(this).attr('data-username');
		var name = username.split('@')[0].split('.').map((s) => s.charAt(0).toUpperCase() + s.substring(1)).join(' ');
        $(this).html(getUserLabel(name, username))
	});

	$('.user-name').each(function(elem){
		var username = $(this).attr('data-username');	
        $(this).html(getUserName(username));
	});

	$('.user-type').each(function(elem){
		var value = $(this).attr('data-value');
		if(value) $(this).html(getUserTypeLabel(value));
		else $(this).html('-')
	});

	$('.user-status').each(function(elem){
		var value = $(this).attr('data-value');
		if(value) $(this).html(getUserStatus(value));
		else $(this).html('-')
	});
	
	$('.comment-avatar').each(function(elem){
		var username = $(this).attr('data-username');
		var name = username.split('.').map((s) => s.charAt(0).toUpperCase() + s.substring(1)).join(' ');
		
		$(this).html(getUserIcon(name, username ))
	});

	$('.tik-severity').each(function(elem){
		var value = $(this).attr('data-value');
		if(value)
			$(this).html(getSeverityIcon($(this).attr('data-value')));
		else
			$(this).html('-');
	});

	$('.tik-priority').each(function(elem){
		var value = $(this).attr('data-value');
		if(value)
			$(this).html(getPriorityIcon($(this).attr('data-value')));
		else
			$(this).html('-');
	});

	$('.tik-status').each(function(elem){
		var value = $(this).attr('data-value');
		if(value)
			$(this).html(getStatusIcon($(this).attr('data-value')));
		else
			$(this).html('-');
	});

	$('.tik-category').each(function(elem){
		var value = $(this).attr('data-value');
		if(value)
			$(this).html(getCategoryIcon($(this).attr('data-value')));
		else
			$(this).html('-');
	});

	$('.rel-time').each(function(elem){
		var value = parseInt($(this).attr('data-value'));
		if(value)
			$(this).html('<span data-toggle="tooltip" data-placement="bottom"  data-html="true" title="" data-original-title="'+getDateTime(parseInt(value))+'">'+getRelativeTime($(this).attr('data-value'))+'</span>');
		else
			$(this).html('-');
	});

	$('.activity-icon').each(function(elem){
		var value = $(this).attr('data-type');
		if(value)
			$(this).addClass(getActivityIconClass(value));
	});

	$('.attachment').each(function(elem){
		var filename = $(this).attr('data-filename');
		var filepath = $(this).attr('data-filepath');
		if(filepath && filename)
			$(this).html(getAttachmentLabel(filename, filepath));
	});

}

function getDateTime(timestampInSeconds) {
	return new Date(timestampInSeconds).toLocaleString()
}

function getDate(timestampInSeconds){
	var time = new Date(timestampInSeconds*1000);
	var month = time .getMonth() + 1;
	var day = time .getDate();
	var year = time .getFullYear();
	return year+ " / " + month + " / " + day;
}


function hashCode(str) {
    var hash = 0;
    for (var i = 0; i < str.length; i++) {
       hash = str.charCodeAt(i) + ((hash << 5) - hash);
    }
    return hash;
} 

function intToRGB(i){
    var c = (i & 0x00FFFFFF)
        .toString(16)
        .toUpperCase();

    let hexCode = "00000".substring(0, 6 - c.length) + c;
	return shadeColor("#"+hexCode, 100);
}

function shadeColor(color, percent) {

	var R = parseInt(color.substring(1,3),16);
	var G = parseInt(color.substring(3,5),16);
	var B = parseInt(color.substring(5,7),16);

	R = parseInt(R * (100 + percent) / 100);
	G = parseInt(G * (100 + percent) / 100);
	B = parseInt(B * (100 + percent) / 100);

	R = (R<255)?R:255;
	G = (G<255)?G:255;
	B = (B<255)?B:255;

	var RR = ((R.toString(16).length==1)?"0"+R.toString(16):R.toString(16));
	var GG = ((G.toString(16).length==1)?"0"+G.toString(16):G.toString(16));
	var BB = ((B.toString(16).length==1)?"0"+B.toString(16):B.toString(16));

	return RR+GG+BB;
}

function getStringInitials(str){
	str  = str.split('@')[0];
	var matches = str.match(/\b(\w)/g);
	var acr = (matches.length > 1) ? [matches[0], matches[matches.length-1]].join('') : matches.join('');
    return acr.toUpperCase();
}

function getUserIcon(name, username){
	if(username)
		return '<div class="userIcon" style="background:#'+intToRGB(hashCode(username))+'" data-toggle="tooltip" data-placement="bottom" data-html="true" title="' + name + '<br> '+getUserName(username)+'"><span>'+getStringInitials(username)+'</span></div>';
	else
		return '-';
}

function getUserLabel(name, username){
	return getUserIcon(name, username);
}

function getUserName(username){
	return (validateEmailAddress(username)) ? username : ('@'+username) ;	
}

function getUserTypeLabel(type){
	var type_map ={10: '<div class="badge badge-corner bg-blue">User</div>', 60: '<div class="badge badge-corner bg-green">Agent</div>', 80: '<div class="badge badge-corner bg-orange">Manager</div>', 100: '<div class="badge badge-corner bg-red">Admin</div>'}
	return type_map[parseInt(type)];
}

function getUserStatus(status){
	var status_map ={0: '<div class="badge badge-corner bg-grey">Disabled</div>', 1: '<div class="badge badge-corner bg-green">Active</div>'}
	return status_map[parseInt(status)];
}

function getSeverityIcon(severity){
	var severity_map = {0:'<div class="badge badge-corner bg-green">Low</div>', 5:'<div class="badge badge-corner bg-yellow">Medium</div>', 10:'<div class="badge badge-corner bg-red">High</div>'}
	return severity_map[parseInt(severity)];
}

function getPriorityIcon(priority){
	var priority_map = {0:'<div class="badge badge-corner bg-green">Low</div>', 5:'<div class="badge badge-corner bg-yellow">Medium</div>', 10:'<div class="badge badge-corner bg-red">High</div>'}
	return priority_map[parseInt(priority)];
}

function getStatusIcon(priority){
	var priority_map = {0:'<div class="badge badge-corner bg-green">Open</div>', 50:'<div class="badge badge-corner bg-yellow">In-Progress</div>', 100:'<div class="badge badge-corner bg-red">Closed</div>'}
	return priority_map[parseInt(priority)];
}

function getCategoryIcon(priority){
	var priority_map = {0:'Bug', 1:'Feature Request', 2:'Software Troubleshooting', 3: 'Software Troubleshooting',
	4:'How To', 5:'Password Reset', 6:'Network', 7: 'Hardware', 8: 'Access and Authorization'}
	return priority_map[parseInt(priority)];
}

function getActivityIconClass(type){
	var activity_type = {1: "", 2: "fa fa-folder-open", 3: "fa fa-check", 4: "fa fa-edit", 5: "fa fa-warning", 6: "fa fa-unsorted", 7: "fa fa-tag" , 8: "fa fa-user-plus" }
	return activity_type[parseInt(type)];
}

function getAttachmentLabel(filename, path){
	var attachment_icon = {"png" : "fa-file-image-o", "jpeg": "fa-file-image-o", "jpg" : "fa-file-image-o", "xlsx":"fa-file-excel-o","xls":"fa-file-excel-o", "csv" : "fa-file-text", "docx" : "fa-file-word-o", "doc" : "fa-file-word-o", "pdf" : "fa-file-pdf-o", "zip":"fa-file-archive-o", "rar" : "fa-file-archive-o"};

	// get extension
	var ext = filename.substring(filename.lastIndexOf('.')+1, filename.length) || filename;
	return '<a target="_blank" href="'+path+'" class="pr-3"><i class="fa '+attachment_icon[ext]+'"></i> '+ filename+'</a> <a class="download-attachment" target="_blank" href="'+path+'" download title="Download"> <i class="fa fa-arrow-circle-down text-blue"></i></a>';
}

//Relative time function, picked from maddy coreui

function getRelativeTime(time){

	const TEMPLATES = {
        prefix: "",
        suffix: " ago",
        seconds: "less than a minute",
        minute: "about a minute",
        minutes: "%d minutes",
        hour: "about an hour",
        hours: "about %d hours",
        day: "a day",
        days: "%d days",
        month: "about a month",
        months: "%d months",
        year: "about a year",
        years: "%d years"
	};
	
	function template(t, n) {
		return TEMPLATES[t] && TEMPLATES[t].replace(/%d/i, Math.abs(Math.round(n)));
	};

	if (!time) return;
    if( typeof time == "number")
        time = String(time);
    time = time.replace(/\.\d+/, ""); // remove non-numeric characters.

    if (isNaN(time)) {
        time = time.replace(/-/, "/").replace(/-/, "/");
        time = time.replace(/T/, " ").replace(/Z/, " UTC");
        time = time.replace(/([\+\-]\d\d)\:?(\d\d)/, " $1$2"); // -04:00 -> -0400
        time = new Date(time * 1000 || time);
    }

    var now = new Date();
    var seconds = ((now.getTime() - time) * .001) >> 0;
    var minutes = seconds / 60;
    var hours = minutes / 60;
    var days = hours / 24;
    var years = days / 365;


    return TEMPLATES.prefix + (
        seconds < 45 && template('seconds', seconds) ||
        seconds < 90 && template('minute', 1) ||
        minutes < 45 && template('minutes', minutes) ||
        minutes < 90 && template('hour', 1) ||
        hours < 24 && template('hours', hours) ||
        hours < 42 && template('day', 1) ||
        days < 30 && template('days', days) ||
        days < 45 && template('month', 1) ||
        days < 365 && template('months', days / 30) ||
        years < 1.5 && template('year', 1) ||
        template('years', years)
    ) + TEMPLATES.suffix;

}




/**
 * Show type based notifications
 * @param {string} type 
 * @param {string} message 
 * @param {object} options 
 * @param {function} cb 
 */
function showNotification(type, message, options, cb){

	var noptions = Object.assign({
		tapToDismiss: true,
		toastClass: 'toast',
		containerId: 'toast-container',
		debug: false,
		showMethod: 'fadeIn', 
		showDuration: 300,
		showEasing: 'swing',
		onShown: renderCustomHTML,
		hideMethod: 'fadeOut',
		hideDuration: 300,
		hideEasing: 'swing',
		onHidden: cb,
		closeMethod: false,
		closeDuration: false,
		closeEasing: false,
		extendedTimeOut: 1000,
		positionClass: 'toast-top-right',
		timeOut: 3000,
		titleClass: 'toast-title',
		messageClass: 'toast-message',
		escapeHtml: false,
		target: 'body',
		closeHtml: '<button type="button">&times;</button>',
		newestOnTop: true,
		preventDuplicates: false,
		progressBar: true,
		escapeHtml : false
	  }, options);

	  
	  toastr.options = noptions;
	  toastr[type](message);

}

/**
 * File Upload method
 * @param {*} event 
 * @param {string} path
 *  
 * */


function fileUpload(event, path, cb) {
	//notify user about the file upload status
	$("#dropBox").html(event.target.value + "...");
	//get selected file
	files = event.target.files;
	//form data check the above bullet for what it is  
	var data = new FormData();
	//file data is presented as an array
	for (var i = 0; i < files.length; i++) {
		var file = files[i];
		if (file.size > 2097152) {
			//check file size (in bytes)
			// $("#dropBox").html("Sorry, your file is too large (>2 MB)");
			$("#file_submit_result").html('');
			$("#fileInput").val("");
			showNotification('error', "Sorry, your file is too large (>2 MB)");
		} else {
			//append the uploadable file to FormData object
			data.append('file', file, file.name);
			//create a new XMLHttpRequest
			var xhr = new XMLHttpRequest();
			//post file data for upload
			xhr.open('POST', path, true);
			xhr.send(data);
			xhr.onload = function () {
				//get response and show the uploading status
				var response = JSON.parse(xhr.responseText);
				$("#comp_upload_filename").val(response.filename);
				if (xhr.status === 200 && response.status == 'ok') {
					// attached_files.push({'file_name':response.original_file_name, 'path':response.filename });
					showNotification('success', 'File '+response.original_file_name+' attached successfully.');
					cb && cb({'file_name':response.original_file_name, 'path':response.filename });
				} else if (response.status == 'type_err') {
					showNotification('error', 'File '+response.original_file_name+'  has unallowed file type');
					$("#fileInput").val("");
				} else {
					showNotification('error', 'File '+response.original_file_name+'  could not be uploaded.');
				}
			};
		}
	}
}

/**
 * Validate if given string is email address
 * @param {string} string 
 */
function validateEmailAddress(str){
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        return (reg.test(str) == false ) ? false: true; 
}


