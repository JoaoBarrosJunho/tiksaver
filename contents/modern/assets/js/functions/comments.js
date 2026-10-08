

function reply(id,name = ''){
    const replyTo = document.getElementById('reply');
    const commentArea = document.getElementById('comment-area');
    replyTo.value = id;
    commentArea.value = '@'+name+' ';
    commentArea.focus();
}


const commentForm = document.getElementById('commentForm');

commentForm.addEventListener('submit', async (e)=>{
e.preventDefault();
buttonload('#submit-comment');
const form = new FormData(commentForm);
form.append('pub-action','new-comment')

try{
const data = await appConect(form);
const response = await data.json();
if(response.success){
    commentAlert(response['message']);
    clearCommentArea();
}else{
    commentAlert(response['message'],0);
}
}catch(error){
    console.error(error);
    commentAlert("Error posting this comment",0);
}
buttonload('#submit-comment',1);
})


function commentAlert(message,type = 1){
    const cm = document.getElementById('comment-alert');
    const style = type != 1 ? 'bg-red-100':'bg-green-100';
    cm.innerHTML = '<div class="w-full mx-6 my-2 py-4 px-4 flex justify-center items-center rounded-md '+style+'" id="comment-alert">'+message+'</div>'

    setTimeout(()=>{
        cm.innerHTML = '';
    },3000);
}

function clearCommentArea(){
    typeof(document.getElementById('comment-area')) != 'undefined'? document.getElementById('comment-area').value = '':'';
    typeof(document.getElementById('reply')) != 'undefined'? document.getElementById('reply').value = 0:'';

}



