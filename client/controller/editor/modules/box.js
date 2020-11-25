
/**Class  representing a box (editable area)
 * Important: before instantiating any object the static method initialize must be called
*/
export default class Box {
    static languages = ['javascript','css','php','html'];
    sayhi(){
        console.log('hi');
    }
    /**
     * Creates a box
     * @param {string} contentType - The type of the box
     */
    constructor(contentType) {
        this.type = contentType;
        Box.prototype.total++;  // {int} - Total number of instantiated boxes
        this.box = this.createHTMLbox();
        Box.prototype.container.append(this.box);   //append the new HTMLElement to the main container
        this.updatePos();
        if(this.pos>0){
            this.updatePrevSibling();
        }
        Box.prototype.boxes.push(this);

    }
    /**
     * Initializes the Box class so the instantiated objects will behave as expected.fa-sort-up
     * This method MUST be called before instantiate any object.
     * @param {HTMLElement} container - Main container where the boxes will be appended
     * @param {string[]} contentTypes - Array of types/tags that will be available
     */
    static initialize(container,contentTypes){
        Box.prototype.boxes = [];
        Box.prototype.total =0;
        Box.prototype.container = container;
        //background colors for the tags
        Box.prototype.colors = ['greenyellow','lightblue','palevioletred','lightgoldenrodyellow','lightsalmon','lightpink','mediumpurple'];
        Box.prototype.types = contentTypes;
        //create styles for each type
        var style = document.createElement('style');
        var css = "";
        Box.prototype.types.forEach((type,index)=>{
            css += '   .type-'+type+'{background-color:'+ Box.prototype.colors[index] +';}';
            console.log(Box.prototype.colors[index]);
        })
        style.appendChild(document.createTextNode(css));
        document.getElementsByTagName('head')[0].appendChild(style);
    }
    static getBoxes(){
        Box.prototype.boxes.forEach(box=>box.updatePos());
        return Box.prototype.boxes;
    }
    /**
     * Creates the HTMLElement of the box and returns it
     * @returns {HTMLElement} Box element
     */
    createHTMLbox() {
        let box = document.createElement('div');
        box.classList.add("box");
        let boxHeader = document.createElement('div');
        boxHeader.classList.add("box-header");

        let arrows = document.createElement('span');
        arrows.classList.add("arrows");
        let arrowUp = document.createElement('i');
        arrowUp.className = " fas fa-sort-up";
        let arrowDown = document.createElement('i');
        arrowDown.className = " fas fa-sort-down";
        arrowDown.classList.add("hidden");
        arrows.append(arrowUp, arrowDown);
        //Arrows event listeners
        arrowUp.addEventListener('click', () => {
            this.moveUp();
            if ((this.pos) <= 0) {
                console.log("add");
                arrowUp.classList.add('hidden');
            }
            arrowDown.classList.remove('hidden');
        });
        arrowDown.addEventListener('click', () => {
            this.moveDown();
            if ((this.pos) >= this.getLastSiblingPos()) {
                console.log(this.pos);
                console.log("add");
                arrowDown.classList.add('hidden');
            }
            arrowUp.classList.remove('hidden');
        });

        let rightContainer = document.createElement("span");
        rightContainer.classList.add('right-container');
        let type = document.createElement('span');
        type.classList.add('content-type');
        type.classList.add('noselect');
        type.classList.add("type-"+this.type);
        type.textContent = this.type;
        let trash = document.createElement('i');
        trash.className = "fas fa-trash-alt";
        trash.addEventListener('click', () => this.delete());
        //if it is code we have to add a selector with the available programming languages
        if(this.type ==='code'){
            let selLang = document.createElement('select');
            //this.selLang = selLang;
            Box.languages.forEach(lang=>{
                let opt = document.createElement('option');
                opt.value = lang;
                opt.textContent = lang;
                selLang.appendChild(opt);
            });
            selLang.addEventListener('change',e=>{
                this.language = selLang.selectedOptions[0].value;
                console.log(this.language);
            });
            rightContainer.append(selLang);
        }
        rightContainer.append(type, trash);
        boxHeader.append(arrows, rightContainer);
        let boxContent = document.createElement('div');
        boxContent.classList.add('box-content');
        boxContent.setAttribute('contenteditable', true);
        box.append(boxHeader, boxContent);
        this.boxContentElement = boxContent;
        return box;
    }

    /**
     * Updates the position of the HTMLElement
     * @returns {int} Position of the HTMLElement
     */
    updatePos() {
        let pos = Array.from(Box.prototype.container.children).indexOf(this.box);
        this.pos = pos;
        return pos;
    }
    /**
     * Returns the box at the indicated position
     * @param {int} pos - Position of the desired box
     * @returns {HTMLElement} Box
     */
    getSibling(pos) {
        return Box.prototype.container.children[pos];
    }
    /**
     * Returns the position of the last box. All the boxes are siblings.
     */
    getLastSiblingPos() {
        return Box.prototype.container.children.length - 1;
    }
    /**
     * Update the visibility of the previous sibling arrows
     */
    updatePrevSibling() {
        if ((this.pos - 1) > 0) {
            this.getSibling(this.pos - 1).querySelector('.fa-sort-up').classList.remove('hidden');
        } else {
            this.getSibling(this.pos - 1).querySelector('.fa-sort-up').classList.add('hidden');
        }
        this.getSibling(this.pos - 1).querySelector('.fa-sort-down').classList.remove('hidden');
    }
    /**
     * Update the visibility of the next sibling arrows
     */
    updateNextSibling() {
        if (this.pos + 1 > this.getLastSiblingPos()) {
            return false;
        }
        if ((this.pos + 1) < this.getLastSiblingPos()) {
            this.getSibling(this.pos + 1).querySelector('.fa-sort-down').classList.remove('hidden');
        } else {
            this.getSibling(this.pos + 1).querySelector('.fa-sort-down').classList.add('hidden');
        }
        console.log('show up arrow');
        console.log(this.getSibling(this.pos + 1));
        this.getSibling(this.pos + 1).querySelector('.fa-sort-up').classList.remove('hidden');

    }

    /**
     * Moves the HTMLElement below the next box
     */
    moveDown() {
        this.updatePos();

        let nextPos = this.pos + 1;
        if (nextPos > this.getLastSiblingPos()) {
            return false;
        }
        let nextSibling = this.getSibling(nextPos);
        this.box.remove();
        nextSibling.insertAdjacentElement('afterEnd', this.box);

        this.updatePos();
        this.updatePrevSibling();
    }

    /**
     * Moves the HTMLElement above the previous box
     */
    moveUp() {
        this.updatePos();

        let previousPos = this.pos - 1;
        if (previousPos < 0) {
            return false;
        }
        let previousSibling = this.getSibling(previousPos);
        this.box.remove();
        previousSibling.insertAdjacentElement('beforeBegin', this.box);

        this.updatePos();
        this.updateNextSibling();
    }

    /**
     * Deletes the HTMLElement
     */
    delete() {
        this.updatePos();
        if (this.pos === this.getLastSiblingPos() && this.pos!== 0) {
            this.getSibling(this.pos - 1).querySelector('.fa-sort-down').classList.add('hidden');
        }
        if (this.pos === 0) {
            console.log(this.pos);
            console.log('first');
            this.getSibling(0).querySelector('.fa-sort-up').classList.add('hidden');
        }
        this.box.remove();
        Box.prototype.boxes = Box.prototype.boxes.filter(b=>b!=this);
    }

    getContent(){
        if(this.type==='resources'){

        }
        return this.box.querySelector('.box-content').innerHTML
    }
}
