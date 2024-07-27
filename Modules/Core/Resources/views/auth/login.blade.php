@extends('core::layouts.themes.' . config('assets.metronic.theme_path') . '.signin.login')

@section('content')
    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="{{ route('admin.index') }}" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
            <!--begin::Heading-->
            @include('core::layouts.themes.' . config('assets.metronic.theme_path') . '.signin.particles.default')
            <!--end::Login options-->
            <!--begin::Input group=-->
            <div class="fv-row mb-8">
                <!--begin::Email-->
                <input class="form-control bg-transparent" type="text" autocomplete="off" placeholder="User name" name="login" value="{{ old('login') }}" required autofocus/>
                @if ($errors->has('login'))
                    <span id="tnc-error" class="help-block">{{ $errors->first('login') }}</span>
                @endif
                <!--end::Email-->
            </div>
            <!--end::Input group=-->
            <div class="fv-row mb-8">
                <!--begin::Password-->
                <input class="form-control bg-transparent" type="password" autocomplete="off" placeholder="Password" name="password" required/>
                @if ($errors->has('password'))
                    <span id="tnc-error" class="help-block">{{ $errors->first('password') }}</span>
                @endif
                <!--end::Password-->
            </div>
            <div class="fv-row mb-3">
                <label class="d-flex text-start active" data-kt-button="true">
                    <!--begin::Remember-->
                    <span class="form-check">
                        <input class="form-check-input" type="checkbox" data-kt-check="true" name="remember" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" {{ old('remember') ? 'checked' : '' }}>
                    </span>
                    <!--end::Remember-->
                    <!--begin::Info-->
                    <span>
                        <span class="text-gray-600 d-block">Remember me</span>
                    </span>
                    <!--end::Info-->
                </label>
            </div>
            <!--end::Input group=-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                <div></div>
                <!--begin::Link-->
{{--                <a href="../../demo42/dist/authentication/layouts/creative/reset-password.html" class="link-primary">Forgot Password ?</a>--}}
                <!--end::Link-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Submit button-->
            <div class="d-grid mb-10">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                    <!--begin::Indicator label-->
                    <span class="indicator-label">Enter</span>
                    <!--end::Indicator label-->
                    <!--begin::Indicator progress-->
                    <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    <!--end::Indicator progress-->
                </button>
            </div>
            <!--end::Submit button-->
    </form>
@endsection
