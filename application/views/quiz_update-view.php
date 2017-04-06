<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form method="post">
		<label for="title">Title</label>
		<input value="<?php echo $quiz->title; ?>" name="title" type="text">
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
		<input value="Update quiz" type="submit">
	</form>
</body>
</html>