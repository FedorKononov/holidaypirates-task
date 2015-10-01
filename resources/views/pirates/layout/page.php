<!DOCTYPE html>
<html lang="ru">

	<?= View::make('layout.meta')->render() ?>

	<body>

		<?= view($content_template)->render(); ?>

		<?= View::make('layout.footer')->render() ?>
	</body>
</html>