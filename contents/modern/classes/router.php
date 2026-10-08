<?php

use App\login\user;

include_once THEME_CLASSES . '/post.php';
include_once THEME_CLASSES . '/ads.php';
function getContent()
{
    $pageTitle = null;
    $query = isset($_GET['p']) ? $_GET['p'] : null;
    $data = [];
    if ($query) {

        $q = explode('/', $query);
        if ($q[array_key_last($q)] == '') {
            array_pop($q);
            header("location: " . URI_NAME . '/' . implode('/', $q));
            die();
        }

        switch ($q[0]) {
            case '404':
                $pageTitle = 'Page not found';
                $data['include'] =  '404.php';
                $data['seo'] = ['title' => $pageTitle];
                break;
            case 'blog':

                $pageTitle = 'Blog';
                $data['include'] =  'blog.php';
                $data['seo'] = ['title' => $pageTitle];
                $data['show_ads'] = adsEnable('post');
                break;
            default:

                $searchPost = postExist($query);
                if (!$searchPost['success']) {
                    $data['include'] =  '404.php';
                    $pageTitle = 'Page not found';
                } else {
                    $isPrivate = $searchPost['data']->post_visibility != 'public' && !user::isAdmin() ? true : false;
                    $data = !$isPrivate ?
                        [
                            'include' => 'single-post.php',
                            'id' => $searchPost['data']->id,
                            'post_data' => $searchPost['data'],
                            'show_ads' => adsEnable('post'),
                            'seo' => [
                                'title' => $searchPost['data']->post_title,
                                'description' => $searchPost['data']->post_content ? substr(str_replace("\n", " ", strip_tags($searchPost['data']->post_content)), 0, 120) : SITE_DESCRIPTION,
                                'image' => ArticlefeaturedImage($searchPost['data']->id),
                                'schema' => getSchema($searchPost['data'])
                            ],

                        ]
                        :
                        ['include' => '404.php', 'seo' => ['title' => 'Page not found', 'description' => '']];
                    $pageTitle = !$isPrivate ? $searchPost['data']->post_title : 'Page not found';
                }
                break;
        }
    } else {
        $pageTitle = isset($_GET['s']) ? "Searched for " . $_GET['s'] : null;
        $data['include'] = 'home.php';
        $data['show_ads'] = adsEnable('home');
    }
    $data['page_title'] = $pageTitle;
    return $data;
}

function notFound()
{
    header('location: ' . URI_NAME . '/404');
    die();
}

function getSchema($data)
{

    $description = $data->post_content ? substr(str_replace("\n", " ", strip_tags($data->post_content)), 0, 120) : SITE_DESCRIPTION;
    $created = (new DateTime($data->post_date))->format('Y-m-d');
    $updated = (new DateTime($data->post_date_update))->format('Y-m-d');
    $author = user::getData("id=$data->post_author", null, null, 'name')[0]->name ?? null;
    $banner = ArticlefeaturedImage($data->id);
    $sitename = SITE_TITLE;
    $sitelogo = getOption('website_logo');
    return '<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "' . $data->post_guid . '"
  },
  "headline": "' . $data->post_title . '",
  "description": "' . $description . '",
  "image": "' . $banner . '",  
  "author": {
    "@type": "Person",
    "name": "' . $author . '"
  },
  "publisher": {
    "@type": "Organization",
    "name": "' . $sitename . '",
    "logo": {
      "@type": "ImageObject",
      "url": "' . $sitelogo . '"
    }
  },
  "datePublished": "' . $created . '",
  "dateModified": "' . $updated . '"
}
</script>
';
}
