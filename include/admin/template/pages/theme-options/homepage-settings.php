



<div class="flex flex-col gap-6 dark:text-gray-100">

        


    <!-- Module Area -->
    <span class="text-sm font-semibold">Modules</span>
    
    <input type="hidden" name="home_modules" id="post_modules" value='<?=getOption('home_modules')?>'>

    <div class="w-full flex flex-col mx-auto gap-6 h-full px-2 py-2 rounded-lg bg-gray-100  dark:bg-gray-700 dark:text-gray-100 " >
        
    <div class="w-full flex flex-col gap-3 py-2 px-2 column  dark:bg-gray-700" id="modules">
    <!-- Modules list -->    
    <?php

    function getModules(){
      $html = '<label class="flex w-full py-4 px-4 item bg-white rounded-md dark:bg-gray-800  hover:mouse-move" draggable="true" id="module_element"><span class="flex flex-col gap-3 text-sm font-semibold text-gray-700 hover:pointer"><span id="moduleTitle" class="dark:text-gray-100">@title</span><label class="flex gap-3 "><span class="text-lg font-semibold text-blue-500 hover:pointer" data-bs-toggle="modal" data-bs-target="#postModule" onclick="@eventEdit"><i class="bx bx-edit"></i></span><span class="text-lg font-semibold text-red-600 hover:pointer" onclick="deleteModule(event)"><i class="bx bx-trash"></i></span><input type="hidden" id="module_result" value=\'@value\'></label></span></label>';
      $modules = getOption('home_modules');
      if($modules){
        $data = json_decode("[".$modules."]");
        $y=0;
        foreach($data as $d){
          
          $event = $d->type_module == 'post' ? "editPostModule(event,'post')":"editPostModule(event,'blank')";
          $Modulevalue = json_encode($data[$y]);
          $myModuleTitle = $d->title==''?'Untitled':$d->title;
          
          print str_replace(['@title','@value','@eventEdit'],["$myModuleTitle ($d->type_module)","$Modulevalue","$event"],$html);
          $y++;
        }
      }
    }

    getModules();
    ?>


    </div>

        <div class="flex gap-3">
        <div class="<?=style['btn-purple-outline']?> hover:pointer" onclick="openModuleModal('module-post')" >
              Add blog module
          </div>
          <div class="<?=style['btn-purple-outline']?> hover:pointer" onclick="openModuleModal('module-blank')">
              Add code html
          </div>
        </div>
       
    </div>
   
    <!-- Modal postModule-->
<div class="modal fade"  id="postModule" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteAlert" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-lg dark:bg-gray-800 dark:text-gray-400">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add module</h1>
        <button type="button" class="btn-close dark:text-gray-400 " data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div id="template-area" >
       
       <!-- Module posts template-->
       
       <!-- Module posts template -->

       
       </div>
       <input type="hidden" id="module_position">
       <input type="hidden" id="module_type">
       
      </div>
      <div class="modal-footer">
        <a id="submit-form" onclick="AddPostModule()" aria-label="Submit" class="<?= style['btn-purple']?> hover:pointer ">Submit</a>
      </div>
    </div>
  </div>
</div>

<!-- Modal-->





<div class="hidden" id="blank_template">
<!-- Module posts template-->

        <!-- Module posts template -->
</div>

<script>
var ModuleBlank = `<div x-data="{importCode:false}" class="flex flex-col gap-3 w-full">
        
        <label class="flex flex-col w-64">
           <span class="text-sm font-semibold">Title Module</span>
           <input type="text" class="<?= style['input-text']?>" id="module_title">
         </label>
 
         <label class="flex flex-col gap-3 w-full">
         <span class="text-sm font-semibold">HTML/JS Code <span class="text-xs">(Short cutes supported: %site_name%,%site_description%,%site_url%)</span></span>
         <textarea  class="<?= style['input-text']?>" id="module_text" cols="30" rows="10"></textarea>
         </label>        
 
         

        <label class="mt-4">
          <button id="import-code" onclick="event.preventDefault()" class="<?=style['btn-purple-outline']?>" @click="importCode=!importCode">Import code</button>
          <select X-show="importCode" id="select_code_option" onchange="startImport()" class="mt-2 <?=style['select']?>">
              <option value="">Select code</option>
              <option value="features">Feature Section</option>
              <option value="ad">Ad</option>
          </select>

        </label>
 
        </div>`;

        var ModulePostTemplate = `
  <label class="flex flex-col w-64">
           <span class="text-sm font-semibold">Title Module</span>
           <input type="text" class="<?= style['input-text']?>" id="module_title">
         </label>

     <!--Num rows-->
     <label class="flex flex-col gap-3 w-64">
         <span class="text-sm font-semibold">Number of posts</span>
         <input type="number" id="module_limit" value="4" class="<?= style['input-text']?> " >
     </label>
 
 
    
 
     <!--Order-->
     <label class="flex flex-col gap-3 w-64">
         <span class="text-sm font-semibold">Order by</span>
         <select  id="module_order" class="<?= style['select']?> ">
           <option value="date">Publish date</option>
           <option value="update">Modified date</option>
           <option value="random">Random</option>
         </select>
     </label>
 
 
        </div>`;


</script>



</div>