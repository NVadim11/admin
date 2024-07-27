"use strict";
var KTAppEcommerceSaveProduct = (function () {
	const e = () => {
			$("#kt_ecommerce_add_product_options").repeater({
				initEmpty: !1,
				defaultValues: { "text-input": "foo" },
				show: function () {
					$(this).slideDown(), t();
				},
				hide: function (e) {
					$(this).slideUp(e);
				},
			});
		},
		t = () => {
			document.querySelectorAll('[data-kt-ecommerce-catalog-add-product="product_option"]').forEach((e) => {
				$(e).hasClass("select2-hidden-accessible") || $(e).select2({ minimumResultsForSearch: -1 });
			});
		};
	return {
		init: function () {
			var o, a;
				new Dropzone("#kt_ecommerce_add_product_media", {
					url: "/admin/images/upload",
					paramName: "file",
					maxFiles: 100,
					maxFilesize: 100,
					addRemoveLinks: !0,
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					accept: function (e, t) {
						"wow.jpg" == e.name ? t("Naha, you don't.") : t();
					},
				}).on("sending", function(file, xhr, formData) {
					var images_table = document.querySelector('input[name="images_table"]'),
						table_link = document.querySelector('input[name="table_link"]'),
						item_id = document.querySelector('input[name="item_id"]');

					formData.append("table", images_table.getAttribute('value'));
					formData.append("link", table_link.getAttribute('value'));
					formData.append("id", item_id.getAttribute('value'));
				});
		},
	};
})();
KTUtil.onDOMContentLoaded(function () {
	KTAppEcommerceSaveProduct.init();
});
