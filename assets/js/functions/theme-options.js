
function Setsection(e, area) {
  const btn = e.target;
  let btnList = document.querySelectorAll('.nav-btn');
  let panelItems = document.querySelectorAll('.panel-item');
  const panel = document.getElementById(area);
  i = 0;

  for (i; i < btnList.length; i++) {
    btnList[i].classList.remove('bg-purple-600');
  }

  let y = 0;
  for (y; y < panelItems.length; y++) {
    panelItems[y].style.display = 'none';
  }


  btn.classList.add('bg-purple-600');
  panel.style.display = 'block';

}


function setToogleValue(id) {
  const Toogle = document.getElementById(id);
  Toogle.value = Toogle.value == 0 ? 1 : 0;
  
}


function selectAllSocial(event) {
  const e = event.target;

  if (e.checked == true) {
    const ssList = document.querySelectorAll("#ss-item");
    let i = 0;
    for (i; i < ssList.length; i++) {
      ssList[i].checked = true;
    }

  } else {
    const ssList = document.querySelectorAll("#ss-item");
    let i = 0;
    for (i; i < ssList.length; i++) {
      ssList[i].checked = false;
    }
  }

  setssItem();
}


function setssItem() {
  let items = [];
  const ssList = document.querySelectorAll("#ss-item");
  const ss_list = document.getElementById("ss_list")
  let i = 0;
  let y = 0;
  for (i; i < ssList.length; i++) {
    if (ssList[i].checked == true) {
      items[y] = ssList[i].value;
      y++;
    }
  }

  if (items.length > 0) {
    ss_list.value = items.join(',')
  } else {
    ss_list.value = " ";
  }

}


//START DRAG AND DROP
const columns = document.querySelectorAll(".column");

document.addEventListener('dragstart', (item) => {
  item.target.classList.add("dragging");

});

