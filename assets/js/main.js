

const formAdd = document.querySelector('#FrmaddUser');

if(formAdd!=null){
formAdd.addEventListener('submit',async function (event){
    event.preventDefault();
    buttonload('#BtnAddModal'); 

    const formdata = new FormData(this);
    const searchParams = new URLSearchParams();
        
    formdata.append("action","addUser");

    for(const data of formdata.entries()){
        searchParams.append(data[0],data[1]);
       
    }

    try{
    const data = await apiConect(formdata);
    const response = await data.json();
    
    
    buttonload('#BtnAddModal',1,'Submit');
    if(response['success']){
        kkMessgae.success(response['message'],2000);
        
        CleanDataU();
        setTimeout(()=>{
            $('#ModalNew').modal('hide');
            let user_data = response['data'];
            switch(user_data['action']){
                case 'update':
                    updateUserTable(user_data['id'],{'name':user_data['name'],'email':user_data['email'],'type':user_data['type'],'status':user_data['status']});
                    break;
                case 'add':
                    let table = document.querySelector('.table_users');
                    let new_element = document.createElement('tr');
                    new_element.classList.add('text-gray-700');
                    new_element.classList.add('dark:text-gray-400');
                    new_element.id = `tr_user_${user_data['id']}`;
                    new_element.innerHTML = user_data['html_code'];
                    table.insertBefore(new_element,table.firstChild);
                    
                break
                default:
                break;
            }
        },1000)
        
    }else{
        kkMessgae.error(response['message'],5000);
         
    }
}catch(error){
    kkMessgae.error('ERROR: '+error);
    console.error(error);
}
    
})
}


/**
 * Preenche o modal com os dados do usuario
 */

async function editU(d){
CleanDataU();
$('#ModalNew').modal('show');
loadModal(1,"#BtnAddModal");
const form = new FormData();
const us = document.getElementById('user_selected');
const formUser = document.getElementById('FrmaddUser');
form.append('action','get-u-data');
form.append('id',d);


try{

    const data = await apiConect(form);
    const response = await data.json();
    
    if(response['success']){
        
    us.value = d;
    formUser.querySelector("#name").value = response['data']['name'];
    formUser.querySelector("#email").value = response['data']['email'];
    
    const types = formUser.querySelectorAll('#type');
    for(let i = 0;i<types.length;i++){
       types[i].checked = types[i].value == response['data']['type']?true:false;
    }

    const status = formUser.querySelectorAll('#status');
    for(let y = 0;y<status.length;y++){
       status[y].checked = status[y].value == response['data']['status']?true:false;
    }
    document.getElementById('manage_action').innerText='Edit';
    $('#ModalNew').modal('show');
    }else{
        kkMessgae.error(response['message']);
    }
loadModal(0,"#BtnAddModal");
}catch(error){
    kkMessgae.error(error);
    console.error(error);
}
}

function dlu(id){
    const selectedUser = document.querySelector('#user_to_delete');
    selectedUser.value = id;
}

const btnDeleteUser = document.querySelector('#deletebutton');
if(btnDeleteUser!=null){
    btnDeleteUser.addEventListener('click',async ()=>{
        buttonload('#deletebutton');
        const selectedUser = document.querySelector('#user_to_delete');
        const form = new FormData();
        form.append('action','delete-user');
        form.append('user',selectedUser.value);

        try{
        const data = await apiConect(form);
        const response = await data.json();
        
        if(response['success']){
            let table_user = document.querySelector('#tr_user_'+selectedUser.value);
            table_user.remove();
            kkMessgae.success(response['message']);
        }else{
            kkMessgae.error(response['message']);
        }

    }catch(error){
        kkMessgae.error('Internal error!');
        console.error(error);
    }

    buttonload('#deletebutton',1,btnDeleteUser.ariaLabel);
    $('#deleteAlert').modal('hide');
    });
}

async function blocku(u,o=0){
    const form = new FormData();

    form.append('action','block-user');
    form.append('user',u);
    form.append('option',o);

    try{
    const data = await apiConect(form);
    const response = await data.json();
if(response['success']){
    kkMessgae.success(response['message']);
    updateUserTable(u,{'status':o});
}else{
    kkMessgae.error(response['message']);
}
    }catch(error){
        kkMessgae.error('Internal error');
        console.error(error);
    }
}

