<div class="panel panel-default">
    <div class="panel-heading">Permissions <a class="btn btn-success btn-xs pull-right" href="<?=action('Moderator\User\PermissionController@create');?>"><i class="glyphicon glyphicon-edit"></i> Create permission</a></div>

    <table class="table table-striped">
        <thead><tr>
            <th>Title</th>
            <th>Code</th>
            <th>Created</th>
        </tr></thead>
        <tbody>
            <?foreach ($items as $item):?>
                <tr>
                    <td><?= $item->title?></td>
                    <td><?= $item->code?></td>
                    <td><?= $item->created_at?></td>
                </tr>
            <?endforeach;?>
        </tbody>
    </table>
</div>

<?=$items->render(); ?>