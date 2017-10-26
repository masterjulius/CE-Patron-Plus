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
	}
}