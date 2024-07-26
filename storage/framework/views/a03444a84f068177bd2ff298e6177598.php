<?php $__env->startSection('content'); ?>
    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="<?php echo e(route('admin.index')); ?>" method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo e(csrf_field()); ?>

            <!--begin::Heading-->
            <?php echo $__env->make('core::layouts.themes.' . config('assets.metronic.theme_path') . '.signin.particles.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!--end::Login options-->
            <!--begin::Input group=-->
            <div class="fv-row mb-8">
                <!--begin::Email-->
                <input class="form-control bg-transparent" type="text" autocomplete="off" placeholder="User name" name="login" value="<?php echo e(old('login')); ?>" required autofocus/>
                <?php if($errors->has('login')): ?>
                    <span id="tnc-error" class="help-block"><?php echo e($errors->first('login')); ?></span>
                <?php endif; ?>
                <!--end::Email-->
            </div>
            <!--end::Input group=-->
            <div class="fv-row mb-8">
                <!--begin::Password-->
                <input class="form-control bg-transparent" type="password" autocomplete="off" placeholder="Password" name="password" required/>
                <?php if($errors->has('password')): ?>
                    <span id="tnc-error" class="help-block"><?php echo e($errors->first('password')); ?></span>
                <?php endif; ?>
                <!--end::Password-->
            </div>
            <div class="fv-row mb-3">
                <label class="d-flex text-start active" data-kt-button="true">
                    <!--begin::Remember-->
                    <span class="form-check">
                        <input class="form-check-input" type="checkbox" data-kt-check="true" name="remember" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" <?php echo e(old('remember') ? 'checked' : ''); ?>>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('core::layouts.themes.' . config('assets.metronic.theme_path') . '.signin.login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ubuntu/theshit_php/Modules/Core/Providers/../Resources/views/auth/login.blade.php ENDPATH**/ ?>