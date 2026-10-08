    <?php
    use App\classes\widget;
    $sidebar = widget::WidgetItems('sidebar_area',['title_class'=>theme_t['heading'],'button_class'=>theme_t['btn-primary']]);
    
    if($sidebar){
        echo '<div class="flex flex-col gap-6   w-full">';
      foreach($sidebar as $s){
        
        
        if($s['item']){
          //START LIST ITEMS
          
          foreach($s['item'] as $item){
            echo '<div class="module-styling widgets-module dark:bg-gray-800 dark:text-gray-100">';
            echo $item['title'];
            echo $item['content'];
            echo '</div>';
          }
          
          //END LIST ITEMS
        }
        
    
      }
      echo '</div>';
    }
    
        ?>