document.addEventListener('dragend', (item) => {
  item.target.classList.remove("dragging");
  setModule();
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


async function AddPostModule() {

  const moduleType = document.getElementById('module_type');
  const title = document.getElementById('module_title');
  const position = document.getElementById('module_position');
  const modules = document.getElementById('modules');
  let response='';

  switch(moduleType.value){
    case 'post':
  
  
  const numberPosts = document.getElementById('module_limit');

  const order = document.getElementById('module_order');
  

  

   response = '{"type_module":"post","title":"' + title.value + '","limite":"' + numberPosts.value + '","order":"' + order.value + '"}';


  if (position.value != '') {
    const moduleResult_list = document.querySelectorAll('#module_result');
    const moduleTitle_list = document.querySelectorAll('#moduleTitle');
    moduleResult_list[position.value].value = response;
    moduleTitle_list[position.value].innerText = title.value;
    position.value = '';
  } else {
    modules.innerHTML += postmoduleElement(title.value+' (post)', response);

  }
    break;
  case 'blank':
  const Moduletext = document.getElementById('module_text');
  
  let ModuleScript = await TextPrepare(Moduletext.value);
  //response = '{"type_module":"blank","title":"'+title.value+'","text":"'+ModuleScript+'"}';
  var content = {'type_module':'blank','title':title.value,'text':ModuleScript};

  if (position.value != '') {
    const moduleResult_list = document.querySelectorAll('#module_result');
    const moduleTitle_list = document.querySelectorAll('#moduleTitle');
    moduleResult_list[position.value].value = /**response**/ JSON.stringify(content);
    moduleTitle_list[position.value].innerText = title.value==''?'Untitled (blank)':title.value+' (blank)';
    position.value = '';
  } else {
//    modules.innerHTML += postmoduleElement(title.value+' (blank)', response,'blank');
const MyModuleTitle = title.value==''?'Untitled':title.value;
modules.innerHTML += postmoduleElement(MyModuleTitle+' (blank)', JSON.stringify(content),'blank');

  }


    break;

    default:

    break;
  }
  $('#postModule').modal('hide');
  clearModuleModal();
  setModule();
}

async function TextPrepare(text,mode = 'set'){

  const form = new FormData();
  form.append('action','text-prepare');
  form.append('value',text);
  form.append('mode',mode);

  try{
  const data = await apiConect(form);
  const response = await data.json();
  
  if(response['success']){

    return response['data'];
  }else{
    return null;
  }
  

}catch(error){
  console.error(error);
}

}



function postmoduleElement(title, value,type='blank') {
  console.log('seted',title,value);
  const myTitle = title!=''?title:'Untitled';
  let html = `<label class="flex w-full py-4 px-4 item bg-white rounded-md dark:bg-gray-800 hover:mouse-move" draggable="true" id="module_element">
  <span class="flex flex-col gap-3 text-sm font-semibold text-gray-700 hover:pointer">
  <span id="moduleTitle" class="dark:text-gray-100">${myTitle}</span>
  <label class="flex gap-3 ">
  <span class="text-lg font-semibold text-blue-500 hover:pointer" onclick="editPostModule(event,'${type}')"><i class="bx bx-edit"></i></span>
  <span class="text-lg font-semibold text-red-600 hover:pointer" onclick="deleteModule(event)"><i class="bx bx-trash"></i></span>
  <input type="hidden" id="module_result" value='${value}'></label></span></label>`;
  return html;
}

async function editPostModule(event,type) {
  const e = event.target.parentNode;
  const moduleValue = e.parentNode.querySelector('#module_result');
  const position = getModulePosition(event);
  let values;

  switch(type){
    case 'post':
    values = JSON.parse(moduleValue.value);
  clearModuleModal();
  openModuleModal('module-post');
  

  document.getElementById('module_position').value = position;
  document.getElementById('module_title').value = values['title'];

  document.getElementById('module_limit').value = values['limite'];
  document.getElementById('module_order').value = values['order'];
  

    break;
    case 'blank':
     values = JSON.parse(moduleValue.value);
      clearModuleModal();
      openModuleModal('module-blank')
      document.getElementById('module_position').value = position;
      document.getElementById('module_title').value =  values['title'];
      document.getElementById('module_text').value =  await TextPrepare(values['text'],'get');
      
    break
    default:
      break;
  }

}


function clearModuleModal() {
  document.querySelector('#template-area').innerHTML = '';
  document.querySelector('#module_position').value = '';
  document.querySelector('#module_type').value = '';

}

function setModule() {
  const moduleInput = document.getElementById('post_modules');
  let results = [];
  const modules = document.querySelectorAll('#module_result');
  let i = 0;

  for (i; i < modules.length; i++) {
    results[i] = modules[i].value;
  }

  moduleInput.value = results.join(',');
}

function getModulePosition(event) {
  const e = event.target.parentNode;
  const moduleValue = e.parentNode.querySelector('#module_result');
  return Array.from(document.querySelectorAll('#module_result')).indexOf(moduleValue)
}

function deleteModule(event) {
  const position = getModulePosition(event);
  const modules = document.querySelectorAll('#module_element');
  modules[position].remove();
  setModule();

}

function setModuleGrid(event) {
  const selectedGrid = event.target;
  const listGrids = document.querySelectorAll('#module_grid');

  for (let i = 0; i < listGrids.length; i++) {
    listGrids[i].checked = false;
  }
  selectedGrid.checked = true;
  changeModalGrid();
}


function openModuleModal(template) {
  clearModuleModal();
  const templateArea = document.getElementById('template-area');
  const moduleType = document.getElementById('module_type');
  switch (template) {
    case 'module-post':
      templateArea.innerHTML = ModulePostTemplate;
      moduleType.value = 'post';
      
      $('#postModule').modal('show');
      break;
    case 'module-blank':
      templateArea.innerHTML = ModuleBlank;
      moduleType.value = 'blank';
      $('#postModule').modal('show');

      break;
    default:
      break;
  }
}


function formatText(value,action = 1){

if(action == 1){
  var strings = {'"':'&quot;',"'":'&#039;'}
  return value.replace(/['"]/g,function(m){
    return strings[m]
  });
}else{
  var map = {'&quot;':'"',"&#039;":"'"}
  return value.replace(/[&quot;&#039;]/g,function(m){
    return map[m];
  })
}
}

function setFontOf(e,a){
  
  try{
  let area = document.getElementById(a);
  const myfonts = document.getElementById('my-fonts');
  const fontList = myfonts.value.split(',');
  
  
  for(let i = 0;i<fontList.length;i++){
    area.classList.remove(fontList[i]);
    
  }

  area.classList.add(e.target.value);
  
  }catch(error){
    console.error(error);
  }

}

function setSizeOf(e,a){
  
  try{
  let area = document.getElementById(a);
  const sizeList = ['text-xs','text-sm','text-lg','text-xl','text-2xl','text-6xl'];
  
  
  for(let i = 0;i<sizeList.length;i++){
    area.classList.remove(sizeList[i]);
  }

  area.classList.add(e.target.value);
  }catch(error){
    console.error(error);
  }

}


function setWeightOf(e,a){
  
  try{
  let area = document.getElementById(a);
  const weightList = ['font-medium','font-semibold','font-bold'];
  
  
  for(let i = 0;i<weightList.length;i++){
    area.classList.remove(weightList[i]);
  }

  area.classList.add(e.target.value);
  }catch(error){
    console.error(error);
  }

}

function changeGrid(e,grid_id){
  let grids = document.querySelectorAll(grid_id);
  let parentElement = e.target.parentNode;
  let i=0;
  for(i;i<grids.length;i++){
    grids[i].classList.remove('bg-gray-50');
  }

  parentElement.classList.add('bg-gray-50')
}

function changeModalGrid(){
  let grids = document.querySelectorAll('.modal_grid');
  let i=0;
  for(i;i<grids.length;i++){
    grids[i].classList.remove('bg-gray-50');
    let radio = grids[i].querySelector("#module_grid");
    radio.checked ==true?grids[i].classList.add('bg-gray-50'):null;
  }
}

const restoreBtn = document.getElementById("restore-theme");

restoreBtn.addEventListener("click",(e)=>{
e.preventDefault();
const a = confirm("Tem a certeza que deseja seguir com está acção?");

if(!a){
  return false;
}

window.location =  restoreBtn.getAttribute("data-restore-uri");

});


async function startImport() {
  const code_type = $("#select_code_option").val();
  $("#select_code_option").attr('disabled','true');
  $("#select_code_option").addClass('opacity-50');
  try{
    const form = new FormData();
    form.append('action','theme');
    form.append('options',JSON.stringify({action:'import-code',code:code_type}));

    const data = await apiConect(form);
    const response = await data.json();

    if(response.success){
      $("#module_text").val(response.data);
    }else{
      kkMessgae.error(response.message);
    }

  }catch(err){
    console.error(err);
  }finally{
    $("#select_code_option").removeAttr('disabled');
    $("#select_code_option").removeClass('opacity-50');
  }
  
}
