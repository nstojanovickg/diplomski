<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    <div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
<?php endif; ?>

    <?php if ($showLabel && $options['label'] !== false): ?>
        <?php if (isset($options['help_block']['credential_tag'])): ?>
        <div class="col-xs-4 col-md-2">
        <?php endif; ?>
            <?= Form::label($name, $options['label'], $options['label_attr']) ?>
        <?php if (isset($options['help_block']['credential_tag'])): ?>
        </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($showField): ?>
        <?php if (isset($options['help_block']['credential_tag'])): ?>
        <div class="col-xs-8 col-md-10">
        <?php endif; ?>
            <?php foreach ((array)$options['children'] as $child): ?>
                <?= $child->render([], true, true, false) ?>
            <?php endforeach; ?>
        <?php if (isset($options['help_block']['credential_tag'])): ?>
        </div>
        <?php endif; ?>
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
