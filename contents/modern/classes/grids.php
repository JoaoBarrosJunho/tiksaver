<?php



function newTitle($title, $SEO = 'h2'){
    return '<div class="w-full flex
     mt-2 mb-2 gap-3   '.theme_t['heading'].' dark:text-gray-100"><'.$SEO.'>'.$title.'</'.$SEO.'></div>';
}

function instanceGrid($grid){
    switch($grid){
        case 'default-grid':
            require_once 'grids-template/default-grid.php';
            return new default_grid();
        break;
        case 'grid-a':
            require_once 'grids-template/grid-a.php';
            return new grid_a();
        break;
        case 'grid-b':
            require_once 'grids-template/grid-b.php';
            return new grid_b();
        break;
        case 'grid-c':
            require_once 'grids-template/grid-c.php';
            return new grid_c();
        break;
        case 'grid-d':
            require_once 'grids-template/grid-d.php';
            return new grid_d();
        break;
        case 'featured-a':
        require_once 'grids-template/featured-grid-a.php';
        return new featured_a();
        break;
        
        default:
            require_once 'grids-template/default-grid.php';
            return new default_grid();
        break;
    }
}