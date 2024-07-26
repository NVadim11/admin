<div class="card border-0">
    <div class="card-header card-header-stretch">

        <div class="card-toolbar">
            <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                <li class="nav-item">
                    <a class="nav-link text-uppercase active" data-bs-toggle="tab" href="#kt_tab_pane_1">EN</a>
                </li>
                <?php $__currentLoopData = $form->getFields(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if( $value instanceof \Kris\LaravelFormBuilder\Fields\ChildFormType && $value->getOption('tab')): ?>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_<?php echo e($name); ?>"><?php echo e($value->getOption('label')); ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                <?php $__currentLoopData = $form->getFields(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!$value instanceof \Kris\LaravelFormBuilder\Fields\ChildFormType || !$value->getOption('tab')): ?>
                        <?php echo form_row($value); ?>

                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <?php $__currentLoopData = $form->getFields(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if( $value instanceof \Kris\LaravelFormBuilder\Fields\ChildFormType && $value->getOption('tab')): ?>
                    <div class="tab-pane fade" id="kt_tab_<?php echo e($name); ?>" role="tabpanel">
                        <?php echo form_row($value); ?>

                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div><?php /**PATH /home/ubuntu/theshit_php/Modules/Core/Providers/../Resources/views/common/modal/form.blade.php ENDPATH**/ ?>