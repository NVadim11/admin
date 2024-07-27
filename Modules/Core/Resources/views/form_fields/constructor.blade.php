<?php
    $nameId = str_replace([']','['], ['','_'], $name);
?>
<?php if ($showLabel && $showField): ?>
<?php if ($options['wrapper'] !== false): ?>
<div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
    <?php endif; ?>

    <?php if ($showLabel && $options['label'] !== false && $options['label_show']): ?>
        <?= Form::customLabel($name, $options['label'], $options['label_attr']) ?>
    <?php endif; ?>

    <?php if ($showField): ?>
        <div>
            <textarea name="{{ $name }}" id="{{ $nameId }}_textarea" style="display: none">
                {!! $options['value'] !!}
            </textarea>
			<select id="{{ $nameId }}_list" class="form-select form-select-sm" data-control="select2">
                <option value="">Выберите блок</option>
            </select>
			<div class="mt-5">
				<a href="#" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#kt_modal_select_users">Показать шаблоны</a>
			</div>
            <div id="{{ $nameId }}_content" class="margin-top-20 ctm-blocks">
				{!! makeBlocks($options['value']) !!}
            </div>

        </div>
	@include('constructor::particles.blocks_modal')
    <?php endif; ?>



    <?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
</div>
<?php endif; ?>
<?php endif; ?>
@push('scripts')
    <script>
        $('document').ready(function(){
           Blocks().init('{{ $nameId }}');
		});
    </script>
@endpush
