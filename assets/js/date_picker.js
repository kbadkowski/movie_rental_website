$.datepicker.setDefaults( $.datepicker.regional[ "pl" ] );
$.datepicker.setDefaults({
  inline: true,
	minDate: 0,
	dateFormat: 'dd.mm.yy'
});

$("#fromDate").datepicker();
$("#toDate").datepicker();