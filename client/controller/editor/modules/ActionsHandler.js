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
            categories: categories,
            contents: contents
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


    async action(action,data){
        data.action = action;

        let dataServ = await fetch('app/routes/postData.php',{
            method: 'put',
            body: JSON.stringify(data)
        }).then(resp=>resp.text());
        console.log(dataServ);
        console.log(JSON.parse(dataServ));

    }

    async getCategories(){
        let neww = "app/routes/postData.php?allCategories=true";
        let resp = await fetch(neww);
        let data = await  resp.json();
        return data;
    }

}