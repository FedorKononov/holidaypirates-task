<h1><?= (empty($group) ? 'Group creating' : 'Group editing')?></h1>

<?if ($errors->count()):?>
    <div class="alert alert-danger" role="alert">Form contains errors</div>
<?endif;?>

<?= empty($group) ? Form::open() : Form::model($group)?>

    <?if (!empty($group)):?>
        <?= Form::hidden('id', $group->id)?>
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

    <?= Form::submit((empty($group) ? 'Create' : 'Save'), ['class' => 'btn btn-primary']) ?>
<?= Form::close() ?>