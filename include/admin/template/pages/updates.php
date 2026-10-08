<?php
use App\classes\leemclasses;

if(isset($_GET['email']) && !empty($_GET['email'])){
    leemclasses::setOptions('current-updatemail',$_GET['email']);
}
?>

<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200 "><?= $TITLE ?></h2>

        <div  class="flex flex-col gap-3 w-full  py-4 px-4  mb-4 text-sm <?=style["bg"]?>">
        <span class="font-semibold text-sm"><?=tts['receive_updates_email']?></span>
        <div class="flex items-center gap-3">
    <div><input type="email" value="<?=leemclasses::option('current-updatemail')?>" placeholder="youremail@mail.com" required name="email" id="email" class="<?=style['input-text']?>"></div>
    <div><button type="submit" id="subscribe" class="<?=style['btn-purple-np']?>"><?=tts['submit']?></button></div>
        </div>
        
</div>
       
        <div class="flex flex-col gap-3 w-full py-4 px-4 mb-4 text-sm <?=style["bg"]?>">  
        <div class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-green-600">
  <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
</svg><span class="text-sm"><?=tts['instaled_version']?>: </span> <span>v<?=V_?></span> </div>
<div class="flex items-center gap-3">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-orange-500">
  <path fill-rule="evenodd" d="M10.5 3.75a6 6 0 0 0-5.98 6.496A5.25 5.25 0 0 0 6.75 20.25H18a4.5 4.5 0 0 0 2.206-8.423 3.75 3.75 0 0 0-4.133-4.303A6.001 6.001 0 0 0 10.5 3.75Zm2.25 6a.75.75 0 0 0-1.5 0v4.94l-1.72-1.72a.75.75 0 0 0-1.06 1.06l3 3a.75.75 0 0 0 1.06 0l3-3a.75.75 0 1 0-1.06-1.06l-1.72 1.72V9.75Z" clip-rule="evenodd" />
</svg>

<span><?=tts['avaible_version']?>: </span> <span id="avaible-version"><?=V_?></span></div>

<span class="text-sm font-semibold"><?=tts['update_log']?></span>  
<pre style="white-space: break-spaces;" class="w-full rounded-md text-xs bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400 py-4 px-4">
Update Log
Version: 1.0.0 (January 20,2025)

- Version released
            </pre>
        </div>
    </div>
</main>


<script>

    async function getVersion() {
        const current = $("#avaible-version").text();
        $("#avaible-version").html(`<i class='bx bx-loader bx-spin' ></i>`);
        try{
        const data = await fetch('https://genius.2jdev.com/app/version?aplication=tikdrop',{
            mode:"cors",
            method:"GET",
        });
        const response = await data.json();
        if(response.ok){
            const version = response.version;
            
            if(version!=current){
                $("#avaible-version").html(`v${version} - <a href='${response.download}' class="text-purple-600" targe="_blank">Download</a>`);
            }else{
                $("#avaible-version").text(`v${current}`);
            }
        }
    }catch(error){
        console.error(error);
        $("#avaible-version").text(`v${current}`);
    }   
    
}
    window.addEventListener("load", async()=>{
        await getVersion();

        $("#subscribe").click(async()=>{
        buttonload("#subscribe",0);

        const email = $("#email").val();
        if(email==''){
        alert("Insert your email!");
        return false;
        }
        

        try{
        const data = await fetch(`https://genius.2jdev.com/app/subscribe?email=${email}&aplication=tikdrop&platform=<?=URI_NAME?>`,{
            mode:"cors",
            method:"GET",
            
        });
        const response = await data.json();
        if(response.ok){
           window.location = window.location.href+`?email=${email}`;
        }else{
            kkMessgae.error(response.message);
        }
    }catch(error){
        console.error(error);
    }  
        buttonload("#subscribe",1,'Submite');
    });


    });


    
</script>