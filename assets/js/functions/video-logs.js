var i_history = {};
async function videoLogsAction(options){
    let form = new FormData();
    form.append('action','video-logs');
    form.append('options',JSON.stringify(options));

    try{
        const data = await apiConect(form);
        return await data.json();
    }catch(error){
        return {'success':false,'message':error}
    }
}


async function blockIP(ip){
    kkMessgae.loading('Wait...');
    const options = {'action':'block_ip','ip':ip};
    const response = await videoLogsAction(options);

    if(response.success){
        kkMessgae.success(response.message);
        window.location = window.location.href;
    }else{
        kkMessgae.error(response.message);
    }
}

async function unblockIP(ip){
    kkMessgae.loading('Wait...');
    const options = {'action':'unblock_ip','ip':ip};
    const response = await videoLogsAction(options);

    if(response.success){
        kkMessgae.success(response.message);
        window.location = window.location.href;
    }else{
        kkMessgae.error(response.message);
    }
}

async function deleteVideoLog(log,e){
    const c = confirm("Are you sure you want to delete this video log?");
    if(!c){
        return false;
    }
    try{
        e.target.setAttribute("disabled","true");
        const options = {'action':'delete-log','log':log};
        const response = await videoLogsAction(options);
        if(response.success){
            $("#tr_"+log).remove();
        }else{
            e.target.removeAttribute("disabled");
            kkMessgae.error(response.message);
        }
    }catch(err){
        console.error(err);
    }
    
    }

