<?php 
include("path.php");
include(ROOT_PATH . "/app/controllers/topics.php");

$posts = getPublishedPosts();
$paginatedPosts = getPaginatedPosts(1);


if (isset($_GET['page']) && isset($_GET['ajax'])) {
	$paginatedPosts = getPaginatedPosts($_GET['page']);
	echo json_encode($paginatedPosts);
	exit(0);
}
?>

<!DOCTYPE html>
<html lang="it">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="icon" type="image/ico" sizes="16x16" href="assets/imgtblog/icon.ico">
		<link rel="stylesheet" href="assets/css/style.css">

		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
		integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" 
		crossorigin="anonymous">

			<!--JQuery-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		
			<!-- Slick Carousel -->
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>		
		
			<!-- Custom Script -->
		<script src="assets/js/scripts.js"></script>		

		<title>T&#8210;BLOG</title>
	</head>
	<body>
		<?php include(ROOT_PATH . "/app/includes/tblog_header.php")?>
				
			<!-- Page Wrapper -->
		<div class="page-wrapper">
		<?php include(ROOT_PATH . "/app/helpers/formErrors.php")?>
			
			<div class="post-slider">
				<h1 class="slider-title">Articoli Recenti</h1>
				<div class="slider">
					<i class="fas fa-chevron-left prev"></i>
					<i class="fas fa-chevron-right next"></i>

				<div class="post-wrapper">
					<?php foreach ($posts as $post): ?>
						<div class="post">
							<a href="tblog_article.php?id=<?php echo $post['id']; ?>">
								<img src="<?php echo BASE_URL . '/assets/imgtblog/images/' . $post['image']; ?>" alt="" class="slider-image">
							</a>
							<div class="post-info">
								<div class="slider-post-title">
									<h4><a href="tblog_article.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h4>
								</div>
								<i class="far fa-user"> <?php echo $post['username']; ?> </i>
								&nbsp;
								<i class="far fa-calendar"> <?php echo date('F j, Y', strtotime($post['created_at'])); ?></i>								
							</div>
						</div>
					<?php endforeach; ?>
				</div>		
			</div>

				<!-- Content -->
			<div class="content clearfix">
				<div class="block_grid">
						<!-- Main Content -->
					<div class="main-content">
						<div class="post-list">						
							<h1 class="recent-post-title">Elenco Articoli</h1>

							<?php foreach ($paginatedPosts['posts'] as $post): ?>
								<div class="post clearfix">
									<a href="tblog_article.php?id=<?php echo $post['id']; ?>">
										<img src="<?php echo $post['image']; ?>" alt="" class="post-image">
									</a>
									<div class="post-preview">
										<h2><a href="tblog_article.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h2>
										<i class="far fa-user"> <?php echo $post['username']; ?> </i>
										&nbsp;
										<i class="far fa-calendar"> <?php echo $post['created_at']; ?></i>
										<div class="preview-article">
											<p class="preview-text"><?php echo $post['body']; ?></p>
										</div>
										<a href="tblog_article.php?id=<?php echo $post['id']; ?>" class="btn read-more">Leggi tutto</a>
									</div>
								</div>
							<?php endforeach; ?>	
						</div>
						<div class="pagination_links">
							<a type="button" class="btn main load-more-btn">Continua</a>			
						</div>					
					</div>
					<?php include(ROOT_PATH . "/app/includes/right_sidebar.php") ?>		
				</div>
			</div>
		</div>
		<?php include(ROOT_PATH . "/app/includes/tblog_footer.php") ?>
	
	</body>
</html>