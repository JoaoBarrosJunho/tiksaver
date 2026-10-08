<?php
use App\classes\leemclasses;


?>

<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200 "><?= $TITLE ?></h2>

       
       
        <div class="flex flex-col gap-3 w-full py-4 px-4 mb-4 text-sm <?=style["bg"]?>">  
       



<pre style="white-space: break-spaces;" class="w-full rounded-md text-xs bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400 py-4 px-4">
<?php 
    $file = SITE_ROOT."/logs.txt";
    if(file_exists($file)){
        $contents = file_get_contents($file);
        print $contents;
    }else{
        echo tts['no_records'];
    }
?></pre>
        </div>
    </div>
</main>


