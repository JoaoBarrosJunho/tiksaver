//START DRAG AND DROP
const columns = document.querySelectorAll(".column");

document.addEventListener('dragstart', (item) => {
  item.target.classList.add("dragging");

});

document.addEventListener('dragend', (item) => {
  item.target.classList.remove("dragging");
})

columns.forEach((item) => {
  item.addEventListener("dragover", (e) => {
    const dragging = document.querySelector(".dragging");
    const applyAfter = getNewPosition(item, e.clientY);

    if (applyAfter) {
      applyAfter.insertAdjacentElement("afterend", dragging);
    } else {
      item.prepend(dragging);
    }
  });
});


function getNewPosition(column, posY) {
  const cards = column.querySelectorAll(".item:not(.dragging)");
  let result;

  for (let refer_card of cards) {
    const box = refer_card.getBoundingClientRect();
    const boxCenterY = box.y + box.height / 2;

    if (posY >= boxCenterY) result = refer_card;
  }

  return result;
}


async function getTemplate(template,gadget=null) {
  loadTemplate();
  const form = new FormData();
  form.append('action', 'get-widget-template');
  form.append('option', template);
  form.append('gadget_id',gadget);

  const data = await apiConect(form);
  const response = await data.json();


  if (response['success']) {
    return { 'success': true, 'data': response['data'] };
  } else {
    return '<label class="flex gap-3 justify-center rounded-md items-center py-4 px-4 bg-red-100 text-sm text-red-700 font-semibold">' + response['message'] + '</label>';
  }
}

function loadTemplate() {
  modalFooter.style.display = "none";
  templateArea.innerHTML = '<label class="flex gap-3 justify-center rounded-md items-center py-4 px-4 bg-blue-100 text-sm text-blue-500 font-semibold"><i class="bx bx-loader-circle bx-flip-vertical bx-spin"></i> Getting template...</label>';
}

let selectedArea = document.getElementById('selectedArea');
let widgetId = document.getElementById('widgetId');
let templateArea = document.getElementById('template-area');
const modalFooter = document.querySelector('.modal-footer');

async function newGadget(area, widget_id) {
  selectedArea.value = area;
  widgetId.value = widget_id;

  const template = await getTemplate('');
  templateArea.innerHTML = template['data'];
}

async function getGadget(id) {

  const template = await getTemplate(id);
  if (template['success']) {
    templateArea.innerHTML = template['data'];
    modalFooter.style.display = 'flex';
  } else {
    templateArea.innerHTML = template['data'];
  }

}




const BtnModal = document.getElementById("submit-form");

BtnModal.addEventListener('click',()=>{
  
  const GadgetForm = document.getElementById("newGadgetForm");
  
  if(GadgetForm!=null){
    GadgetForm.addEventListener('submit',async (e)=>{
      e.preventDefault();
      buttonload("#submit-form");
  
      const form = new FormData(GadgetForm);
      form.append('action','add-new-widget');
      form.append('parent',widgetId.value);
  
      const data = await apiConect(form);
      const response = await data.json();
  
      if(response['success']){
        kkMessgae.success(response['message']);
        $('#widgetModal').modal('hide');

        switch(response['action']){
          case 'add':
            const widgetArea = document.getElementById(selectedArea.value);
            widgetArea.innerHTML += response['data'];
          break;
          case 'update':
            const itemUpdated = document.getElementById('item_title_'+response['data']['id']);
            itemUpdated.innerText = response['data']['title'];
          break;
          default:
            break;
        }
        
      }else{
        $('#widgetModal').modal('hide');
        kkMessgae.error(response['message']);
      }
      buttonload("#submit-form",1,BtnModal.ariaLabel);
      
      
    });
  }

  document.getElementById("sendGadgetform").click();
});


async function editWidget(id){
  
  const template = await getTemplate(null,id);

  if(template['success']){
    templateArea.innerHTML = template['data'];
    modalFooter.style.display = 'flex';
  }else{

    templateArea.innerHTML = template['data'];
    modalFooter.style.display = 'none';
  }
}


async function deleteWidget(id){
  const itemBody = document.getElementById('item_body_'+id);
  const form = new FormData();
  form.append('action','delete-widget');
  form.append('widget_id',id);

  try{
    const data = await apiConect(form);
    const response = await data.json();

    if(response['success']){
      itemBody.remove();
      btnSaveAll.click();
    }else{
      kkMessgae.error(response['message']);
    }

  }catch(error){
    kkMessgae.error(error);
  }

}

const btnSaveAll = document.getElementById('save-all');
let success = false;
btnSaveAll.addEventListener('click',async ()=>{

buttonload('#save-all',0,'','Saving...');
const AllForms = document.querySelectorAll('.column');
let i = 0;

for(i;i<AllForms.length;i++){
  try{
    const formNow = AllForms[i];
    const form = new FormData(formNow);
    const response = await saveAll(form);
    success = response['success'];
  }catch(error){
    kkMessgae.error(error);
  }

}


buttonload('#save-all',1,btnSaveAll.ariaLabel);

if(success){
  kkMessgae.success("Layout has been updated!");

}else{
  kkMessgae.error("Error updating layout!");
}
});


async function saveAll(form){
  const selectedform = form;
  let failResponse = [];
  selectedform.append('action','save-all-widgets');

  try{
    const data = await apiConect(selectedform);
    const response = await data.json();
    return response;

  }catch(error){
    failResponse['success'] = false;
    failResponse['message'] = error;

    return failResponse;
  }
  

}