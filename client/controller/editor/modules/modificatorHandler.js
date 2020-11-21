

export default class ModificatorsHandler{
    // modificators is an arry of objects that indicates the named assigned to that modificator
    //and the tag to assign
    constructor(modificators){
        this.modificators = modificators;
        this.modificatorsNames = modificators.map(mod=>mod.name);
        this.modificatorsTags = modificators.map(mod=>mod.tag);
        this.modificatorsSyles = modificators.map(mod=>mod.style);

    }
    setTagToSelectedText(tag){
        console.log('method');
        let selection = document.getSelection();
        let selection_text = selection.toString();
        //check if there is some text selected
        if(selection_text.length<1){
            return false;
        }
        let range = selection.getRangeAt(0);
        let parentElement = range.commonAncestorContainer.parentElement;
        //check if the selected text is 'clean' or already has applied some style
        console.log(parentElement);
        if (parentElement.classList.contains("box-content")) {
            let span = this.createElementFromTagName(tag,selection_text);
            console.log(span);
            range.deleteContents();
            range.insertNode(span);
        } else {
            //if it has some style then we have to split the parent
            console.log('not here');
        }
    }
    createElementFromTagName(name,content){
        let tag;
        for (let index = 0; index < this.modificators.length; index++) {
            if(this.modificatorsNames[index]==name){
                tag = this.modificatorsTags[index];
                break;
            }
        }
        //check if the name exists
        if(tag===undefined){
            return false;
        }

        let newElement = document.createElement(tag);
        newElement.textContent = content;
        return newElement;
    }

}