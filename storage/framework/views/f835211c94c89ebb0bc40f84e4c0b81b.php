<!--begin::User-->
<div class="">
	<!--begin::User info-->
	<div class="d-flex align-items-center" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-overflow="true" data-kt-menu-placement="top-start">
		<div class="d-flex flex-center cursor-pointer symbol symbol-circle symbol-40px">
			<img src="<?php echo e(config('assets.metronic.assets_path', '')); ?>/media/avatars/300-1.jpg" alt="image" />
		</div>
		<!--begin::Name-->
		<div class="d-flex flex-column align-items-start justify-content-center ms-3">
			<span class="text-gray-500 fs-8 fw-semibold"><?php echo e(__('core::app.title_hello')); ?></span>
			<a href="#" class="text-gray-800 fs-7 fw-bold text-hover-primary"><?php echo e(Auth::user()->name); ?></a>
		</div>
		<!--end::Name-->
	</div>
	<!--end::User info-->
	<!--begin::User account menu-->
	<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
		<!--begin::Menu item-->
		<div class="menu-item px-3">
			<div class="menu-content d-flex align-items-center px-3">
				<!--begin::Avatar-->
				<div class="symbol symbol-50px me-5">
					<img alt="Logo" src="<?php echo e(config('assets.metronic.assets_path', '')); ?>/media/avatars/300-1.jpg" />
				</div>
				<!--end::Avatar-->
				<!--begin::Username-->
				<div class="d-flex flex-column">
					<div class="fw-bold d-flex align-items-center fs-5"><?php echo e(Auth::user()->name); ?>

						<span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Admin</span></div>
					<a href="mailto:<?php echo e(Auth::user()->email); ?>" class="fw-semibold text-muted text-hover-primary fs-7"><?php echo e(Auth::user()->email); ?></a>
				</div>
				<!--end::Username-->
			</div>
		</div>
		<!--end::Menu item-->
		<!--begin::Menu separator-->
		<div class="separator my-2"></div>
		<!--end::Menu separator-->
		<?php echo $__env->make('core::layouts.themes.' . config('assets.metronic.theme_path') . '.particles.user.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php echo $__env->make('core::layouts.themes.' . config('assets.metronic.theme_path') . '.particles.user.mode', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<!--begin::Menu item-->
		<div class="menu-item px-5">
			<a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="menu-link px-5"><?php echo e(__('core::app.btn_signout')); ?></a>
			<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
				<?php echo e(csrf_field()); ?>

			</form>
		</div>
		<!--end::Menu item-->
	</div>
	<!--end::User account menu-->
</div>
<!--end::User--><?php /**PATH /home/ubuntu/theshit_php/Modules/Core/Providers/../Resources/views/layouts/themes/theme42/particles/user/info.blade.php ENDPATH**/ ?>