<h1><?= (empty($permission) ? 'Permission creating' : 'Permission editing')?></h1>

<?if ($errors->count()):?>
    <div class="alert alert-danger" role="alert">Form contains errors</div>
<?endif;?>

<?= empty($permission) ? Form::open() : Form::model($permission)?>

    <?if (!empty($permission)):?>
        <?= Form::hidden('id', $permission->id)?>
    <?endif;?>

    <?  if ($errors->has('title'))
            echo $errors->first('title'), '<br/>';
    ?>

    <?= Form::label('title', 'Title: ') ?>
    <?= Form::text('title', null, ['class' => 'form-control']) ?> <br/><br/>


    <?  if ($errors->has('code'))
            echo $errors->first('code'), '<br/>';
    ?>

    <?= Form::label('code', 'Code: ') ?>
    <?= Form::text('code', null, ['class' => 'form-control']) ?> <br/><br/>

    <?= Form::submit((empty($permission) ? 'Create' : 'Save'), ['class' => 'btn btn-primary']) ?>
<?= Form::close() ?>