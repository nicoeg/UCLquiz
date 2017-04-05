<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Quizzes</title>
</head>
<body>
	<h1>Overview</h1>
	<?php echo anchor('quiz/create', 'Create new quiz'); ?>
	<table>
			<tr>
				<th>Title</th>
				<th>Level</th>
				<th>Course</th>
				<th>Created by</th>
				<th>Actions</th>
			</tr>
			<?php foreach($quizzes as $row) : ?>
				<tr>
					<td><?php echo $row->title; ?></td>
					<td><?php echo $row->level; ?></td>
					<td><?php echo $row->cID; ?></td>
					<td><?php echo $row->uID; ?></td>
					<td>
						<?php
							echo anchor('quiz/view/' . $row->id . '', 'View');
							echo anchor('quiz/delete/' . $row->id . '', 'Delete');
						?>
					</td>
				</tr>
			<?php endforeach; ?>
	</table>
</body>
</html>