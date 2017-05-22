<div id="create-quiz"></div>

<?php if (isset($quiz_id)) { ?>
	<script>
		quiz_id = <?= $quiz_id ?>;
	</script>
<?php } ?>
<script src="<?= base_url('dist/js/CreateQuiz.js') ?>"></script>
