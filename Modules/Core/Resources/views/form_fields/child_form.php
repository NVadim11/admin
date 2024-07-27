

<?php if ($showLabel && $options['label'] !== false && $options['label_show']): ?>
    <?= Form::customLabel($name, $options['label'], $options['label_attr']) ?>
<?php endif; ?>

<?php if ($showField): ?>
    <?php foreach ((array)$options['children'] as $child): ?>
        <?php if( ! in_array( $child->getRealName(), (array)$options['exclude']) ) { ?>
            <?= $child->render() ?>
        <?php } ?>
    <?php endforeach; ?>

    <?php include 'help_block.php' ?>

<?php endif; ?>
