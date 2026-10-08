const api = typeof(appApi) != 'undefined' ? appApi:null;

async function closeAlert(message){
    let form = new FormData();
    form.append('action','close-flash');
    form.append('message',message);
try{
    return await apiConect(form);
}catch(error){
    console.error(error);
}
     
}

async function setLanguage(lang){
    const form = new FormData();
    form.append('pub-action','set-lang');
    form.append('lang',lang);

    try{
        const data = await apiConect(form);
        const response = await data.json();

        response['success']?window.location = window.location.href:kkMessgae.error(response['message']);
        

    }catch(error){
        console.error(error);
    }
}


const formLogin = document.querySelector('#Formlogin');

if(formLogin != null){
formLogin.addEventListener('submit',async function (event){
    event.preventDefault();
    buttonload('#BtnLogin'); 

    const formdata = new FormData(this);
    const searchParams = new URLSearchParams();
        
    formdata.append("action","signin");

    for(const data of formdata.entries()){
        searchParams.append(data[0],data[1]);
       
    }

    try{
    const data = await apiConect(formdata);
    const response = await data.json();
    
    
    
    buttonload('#BtnLogin',1,'Sign In');
    if(response['success']){
        kkMessgae.success(response['message'],2000);
        setTimeout(() => {
            window.location = window.location.href;
        }, 1000);
    }else{
        kkMessgae.error(response['message'],3000);
        document.querySelector('#email').value = '';
        document.querySelector('#password').value = '';
        if(response['code']==502){
            setTimeout(() => {
                window.location = './checkpoint';
            }, 1000);
            
        }
        

        
    }
}catch(error){
    kkMessgae.error('Internal error!');
    buttonload('#BtnLogin',1,'Sign In');
    console.error(error)
}
    
    
})
}


const formCheP = document.querySelector('#FormCheckPoint');

if(formCheP != null){
    formCheP.addEventListener('submit',async function (event){
    event.preventDefault();
    buttonload('#BtnCheckpoint'); 

    const formdata = new FormData(this);
    const searchParams = new URLSearchParams();
        
    formdata.append("action","checkpoint");

    for(const data of formdata.entries()){
        searchParams.append(data[0],data[1]);
       
    }

    const data = await apiConect(formdata);
    const response = await data.json();
    
    
    buttonload('#BtnCheckpoint',1,'Done');
    if(response['success']){
        kkMessgae.success(response['message'],5000);
        setTimeout(() => {
            window.location = window.location.href;
        }, 1000);
    }else{
        kkMessgae.error(response['message'],5000);
        document.querySelector('#code').value = '';

        
    }
    
    
})
}



//signup function

const formSignUp = document.querySelector('#frmSignup');

if(formSignUp!=null){
    
    formSignUp.addEventListener('submit',async function (event){
    event.preventDefault();
    buttonload('.btnsub'); 

    const formdata = new FormData(this);
    const searchParams = new URLSearchParams();
        
    formdata.append("action","signup");

    for(const data of formdata.entries()){
        searchParams.append(data[0],data[1]);
       
    }

    try{

    const data = await apiConect(formdata);
    const response = await data.json();
    
    
    
    if(response['success']){
        kkMessgae.success(response['message'],2000);
        setTimeout(function(){
            if(response['code']=='502'){
                window.location = './checkpoint';
            }else if(response['code']=='501'){
                window.location = './login';
            }
        },2000)
    }else{
        kkMessgae.error(response['message'],5000);
    }
    
}catch(error){
    kkMessgae.error('Internal error!');
    console.error(error);
}
buttonload('.btnsub',1,'Submit');
    
})
}


//recover send function

const formCheckEmail = document.querySelector('#formEmailRecoverCheck');

if(formCheckEmail!=null){
    
    formCheckEmail.addEventListener('submit',async function (event){
    event.preventDefault();
    buttonload('.btnsub'); 

    const formdata = new FormData(this);
    const searchParams = new URLSearchParams();
        
    formdata.append("action","recover");

    for(const data of formdata.entries()){
        searchParams.append(data[0],data[1]);
       
    }

    const data = await apiConect(formdata);
    const response = await data.json();
    
    
    buttonload('.btnsub',1,'Submit');
    if(response['success']){
        kkMessgae.success(response['message'],5000);
        this.querySelector("input[type=email]").value='';
    }else{
        kkMessgae.error(response['message'],5000);
        this.querySelector("input[type=email]").value='';
        
    }
    
})
}

const formRecover = document.querySelector('#formRecovery');

