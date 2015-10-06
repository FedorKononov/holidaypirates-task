<div class="panel panel-default">
    <div class="panel-heading">Moderator list of job offers</div>

    <table class="table table-striped">
        <thead><tr>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>User</th>
            <th>Created</th>
            <th>Actions</th>
        </tr></thead>
        <tbody>
            <?foreach ($items as $item):?>
                <tr>
                    <td><?= $item->title?></td>
                    <td><?= $item->description?></td>
                    <td><span class="label 
                    <?if ($item->status === 'active'):?>
                        label-success
                    <?elseif ($item->status === 'moderation'):?>
                        label-warning
                    <?else:?>
                        label-default
                    <?endif;?>"><?= $item->status?></span></td>
                    <td><?= $item->user->email?></td>
                    <td><?= $item->created_at?></td>
                    <td>
                        <div class="btn-group btn-group-xs">
                            <?if ($item->status == 'moderation'):?>
                                <a class="btn btn-success" href="/moderator/job/status/<?= $item->id?>/active">approve</a>
                            <?endif;?>
                            <?if ($item->status != 'rejected'):?>
                                <a class="btn btn-danger" href="/moderator/job/status/<?= $item->id?>/rejected">reject</a>
                            <?endif;?>
                        </div>
                    </td>
                </tr>
            <?endforeach;?>
        </tbody>
    </table>
</div>

<?=$items->render(); ?>