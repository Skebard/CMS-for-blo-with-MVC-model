let body = document.querySelector('body');
let createPostBtn = document.getElementById('create-post-btn-id');
let createPostForm = document.getElementById("create-post-form-id");
let modalCreatePost = document.getElementById("modal-create-post-id");
let cancelNewPost = document.getElementById('cancel-id');


cancelNewPost.addEventListener('click',()=>{
    modalCreatePost.classList.add('hidden');
});
createPostBtn.addEventListener('click',e=>{
    modalCreatePost.classList.remove('hidden');
});

createPostForm.addEventListener('submit',async e=>{
    e.preventDefault();
    if(e.target.classList.contains('btn-cancel')){
        return true;
    }
    let data = new FormData(createPostForm);
    let resp = await fetch('app/routes/postData.php',{
        method:'post',
        body:data
    });
    let dataResp = await resp.json();
    if(dataResp.completed){
        modalCreatePost.classList.add('hidden');
    }
});


body.addEventListener('click',e=>{
    console.log(e.target);
        let title;
        //check if the row is clicked
        if(e.target.classList.contains('post') ){
            title = e.target.dataset.id;
        //check if one column of the row has been clicked
        }else if(e.target.parentElement.classList.contains('post')){
            title = e.target.parentElement.dataset.id;
        }
        if(title!=undefined){
            //window.location.href = 'postEditor.php?id='+
            window.location.href = 'postEditor.php?id='+title;
            console.log(title);
        }
    });