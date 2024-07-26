<div <?= $options['wrapperAttrs'] ?> >
    <?php if ($showField): ?>
		<!--begin::Image input-->
		<div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
			<!--begin::Preview existing avatar-->
			<label class="form-label"><?= $options['label'] ?></label>
			<div class="image-input-wrapper w-150px h-150px" style="background-image: url(<?= $options['value'] ? getImagePath($options['value'], 200, 200) : config('assets.metronic.assets_path') . '/media/svg/files/blank-image.svg' ?>)"></div>
			<!--end::Preview existing avatar-->
			<!--begin::Label-->
			<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" style="top: 32px;" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change image">
				<i class="ki-outline ki-pencil fs-7"></i>
				<!--begin::Inputs-->
                <?= Form::input('hidden', str_replace($options['real_name'], $options['real_name']. '_old', $name), $options['value'], $options['attr']) ?>
                <?= Form::input('file', $name, $options['value'], $options['attr']) ?>
				<!--end::Inputs-->
			</label>
            <?php if ($options['value']): ?>
				<div>
                    <?= Form::input('checkbox', str_replace($options['real_name'], $options['real_name']. '_del', $name), 1,
                        ['id'=>str_replace($options['real_name'], $options['real_name']. '_del', $name)]) ?>
                    <?= Form::customLabel(str_replace($options['real_name'], $options['real_name']. '_del', $name),
                        'Удалить', []) ?>
				</div>

            <?php endif; ?>
			<!--end::Label-->
			<!--begin::Cancel-->
			<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
				<i class="ki-outline ki-cross fs-2"></i>
			</span>
			<!--end::Cancel-->
			<!--begin::Remove-->
			<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
				<i class="ki-outline ki-cross fs-2"></i>
			</span>
			<!--end::Remove-->
		</div>
		<!--end::Image input-->
		<!--begin::Description-->
		<div class="text-muted fs-7">Image: *.png, *.jpg, *.jpeg</div>
		<!--end::Description-->

        <?php include 'help_block.php' ?>
        <?php include 'errors.php' ?>
    <?php endif; ?>
</div>
