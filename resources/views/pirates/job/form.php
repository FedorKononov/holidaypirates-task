<h1><?= (empty($job) ? 'Post new job offer' : 'Edit job offer')?></h1>

<?if ($errors->count()):?>
    <div class="alert alert-danger" role="alert">Form contains errors</div>
<?endif;?>

<?= empty($job) ? Form::open() : Form::model($job)?>

    <?if (!empty($job)):?>
        <?= Form::hidden('id', $job->id)?>
    <?endif;?>

    <?  if ($errors->has('title'))
            echo $errors->first('title'), '<br/>';
    ?>

    <?= Form::label('title', 'Title: ') ?>
    <?= Form::text('title', null, ['class' => 'form-control']) ?> <br/><br/>


    <?  if ($errors->has('description'))
            echo $errors->first('description'), '<br/>';
    ?>

    <?= Form::label('description', 'Description: ') ?>
    <?= Form::textarea('description', null, ['class' => 'form-control']) ?> <br/><br/>

    <?= Form::submit((empty($job) ? 'Post' : 'Save'), ['class' => 'btn btn-primary']) ?>
<?= Form::close() ?>