<?php
session_start();
require('connect.php');

//function dd($value){echo "<pre>", print_r($value, true), "</pre>"; die();}

function executeQuery($sql, $data)
{
	global $conn;
	$stmt = $conn->prepare($sql);
	$values = array_values($data);
	$types = str_repeat('s', count($values));
	$stmt ->bind_param($types, ...$values);
	$stmt ->execute();
	return $stmt;
}


function selectAll($table, $conditions = [])  
{
	global $conn;
	$sql ="SELECT * FROM $table";
	if (empty($conditions)) {	
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		return $records;
	} else {
		//$sql ="SELECT * FROM users WHERE username='...' AND admin=0"
		$i = 0;
		foreach ($conditions as $key => $value){
			if ($i===0) {
				$sql = $sql . " WHERE $key=?";
			} else {
				$sql = $sql . " AND $key=?";
			}
			$i++;
		}
		$stmt = executeQuery($sql, $conditions);
		$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		return $records;
	}
}


function selectOne($table, $conditions)  
{
	global $conn;
	$sql ="SELECT * FROM $table";
	$i = 0;
	foreach ($conditions as $key => $value){
		if ($i===0) {
			$sql = $sql . " WHERE $key=?";
		} else {
			$sql = $sql . " AND $key=?";
		}
		$i++;
	}
	//$sql ="SELECT * FROM $table WHERE $conditions LIMIT 1"
	$sql = $sql ." LIMIT 1";
	$stmt = executeQuery($sql, $conditions);
	$records = $stmt->get_result()->fetch_assoc();
	return $records;
}


function create($table, $data)
{
	global $conn;
	//$sql ="INSERT INTO users SET username=?, admin=?, email=?, password=?"
	$sql = "INSERT INTO $table SET ";
	$i = 0;
	foreach ($data as $key => $value){
		if ($i===0) {
			$sql = $sql . " $key=?";
		} else {
			$sql = $sql . ", $key=?";
		}
		$i++;
	}
	$stmt = executeQuery($sql, $data);
	$id = $stmt->insert_id;
	return $id;

}


function update($table, $id, $data)
{
	global $conn;
	//$sql ="UPDATE INTO users SET username=?, admin=?, email=?, password=? WHERE id=?"
	$sql = "UPDATE $table SET ";
	$i = 0;
	foreach ($data as $key => $value){
		if ($i===0) {
			$sql = $sql . " $key=?";
		} else {
			$sql = $sql . ", $key=?";
		}
		$i++;
	}
	$sql = $sql . " WHERE id=?";
	$data['id'] = $id;
	$stmt = executeQuery($sql, $data);
	$id = $stmt->insert_id;
	return $stmt->affected_rows;
}


function delete($table, $id)
{
	global $conn;
	$sql ="DELETE FROM $table WHERE id=?";
	
	$stmt = executeQuery($sql, ['id'=>$id]);
	return $stmt->affected_rows;
}


function countLike($postId)
{
	global $conn;
    $sql = "SELECT count(id) FROM likes WHERE post_id = $postId";
    $result = mysqli_query($conn, $sql);
	$numLike= mysqli_fetch_assoc($result);
	foreach ($numLike as $value)
	  {echo $value;}
}


function addLike($userId, $postId)
{
	global $conn;
    $sql = "INSERT INTO likes(user_id, post_id) 
			VALUES ($userId, $postId)";
	$result = mysqli_query($conn, $sql);
    if (!$result) {
        die (mysqli_error($conn) . " while executing query: " . $sql);
    }
}


function removeLike($userId, $postId)
{
	global $conn;
    $sql = "DELETE FROM likes WHERE user_id=$userId AND post_id = $postId";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die (mysqli_error($conn) . " while executing query: " . $sql);
    }
}


function countComment($postId)
{
	global $conn;
    $sql = "SELECT count(id) FROM comments WHERE post_id = $postId";
    $result = mysqli_query($conn, $sql);
	$numComment= mysqli_fetch_assoc($result);
	foreach ($numComment as $value)
	  {echo $value;}
}


