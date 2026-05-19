<?php
$db = new mysqli('localhost', 'root', '', 'ci4_blog');
$res = $db->query("SELECT id, title, content FROM posts ORDER BY id DESC LIMIT 5");
while($row = $res->fetch_assoc()) {
    echo 'ID: '.$row['id'].' | TITLE: '.$row['title'].' | CONTENT LENGTH: '.strlen($row['content'])."\n";
}
