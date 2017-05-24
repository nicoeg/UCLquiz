<div id="teacherresult"></div>

<?php if (isset($quiz_id)) { ?>
	<script>
		quiz_id = <?= $quiz_id ?>;
	</script>
<?php } ?>

<script src="<?= base_url('dist/js/manifest.js') ?>"></script>
<script src="<?= base_url('dist/js/vendor.js') ?>"></script>
<script src="<?= base_url('dist/js/TeacherResult.js') ?>"></script>
