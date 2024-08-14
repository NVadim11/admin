<!--begin::Form-->
<form class="form w-100 mb-13" novalidate="novalidate" id="kt_sing_in_two_factor_form" action="{{ route('login') }}" data-kt-redirect-url="{{ route('admin.index') }}">
	{{ csrf_field() }}
	<!--begin::Icon-->
	<div class="text-center mb-10">
		<img alt="Logo" class="mh-125px" src="{{ config('assets.metronic.assets_path', '') }}/media/svg/misc/smartphone-2.svg" />
	</div>
	<!--end::Icon-->
	<!--begin::Heading-->
	<div class="text-center mb-10">
		<!--begin::Title-->
		<h1 class="text-dark mb-3">Two-Factor Verification</h1>
		<!--end::Title-->
		<!--begin::Sub-title-->
		<div class="text-muted fw-semibold fs-5 mb-5">Enter the verification code from your Authenticator App</div>
		<!--end::Sub-title-->
	</div>
	<!--end::Heading-->
	<!--begin::Section-->
	<div class="mb-10">
		<!--begin::Label-->
		<div class="fw-bold text-start text-dark fs-6 mb-1 ms-1">Type your 6 digit security code</div>
		<!--end::Label-->
		<!--begin::Input group-->
		<div class="d-flex flex-wrap flex-stack">
			<input type="text" name="code_1" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2" value="" />
			<input type="text" name="code_2" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2" value="" />
			<input type="text" name="code_3" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2" value="" />
			<input type="text" name="code_4" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2" value="" />
			<input type="text" name="code_5" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2" value="" />
			<input type="text" name="code_6" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2" value="" />
		</div>
		<!--begin::Input group-->
	</div>
	<!--end::Section-->
	<!--begin::Submit-->
	<div class="d-flex flex-center">
		<button type="button" id="kt_sing_in_two_factor_submit" class="btn btn-lg btn-primary fw-bold">
			<span class="indicator-label">Submit</span>
			<span class="indicator-progress">Please wait...
			<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
		</button>
	</div>
	<!--end::Submit-->
	<input type="hidden" name="login" value="{{ $login }}">
	<input type="hidden" name="password" value="{{ $password }}">
</form>
<!--end::Form-->
<script src="{{ config('assets.base.scripts', '') }}/sign-in/two-factor.js"></script>