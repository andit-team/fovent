/*
 * Laravel Classified
 *  All Rights Reserved
 *
 * 
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice
 * 
 */

$(document).ready(function () {
	/* CSRF Protection */
	var token = $('meta[name="csrf-token"]').attr('content');
	if (token) {
		$.ajaxSetup({
			headers: { 'X-CSRF-TOKEN': token }
		});
	}

	$('input#locSearch').devbridgeAutocomplete({
		zIndex: 1492,
		serviceUrl: siteUrl + '/ajax/countries/' + countryCode + '/cities/autocomplete',
		type: 'post',
		data: {
			'city': $(this).val(),
			'_token': $('input[name=_token]').val()
		},
		minChars: 1,
		onSearchStart: function () {
			/* Hide & Disable the field's Tooltip */
			$('#locSearch.tooltipHere').tooltip('hide');
			$('#locSearch.tooltipHere').tooltip('disable');
		},
		onSelect: function (suggestion) {
			$('#lSearch').val(suggestion.data);

			/* Enable the field's Tooltip */
			$('#locSearch.tooltipHere').tooltip('enable');
		}
	});
});