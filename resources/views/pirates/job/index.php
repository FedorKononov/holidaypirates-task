<div class="panel panel-default">
    <div class="panel-heading">Job offers
        <?if ($auth_user):?>
            <a class="btn btn-success btn-xs pull-right" href="<?=action('Job\JobController@create');?>"><i class="glyphicon glyphicon-edit"></i> Post new</a>
        <?endif;?>
    </div>

    <table class="table table-striped">
        <thead><tr>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>User</th>
            <th>Created</th>
        </tr></thead>
        <tbody>
            <?foreach ($items as $item):?>
                <tr class="<?if ($auth_user and $item->user_id == $auth_user->id):?>info<?endif;?>">
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
                </tr>
            <?endforeach;?>
        </tbody>
    </table>
</div>

<?=$items->render(); ?>