<div class="d-flex justify-content-end">
	<!--begin::Button-->
	<a href="{{ action($controller.'@index') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">{{ __('core::app.btn_cancel') }}</a>
	<!--end::Button-->
	<!--begin::Button-->
	<button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
		<span class="indicator-label">{{ __('core::app.btn_save') }}</span>
		<span class="indicator-progress">{{ __('core::app.title_loading') }}
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
	</button>
	<!--end::Button-->
</div>