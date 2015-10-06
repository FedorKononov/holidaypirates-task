New job offer comes to moderation.
<br/><br/>
"<?=$job->title;?>" <br/><br/>

<?=$job->description;?>

<br/><br/>

<a href="<?=url('moderator/job/status/'. $job->id .'/active');?>">Approve</a> or <a href="<?=url('moderator/job/status/'. $job->id .'/rejected');?>">Reject</a>