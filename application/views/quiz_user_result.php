<div id="userquizresult"></div>

<?php if (isset($user_quiz_id)) { ?>
	<script>
		user_quiz_id = <?= $user_quiz_id ?>;
	</script>
<?php } ?>

<script src="<?= base_url('dist/js/manifest.js') ?>"></script>
<script src="<?= base_url('dist/js/vendor.js') ?>"></script>
<script src="<?= base_url('dist/js/UserQuizResult.js') ?>"></script>
