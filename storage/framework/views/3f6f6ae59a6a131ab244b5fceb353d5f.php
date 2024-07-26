<?php $__env->startSection('page-title', 'Settings'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card rounded-0 border-0">
        <div class="card-body pt-0">
            <?php echo form_start($form, ['class'=>'form-horizontal form-bordered form-label-stripped']); ?>

            <?php echo $__env->make('core::settings.form_body', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo form_end($form); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('core::layouts.themes.' . config('assets.metronic.theme_path') . '.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ubuntu/theshit_php/Modules/Core/Providers/../Resources/views/settings/index.blade.php ENDPATH**/ ?>