<?php if ($showLabel && $showField): ?>
	<?php if ($options['wrapper'] !== false): ?>
		<div <?= $options['wrapperAttrs'] ?> >
	<?php endif; ?>
<?php endif; ?>

			<?php if ($showLabel && $options['label'] !== false && $options['label_show']): ?>
				<?= Form::customLabel($name, $options['label'], $options['label_attr']) ?>
			<?php endif; ?>

			<?php if ($showField): ?>
				<div class="col-md-9">
					<?php if ($options['value']): ?>
						<div>
							<a href="<?=Storage::url($options['value'])?>" target="_blank"><?=$options['value']?></a>
						</div>
						<div>

							<?= Form::input('checkbox',  str_replace($options['real_name'], $options['real_name']. '_del', $name), 1,
								['id'=>str_replace($options['real_name'], $options['real_name']. '_del', $name)]) ?>
							<?= Form::customLabel(str_replace($options['real_name'], $options['real_name']. '_del', $name), 'Delete', []) ?>
						</div>

					<?php endif; ?>
					<style>
						.fileinput-new .form-control {display: none;}
					</style>
					<div class="fileinput fileinput-new" data-provides="fileinput">
						<div class="input-group input-large">
							<div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
								<i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename"></span>
							</div>
							<span class="input-group-addon default btn-file">
								<span onclick="$(this).parent('.btn-file').find('input[type=file]').click();" class="fileinput-new btn btn-sm btn-primary rounded-0">Select file  </span>
								<span onclick="$(this).parent('.btn-file').find('input[type=file]').click();" class="fileinput-exists btn btn-sm btn-primary rounded-0">Chenge file</span>
								<?= Form::input('hidden', str_replace($options['real_name'], $options['real_name']. '_old', $name), $options['value'], $options['attr']) ?>
								<?= Form::input('file', $name, $options['value'], $options['attr']) ?>
							</span>
							<a href="javascript:;" class="input-group-addon btn btn-sm btn-danger fileinput-exists rounded-0" data-dismiss="fileinput">Delete </a>
						</div>
					</div>

					<?php include 'help_block.php' ?>

					<?php include 'errors.php' ?>
				</div>
			<?php endif; ?>



			<?php if ($showLabel && $showField): ?>
			<?php if ($options['wrapper'] !== false): ?>
		</div>
	<?php endif; ?>
<?php endif; ?>