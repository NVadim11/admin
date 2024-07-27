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
            <div style="margin-bottom: 10px;">
                <?= Form::input('text', 'coord_x', $options['value']['coord_x'], ['id'=>'coord_x', 'class'=>$options['attr']['class']]) ?>
                <div class="help-block">Координата X</div>
            </div>
            <div>
                <?= Form::input('text', 'coord_y', $options['value']['coord_y'], ['id'=>'coord_y', 'class'=>$options['attr']['class']]) ?>
                <div class="help-block">Координата Y</div>
            </div>

        </div>

    <?php endif; ?>



    <?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
</div>
<?php endif; ?>
<?php endif; ?>

<div class="form-group">
    <label class="control-label col-md-2">Поиск адреса</label>
    <div class="col-md-9">
        <input class="form-control" value="" id="search" name="" />
        <span class="help-block">Начните печатать и выберите пункт из появившихся подсказок</span>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-2">Координаты </label>
    <div class="col-md-9">
        <div id="map" style="width: 100%; height: 500px;" data-zoom="{!! $options['value'] ? $options['zoom']['exists']:$options['zoom']['new'] !!}"></div>
</div>
</div>

@push('scripts')
<script src="{{ asset('admin/js/map.js') }}" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRcQiKSIOx58iiQ5IQaBKR41SAlVW0pcI&callback=initMap&libraries=places" type="text/javascript"></script>
@endpush