function getPostComments($postId)
{
	global $conn;
	$sql = "SELECT * 
			FROM comments 
			WHERE post_id = $postId";
	$result = mysqli_query($conn, $sql);
	$comments = mysqli_fetch_all($result,MYSQLI_ASSOC);
	return $comments;
}


function getUsernameByCommentuserID($postId,$userId)
{
	global $conn;
	$sql = "SELECT username 
			FROM users as u, 
			comments as c 
			WHERE c.post_id = $postId 
			AND c.user_id = u.id 
			AND u.id = $userId";
	$result = mysqli_query($conn, $sql);
	$username = mysqli_fetch_row($result);
	return $username;
}


function esclude($term)
{
	global $conn;
		// rimuovi lo spazio vuoto che circonda la stringa
	$checked = trim($term); 
		// rimuove gli slash aggiunti con addslashes
	$checked = stripslashes($checked);
		// converte caratteri speciali in entità HTML
	$checked = htmlspecialchars($checked);
		//esclude i caratteri speciali in una stringa da utilizzare in un'istruzione SQL
	$checked = mysqli_real_escape_string($conn, $checked);
	return $checked;
}


function getUserById($id)
{
    global $conn;
    $sql = "SELECT * FROM users WHERE id=$id LIMIT 1";

    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    // returns user in an array format: 
    // ['id'=>1 'username' => 'jk', 'email'=>'a@a.com', 'password'=> 'mypass']
    return $user; 
}


function getPublishedPosts()
{
	global $conn;
		//SELECT * FROM posts WHERE published=1
		$sql = "SELECT 
					p.*, u.username 
				FROM posts AS p 
				JOIN users AS u 
				ON p.user_id=u.id 
				WHERE p.published=?
					
				ORDER BY p.created_at DESC
				LIMIT 5";

		$stmt = executeQuery($sql, ['published' => 1]);
		$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		return $records;
}


function getPostWhithUsername($postId)
{
	global $conn;
		//SELECT * FROM posts WHERE published=1
		$sql = "SELECT 
					p.*, u.username 
				FROM posts AS p 
				JOIN users AS u 
				ON p.user_id=u.id 
				WHERE p.published=?
				AND  p.id=?
				LIMIT 1";
		$stmt = executeQuery($sql, ['published' => 1,'id' => $postId]);
		$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		return $records;
}


function formatPostFilelds($posts)
{
	if (empty($posts)){
		return[];
	}

	$formattedPosts = [];
	foreach ($posts as $post) {
		$currentPost = $post;
		$currentPost['body'] = html_entity_decode(substr($post['body'], 0, 170) . '...');
		$currentPost['created_at'] = date('F j, Y', strtotime($post['created_at']));
		$currentPost['image'] = BASE_URL . '/assets/imgtblog/images/' . $post['image'];
		array_push($formattedPosts, $currentPost);
	}
	return $formattedPosts;
}


function getPaginatedPosts($currentPage = 1, $recordPerPage = 3)
{
	global $conn;
		$sql = "SELECT
					p.*, u.username 
				FROM posts AS p 
				JOIN users AS u 
				ON p.user_id=u.id 
				WHERE p.published=1
				LIMIT ?,?";
		$data = [
			'offset' => ($currentPage - 1) * $recordPerPage,
			'numberOfRecords' => $recordPerPage
		];
		$stmt = executeQuery($sql, $data);
		$posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		return [
			'posts' => formatPostFilelds($posts),
			'nextPage' => count($posts) < $recordPerPage ? false : $currentPage + 1,
		];
}


