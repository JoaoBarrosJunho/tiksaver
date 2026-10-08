<?php

use App\classes\import_gn_content;


$content = $_FILES['blog_content'] ?? null;

if ($content && $content['type'] != 'text/json') {
    $user = $importer->user ?? null;
    $visibility = $importer->visibility ?? null;
    $i = new import_gn_content($user, $visibility);
    $i->setContent($content['tmp_name']);
    $execute = $i->getBlogPosts();
} else {
    $execute = ['success' => false, 'message' => 'Invalid import file!', 'data' => $_FILES];
}


$success = $execute['success'];
$message = $execute['success'] ? $execute['message'] : $execute['message'];
$dataResponse = $execute['data'];
