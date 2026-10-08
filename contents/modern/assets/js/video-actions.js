async function videoAction(options,custom_form=null){
    let form = custom_form?new FormData(custom_form): new FormData();
    form.append('pub-action','video');
    form.append('options',JSON.stringify(options));

    try{
        const data = await appConect(form);
        return await data.json();
    }catch(error){
        return {'success':false,'message':error}
    }
}

async function getVideo(url,form=null){
    const options = {'action':'retrieve','url':url};
    return await videoAction(options,form);
}

const videoForm = document.getElementById("video-form");

videoForm.addEventListener("submit",async(e)=>{
    e.preventDefault();
    const btnLabel = $("#download_btn").html();
    buttonload("#download_btn",0,'','');
    try{
        $("#result-section").addClass("hidden");
        const videoURL = document.getElementById("video_url"); 
        const response = await getVideo(videoURL.value,videoForm);
        if(response.success){
            setDownloadSection(response.data);
        }else{
            Tnotification(response.message,false);
        }
    }catch(err){
        console.error(err);
        alert(err);
        Tnotification("Internal error!",false);
    }finally{
        buttonload("#download_btn",1,btnLabel);
    }
    
});


function setDownloadSection(data){
const resultSection = document.getElementById("result-section");
const download_urls = getDownloadLinks(data);
const module = ` <div class="w-full rounded-md border  grid md:grid-cols-3 gap-3 p-4 ">
        <img src="${data.thumbnail}" alt="${data.title}" style="max-height: 250px;" class=" mx-auto rounded-md object-cover">


        <div class="w-full grid  md:col-span-2   gap-3  ">

            ${download_urls}

        </div>
    </div>

    <div class="w-full   py-2 px-2">
        <div class="grid text-center w-full  text-sm">
            <div class="w-full justify-center flex items-center gap-3 text-xs">
                <span>By:</span>
                <span>${data.author_name}</span>
            </div>
            <span class="font-semibold">${data.title}</span>

        </div>
    </div>
`;

resultSection.innerHTML = module;
resultSection.classList.remove("hidden");
resultSection.scrollIntoView({behavior:"smooth"});

}


function getDownloadLinks(data){
let i = 0;
let results = [];
data.medias.forEach((l) => {
    if(l.extension=='mp4'){
        results[i] = `<div class="w-full flex gap-3 items-center">
                <span class="p-2 rounded-full bg-primary text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path d="M0 128C0 92.7 28.7 64 64 64l256 0c35.3 0 64 28.7 64 64l0 256c0 35.3-28.7 64-64 64L64 448c-35.3 0-64-28.7-64-64L0 128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2l0 256c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1l0-17.1 0-128 0-17.1 14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z" />
                    </svg>
                </span>
                <div class="w-full grid grid-cols-2 gap-3">
                    <span class="flex items-center text-sm">
                       ${l.quality=='hd'?myBtn.tts.no_watermark+' (HD)':myBtn.tts.watermark} 
                    </span>
                    <span><button onclick="window.location='${l.url}'"  class=" w-full text-sm ${myBtn.primary}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 w-4" fill="currentColor" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 242.7-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7 288 32zM64 352c-35.3 0-64 28.7-64 64l0 32c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-32c0-35.3-28.7-64-64-64l-101.5 0-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352 64 352zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z" />
                            </svg>
                            .${l.extension} | ${l.size_formated??''}MB
                        </button>
                    </span>
                </div>
            </div>`;
    }else{
        results[i] = `<div class="w-full flex gap-3 items-center">
                <span class="p-2 rounded-full bg-primary text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path d="M499.1 6.3c8.1 6 12.9 15.6 12.9 25.7l0 72 0 264c0 44.2-43 80-96 80s-96-35.8-96-80s43-80 96-80c11.2 0 22 1.6 32 4.6L448 147 192 223.8 192 432c0 44.2-43 80-96 80s-96-35.8-96-80s43-80 96-80c11.2 0 22 1.6 32 4.6L128 200l0-72c0-14.1 9.3-26.6 22.8-30.7l320-96c9.7-2.9 20.2-1.1 28.3 5z" />
                    </svg>

                </span>
                <div class="w-full grid grid-cols-2 gap-3">
                    <span class="flex items-center text-sm">
                    ${myBtn.tts.music}
                    </span>
                    <span><button onclick="window.location='${l.url}'" target="_blank"  class="w-full text-sm ${myBtn.primary}">

                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 w-4" fill="currentColor" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 242.7-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7 288 32zM64 352c-35.3 0-64 28.7-64 64l0 32c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-32c0-35.3-28.7-64-64-64l-101.5 0-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352 64 352zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z" />
                            </svg>
                            .${l.extension} | 128kpbs
                        </button>
                    </span>
                </div>
            </div>`;
    }

    i++;
});

  
            return results.join("\n");
}


function Tnotification(message, status = true) {
    const style = status ? ['text-green-500', 'bg-white', 'py-1', 'px-2', 'rounded-md', 'shadow-xs'] : ['text-red-600', 'bg-white', 'py-1', 'px-2', 'rounded-md', 'shadow-xs'];
    const styleR = !status ? ['text-green-500'] : ['text-red-600'];

    $("#tmail_notification").addClass(style);
    $("#tmail_notification").removeClass(styleR);
    $("#tmail_notification").text(message);
    $("#tmail_notification").removeClass('hidden');

    setTimeout(() => {
        $("#tmail_notification").text('');
        $("#tmail_notification").addClass('hidden');
    }, 10000);
}