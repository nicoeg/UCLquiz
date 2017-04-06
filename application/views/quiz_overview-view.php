<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Quizzes</title>
	<style>
		.modal {
			display: none;
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			width: 80%;
			height: 80%;
			background: #fff;
			padding: 50px;
		}

		.modal--active {
			display: block;
		}
	</style>
	<script>
		window.settings = {
			baseUrl: '<?php echo base_url(); ?>',
		}
	</script>
</head>
<body>
	<div class="modal">
		<div class="modal__content">
			<h1>Quiz navn</h1>
			<p>
				<span class="modal__key">ID</span>
				<span class="modal__value" id="id"></span>
			</p>
			<p>
				<span class="modal__key">Title</span>
				<span class="modal__value" id="title"></span>
			</p>
			<p>
				<span class="modal__key">Level</span>
				<span class="modal__value" id="level"></span>
			</p>
			<p>
				<span class="modal__key">Course</span>
				<span class="modal__value" id="course"></span>
			</p>
			<p>
				<span class="modal__key">Created By</span>
				<span class="modal__value" id="createdBy"></span>
			</p>
			<p>
				<span class="modal__key">Actions</span>
				<span class="modal__value" id="actions"></span>
			</p>
		</div>
	</div>
	<h1>Overview</h1>
	<?php echo anchor('quiz/create', 'Create new quiz'); ?>
	<table>
			<tr>
				<th>ID</th>
				<th>Title</th>
				<th>Level</th>
				<th>Course</th>
				<th>Created by</th>
				<th>Actions</th>
			</tr>
			<?php foreach($quizzes as $row) : ?>
				<tr>
					<td><?php echo $row->id; ?></td>
					<td><?php echo $row->title; ?></td>
					<td><?php echo $row->level; ?></td>
					<td><?php echo $row->cID; ?></td>
					<td><?php echo $row->uID; ?></td>
					<td>
						<a class="link--view" href="<?php echo base_url(); ?>/quiz/view/<?php $row->id; ?>" data-id="<?php echo $row->id; ?>">View</a>
						<a class="link--delete" href="<?php echo base_url(); ?>/quiz/delete/<?php $row->id; ?>" data-id="<?php echo $row->id; ?>">Delete</a>
					</td>
				</tr>
			<?php endforeach; ?>
	</table>

	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="<?php echo base_url(); ?>/assets/js/admin/quiz.js"></script>
</body>
</html>