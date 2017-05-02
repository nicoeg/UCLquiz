<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('dist/css/flexboxgrid.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('dist/css/stylesheet.css'); ?>">
	<title>UCLquiz</title>

    <script>
        window.settings = {
            baseUrl: '<?php echo base_url(); ?>',
        }
    </script>
</head>
<body>
<header>
    <a href="<?php echo base_url();?>"><img src="<?= base_url('images/ucl.jpg') ?>" alt="UCL Logo" class="logo"></a>

    <nav>
        <a href="<?= base_url('support') ?>">Har du brug for hjælp?</a>
        <?php if (isset($logged_in) && $logged_in) { ?>
            <a href="<?= base_url() ?>">Log ud</a>
        <?php } ?>
        <?php if(uri_string() === 'quizview') : ?>
            <?php if($teacher) : ?> 
                <a href="<?= base_url(); ?>/createquiz" class="button primary">Lav quiz</a> 
            <?php endif; ?>
        <?php endif; ?>
    </nav>
</header>