function getPostsByTopicId($topic_id)
{
	global $conn;
		//SELECT * FROM posts WHERE published=1
		$sql = "SELECT 
					p.*, u.username 
				FROM posts AS p 
				JOIN users AS u 
				ON p.user_id=u.id 
				WHERE p.published=?
				AND topic_id=?
				AND u.username=`username`
				ORDER BY p.created_at DESC";

		$stmt = executeQuery($sql, ['published' => 1, 'topic_id' => $topic_id]);
		$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		return $records;
}


function getPostsByUserId($user_id) {
	global $conn;
		$sql = "SELECT 
					p.*, u.username 
				FROM posts AS p 
				JOIN users AS u 
				ON p.user_id=u.id 
				WHERE p.published=?
				AND user_id=?
				AND u.username=`username`					
				ORDER BY p.created_at DESC";

		$stmt = executeQuery($sql, ['published' => 1, 'user_id' => $user_id]);
		$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		return $records;
}


function getPostsWhithUsername()
{
	global $conn;
	$sql = "SELECT 
				p.*, u.username 
			FROM posts AS p 
			JOIN users AS u 
			ON p.user_id=u.id			
			ORDER BY p.created_at DESC";
			
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	return $records;
}


function getUserPosts($userId)
{
	global $conn;
	$sql = "SELECT 
				p.*, u.username 
			FROM posts AS p 
			JOIN users AS u 
			ON p.user_id=u.id
			WHERE p.user_id = $userId		
			ORDER BY p.created_at DESC";
			
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	return $records;
}


function getOthersPosts($userId)
{
	global $conn;
	$sql = "SELECT 
				p.*, u.username 
			FROM posts AS p 
			JOIN users AS u 
			ON p.user_id=u.id
			WHERE p.user_id != $userId
			AND p.published=1		
			ORDER BY p.created_at DESC";
			
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	return $records;
}


function searchPosts($term)
{
	$match = '%' . $term . '%';
	global $conn;
		$sql = "SELECT 
					p.*, u.username 
				FROM posts AS p 
				JOIN users AS u 
				ON p.user_id=u.id 
				WHERE p.published=1
				AND p.title LIKE ? OR p.body LIKE ? OR u.username LIKE ?
				ORDER BY created_at DESC";

		$stmt = executeQuery($sql, ['username' => $match,  'title' => $match, 'body' => $match]);
		$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		return $records;
}


function searchAdmins($term)
{
	$match = '%' . $term . '%';
	global $conn;
		$sql = "SELECT admin_users.*
				FROM users AS admin_users
				WHERE admin_users.username LIKE ?
				AND admin_users.admin = 1
				ORDER BY created_at DESC";

		$stmt = executeQuery($sql, ['username' => $match]);
		$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		return $records;
}


function searchUsers($term)
{
	$match = '%' . $term . '%';
	global $conn;
		$sql = "SELECT author_users.*
				FROM users AS author_users
				WHERE author_users.username LIKE ?
				AND author_users.admin = 0

				ORDER BY created_at DESC";

		$stmt = executeQuery($sql, ['username' => $match]);
		$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		return $records;
}


function searchOthersTitles($term, $u_Id)
{
	$match = '%' . $term . '%';
	global $conn;
		$sql = "SELECT othersPosts.*, u.username
				FROM posts AS othersPosts
				JOIN users AS u 
				ON othersPosts.user_id=u.id 
				WHERE othersPosts.title LIKE ?
				AND othersPosts.user_id != $u_Id
				AND othersPosts.published=1
				ORDER BY created_at DESC";

		$stmt = executeQuery($sql, ['title' => $match]);
		$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		return $records;
}


function searchUserTitles($term, $u_Id)
{
	$match = '%' . $term . '%';
	global $conn;
		$sql = "SELECT userPosts.*, u.username
				FROM posts AS userPosts
				JOIN users AS u 
				ON userPosts.user_id=u.id 
				WHERE userPosts.title LIKE ?
				AND userPosts.user_id = $u_Id
				ORDER BY created_at DESC";

		$stmt = executeQuery($sql, ['title' => $match]);
		$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		return $records;
}
?>