<a href="#"
   id="<?php echo e($name); ?>-<?php echo e($value . '-' . $model->id); ?>"
   data-name="<?php echo e($name); ?>"
   data-type="select"
   data-pk="<?php echo e($model->id); ?>"
   data-url="<?php echo e(action($controller.'@ajaxUpdate', ['id' => $model->id])); ?>"
   data-title="<?php echo e($field['name']); ?>"><?php echo e($field['choises'][$value] ?? ''); ?>

</a>
<?php $__env->startPush('scripts'); ?>
	<script>
		jQuery(document).ready(function() {
			$('#<?php echo e($name); ?>-<?php echo e($value . '-' . $model->id); ?>').editable({
				value: <?php echo e($value); ?>,
				source: [
					<?php $__currentLoopData = $field['choises']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						{value: '<?php echo e($val); ?>', text: '<?php echo e($title); ?>'},
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				]
			});
		});
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->yieldPushContent('scripts'); ?>
<?php /**PATH /home/ubuntu/theshit_php/Modules/Core/Providers/../Resources/views/list_fields/option.blade.php ENDPATH**/ ?>