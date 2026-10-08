async function manageAPI(options,f = null) {
    let form = f? new FormData(f):new FormData();
    form.append('action', 'apikey');
    form.append('options', JSON.stringify(options));

    try {
        const data = await apiConect(form);
        return await data.json();
    } catch (error) {
        return { 'success': false, 'message': error }
    }
}


$("#add-apikey").click(()=>{
    ClearModalAPI();
    $("#modal-apikey").modal("show");
});

function ClearModalAPI(){
    $("#api_name").val("");
    $("#current_api").val("");
}

async function addAPI() {
    const formEdpoint = document.getElementById("api-form");
    
    const options = { 'action': 'save-api'};
    const response = await manageAPI(options,formEdpoint);

    if (response.success) {
    kkMessgae.success(response.message);
    window.location = window.location.href;
    $("#modal-apikey").modal('hide');
    } else {
        kkMessgae.error(response.message);
        console.log(response.message);
    }

}

document.getElementById("api-form").addEventListener("submit",async(e)=>{
    e.preventDefault();
    let btnText = $("#save-api").html();
    try{
        buttonload("#save-api");
        await addAPI();
    }catch(err){
        console.error(err);
    }finally{
        buttonload("#save-apit",1,btnText);
    }
    
})


async function removeAPI(id) {

    if(!confirm("Are you sure you want to proceed with removing this API Key?")){
        return false;
    }

    const options = { 'action': 'remove-api', 'id': id };
    const response = await manageAPI(options);

    if (response.success) {
        kkMessgae.success(response.message);
        $("#tr_"+id).remove();
    } else {
        kkMessgae.error(response.message);
        console.log(response.message);
    }

}


async function regenerateKey(id) {

    if(!confirm("Are you sure you want to proceed with update this API Key?")){
        return false;
    }
    
    try{
        const options = { 'action': 'new-key', 'id': id };
        const response = await manageAPI(options);
    
        if (response.success) {
            $("#token_"+id).attr("data-token",response.data.token);
            $("#token_"+id).text(response.data.short_token);
        } else {
            kkMessgae.error(response.message);
            console.log(response.message);
        }
    
    }catch(err){
        console.error(err)
    }
    
}




async function editAPI(id){
    try{
        ClearModalAPI();
        kkMessgae.loading("Wait...",200);
        const options = { 'action': 'retrieve-api', 'id': id };
        const response = await manageAPI(options);
    
        if (response.success) {
            $("#api_name").val(response.data.api_name);
            $("#current_api").val(id);
            $("#as_limited").val(response.data.asLimited);
            $("#day_limit").val(response.data.day_limit)
            
            $("#modal-apikey").modal("show");
        } else {
            kkMessgae.error(response.message);
            console.log(response.message);
        }
    }catch(err){
        console.error(err)
    }
    
}



