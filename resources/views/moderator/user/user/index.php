<div class="panel panel-default">
    <div class="panel-heading">Users</div>

    <table class="table table-striped">
        <thead><tr>
            <th>Name</th>
            <th>Email</th>
            <th>Created</th>
            <th>Actions</th>
        </tr></thead>
        <tbody>
            <?foreach ($items as $item):?>
                <tr>
                    <td><?= $item->name?></td>
                    <td><?= $item->email?></td>
                    <td><?= $item->created_at?></td>

                    <td>
                        <div class="btn-group btn-group-xs"><a class="btn btn-default" href="/moderator/user/<?= $item->id?>/edit"><i class="glyphicon glyphicon-edit"></i> edit</a></div>
                    </td>
                </tr>
            <?endforeach;?>
        </tbody>
    </table>
</div>

<?=$items->render(); ?>