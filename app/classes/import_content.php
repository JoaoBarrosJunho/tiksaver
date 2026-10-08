<?php

namespace App\classes;

use App\login\user;
use DateTime;
use Exception;

class import_content
{


    protected $content;
    protected $author;
    protected $visibility;
    public function __construct($author = null,$visibility = null)
    {
        $this->author = $author ?? user::logged('id');
        $this->visibility = $visibility??'public';
    }

    public function blogger($file_dir)
    {

        $content = file_get_contents($file_dir) ?? null;
        if ($content) {
            $this->content = $content;
            return $content;
        }

        return false;
    }

    public function getTitle($content)
    {
        return $this->extractData('/<title type=\'text\'>(.+?)<\/title>/', $content);
    }

    public function getContent($content)
    {
        $contents = explode('{#}', $content)[1] ?? null;
        return $contents;
    }

    public function getBlogPosts()
    {
        $success = false;
        $message = '';
        $data = [];
        try {
            foreach (explode("<entry>", $this->content) as $key => $value) {
                if (strpos($value, "kind#post")) {
                    $post = $this->postData($value);
                    if ($post['title']) {
                        $slug = urilize::text($post['title']);
                        if (!post::selectPost("post_slug='$slug'")) {
                            $p = new post();
                            $p->setPost_autor($this->author);
                            $published = (new DateTime($post["published"]))->format("Y-m-d H:i:s");
                            $save = $p->postArticle($post['title'], $slug, leemclasses::genGuid($slug), 'published', html_entity_decode($post["content"]) ?? ' ', 'public', 1, $published);
                            if ($save['success']) {
                                $post_id = $save['article_id'];
                                postmeta::setFeaturedImage($post_id, $post['thumb']??null);
                                $category = $post['category'] ? metatags::addMetaTags($post['category'], "category") : null;
                                $category ? postmeta::setPostCategory($post_id, [$category]) : null;
                                $success = true;
                                $message = 'Posts imported';
                                $data[] = $post_id;
                            }
                        }
                        $message = !$data?'No new posts to import!':$message;
                    }
                }
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
            leemclasses::newLog("ERROR ON BLOG IMPORTER: " . $message);
        }
        
        return ['success' => $success, 'message' => $message,'data'=>$data];
    }

    public function postData($post)
    {
        $processed = str_replace(["<content type='html'>", '</content>'], ["{#}", "{#}"], $post);
        $myData = $this->getContent($processed);

        return ['title' => $this->getTitle($post), 'published' => $this->extractData('/<published>(.+?)<\/published>/', $post), 'category' => $this->extractData('/term=\'(.+?)\'/', $post), 'thumb' => $myData ? $this->extractData('/src="(.+?)"/', $myData) : null, 'content' => $myData];
    }

    public function extractData($pattern, $content)
    {
        if (preg_match($pattern, $content, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
