<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Quizzes</title>
</head>
<body>
	<h1>Single</h1>
	<?php echo anchor('quiz/update', 'refresh'); ?>
	<table>
			<tr>
				<th>Title</th>
				<th>Level</th>
				<th>Course</th>
				<th>Created by</th>
			</tr>
			<tr>
				<td><?php echo $quiz->title; ?></td>
				<td><?php echo $quiz->level; ?></td>
				<td><?php echo $quiz->cID; ?></td>
				<td><?php echo $quiz->uID; ?></td>
			</tr>
	</table>
</body>
</html>