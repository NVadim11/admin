<span style="display: none;"><?php echo e($value); ?></span>
<a href="#"
   data-type="text"
   data-name="<?php echo e($name); ?>"
   data-pk="<?php echo e($model->id); ?>"
   data-url="<?php echo e(action($controller.'@ajaxUpdate', ['id' => $model->id])); ?>"
   class="editable-name editable"><?php echo e($value); ?>

</a>

<?php $__env->startPush('scripts'); ?>
	<script>
		$(document).ready(function() {
			$('.editable-name').editable({
				type: 'text',
				id: $(this).data('pk'),
				url: '/post',
				title: 'Enter text'
			});
		});
		$.ajaxSetup({
			headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}
		});
	</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->yieldPushContent('scripts'); ?><?php /**PATH /home/ubuntu/theshit_php/Modules/Core/Providers/../Resources/views/list_fields/text.blade.php ENDPATH**/ ?>