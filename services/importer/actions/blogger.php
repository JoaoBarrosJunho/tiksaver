<?php

use App\classes\import_content;


$content = $_FILES['blog_content'] ?? null;

if ($content && $content['type'] != 'application/xml') {
    $user = $importer->user ?? null;
    $visibility = $importer->visibility ?? null;
    $i = new import_content($user, $visibility);
    $i->blogger($content['tmp_name']);
    $execute = $i->getBlogPosts();
} else {
    $execute = ['success' => false, 'message' => 'Invalid file!', 'data' => $_FILES];
}


$success = $execute['success'];
$message = $execute['success'] ? $execute['message'] : $execute['message'];
$dataResponse = $execute['data'];
