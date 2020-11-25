//*** IMPORT MODULES */
import Box from './modules/box.js';
import ModificatorsHandler from './modules/modificatorHandler.js';
import TagsHandler from './modules/tagsHandler.js';
import ActionsHandler from './modules/ActionsHandler.js';


let ah = new ActionsHandler;






//*** DATA ***/
let availableContentTypes = ['subtitle', 'subtitle2', 'text', 'image', 'code','resources'];
let availableModificators = ['link', 'bold', 'cursive'];
let availableModificators2 = [{
    name: 'link',
    tag: 'a',
    style: ''
}, {
    name: 'bold',
    tag: 'b',
    style: ''
}, {
    name: 'cursive',
    tag: 'i',
    style: ''
}];
let categoryTags = ['CSS', 'Javascript', "PHP", 'JQuery', 'bootstrap', 'MySql', 'HTTP', 'Random'];
let selectedTagsContainer = document.getElementById("category-tags-id");
let selectTagBtn = document.getElementById('btn-add-tag-id');

let boxes = [];

//*** HTML elements ****/
let postContent = document.getElementById("post-wrapper");
let contentOptionsWrapper = document.getElementById('content-options-id');
let saveBtn = document.getElementById('btn-save-id');
let publishBtn = document.getElementById('btn-publish-id');
let cancelBtn = document.getElementById('btn-cancel-id');
let withdrawBtn = document.getElementById('btn-withdraw-id');
let title = document.getElementById('title-id');
let mainImgUrl = document.getElementById('main-image-id');


let postId;

//get

//Get category tags






Box.initialize(postContent, availableContentTypes);
let tagHandler;
(async function(){
    categoryTags = await ah.getCategories();
    tagHandler = new TagsHandler(categoryTags, selectedTagsContainer, selectTagBtn);
    getPost();
})();

//*** EVENT LISTENERS ***//

//go back to the adminPanel
cancelBtn.addEventListener('click',e=>{
    window.location.href = 'adminPanel.php';
});



//Create selectable tags and add event listeners to add boxes
availableContentTypes.forEach(conType => {
    let li = document.createElement('li');
    li.textContent = conType;
    contentOptionsWrapper.appendChild(li);
    li.addEventListener('click', e => {

        let box = new Box(conType);
        console.log(Box.getBoxes());
    });
});

let modHandler = new ModificatorsHandler(availableModificators2);

availableModificators2.forEach(mod => {
    let li = document.createElement('li');
    li.textContent = mod.name;
    contentOptionsWrapper.appendChild(li);
    //we must use the mousedown event that destroys the selected text
    //after the event is handled. click event will not work
    li.addEventListener('mousedown', e => {
        let text = window.getSelection();
        console.log("DATA text");
        console.log(text);
        e.preventDefault();
        console.log('Styling: ')
        console.log(mod.name);
        modHandler.setTagToSelectedText(mod.name);
    })
});

withdrawBtn.addEventListener('click',e=>{
    ah.withdraw(postId);
    withdrawBtn.classList.add('hidden');
    publishBtn.classList.remove('hidden');
});
publishBtn.addEventListener('click',e=>{
    ah.publish(postId);
    saveBtn.click();
    withdrawBtn.classList.remove('hidden');
    publishBtn.classList.add('hidden');


});

saveBtn.addEventListener('click',e=>{
    let mainCategory = tagHandler.tagsNameId.filter(tag=>tag.name===tagHandler.mainTag)[0];
    //let mainCategory = tagHandler.mainTag;
    let categories = tagHandler.selectedTags.length>0?tagHandler.selectedTags:false;
    if(categories){
        categories = categories.map(category=>tagHandler.tagsNameId.filter(tag=>tag.name===category)[0]);
    }
    let contents = [];
    // type content
    Box.getBoxes().forEach(box=>{
        let dataObj = {
            type: box.type,
            content: box.getContent(),
            pos: box.pos
        }
        if(box.type ==='code'){
            dataObj.lang = box.language;
        }
        contents.push(dataObj);
    });
    console.log(tagHandler.mainTag);
    ah.save(postId,title.textContent,mainImgUrl.textContent,mainCategory,categories,contents);
});



//*** end event listeners ***/


//*** lOAD POST ***/


async function getPost(){
    let postTitle = window.location.href.split('?id=');
    if(postTitle.length===2){
        postTitle = postTitle[1];
    }else{
        //window.location.replace('adminPanel.php','_self');
    }
    let resp = await fetch('app/routes/postData.php?id='+postTitle);
    let data = await resp.json();

    //set title 
    postId = data.postInfo.id;
    title.textContent = data.postInfo.title;
    mainImgUrl.textContent = data.postInfo.mainImage;
    tagHandler.selectedTags.push(data.mainCategory);
    tagHandler.addSelectedHTMLtag(data.mainCategory);
    tagHandler.mainTag = data.mainCategory;
    data.categories = data.categories.filter(cat=>cat!==data.mainCategory);
    data.categories = data.categories.map((cat)=>cat.name);
    tagHandler.selectedTags.push(...data.categories);
    data.categories.forEach(category=>{
        tagHandler.addSelectedHTMLtag(category);
    });
    let postContents = data.postContents.sort((a,b)=>a.position-b.position);
    postContents.forEach(section=>{
        let a = new Box(section.type);
        if(section.type==='resources'){
            let tmpContainer = document.createElement('div');
            tmpContainer.innerHTML = section.content;
            let strContent = "";
            Array.from(tmpContainer.children).forEach((child)=>{
                let name = child.textContent;
                let link = child.href;
                strContent +=`<div><input type="text" placeholder="Name" value="${name}"><input type="text" placeholder="Link" value="${link}"></div>`
            });
            section.content = strContent;
            a.boxContentElement.insertAdjacentHTML('afterbegin',strContent);
        }else{
            a.boxContentElement.innerHTML = section.content;
        }
    })

 

    if(data.postInfo.STATUS==='published'){
        //hide publish button
        publishBtn.classList.add('hidden');
        //show withdraw btn
    }else{
        withdrawBtn.classList.add('hidden');
    }
    console.log(data);
}


window['createBoxes'] = function (x) {
    for (let i = 0; i < x; i++) {
        let a = new Box('text ' + i);
    }
};
window['createBox'] = function (x){
    return new Box('text');
}