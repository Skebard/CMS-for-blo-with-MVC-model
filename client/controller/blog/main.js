import Blog from './Blog.js';


let postsContainer = document.querySelector("#posts-container-id .posts-page");
let categoriesContainer = document.querySelector("#posts-overview-id > .categories-tags");
let loadMoreBtn = document.getElementById('load-more-btn-id');
let loadingSpinner = document.getElementById('loading-spinner-id');
let searchBtn = document.getElementById('search-btn-id');
let searchInput = document.getElementById('search-input-id');


//Initialize the page
(async function(){
    let myBlog = new Blog(postsContainer,categoriesContainer,loadMoreBtn,loadingSpinner);
    let a = await myBlog.printCategories();
    myBlog.init();
    loadMoreBtn.addEventListener('click', async  e=>{
        let resp = await myBlog.loadMore();
    });
    searchBtn.addEventListener('click',e=>{
        console.log(searchInput.value);
        myBlog.textSearch(searchInput.value);
    })
    searchInput.addEventListener('keydown',e=>{
        if(e.key==='Enter'){
            myBlog.textSearch(searchInput.value);
        }
    })

    $(window).scroll(function(){
        if($(window).scrollTop() + $(window).height() > $("#posts-container-id").height())
        {
        loadMoreBtn.click();
        }
       });



})();

