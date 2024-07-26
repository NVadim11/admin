<?php $__env->startSection('page-title', $title); ?>

<?php $__env->startSection('actions'); ?>
	<a href="<?php echo e(action($controller.'@create')); ?>" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"> <?php echo e(__('core::app.btn_create')); ?></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<!--begin::Card-->
	<div class="card rounded-0 border-0">
		<!--begin::Card header-->
		<div class="card-header border-1 pt-0">
			<!--begin::Card title-->
			<div class="card-title">
				<!--begin::Search-->
				<div class="d-flex align-items-center position-relative my-1">
					<i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
					<form action="<?php echo e(action($controller.'@index')); ?>" method="get">
						<input type="text" name="search" value="<?php echo e(request()->get('search') ?? ''); ?>" data-kt-customer-table-filter="search" class="form-control ps-13 rounded-0 h-40px" placeholder="<?php echo e(__('core::app.placeholder_search')); ?>" />
					</form>
				</div>
				<!--end::Search-->
			</div>
			<!--begin::Card title-->
			<!--begin::Card toolbar-->
			<div class="card-toolbar">
				<!--begin::Toolbar-->
				<div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
					<!--begin::Filter-->
					<button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
						<i class="ki-outline ki-filter fs-2"></i>Filter</button>
					<!--begin::Menu 1-->
					<div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px h-700px overflow-scroll" data-kt-menu="true">
						<!--begin::Header-->
						<div class="px-7 py-5">
							<div class="fs-5 text-dark fw-bold">Filter Options</div>
						</div>
						<!--end::Header-->
						<!--begin::Separator-->
						<div class="separator border-gray-200"></div>
						<!--end::Separator-->
						<!--begin::Content-->
						<div class="px-7 py-5" data-kt-user-table-filter="form">
							<form action="<?php echo e(action($controller.'@index')); ?>" method="GET">
								<!--begin::Input group-->
								<?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php if($field['type'] == 'option'): ?>
									<div class="mb-7">
										<label class="form-label fs-6 fw-semibold"><?php echo e($field['name']); ?>:</label>
										<select class="form-select form-select-sm" data-kt-select2="true" name="<?php echo e($k); ?>" data-placeholder="Select option" data-allow-clear="true" data-kt-user-table-filter="role" data-hide-search="true">
											<option></option>
											<?php $__currentLoopData = $field['choises']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n => $choice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option value="<?php echo e($n); ?>" <?php echo e(!empty(request()->get($k)) && request()->get($k) == $n ? 'selected' : ''); ?>><?php echo e($choice); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</select>
									</div>
									<?php elseif($field['type'] == 'text'): ?>
										<div class="mb-7">
											<label class="form-label fs-6 fw-semibold"><?php echo e($field['name']); ?>:</label>
											<div>
												<input class="form-control form-control-sm fw-bold" value="<?php echo e(!empty(request()->get($k)) ? request()->get($k) : ''); ?>" name="<?php echo e($k); ?>" type="text" id="<?php echo e($k); ?>">
											</div>
										</div>
									<?php elseif($field['type'] == 'static'): ?>
										<div class="mb-7">
											<label class="form-label fs-6 fw-semibold"><?php echo e($field['name']); ?>:</label>
											<div>
												<input class="form-control form-control-sm fw-bold" value="<?php echo e(!empty(request()->get($k)) ? request()->get($k) : ''); ?>" name="<?php echo e($k); ?>" type="text" id="<?php echo e($k); ?>">
											</div>
										</div>
									<?php elseif($field['type'] == 'textarea'): ?>
										<div class="mb-7">
											<label class="form-label fs-6 fw-semibold"><?php echo e($field['name']); ?>:</label>
											<div>
												<input class="form-control form-control-sm fw-bold" value="<?php echo e(!empty(request()->get($k)) ? request()->get($k) : ''); ?>" name="<?php echo e($k); ?>" type="text" id="<?php echo e($k); ?>">
											</div>
										</div>
									<?php endif; ?>
									<!--end::Input group-->
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<!--begin::Actions-->
								<div class="d-flex justify-content-end">
									<button type="reset" onclick="location.href='<?php echo e(action($controller.'@index')); ?>'" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Reset</button>
									<button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">Apply</button>
								</div>
							</form>
							<!--end::Actions-->
						</div>
						<!--end::Content-->
					</div>
					<!--end::Menu 1-->
					<!--end::Filter-->
					<!--begin::Export-->


					<!--end::Export-->
					<!--begin::Add customer-->
					<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_customer"><?php echo e(__('core::app.btn_add')); ?></button>
					<!--end::Add customer-->
				</div>
				<!--end::Toolbar-->
				<!--begin::Group actions-->
				<div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
					<div class="fw-bold me-5">
						<span class="me-2" data-kt-customer-table-select="selected_count"></span><?php echo e(__('core::app.btn_selected')); ?></div>
					<button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected"><?php echo e(__('core::app.btn_delete_selected')); ?></button>
				</div>
				<!--end::Group actions-->
			</div>
			<!--end::Card toolbar-->
		</div>
		<!--end::Card header-->
		<!--begin::Card body-->
		<div class="card-body pt-0">
			<?php echo $__env->make('core::common.table.' . $outlist, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>
		<!--end::Card body-->
	</div>
	<!--end::Card-->

	<?php echo $__env->make('core::common.modal.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('core::layouts.themes.' . config('assets.metronic.theme_path') . '.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ubuntu/theshit_php/Modules/Core/Providers/../Resources/views/common/index.blade.php ENDPATH**/ ?>