<?php if ($showLabel && $showField): ?>
    <div <?= $options['wrapperAttrs'] ?> >
<?php endif; ?>

<?php if ($showLabel && $options['label'] !== false && $options['label_show']): ?>
    <?= Form::customLabel($name, $options['label'], $options['label_attr']) ?>
<?php endif; ?>

<?php if ($showField): ?>
        <div>
        <?= Form::input($type, $name, $options['value'], $options['attr']) ?>

        <?php include 'help_block.php' ?>

        <?php include 'errors.php' ?>
        </div>
<?php endif; ?>



<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    </div>
    <?php endif; ?>
<?php endif; ?>