function CleanDataU(){
    const frm = document.getElementById('FrmaddUser');
    let inputs = frm.querySelectorAll('input');
    document.getElementById('manage_action').innerText='Add';
    for(let i = 0;i<inputs.length;i++){
        switch(inputs[i].type){
            case 'text':
                inputs[i].value = '';
                break;
                case 'password':
                inputs[i].value = '';
                break;
                case 'radio':
                inputs[i].checked = false;
                break;
                case 'email':
                    inputs[i].value = '';
                break;
                case 'hidden':
                inputs[i].value='';
                break;
                default:
                break;
        }
    }
}

function updateUserTable(id,data){
    
    const table = document.getElementById('tr_user_'+id);
    const user_info = table.querySelectorAll('.user_info')
    let status = data['status']!=null?parseInt(data['status']):0;

    const blockAction = status==1?`<button class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-orange-500 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray' title='Block' onclick='blocku(${id})'>
    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-5 h-5'>
    <path stroke-linecap='round' stroke-linejoin='round' d='M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636' />
   </svg>
    </button>`:`<button class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-500 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray' title='Unlock ' onclick='blocku(${id},1)'>
    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-5 h-5'>
    <path stroke-linecap='round' stroke-linejoin='round' d='M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z' />
  </svg></button>`;

  switch (status) {
    case 1:
      new_status = `<span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
  >Active</span>`;
      break;
    case 2:
        new_status = `<span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-orange-100 rounded-full dark:bg-green-700 dark:text-green-100"
  >Unverified</span>`;
      break;
    default:
        new_status = `<span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700"
  >Disabled</span>`;
      break;
  }

  data['name']!=null?user_info[0].innerText= data['name']:null;
  data['email']!=null?user_info[1].innerText=data['email']:null;
  data['type']!=null?user_info[2].innerText=data['type']:null;
  user_info[3].innerHTML = new_status;
  user_info[4].innerHTML = blockAction;

}

const postSelected = document.getElementById('id-post-delete');
function dlPost(id){
    postSelected.value = id;
}

const deleteBtn = document.getElementById("Okdelete");
if(deleteBtn!=null){
    deleteBtn.addEventListener('click',async ()=>{

        buttonload('#Okdelete',0,null,'');
        const response = await deletePost(postSelected.value);
        if(response['success']){
        const tableElement = document.getElementById('tr_'+response['post']);
        tableElement.remove();
        kkMessgae.success(response['message']);
        }else{
            kkMessgae.error(response['message']);
        }
    
        buttonload('#Okdelete',1,deleteBtn.ariaLabel);
        $('#deleteAlert').modal('hide');
        
    
    
    });
    
}

async function deletePost(id){
    if(id>0){
        let form = new FormData();
        form.append('action','delete-post');
        form.append('post',id);

        const data = await apiConect(form);
        const response = await data.json();
        return response;
    }
}

async function editMetaTag(id){
    const form = new FormData();

    form.append('action','get-mettag');
    form.append('metatag',id);

    const data = await apiConect(form);
    const response = await data.json();

    if(response['success']){
        const nameMetaTag = document.getElementById('nameMetaTag');
        const slugMetaTag = document.getElementById('slugMetaTag');
        const idMetaTag = document.getElementById('idMetaTag');
        const action = document.getElementById('action');
        idMetaTag.value = id;
        action.value = 'edit-metatag';
        nameMetaTag.value = response['name'];
        slugMetaTag.value = response['slug'];

    }else{
        kkMessgae.error(response['message']);
        $('#EditMetaTag').modal('hide');
    }
}

const deleteMetaTag = document.getElementById('deleteMetaTag');
if(deleteMetaTag!=null){

    deleteMetaTag.addEventListener('click', async ()=>{
        buttonload('#deleteMetaTag',0,null,'');
        
        const typeTag = document.getElementById('type-tag');
        const form = new FormData();
        form.append('action','delete-metatag');
        form.append('metatag',postSelected.value);
        form.append('type',typeTag.value);
    
        const data = await apiConect(form);
        const response = await data.json();
    
        if(response['success']){
            kkMessgae.success(response['message']);
            const TrTag = document.getElementById('tr_'+response['metatag']);
            TrTag.remove();
        }else{
            kkMessgae.error(response['message']);
        }
        
        buttonload('#deleteMetaTag',1,deleteMetaTag.ariaLabel);
        $('#deleteAlert').modal('hide');
        
    });
}

