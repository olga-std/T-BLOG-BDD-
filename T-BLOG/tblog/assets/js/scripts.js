function gestoreLoad() {
  window.onscroll = function scrollUp() {
    document.getElementById('scroll_up')
    .style.display = (window.pageYOffset > '920' ? 'block' : 'none');
  };


  $(document).ready(function() {
    $(".menu-toggle").on("click", function() {
      $(".nav").toggleClass("showing");
      $(".nav ul").toggleClass("showing");
    });

    $(".post-wrapper").slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      nextArrow: $(".next"),
      prevArrow: $(".prev"),
      responsive: [
        {
          breakpoint: 1500,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 1082,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 730,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });
  });


  const loadMoreBtn = document.querySelector('.load-more-btn');
  const postList = document.querySelector('.post-list');
  const paginationLinks = document.querySelector('.pagination_links');

  function displayPosts(posts) {
      posts.forEach(post =>{
          let postHtmlString = `
              <div class="post clearfix">
                  <a href="tblog_article.php?id=${post.id}">
                      <img src="${post.image}" alt="" class="post-image">
                  </a>
                  <div class="post-preview">
                      <h2><a href="tblog_article.php?id=${post.id}">${post.title}</a></h2>
                      <i class="far fa-user"> ${post.username} </i>
                      &nbsp;
                      <i class="far fa-calendar"> ${post.created_at}</i>
                      <div class="preview-article">
                          <p class="preview-text">${post.body}</p>
                      </div>
                      <a href="tblog_article.php?id=${post.id}" class="btn read-more">Leggi tutto</a>
                  </div>
              </div>
          `;

          const domParser = new DOMParser();
          const doc = domParser.parseFromString(postHtmlString, 'text/html');
          const postNode = doc.body.firstChild;
          postList.appendChild(postNode);
      });
  }

  let nextPage = 2;
  loadMoreBtn.addEventListener('click', async function(e) {
      loadMoreBtn.textContent = 'Caricamento in corso...';
      const response = await fetch(`index.php?page=${nextPage}&ajax=1`);
      const data = await response.json();
      console.log({data});
      
      displayPosts(data.posts);
      nextPage = data.nextPage;
      if (!data.nextPage) {
          paginationLinks.innerHTML = '<div style="color: silver;">&#45; nessun altro articolo &#45;</div>';
      } else {
          loadMoreBtn.textContent = 'Continua';
      }
  });
};
window.onload = gestoreLoad;