if(formRecover!=null){
    
    formRecover.addEventListener('submit',async function (event){
    event.preventDefault();
    buttonload('.btnsub'); 

    const formdata = new FormData(this);
    const searchParams = new URLSearchParams();
        
    formdata.append("action","reset-password");

    for(const data of formdata.entries()){
        searchParams.append(data[0],data[1]);
       
    }

    const data = await apiConect(formdata);
    const response = await data.json();
    
    
    
    if(response['success']){
        kkMessgae.success(response['message'],3000);
        
        setTimeout(()=>{
            window.location = response['redirect'];
        },3000)
        
    }else{
        kkMessgae.error(response['message'],5000);
        
        buttonload('.btnsub',1,'Submit');
    }
    
})
}

// GEN Code

const sendCoBtn = document.querySelector('#newcode');

if(sendCoBtn!=null){
    let gencode = false;
    setTimeout(()=>{
        sendCoBtn.style.display = 'block';
        gencode = true;
    },1000*60)
    
    sendCoBtn.addEventListener('click', async function (event){
        if(gencode){
        
        const action = new FormData();
        action.append('action','resend-code');
        
        kkMessgae.loading('Wait...');
        const data = await apiConect(action);
        const response = await data.json();
        
        if(response['success']){
            kkMessgae.success(response['message'],5000);
            sendCoBtn.remove();
            gencode = false;
        }else{
            kkMessgae.error(response['message'],5000);
            
        }
        }
        
    })
}





// API Conection

async function apiConect(data){

   return fetch(api,{
        method:'POST',
        mode:'cors',
        headers:{'Contet-Type':'application/json'},
        body: data
    });

}

// FUNCTION CREAR MODAL





//LOADING BUTTON
function buttonload(selector,cond=0,BtnText='',loadmessage='Loading...'){
const text="<i class='bx bx-loader-circle bx-spin' ></i>"+loadmessage+"";
const btn = document.querySelector(`${selector}`);

if(cond ==0){
    btn.disabled = true;
    btn.innerHTML = text;
}else{
    setTimeout(()=>{
    btn.innerHTML = BtnText;
    btn.disabled = false;
    },500)
}

}

//TOAST START

window.kkMessgae = {

    msgTop: 50,
    zIndex: 12580,
    duration: 3000,
    starTop: -50,

    success: function (msg, duration) {
        duration = typeof duration === 'undefined' ? this.duration : duration;
        var message = this._generatingMessage('success', msg);
        return this._end(message, duration);
    },

    warning: function (msg, duration) {
        duration = typeof duration === 'undefined' ? this.duration : duration;
        var message = this._generatingMessage('warning', msg);
        return this._end(message, duration);
    },

    error: function (msg, duration) {
        duration = typeof duration === 'undefined' ? this.duration : duration;
        var message = this._generatingMessage('error', msg);
        return this._end(message, duration);
    },

    info: function (msg, duration) {
        duration = typeof duration === 'undefined' ? this.duration : duration;
        var message = this._generatingMessage('info', msg);
        return this._end(message, duration);
    },

    loading: function (msg, duration) {
        duration = typeof duration === 'undefined' ? this.duration : duration;
        var message = this._generatingMessage('loading', msg);
        return this._end(message, duration);
    },

    _generatingMessage: function (type, msg) {
        this._init();
        var message = {};
        var _id = this._randomString();
        message['obj'] = '[kk="' + _id + '"]';
        message['html'] = this._generatingMessageHtml(type, msg, _id);
        var me = this;
        message['remove'] = function () {
            me._remove(message['obj']);
        };
        message['text'] = function (msg) {
            $('.kk-message').find(message['obj']).find('.text').html(msg);
        };
        return message;
    },

    _generatingMessageHtml: function (type, msg, obj) {
        var html = '<div class="kk-message-notice" kk="' + obj + '" style="margin: 8px 0; width: 100%; margin-top: -' + this.starTop + 'px; opacity: 0;">';
        html += '<div style="display: inline-block; padding: 10px 20px; border-radius: 4px; box-shadow: 0 1px 6px rgba(0,0,0,.2); background: #fff;">';
        html += '<i style="margin-right: 15px; font-size: 24px; vertical-align: middle; ">';
        switch(type) {
            case 'success':
                html += "<i class='bx bxs-check-circle bx-tada' style='color:#53d02d' ></i>";
                break;
            case 'warning':
                html += "<i class='bx bxs-info-circle bx-tada' style='color:#ff9201' ></i>";
                break;
            case 'error':
                html += "<i class='bx bxs-x-circle bx-tada' style='color:#ff0101;'  ></i>";
                break;
            case 'loading':
                html += "<i class='bx bx-loader-circle bx-spin' style='color:#9e2bec' ></i>";
                break;
            default:
                html += "<i class='bx bxs-info-circle bx-tada' style='color:#ff9201' ></i>";
                break;
        }
        html += '</i>';
        html += '<span>' + msg + '</span>';
        html += '<div>';
        html += '<div>';
        return html;
    },

    _remove: function (obj) {
        $('.kk-message').find(obj).animate({marginTop: '0px', opacity: 0}, 300, function () {
            $('.kk-message').find(obj).remove();
        });
    },

    _randomString: function (len) {
        len = len || 32;
        var $chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';
        var maxPos = $chars.length;
        var ret = '';
        var time = new Date().getTime().toString();
        if (len / 2 > time.length) {
            len = len - time.length;
        } else {
            len = len / 2;
        }
        for (var i = 0; i < len; i++) {
            ret += $chars.charAt(Math.floor(Math.random() * maxPos));
            if (time[i]) {
                ret += time[time.length - i - 1];
            }
        }
        return ret;
    },

    _init: function () {
        if ($('.kk-message').length === 0) {
            var html = '<div class="kk-message" style="top: ' + this.msgTop + 'px; width: 100%; z-index: ' + this.zIndex + '; font-size: 14px; position: fixed; padding: 8px; text-align: center;"></div><style>@keyframes ani-load-loop{0%{transform:rotate(0)}50%{transform:rotate(180deg)}to{transform:rotate(1turn)}} .kk-message-notice{transition: height .3s ease-in-out,padding .3s ease-in-out;}</style>';
            $('body').append(html);
        }
    },

    _end: function (message, duration) {
        var me = this;
        $('.kk-message').append(message['html']);
        $('.kk-message').find(message['obj']).animate({marginTop: '8px', opacity: 1}, 100, function () {
            if (duration > 0) {
                setTimeout(function () {
                    me._remove(message['obj']);
                }, duration);
            }
        });
        return message;
    }

};



