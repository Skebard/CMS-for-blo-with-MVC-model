export default class TagsHandler {


    constructor(tags, container, selectBtn) {
        console.log('Tags: ');
        console.log(tags);
        this.totalTags = 0; //total number of tags
        this.container = container;
        this.tags = tags.map(tag=>tag.name);
        this.tagsNameId = tags;
        this.selectedTags = [];
        this.mainTag = undefined;
        this.mainCategory = undefined;
        this.selectBtn = selectBtn;
        this.addEventListeners();
    }

    addEventListeners() {
        //set main tag
        this.container.addEventListener('click', e => {
            if (e.target.tagName == 'LI') {
                let mainTag = e.currentTarget.querySelector('.main');
                this.mainTag = e.target.childNodes[0].textContent;
                if (mainTag) {
                    mainTag.classList.remove('main');
                }
                e.target.classList.add('main');
                //remove tags
            }else if(e.target.classList.contains('remove-btn')){
                //get tag category
                let removedTag = e.target.previousSibling.textContent;
                e.target.parentElement.remove();
                this.selectedTags = this.selectedTags.filter(tag=>{
                    return tag !== removedTag;
                });
                console.log(this.selectedTags);
            }
        });
        //display available tags
        this.selectBtn.addEventListener('click', e => {
            this.displayAvailableTags();
        });

        //select tag
        this.createHTMLavailableTags();
        this.modalSelectTags.addEventListener('click', e => {
            if (e.target.tagName == 'LI') {
                this.selectedTags.push(e.target.textContent);
                this.addSelectedHTMLtag(e.target.textContent);
                e.target.style.display = "none";
            }
        })

    }
    addSelectedHTMLtag(tagName) {
        let li = document.createElement('li');
        let removeBtn = document.createElement('span');
        removeBtn.textContent = 'X';
        removeBtn.classList.add('remove-btn');
        li.textContent = tagName;
        console.log(this.selectedTags);
        if(this.selectedTags.length==1){
            li.classList.add('main');
        }
        li.appendChild(removeBtn);
        this.container.append(li);
    }
    displayAvailableTags() {
        this.availableTagsContainer.innerHTML = '';
        let noneSelectedTags = this.tags.filter(tag => {
            return !this.selectedTags.includes(tag);
        })
        noneSelectedTags.forEach(tag => {
            let li = document.createElement('li');
            li.textContent = tag;
            li.style = 'padding:0.5rem;font-size:1.2rem; cursor:pointer;';
            this.availableTagsContainer.append(li);
        });

        this.modalSelectTags.style.display = 'flex';
        //create modal


    }
    createHTMLavailableTags() {
        let modalContainer = document.createElement('div');
        modalContainer.className = 'available-tags-container';
        modalContainer.style = 'z-index:9999; position:fixed; left:0; bottom:0; width:100%; height:100%; display:none; justify-content:center; align-items:center';
        let modalBg = document.createElement('div');
        modalBg.className = "modal-bg";
        modalBg.style = 'position:absolute;  left:0; bottom:0; width:100%; height:100%; display:block; opacity:0.6; background-color:black';
        let optionsContainer = document.createElement("ul");
        optionsContainer.style = 'z-index:10;width:300px; height:300px; background-color:white; display:flex; flex-direction:column; ';
        let noneSelectedTags = this.tags.filter(tag => {
            return !this.selectedTags.includes(tag);
        })
        var css = '.available-tags-container li:hover{ background-color: #00FF00 }';
        var style = document.createElement('style');

        if (style.styleSheet) {
            style.styleSheet.cssText = css;
        } else {
            style.appendChild(document.createTextNode(css));
        }

        document.getElementsByTagName('head')[0].appendChild(style);
        noneSelectedTags.forEach(tag => {
            let li = document.createElement('li');
            li.textContent = tag;
            li.style = 'padding:0.5rem;font-size:1.2rem; cursor: pointer;';
            optionsContainer.append(li);
        })

        modalContainer.append(modalBg, optionsContainer);
        modalContainer.addEventListener('click', e => {
            if (e.target.classList.contains('modal-bg')) {
                e.currentTarget.style.display = 'none';
            }
        })
        document.querySelector('body').appendChild(modalContainer);
        this.modalSelectTags = modalContainer;
        this.availableTagsContainer = optionsContainer;

    }
    removeTag() {

    }
    setMainTag() {

    }

}