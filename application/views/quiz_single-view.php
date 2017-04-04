<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Quizzes</title>
</head>
<body>
	<h1>Single</h1>
	<table>
			<tr>
				<th>Title</th>
				<th>Level</th>
				<th>Course</th>
				<th>Created by</th>
			</tr>
			<?php foreach($quiz as $row) : ?>
				<tr>
					<td><?php echo $row->title; ?></td>
					<td><?php echo $row->level; ?></td>
					<td><?php echo $row->cID; ?></td>
					<td><?php echo $row->uID; ?></td>
				</tr>
			<?php endforeach; ?>
	</table>
</body>
</html>