<?php 
use App\classes\leemclasses;
function numRegisters(){
    
    $register_values = [5,10,25,50,100];
    $selected = leemclasses::getNumberOfResister();
    $result = [];
    foreach($register_values as $r){
        $select = $r==$selected?'selected':'';
        $result[] = "<option value='$r' $select>$r</option>";
    }
        return implode("\n",$result);
    } 
    
?>
<form action="" method="POST" class="flex gap-3 items-center justify-end mb-4 mt-4 px-4">
   <span class="text-sm text-gray-700 dark:text-gray-100"> <?= tts['items_per_page']?> </span>
        <label>
        <select name="NumberOfResisters" id="NumberOfResisters" class="<?= style['input-text']?> form-select hover:pointer">
            <?=numRegisters()?>
        </select>
        </label>
        <label>
        <button class="<?= style['btn-purple-np']?>" type="submit"><?= tts['set']?></button>
        </label>

    
    </form>