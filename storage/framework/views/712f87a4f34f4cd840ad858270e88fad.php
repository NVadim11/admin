<?php $aside = 0; $k = 0; $n = 0; ?>
<?php $__currentLoopData = $form->getFields(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<?php if($value->getOption('aside')): ?>
		<?php $aside = 1; ?>
	<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<div class="card border-0">
	<div class="card-header card-header-stretch">
		<div class="card-toolbar">
			<ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
				<?php $__currentLoopData = $form->getFields(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php if( $value instanceof \Kris\LaravelFormBuilder\Fields\ChildFormType && $value->getOption('tab')): ?>
						<li class="nav-item">
							<a class="nav-link <?php echo e(!$k ? 'active' : ''); ?>" data-bs-toggle="tab" href="#kt_tab_<?php echo e($name); ?>"><?php echo e($value->getOption('label')); ?></a>
						</li>
					<?php endif; ?>
					<?php $k++; ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
		</div>
	</div>
	<div class="card-body">
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
				<!--begin::Form-->
				<div id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="../../demo42/dist/apps/ecommerce/catalog/products.html">
					<?php if($aside): ?>
						<!--begin::Aside column-->
						<div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
							<?php $__currentLoopData = $form->getFields(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if(!$value instanceof \Kris\LaravelFormBuilder\Fields\ChildFormType || !$value->getOption('tab')): ?>
									<?php if($value->getOption('aside')): ?>
										<!--begin::Thumbnail settings-->
										<div class="card card-flush py-4">
											<!--begin::Card header-->
											<div class="card-header">
												<!--begin::Card title-->
												<div class="card-title">
													<h2><?php echo e($value->getOption('label')); ?></h2>
												</div>
												<!--end::Card title-->
											</div>
											<!--end::Card header-->
											<!--begin::Card body-->
											<div class="card-body text-center pt-0">
												<?php echo form_row($value); ?>

											</div>
											<!--end::Card body-->
										</div>
										<!--end::Thumbnail settings-->
									<?php endif; ?>
								<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
						<!--end::Aside column-->
					<?php endif; ?>
				</div>
				<!--end::Form-->
			</div>

			<?php $__currentLoopData = $form->getFields(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if( $value instanceof \Kris\LaravelFormBuilder\Fields\ChildFormType && $value->getOption('tab')): ?>
					<div class="tab-pane fade <?php echo e(!$n ? 'show active' : ''); ?>" id="kt_tab_<?php echo e($name); ?>" role="tabpanel">
						<?php echo form_row($value); ?>

					</div>
					<?php $n++; ?>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</div>
	<?php echo $__env->make('core::settings.particles.save-button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div><?php /**PATH /home/ubuntu/theshit_php/Modules/Core/Providers/../Resources/views/form_body.blade.php ENDPATH**/ ?>