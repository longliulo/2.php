 <?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//convert to utf8
mysqli_set_charset($conn,"utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Select column in database
$sql = "
SELECT wp_posts.id, wp_posts.post_title, wp_posts.post_name, wp_posts.post_content, wp_terms.name, wp_terms.slug 
FROM wp_posts, wp_term_relationships, wp_terms
where wp_posts.id = wp_term_relationships.object_id and
wp_term_relationships.term_taxonomy_id = wp_terms.term_id and
wp_terms.term_id not in (1,2);
";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        //print_r($row);
        $page_access_token = '';
		$page_id = '';


		$data['link'] = "http://domain.com/". $row["slug"] ."/" . $row["post_name"];
		$data['message'] = strip_tags($row["post_content"]);
		$data['caption'] = $row["post_title"];
		$data['description'] = $row["post_title"] . " " . $row["name"];

		$data['access_token'] = $page_access_token;
		$post_url = 'https://graph.facebook.com/'.$page_id.'/feed';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $post_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$return = curl_exec($ch);
		curl_close($ch);
       
    }
} else {
    echo "0 results";
}
$conn->close();
?> 