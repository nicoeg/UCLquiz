<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Create</title>
	<script>
		window.settings = {
			baseUrl: '<?php echo base_url(); ?>'
		}
	</script>
</head>
<body>
	<h1>Create</h1>
	<form method="post">
		<label for="title">Title</label>
		<input name="title" type="text">
		<label for="course">Course</label>
		<select name="course">
			<option value="1">Fag 1</option>
			<option value="2">Fag 2</option>
			<option value="3">Fag 3</option>
		</select>
		<label for="level">Level</label>
		<select name="level">
			<option value="1">Level 1</option>
			<option value="2">Level 2</option>
			<option value="3">Level 3</option>
			<option value="4">Level 4</option>
			<option value="5">Level 5</option>
		</select>
		<input value="Create quiz" type="button">
	</form>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="<?php echo base_url(); ?>/assets/js/admin/quiz.js"></script>
</body>
</html>