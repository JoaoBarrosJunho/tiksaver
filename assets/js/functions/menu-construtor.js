

function updateTitle(id,item){
    
    const menuName = document.getElementById("pageName_"+id);
    const menuTitle = document.getElementById("menuTitle_"+id);
    
    menuName.innerText = item.target.value;
    menuTitle.value = item.target.value;
}

function updateLink(id,item){
    
    const menuLink = document.getElementById("menuLink_"+id);
    menuLink.value = item.target.value;
}

const formMenu = document.getElementById("formMenuItems");

function newMenuItem(title,url){
    const elemento = createmenuElement(title,url);
    formMenu.innerHTML += elemento;
}



function addLinkPage(){
    const pageList = document.querySelectorAll("#pageListItem");
    let i = 0;

    for(i;i<pageList.length;i++){
        if(pageList[i].checked == true){
            const data = pageList[i].value.split('@:');
            const url = data[0];
            const title = data[1];
            newMenuItem(title,url);
            pageList[i].checked = false;
        }

        
        
    }

}

function addLinkCategory(){
    const categoryList = document.querySelectorAll("#categoryListItem");
    let i = 0;

    for(i;i<categoryList.length;i++){
        if(categoryList[i].checked == true){
            const data = categoryList[i].value.split('@:');
            const url = data[0];
            const title = data[1];
            newMenuItem(title,url);
            categoryList[i].checked = false;
        }

        
        
    }

}

function addLinkPersonalized(){
    const title = document.getElementById('linkTitle');
    const url = document.getElementById('linkURL');

    if(title.value == '' || url.value == ''){
        kkMessgae.error('Fill all fields!');
    }else{
        newMenuItem(title.value,url.value);
        title.value = '';
        url.value = '';
    }
}


//START DRAG AND DROP
const columns = document.querySelectorAll(".column");

document.addEventListener('dragstart', (item)=>{
    item.target.classList.add("dragging");
    
    });

document.addEventListener('dragend',(item)=>{
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


  function createmenuElement(title,url){
    let id = document.querySelectorAll('.item').length>0?(document.querySelectorAll('.item').length + 1):1;
    let elementHTML = '<label id="item_'+id+'" class="block px-2 py-3 bg-gray-100 border-sm border-gray-300 dark:bg-gray-800 item" draggable="true" x-data="{open: false}">';
    elementHTML+='<label class="inline-flex items-center hover:pointer justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" @click="open = !open" aria-haspopup="true">';
    elementHTML+='<span class="inline-flex items-center"> <span class="ml-4" id="pageName_'+id+'">'+title+'</span></span> <i class="bx bx-chevron-down"></i> </label>';
    elementHTML+=' <template x-if="open">';
    elementHTML+=' <ul x-transition:enter="transition-all ease-in-out duration-300" x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl" x-transition:leave="transition-all ease-in-out duration-300" x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0" class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900" aria-label="submenu">';
    elementHTML+='<li class="flex flex-col gap-3">';
    elementHTML+='<input type="text"  value="'+title+'"  onchange="updateTitle('+id+',event)" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Page tile">';
    elementHTML+='<input type="text"  value="'+url+'" onchange="updateLink('+id+',event)" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Page URL">';
    elementHTML+='<label class="text-sm underline text-red-600 hover:pointer " onclick="deleteItem('+id+')">Remove item</label>';
    elementHTML+='</li></ul></template>';
    elementHTML+='<input type="hidden" name="titlemenu[]" value="'+title+'" id="menuTitle_'+id+'" >';
    elementHTML+='<input type="hidden" name="linkmenu[]" value="'+url+'" id="menuLink_'+id+'">';
    elementHTML+='</label>';
    return elementHTML;
}

function deleteItem(id){
    const item = document.getElementById('item_'+id);
    item.remove();
};



function saveMenu(){
    const submitMenu = document.getElementById('SubmitMenu');
    submitMenu.click();

}


