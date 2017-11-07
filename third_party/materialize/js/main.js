var httpLocation = window.location;
var base_url = httpLocation.protocol + "//" + httpLocation.host + "/" + httpLocation.pathname.split('/')[1] + '/' + httpLocation.pathname.split('/')[2] + '/';
(function($){
	$(function(e){
		app.initialize();
	});
})(jQuery);

var app = {
	initialize:function(){
		this.init_datepicker('.datepicker');
		members.initialize();
	},
	init_datepicker(selector) {
		$(selector).pickadate({
			selectMonths: true, // Creates a dropdown to control month
			selectYears: 15, // Creates a dropdown of 15 years to control year,
			today: 'Today',
			clear: 'Clear',
			close: 'Ok',
			closeOnSelect: false // Close upon selecting a date,
		});
	}
};

var members = {
	initialize: function() {
		this.check_agreement('.chkbox-agreement');
		this.init_autocomplete_parent('#recruiter');
		// tree.init_childrens('ul.child-tree-list li');

		// // init collapsible
		// $('.collapsible').collapsible();
	},
	check_agreement: function(selector) {
		var checkBoxes = $(selector),
			submitButton = $('#saveMember');

		checkBoxes.change(function () {
			submitButton.attr("disabled", checkBoxes.is(":not(:checked)"));
			if(checkBoxes.is(":not(:checked)")) {
				submitButton.closest('i').addClass('disabled');
			} else {
				submitButton.closest('i').removeClass('disabled');
			}       
		});
	},
	init_autocomplete_parent: function( selector ) {
		members.async_search_parent();
	},
	async_search_parent: function() {
		$.ajax({
			url: base_url + 'members_controller/get_recruiter/',
			dataType: "json",
			beforeSend: function(xhr) {

			},
			success: function(response) {
				var autocompleteDatas = [];
				$.each(response, function(key, value) {
					var keyName = value.member_first_name + " " + value.member_middle_name + " " + value.member_last_name;
					var associativeDatas = { id: value.member_id, text: keyName, img: null };
					autocompleteDatas.push(associativeDatas);
				});
				var $autocomplete = $('ul.autocomplete-content');
				$autocomplete.empty();

				$('input#recruiter').autocomplete2({
					data: autocompleteDatas
				});
			},
			complete: function(xhr,status) {
				// console.log(status);
			},
			error: function(xhr) {
				if (xhr.statusText != 'OK') {
					console.log(xhr.responseText);
				}
			}
		});
	}
}

// Tree Functionalities
var tree = {
	init_childrens: function(selector) {
		$(selector).each(function(e){
			var $this = $(this);
			var $child = $this.find('.child-list');
			var $container = $this.find('.sub-child-body');
			var $parent_id = parseInt( $child.attr('data-id') );
			tree.async_get_childrens($parent_id, $container);
		});
	},
	async_get_childrens: function( $parent_id, $container ) {
		$.ajax({
			url: base_url + 'members_controller/get_childrens/',
			method: "POST",
			dataType: "json",
			data: {
				parent_id: $parent_id
			},
			beforeSend: function(xhr) {

			},
			success: function(response) {
				if ( jQuery.isEmptyObject( response ) != true ) {
					$container.html('<ul class="collapsible popout sub-child-tree-list" data-collapsible="expandable"></ul>');
					console.log(response);
					$.each(response, function(key,value) {
						var childFullName = value.member_first_name + ' ' + value.member_middle_name + ' ' + value.member_last_name;
						var listChildren = '<li><div class="collapsible-header child-list" data-id="'+ value.member_id +'"><i class="material-icons"></i> '+ childFullName +'</div><div class="collapsible-body sub-child-body"></div></li>';
						$('.sub-child-tree-list').append( listChildren );
					});
					$('.collapsible').collapsible();
				}
			},
			complete: function(xhr,status) {
				// console.log(status);
			},
			error: function(xhr) {
				if (xhr.statusText != 'OK') {
					console.log(xhr.responseText);
				}
			}
		});
	}
}

// Individual functions