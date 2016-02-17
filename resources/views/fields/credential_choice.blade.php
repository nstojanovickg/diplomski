<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    <div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
<?php endif; ?>

    <?php if ($showLabel && $options['label'] !== false): ?>
    <div class="col-xs-1">
        <?= Form::label($name, $options['label'], $options['label_attr']) ?>
    </div>
    <?php endif; ?>

    <?php if ($showField): ?>
    <div class="col-xs-11">
        <?php foreach ((array)$options['children'] as $child): ?>
            <?= $child->render([], true, true, false) ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if ($options['help_block']['text']): ?>
        <<?= $options['help_block']['tag'] ?> <?= $options['help_block']['helpBlockAttrs'] ?>>
            <?= $options['help_block']['text'] ?>
        </<?= $options['help_block']['tag'] ?>>
    <?php endif; ?>

    <?php if ($showError && isset($errors)): ?>
        <?php foreach ($errors->get($nameKey) as $err): ?>
            <div <?= $options['errorAttrs'] ?>><?= $err ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    </div>
    <?php endif; ?>
<?php endif; ?>
