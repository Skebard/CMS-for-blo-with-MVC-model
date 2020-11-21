export default class ActionsHandler{
    //this class is in charge for saving, publishing and cancel

    //Sent all the data to server and get response
    //when sending data we will make the easier approach: remove all the contents and save the new ones
    save(id,title,mainImage,mainCategory,categories,contents){
        let data = {
            id:id,
            title:title,
            description: 'description field is not implemented yet',
            mainImage: mainImage,
            mainCategory: mainCategory,
            categories: JSON.stringify(categories),
            contents: JSON.stringify(contents)
        }
        console.log(data);
        this.action('save',data);
    }

    //sent all the data to server and get response
    publish(id){
        let data = {
            id:id
        };
        this.action('publish',data);
    }

    withdraw(id){
        let data = {
            id:id
        };
        this.action('withdraw',data);
    }

    create(title){
        let data = {
            title:title
        }
        this.action('create',data);
    }
    async action(action,data){
        let formData = new FormData;
        Object.entries(data).forEach(entrie=>{
            formData.append(entrie[0],entrie[1]);
        });
        formData.append('action',action)
        let dataObject ={};
        formData.forEach((value,key)=>{dataObject[key]=value});

        let dataServ = await fetch('app/routes/postData.php',{
            method: 'put',
            body: JSON.stringify(dataObject)
        }).then(resp=>resp.text());
        console.log(dataServ);

    }

    async getCategories(){
        let old = "../blog/posts/newData.php?categories";
        let neww = "app/routes/postData.php?allCategories=true";
        let resp = await fetch(neww);
        let data = await  resp.json();
        return data;
    }

}