import Blog from './Blog.js';


let postsContainer = document.querySelector("#posts-container-id .posts-page");
let categoriesContainer = document.querySelector("#posts-overview-id > .categories-tags");
let loadMoreBtn = document.getElementById('load-more-btn-id');

(async function(){
    let myBlog = new Blog(postsContainer,categoriesContainer);
    let a = await myBlog.printCategories();
    myBlog.init();
    loadMoreBtn.addEventListener('click',e=>{
        myBlog.loadMore();
    });
})();


//search by main category

//Displays the loading animation
function displayLoading(){
    loadingHTML.classList.remove("hidden");
}
function hideLoading(){
    loadingHTML.classList.add("hidden");
}
