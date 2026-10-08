<?php

namespace App\classes;

use DateTime;
use Thepixeldeveloper\Sitemap\Urlset;
use Thepixeldeveloper\Sitemap\Url;
use Thepixeldeveloper\Sitemap\Drivers\XmlWriterDriver;
use Thepixeldeveloper\Sitemap\Sitemap as SitemapSitemap;
use Thepixeldeveloper\Sitemap\SitemapIndex;

class sitemap
{

    private $urlSet;
    protected $limit;

    public function __construct()
    {
        $this->limit = 1000;
        $this->urlSet = new Urlset();
    }

    public  function get()
    {
        $driver = new XmlWriterDriver();
        $driver->addProcessingInstructions('xml-stylesheet', 'type="text/xsl" href="' . URI_NAME . '/assets/css/sitemap.xsl"');

        $this->urlSet->accept($driver);
        return $driver->output();
    }

    public function setUrl($link, $date, $priority = '0.64')
    {
        $date = new DateTime("$date");
        $url = new Url($link);
        $url->setLastMod($date);
        $url->setPriority($priority);
        $this->urlSet->add($url);
    }

    public function setPosts()
    {
        $limit_ = $this->limit;
        $where = "post_type='article' AND post_visibility='public'";
        $pg_num = (new leemclasses())->pagination('posts', $limit_, $where);
        $sitemapeFileDir = SITE_ROOT . "/app/views/sitemap/post-sitemap@Page.xml";


        if ($pg_num > 1) {
            $y = 1;


            for ($y; $y <= $pg_num; $y++) {

                $newDir = $y > 1 ? str_replace('@Page', $y, $sitemapeFileDir) : str_replace('@Page', '', $sitemapeFileDir);


                $resisters = 0;

                if (file_exists($newDir)) {
                    $sitemapeString = file_get_contents($newDir);
                    $resisters = substr_count($sitemapeString, "<loc>");
                }

                if ($resisters != $limit_) {

                    $page = $y;

                    $offset = (new leemclasses())->getOffset($page, $limit_);

                    $posts = post::selectPost("post_type='article' AND post_visibility='public'", "$limit_ OFFSET $offset", 'id ASC', 'post_date_update,post_guid');

                    if ($posts && count($posts) != $resisters) {
                        if (!file_exists($newDir) || count($posts) <= $limit_) {
                            unset($this->urlSet);
                            $this->urlSet = new Urlset();
                            foreach ($posts as $post) {
                                $this->setUrl($post->post_guid, $post->post_date_update, '0.80');
                            }

                            if ($newDir) {
                                $f = fopen($newDir, 'w');
                                if (fwrite($f, $this->get())) {
                                    fclose($f);
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $posts = post::selectPost("post_type='article' AND post_visibility='public'", $this->limit, 'id DESC', 'post_date_update,post_guid');
            if ($posts) {
                $newDir = str_replace('@Page', '', $sitemapeFileDir);
                foreach ($posts as $post) {
                    $this->setUrl($post->post_guid, $post->post_date_update, '0.80');
                }

                if ($newDir) {
                    $f = fopen($newDir, 'w');
                    if (fwrite($f, $this->get())) {
                        fclose($f);
                    }
                }
            }
        }
        $this->updateIndex($pg_num);
        return true;
    }

    public function setStaticPages()
    {
        $pages = post::selectPost("post_type='page' AND post_visibility='public'", null, 'id DESC', 'post_date_update,post_guid');

        if ($pages) {
            foreach ($pages as $page) {
                $this->setUrl($page->post_guid, $page->post_date_update, '0.7');
            }
        }
    }


    public function setCategories()
    {
        $categories = metatags::selectMetaTags('type="category"', 'name,type,slug','id DESC',$this->limit);
        $date = date('Y-m-d H:i:s');
        if ($categories) {
            foreach ($categories as $category) {
                $this->setUrl(metatags::getMetatagGuid($category->slug, $category->type), $date, '0.6');
            }
        }
    }

    public function setTags()
    {
        $Tags = metatags::selectMetaTags('type="tag"', 'name,type,slug', 'id DESC',$this->limit);
        $date = date('Y-m-d H:i:s');
        if ($Tags) {
            foreach ($Tags as $tag) {
                $this->setUrl(metatags::getMetatagGuid($tag->slug, $tag->type), $date, '0.5');
            }
        }
    }

    public function update($sitemap = '')
    {
        unset($this->urlSet);
        $this->urlSet = new Urlset();

        $file = null;

        switch ($sitemap) {
            case 'page':

                $home = ['url' => URI_NAME, 'date' => (new DateTime('now'))->format('Y-m-d H:i:s'), 'priority' => '1.0'];
                $this->setUrl($home['url'], $home['date'], $home['priority']);
                $this->setStaticPages();
                $file = SITE_ROOT . '/app/views/sitemap/page-sitemap.xml';
                if ($file) {
                    $f = fopen($file, 'w');
                    if (fwrite($f, $this->get())) {
                        fclose($f);
                        return true;
                    } else {
                        return false;
                    }
                }

                break;
            case 'article':
                $this->setPosts();
                break;
            
            /**case 'category':

                $this->setCategories();
                $file = SITE_ROOT . '/app/views/sitemap/category-sitemap.xml';

                if ($file) {
                    $f = fopen($file, 'w');
                    if (fwrite($f, $this->get())) {
                        fclose($f);
                        return true;
                    } else {
                        return false;
                    }
                }

                break;
            case 'tag':

                $this->setTags();
                $file = SITE_ROOT . '/app/views/sitemap/tag-sitemap.xml';
                if ($file) {
                    $f = fopen($file, 'w');
                    if (fwrite($f, $this->get())) {
                        fclose($f);
                        return true;
                    } else {
                        return false;
                    }
                }

                break;**/
            default:

                break;
        }
    }

    public function updateIndex($pages = null)
    {
        $where = "post_type='article' AND post_visibility='public'";
        $pg_num = $pages ? $pages:(new leemclasses())->pagination('posts',$this->limit, $where);0;
        $IndexPages = [
             URI_NAME . '/post-sitemap.xml',
            URI_NAME . '/page-sitemap.xml',
        ];
        $file = SITE_ROOT . '/app/views/sitemap/sitemap.xml';

        $y = 1;
        for ($y; $y <= $pg_num; $y++) {
            if ($y > 1) {
                    $IndexPages[] = URI_NAME . "/post-sitemap$y.xml";
            }
        }

        $date = new DateTime('now');
        $sitemapIndex = new SitemapIndex();


        foreach ($IndexPages as $i) {
            $fileIndex = str_replace(URI_NAME,SITE_ROOT."/app/views/sitemap",$i);
            if(file_exists($fileIndex)){
            $url = new SitemapSitemap($i);
            $url->setLastMod($date);
            $sitemapIndex->add($url);
            }
        }

        $driver = new XmlWriterDriver();
        $driver->addProcessingInstructions('xml-stylesheet', 'type="text/xsl" href="' . URI_NAME . '/assets/css/sitemap.xsl"');
        $sitemapIndex->accept($driver);


        $f = fopen($file, 'w');
        if (fwrite($f, $driver->output())) {
            fclose($f);
            return true;
        } else {
            return false;
        }
    }

    function updateAll()
    {
        $this->update('page');
        $this->update('article');
        
        /**$this->update('category');
        $this->update('tag');**/
        $this->updateIndex();
    }
}
