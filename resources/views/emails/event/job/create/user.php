<?if ($job->status == 'active'):?>
Your job offer "<?=$job->title;?>" has been posted.
<?else:?>
Your job offer "<?=$job->title;?>" is on moderation.
<?endif;?>