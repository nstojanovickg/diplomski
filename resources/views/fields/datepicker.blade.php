@section('styles')
    {!! Html::style('css/bootstrap-datepicker.css') !!}
@stop
@section('scripts')
	{!! Html::script('js/bootstrap-datepicker.js') !!}
@stop
<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    <div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
<?php endif; ?>

    <?php if ($showLabel && $options['label'] !== false): ?>
    <?= Form::label($name, $options['label'], $options['label_attr']) ?>
    <?php endif; ?>

    <?php if ($showField): ?>
	<?php if (isset($options['help_block']['col_tag'])): ?>
    <div class="col-xs-8">
    <?php endif; ?>
        <div class="input-group date">
		<?= Form::input($type, $name, $options['value'], $options['attr']) ?>
        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
        </div>
	<?php if (isset($options['help_block']['col_tag'])): ?>
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
<script>
$('.input-group.date').datepicker({
	<?php
	if (isset($options['date']) && $options['date']) {
    ?>
    format: "yyyy-mm-dd",
	<?php
	}
	else{
	?>
	format: "yyyy-mm-dd 00:00:00",
	<?php
	}?>
    weekStart: 1,
    forceParse: false,
    autoclose: true,
    todayHighlight: true,
	orientation: "auto top"
});
</script>