<?php $this->helpers->suspensionRedirect($view); ?>
<!DOCTYPE html>
<html lang="en" <?php $this->helpers->htmlClasses(); ?>>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />

    <?php $this->helpers->seo($view); ?>
    <link rel="icon" href="public/images/favicon.png" type="image/x-icon">

    <!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
    <link href="<?php echo URL; ?>public/styles/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/fancybox/source/jquery.fancybox.css" media="screen" />
    <?php $this->helpers->analytics(); ?>
</head>
<body <?php $this->helpers->bodyClasses($view);?>>
<header>
	<div id="header">
		<div class="row">
			<h1>HEADER</h1>
			<nav>
				<a href="#" id="pull"><strong>MENU</strong></a>
				<ul>
					<li <?php $this->helpers->isActiveMenu("home"); ?>><a href="<?php echo URL ?>">HOME</a></li>
					<li <?php $this->helpers->isActiveMenu("gallery"); ?>><a href="<?php echo URL ?>gallery">GALLERY</a></li>
					<li <?php $this->helpers->isActiveMenu("contact"); ?>><a href="<?php echo URL ?>contact">CONTACT US</a></li>
				</ul>
			</nav>
		</div>		
	</div>
</header>

<?php if($view == "home"):?>
	<div id="banner">
		<div class="row">
			<h1>BANNER</h1>
		</div>
	</div>
<?php endif; ?>