import Blog from './Blog.js';


let postsContainer = document.querySelector("#posts-container-id .posts-page");
let categoriesContainer = document.querySelector("#posts-overview-id > .categories-tags");
let loadMoreBtn = document.getElementById('load-more-btn-id');
let loadingSpinner = document.getElementById('loading-spinner-id');

(async function(){
    let myBlog = new Blog(postsContainer,categoriesContainer,loadMoreBtn,loadingSpinner);
    let a = await myBlog.printCategories();
    myBlog.init();
    loadMoreBtn.addEventListener('click', async  e=>{
        let resp = await myBlog.loadMore();
        if(!resp){
            // loadMoreBtn.classList.add('hidden');
        }
    });
})();

