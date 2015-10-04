<h1><?= (empty($user) ? 'User creating' : 'User editing')?></h1>

<?if ($errors->count()):?>
    <div class="alert alert-danger" role="alert">Form contains errors</div>
<?endif;?>

<?= empty($user) ? Form::open() : Form::model($user)?>

    <?if (!empty($user)):?>
        <?= Form::hidden('id', $user->id)?>
    <?endif;?>

    <?  if ($errors->has('email'))
            echo $errors->first('email'), '<br/>';
    ?>

    <?= Form::label('email', 'Email: ') ?>
    <?= Form::text('email', null, ['class' => 'form-control']) ?> <br/><br/>


    <?  if ($errors->has('name'))
            echo $errors->first('name'), '<br/>';
    ?>

    <?= Form::label('name', 'Name: ') ?>
    <?= Form::text('name', null, ['class' => 'form-control']) ?> <br/><br/>


    <?  if ($errors->has('password'))
            echo $errors->first('password'), '<br/>';
    ?>

    <?= Form::label('password', 'Password: ') ?>
    <?= Form::password('password', ['class' => 'form-control']) ?> <br/><br/>

    <?if (empty($user)):?>
        <?= Form::label('password', 'Repeat password: ') ?>
        <?= Form::password('password_confirmation', ['class' => 'form-control']) ?> <br/><br/>
    <?endif;?>


    <?  if ($errors->has('groups'))
            echo $errors->first('groups'), '<br/>';
    ?>

    <?= Form::label('groups', 'Groups: ') ?>
    <?
        $selected = old('groups', !empty($user) ? $user->groups->lists('id') : []);

        foreach ($groups as $item)
            echo '<br/>', Form::checkbox('groups[]', $item->id, in_array($item->id, $selected)), ' ', $item->title;
    ?>
    <br/><br/>

    <?= Form::submit((empty($user) ? 'Create' : 'Save'), ['class' => 'btn btn-primary']) ?>
<?= Form::close() ?>