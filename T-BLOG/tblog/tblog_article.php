<?php 
include("path.php"); 
include(ROOT_PATH . "/app/controllers/posts.php");

if (isset($_GET['id'])) {
	$postId=$_GET['id'];
	$posts = getPostWhithUsername($postId);
	$post = $posts['0'];
}

if (isset($_SESSION['id'])) {
	$userId = $_SESSION['id'];
}

if (isset($_POST['action'])) { //action viene stabilito con un if dal value di un input
	usersOnly();
	$action = $_POST['action'];
	if ($action == 'like') { //se è settato like allora verrà aggiunto un like nel db
		addLike($userId, $postId);
		header('location: tblog_article.php?id='. $post['id'] );
		exit(0);
	}
	elseif ($action == 'dislike') { //se è settato dislike allora verrà rimosso il like già inserito nel db
		removeLike($userId, $postId);
		header('location: tblog_article.php?id='. $post['id'] );
		exit(0);
	}
}

$comments = getPostComments($postId);
if (isset($_POST['comment_btn'])) {
	usersOnly();
	$comment = esclude($_POST['comment'],0,800); //ricevo in input la stringa e la controllo
	if (preg_match('/[\^£$&*}{@#~><>|=_+]/', $comment))
	  {array_push($errors, "Uno o pi&#249; caratteri non validi"); 
	}

	if (empty($comment)) { 
		array_push($errors, "Inserisci il testo del commento"); 
	}

	if (count($errors) == 0) {//se non ci sono errori inserisce nel db il commento e reindirizza
	   	$sql = "INSERT INTO comments(user_id,post_id,body,created_at) VALUES('$userId','$postId', '$comment',now())";
	   	$result = mysqli_query($conn, $sql);
	   	if (!$result) {
		   	echo "Errore nella query $query: " . $conn->error; 
		} else { 
			$userId = getUserById($userId) ;
			header('location: tblog_article.php?id='. $postId);
			exit(0);
		}
	}	
}

if (isset($_POST['comment-off'])) { //cancella dai commenti e reindirizza
	usersOnly();
	$commentId = ($_POST['delete']);
	$sql = "DELETE FROM comments WHERE id='$commentId'";
	$result = mysqli_query($conn,$sql);
	if (!$result) {
		echo "Errore nella query $sql: " . $conn->error; 
	} else {
		header('location: tblog_article.php?id='. $postId);
		exit(0);
	} 
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
		integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

			<!--JQuery-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
			<!-- Custom Script -->
		<script src="assets/js/scripts.js"></script>

		<title><?php echo $post['title']; ?>  &#31; T&#8210;BLOG</title>
	</head>
	<body>
		<?php include(ROOT_PATH."/app/includes/tblog_header.php") ?>
		<div class="page-wrapper">			
			<div class="content clearfix">
				<div class="block_grid">
					<div class="main-content-wrapper">
						<div class="main-content article">
							<div class="title-comments">
								<h1 class="post-title"><?php echo $post['title']; ?></h1>
								<div class="count_comments">
									<a href="#comments">
										<i class="fas fa-comments"></i>
										<sup><?php echo $numComment = countComment($postId); ?></sup>
									</a>
								</div>
							</div>																	
							<div class="post-content">
								<img src="<?php echo BASE_URL . '/assets/imgtblog/images/' . $post['image']; ?>" alt="">
								<?php echo html_entity_decode($post['body']); ?>
							</div>
							<div class="article_info">
								<div class="section user_info">
									<a href="<?php echo BASE_URL . '/tblog_search.php?u_id=' . $post['user_id'] . '&name=' . $post['username'] ; ?>">
										<button class="btn main"><i class="far fa-user"> <?php echo $post['username'] ?></i></button>
									</a>
									<i class="date_post far fa-calendar"> <?php echo date('F j, Y', strtotime($post['created_at'])); ?></i>
								</div>
							</div>							
							<div class="like" >								
								<a class="count"><i class="fas fa-heart"></i><sub><?php echo $numLike = countLike($postId); ?></sub></a>
								<div class="like-btn">					
									<?php if(isset($_SESSION['id'])): ?>
										<script>
											function likeFunction(x) {
												x.classList.toggle("btn main fa fa-heart-broken");
											};
										</script>									
										<?php //controla se l'user ha già messo like 
											$results = mysqli_query($conn, "SELECT * FROM likes WHERE user_id=$userId AND post_id=$postId");									

											if (mysqli_num_rows($results) == 1): ?>
												<form method="post">													
													<button type="submit" onclick="likeFunction(this)" class="btn main fa fa-heart-broken" title="non mi piace pi&#249;"></button>
													<input type="hidden" name="action" value="dislike">
													<input type="hidden" name="post_id" value="<?php echo $postId; ?>">
												</form>
											<?php else: ?>												
												<form method="post">
													<button type="submit" onclick="likeFunction(this)" class="btn main fa fa-heart" title="mi piace"></button>
													<input type="hidden" name="action" value="like">
												</form>
										<?php endif; ?>
									<?php else: ?>
										<a href="<?php echo BASE_URL . '/tblog_login.php' ?>">
											<button style="background-color:silver;" class="btn fa fa-heart" title="Per mettere &#128153; entra nel tuo profilo"></button>
										</a>
									<?php endif; ?>
								</div>										
							</div>			
						</div>
						<div class="section comments">
							<div class="main-content comments">				
								<div class="content-comments">
									<?php if(isset($_SESSION['id'])): ?>
										<?php include(ROOT_PATH . "/app/helpers/formErrors.php")?>																		
										<form method="post" class="add-comment" action="tblog_article.php?id=<?php echo $postId; ?>">
											<textarea class= "text-input" name="comment" rows="4" minlength="4" maxlength="800" placeholder="Scrivi un commento... "></textarea>
											<button type="submit" class= "btn main comment" name="comment_btn">Commenta</button><br>
										</form >
									<?php else: ?>
										<p><i>*<sub>per lasciare un commento <a href="<?php echo BASE_URL . '/tblog_login.php' ?>"><u>enta nel tuo profilo</u></a>.<sub></i></p>
									<?php endif; ?>
									<h2 class="section-title" id="comments">Commenti</h2>								
									<?php foreach ($comments as $comment): //visualizzo tutti i commenti ?>
										<div class="comments_item">
											<?php $commentId = $comment['id']; ?>
											<?php $commentUserId = $comment['user_id']; ?>
											<div class="text-comment">													
												<h4>
													<u><?php $username = getUsernameByCommentuserId($postId,$commentUserId); echo $username['0']; ?></u> 
													<sub><i class="far fa-calendar"> <?php echo date("F j, Y ", strtotime($comment["created_at"])); ?></i></sub>
												</h4>
												<p><?php echo($comment['body']);?></p>													
											</div>
											<?php if(isset($_SESSION['id'])): ?>
												<?php if($userId == $commentUserId): //l'utente vedrà il bottone per eliminare il commento se lui lo ha scritto?>
													<form method="post" class="comment-off" action="tblog_article.php?id=<?php echo $postId; ?>">
														<input type="hidden" name="delete" value="<?php echo $commentId; ?>">
														<button type="submit" class="btn main off-comment" name="comment-off">elimina</button>
													</form>													
												<?php endif; ?>
											<?php endif; ?>
										</div>
									<?php endforeach; ?>
								</div>	
							</div>
						</div>											
					</div>
					<?php include(ROOT_PATH . "/app/includes/right_sidebar.php") ?>				
				</div>
			</div>
		</div>
		<?php include(ROOT_PATH . "/app/includes/tblog_footer.php") ?>
	</body>
</html>