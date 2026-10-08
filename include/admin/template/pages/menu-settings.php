<?php
use App\classes\menu;
use App\classes\leemclasses;

include_once 'modules/menu-parts/alerts.php';
include_once 'modules/menu-parts/menu-list.php';

?>

<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="flex gap-3 items-center my-6  text-2xl font-semibold text-gray-700 dark:text-gray-200 "><?= $TITLE ?> <a href="<?=URI_NAME?>/panel/menu-settings?action=new" class="<?= style['btn-purple-outline']?> <?php if(isset($_GET['action']) && $_GET['action'] == 'new'){ echo 'hidden';}?>"><?=tts['add_new']?></a></h2>
        <?php
        Alert();

        if (isset($_GET['action']) && !empty($_GET['action'])) {
            include_once 'modules/menu-parts/create-menu.php';
            include_once SITE_ROOT.'/include/footer.php';
            die();
        }

        if (isset($_POST['titlemenu'], $_POST['linkmenu'])) {

            if (isset($_GET['menu']) && is_numeric($_GET['menu'])) {
                
            $links = [];
            $id = $_GET['menu'];
            $titleMenu = $_POST['titlemenu'];
            $linkMenu = $_POST['linkmenu'];
            $i = 0;

            for ($i; $i < count($titleMenu); $i++) {
                $links[] = $titleMenu[$i] . "@:" . $linkMenu[$i];
            }
            $execute = menu::setItems(json_encode($links),$id);
            if($execute){
                echo leemclasses::notification('Action has been succeeded!');
            }
            
            } else {
                echo leemclasses::notification(tts['menu_notselected'].'!', 3000, 'bg-red-100');
            }

        }

        ?>



        <!--Menu selection area-->
        <div class="flex gap-6  w-full px-4 py-3 mb-8 <?=style["bg"]?>">


            <form action="" method="GET" class="flex gap-3 ">
                <label>
                    <select name="menu" id="menu" class="<?= style['input-text'] ?> form-select hover:pointer">
                        <option value=""><?=tts['select_menu']?></option>
                        <?php getMenuList(); ?>
                    </select>
                </label>
                <label>
                    <button class="<?= style['btn-purple-np'] ?>" type="submit"><?=tts['select']?></button>
                </label>
            </form>
        </div>
        <!--Menu selection area-->



        <!--Menu management area-->
        <div class="grid gap-6 px-4 py-3 mb-8   md:grid-cols-4 <?=style["bg"]?>">
            <div class="w-full h-full px-2 py-2 rounded-lg bg-gray-50  dark:bg-gray-700">

                <?php
                include_once 'modules/menu-parts/menu-options.php';
                ?>

            </div>

            <div class="flex flex-col  gap-6 w-full h-full px-5 py-4 bg-gray-100 rounded-lg justify-center items-center dark:bg-gray-700  md:col-span-3">
                <label>
                <?php include_once 'modules/menu-parts/menu-title.php'?>
                </label>

                <form id="formMenuItems" method="POST" class="bg-white rounded-lg py-2 px-2 min-w-300  column" style="max-width: 300px;">

                    <?php include_once 'modules/menu-parts/menu-items.php'; ?>
                    <button type="submit" class="hidden" id="SubmitMenu"><?=tts['send']?></button>
                </form>

                <div class="flex gap-3 <?= !isset($_GET['menu']) || !is_numeric($_GET['menu'])?'hidden':''?>">
                    <label><button id="save-menu" onclick="saveMenu()" class="<?= style['btn-purple-np'] ?>" aria-label="<?=tts['save_menu']?>"><?=tts['save_menu']?></button></label>
                    <label><button  class="<?= style['btn-red'] ?>" aria-label="<?=tts['delete_menu']?>" data-bs-toggle='modal' data-bs-target='#deleteAlert'><?=tts['delete_menu']?></button></label>
                </div>
                

            </div>

        </div>
        <!--Menu management area-->
    </div>
</main>

<!-- Modal Delete-->
<div class="modal fade" id="deleteAlert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteAlert" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-lg dark:bg-gray-800 dark:text-gray-400">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel"><?=tts['delete_menu']?></h1>
        <button type="button" class="btn-close dark:text-gray-400" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id-post-delete" id="id-post-delete">
      <p class="text-sm text-gray-700 dark:text-gray-400">
      <?=tts['delete_menu_alert']?>  
          </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray" data-bs-dismiss="modal"><?=tts['cancel']?> </button>
        <button onclick="window.location = '<?= URI_NAME?>/panel/menu-settings?action=delete&menu=<?= isset($_GET['menu']) && is_numeric($_GET['menu'])?$_GET['menu']:''?>'" aria-label="<?=tts['yes']?>" class="w-full px-5 text-center py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-purple" ><?=tts['yes']?></button>
      </div>
    </div>
  </div>
</div>