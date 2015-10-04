<div class="panel panel-default">
    <div class="panel-heading">My job offers <a class="btn btn-success btn-xs pull-right" href="<?=action('Job\JobController@create');?>"><i class="glyphicon glyphicon-edit"></i> Post new</a></div>

    <table class="table table-striped">
        <thead><tr>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Created</th>
        </tr></thead>
        <tbody>
            <?foreach ($items as $item):?>
                <tr>
                    <td><?= $item->title?></td>
                    <td><?= $item->description?></td>
                    <td><?= $item->status?></td>
                    <td><?= $item->created_at?></td>
                </tr>
            <?endforeach;?>
        </tbody>
    </table>
</div>

<?=$items->render(); ?>