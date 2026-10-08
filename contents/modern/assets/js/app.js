


async function appConect(data){
try{
    return fetch(appApi,{
        method:'POST',
        mode:'cors',
        body: data
     });
}catch(error){
    return {'success':false,'message':`${error}`};
}
}

async function setLanguage(lang){
    const form = new FormData();
    form.append('pub-action','set-lang');
    form.append('lang',lang);

    try{
        const data = await appConect(form);
        const response = await data.json();

        response['success']?window.location = window.location.href:kkMessgae.error(response['message']);

    }catch(error){
        console.error(error);
    }
}

//LOADING BUTTON
function buttonload(selector,cond=0,BtnText='',loadmessage='Loading...'){
    
    
    try{
        const text="<i class='bx bx-loader-circle bx-spin' ></i>"+loadmessage+"";
        const btn = document.querySelector(`${selector}`);
        if(cond ==0){
            btn.disabled = true;
            btn.innerHTML = text;
        }else{
            setTimeout(()=>{
            BtnText = BtnText!=''?BtnText:btn.ariaLabel;
            btn.innerHTML=BtnText;
            btn.disabled = false;
            },500)
        }
    }catch(error){
        console.error(error);
    }
    
    
    }