const formmodalMetaTag = document.getElementById('formMetaTag');

if(formmodalMetaTag != null){

    formmodalMetaTag.addEventListener('submit', async (event)=>{
        event.preventDefault();
        const btnSubmit = document.getElementById('saveMetaTag');
        buttonload('#saveMetaTag');
        const form = new FormData(formmodalMetaTag);
        
        const data = await apiConect(form);
        const response = await data.json();

        if(response['success']){
            kkMessgae.success(response['message']);
            document.getElementById('td_name_'+form.get('idMetaTag')).innerText = response['name'];
            document.getElementById('td_slug_'+form.get('idMetaTag')).innerText = response['slug'];
            $('#EditMetaTag').modal('hide');
        }else{
            kkMessgae.error(response['message']);
        }

        buttonload('#saveMetaTag',1,btnSubmit.ariaLabel);
    })
}

const btnSubmitMetaTag = document.getElementById('saveMetaTag');

if(btnSubmitMetaTag != null){
    btnSubmitMetaTag.addEventListener('click', ()=>{
        const sendform = document.getElementById('sendForm');
        sendform.click();
    });
}

const formNewMetaTag = document.getElementById('formNewMetaTag');
if(formNewMetaTag!=null){
    formNewMetaTag.addEventListener('submit', async (event)=>{
        buttonload('#AddMetaTag');
        event.preventDefault();
        const form = new FormData(formNewMetaTag);
        form.append('action','add-metatag');
        
        const data = await apiConect(form);
        const response = await data.json();
        if(response['success']){
            kkMessgae.success(response['message']+' Refreshing...',3000);
            setTimeout(()=>{
                window.location = window.location.href;
            },4000);
        }else{
            kkMessgae.error(response['message']);
        }
        buttonload('#AddMetaTag',1,'Submit');
    });
}

const btnAddNew = document.getElementById('AddMetaTag');
if(btnAddNew != null){
    btnAddNew.addEventListener('click', ()=>{
        document.getElementById('submit-newMeta').click();
    });
}


async function editAttachment(id){
    const AttId = document.getElementById("idAttachment");
    const title = document.getElementById("titleAttachment");
    const Description = document.getElementById("descriptionAttachment");
    const Permalink = document.getElementById("permalinkAttachment");

    const response = await getAttachmentData(id);

    if(response['success']){
        AttId.value = id;
        title.value = response['data']['title'];
        Description.value = response['data']['description'];
        Permalink.value = response['data']['permalink'];
    }else{
        kkMessgae.error(response['message']);
    }
}

async function getAttachmentData(id){
    const form = new FormData();
    form.append('action','get-attachmentInfo');
    form.append('attachment',id);

    const data = await apiConect(form);
    const response = await data.json();
    return response;
}




const saveAttachment = document.getElementById('saveAttachment');

if(saveAttachment !=null){
    saveAttachment.addEventListener('click',async ()=>{
        
        const btnSubmit = document.getElementById('sendForm');
        btnSubmit.click();

        
    });
}

const formAttachment = document.getElementById('formAttachment');

if(formAttachment != null){
    formAttachment.addEventListener('submit',async (event)=>{
        event.preventDefault();
        buttonload('#saveAttachment');
        const form = new FormData(formAttachment);
        form.append('action','update-attachment');

        const data = await apiConect(form);
        const response = await data.json();

        if(response['success']){

            kkMessgae.success(response['message']);
        }else{
            kkMessgae.error(response['message']);
        }
        buttonload('#saveAttachment',1,saveAttachment.ariaLabel);
    });    
}

const copyAttLink = document.getElementById('copy-permalink');

if(copyAttLink!=null){
    copyAttLink.addEventListener('click',()=>{
        const attLink = document.getElementById('permalinkAttachment');
        copyPemalink(attLink.value);
         
     });
}

function copyPemalink(text){
    navigator.clipboard.writeText(text).then(()=>{
        kkMessgae.success('Copied!');
    },()=>{
        kkMessgae.error('Uncopied!');
    });
}