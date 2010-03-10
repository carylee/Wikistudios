jQuery(document).ready(function() {
	// Document ready...
	
	$("#sortable").sortable({
		placeholder: "ui-selected", 
		revert: true
	});
	
	$("#progressbar").reportprogress(0);

});
