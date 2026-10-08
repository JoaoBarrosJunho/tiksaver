

async function approvecomment(id){
    const form = new FormData();
    form.append('action','comment');
    form.append('option','approve');
    form.append('comment_id',id);

    try{
        const data = await apiConect(form);
        const response = await data.json();
    
        if(response['success']){
            kkMessgae.success(response['message']);
            await updateStatus(id,'approve');
        }else{
            kkMessgae.error(response['message'])
        }
    }catch(error){
        console.error(error);
    }
}


async function occultcomment(id){
    const form = new FormData();
    form.append('action','comment');
    form.append('option','occult');
    form.append('comment_id',id);

    try{
        const data = await apiConect(form);
        const response = await data.json();
        
        if(response['success']){
            kkMessgae.success(response['message']);
            await updateStatus(id,'occult')
        }else{
            kkMessgae.error(response['message'])
        }
        
    }catch(error){
        console.error(error);
    }
}

async function approveAll(){
    const form = new FormData();
    form.append('action','comment');
    form.append('option','approveAll');

    try{
        const data = await apiConect(form);
        const response = await data.json();
        
        if(response['success']){
            kkMessgae.success(response['message']);
            window.location = location.href;
        }else{
            kkMessgae.error(response['message'])
        }
        
    }catch(error){
        console.error(error);
    }
}

async function deletecomment(id){
    const form = new FormData();
    form.append('action','comment');
    form.append('option','delete');
    form.append('comment_id',id);

    try{
        const data = await apiConect(form);
        const response = await data.json();
        
        if(response['success']){
            kkMessgae.success(response['message']);
            await removeFormItem(id);
            
        }else{kkMessgae.error(response['message']);}
        
    }catch(error){
        kkMessgae.error(error);
    }
}

async function removeFormItem(id){
    const formItem = document.getElementById('tr_'+id);
    formItem.remove();
}



async function updateStatus(id,action){
    const status = document.getElementById('status_'+id);
    const actionItem = document.getElementById('actions_'+id);
    const occultedCommentActions = "<a onclick='approvecomment("+id+")' title='Approve' class='flex items-center justify-between hover:pointer px-2 py-2   leading-5 text-green-500 rounded-lg dark:text-green-400 focus:outline-none focus:shadow-outline-gray'><i class='bx bxs-message-check'></i></a>    <a title='Reject' onclick='deletecomment("+id+")' class='flex items-center justify-between px-2 py-2   leading-5 text-red-600 hover:pointer rounded-lg dark:text-red-400 focus:outline-none focus:shadow-outline-gray'><i class='bx bxs-message-alt-x'></i></a>";
    const ApprovedCommentActions = "<a  title='Occult'  onclick='occultcomment("+id+")' class='flex items-center justify-between px-2 py-2   leading-5 text-orange-500 hover:pointer rounded-lg dark:text-orange-100 focus:outline-none focus:shadow-outline-gray'><i class='bx bxs-message-minus'></i></a><a  title='delete'  onclick='deletecomment("+id+")' class='flex items-center justify-between px-2 py-2  leading-5 text-red-600 hover:pointer rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray'><i class='bx bxs-trash'></i></a>";
    switch(action){
        case 'occult':
        status.innerText = 'Pending';
        status.classList.remove('bg-green-100');
        status.classList.add('bg-orange-100');
        status.classList.remove("dark:bg-green-500");
        status.classList.add("dark:bg-orange-500");
        actionItem.innerHTML = occultedCommentActions;
        break;
        case 'approve':
        status.innerText = 'Approved';
        status.classList.remove("bg-orange-100");
        status.classList.add("bg-green-100");
        status.classList.remove("dark:bg-orange-500");
        status.classList.add("dark:bg-green-500");
        actionItem.innerHTML = ApprovedCommentActions;
        break;
        default:
        break;
    }


    
}