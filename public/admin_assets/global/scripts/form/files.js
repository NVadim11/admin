"use strict";
KTUtil.onDOMContentLoaded(function () {
	new Dropzone("#kt_modal_create_attachments_file", {
		url: "/admin/images/upload",
		paramName: "file",
		maxFiles: 1,
		maxFilesize: 100,
		addRemoveLinks: !0,
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
	}).on("sending", function(file, xhr, formData) {
		var images_table = document.querySelector('input[name="images_table"]'),
			table_link = document.querySelector('input[name="table_link"]'),
			item_id = document.querySelector('input[name="item_id"]');

		// formData.append("table", images_table.getAttribute('value'));
		// formData.append("link", table_link.getAttribute('value'));
		// formData.append("id", item_id.getAttribute('value'));
	});
});