function newimage(i){
    const inputFile = i;
    const label = document.getElementById(inputFile);
    
    const image = label.querySelector("img");
    const input = label.querySelector("input[type=file]");
    image.src = URL.createObjectURL(input.files[0]);
}


async function uploadImage(url,name){
    const form = new FormData();
    form.append('action','upload-image');
    form.append('file',url);
    form.append('name',name);

    try{
        const data = await apiConect(form);
        const response = await data.json();

        response['success']?kkMessgae.success(response['message']):kkMessgae.error(response['message']);
    
        return response['success'];

    }catch(error){
        console.error(error);
    }

}

function setPanelTemplate(e,menu){
	const btn_color = 'bg-gray-50';
	let buttons_list = document.querySelectorAll('.btn-option');
	let template_list = document.querySelectorAll('.panel-template');
	const selected_template = document.getElementById(menu);

	for(let i=0;i<buttons_list.length;i++){
		buttons_list[i].classList.remove(btn_color);
		buttons_list[i].classList.remove('dark:bg-gray-700');
		template_list[i].classList.remove('flex');
		template_list[i].classList.add('hidden');
	}

	selected_template.classList.remove('hidden');
	selected_template.classList.add('flex');
	
	e!=null? e.target.classList.add(btn_color):null;
	e!=null? e.target.classList.add('dark:bg-gray-700'):null;
}




function loadModal(s = 0,btn_id){
    let e = $('#await-modal');
    let btnS = $(btn_id);
    if(s){
        e.removeClass('hidden');
        btnS.attr('disabled','true');
    }else{
        e.addClass('hidden');
        btnS.removeAttr('disabled');
        
    }
}

function removeStatus(){
    let status = document.querySelectorAll('.external_status');
    status.forEach((item)=>{
        item.remove();
    })
    }
    
    
    function newStatusMessage(title,message,status){
        let bg = status?'bg-green-100':'bg-red-100';
        let text = status?'text-green-500':'text-red-600';
        let html = `<span class="font-semibold">${title}</span> <span>${message}</span>`;
        let div = document.createElement('div');
        div.classList.add('w-full', 'flex', 'gap-3',bg,text,'items-center','mb-2','rounded-md','py-2','px-2','text-sm','external_status');
        div.setAttribute('onclick','removeStatus()');
        div.innerHTML = html;
    
        $('.status-area').append(div);
        document.querySelector(".status-area").scrollIntoView({behavior:"smooth"});
    
    }

    function setToogleValue(id) {
        const Toogle = document.getElementById(id);
        Toogle.value = Toogle.value == 0 ? 1 : 0;
        
      }


      async function checkNotification(id){
        let form = new FormData();
        form.append('action','onesignal');
        form.append('option',JSON.stringify({'action':'check_notification','id':id}));
    
        try{
            const data = await apiConect(form);
            const response = await data.json();
            newStatusMessage('',response.message,response.success);
        }catch(error){
            console.error(error);
        }
    }