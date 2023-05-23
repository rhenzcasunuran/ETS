const buttons = document.querySelectorAll('.archive_btn');
buttons.forEach((button) => {
  button.addEventListener("click", (e) => {
    var parentElement = button.parentElement;
    var id = parentElement.id;
    var competitionName = id;

    var close = document.getElementById('close-btn');
    var cancel = document.getElementById('backbtn');
    var go = document.getElementById('gobtn');
    var okpopup_wrapper = document.getElementById('archive-pp-wrap');
    var cautionpopup_wrapper = document.getElementById('caution-pp-wrap');
    var arcc = document.getElementById('archive-pp');
    var bacc = document.getElementById('caution-pp');
    cautionpopup_wrapper.style.display = 'block';
    bacc.style.display='block';
    /*If the area outside the Caution popup is clicked */
    if (cautionpopup_wrapper) {
        cautionpopup_wrapper.addEventListener("click", function(){
            cautionpopup_wrapper.style.display = "none";
            bacc.style.display='none';
        });
        go.addEventListener("click", function(){
            cautionpopup_wrapper.style.display = "none";
            bacc.style.display='none';
            okpopup_wrapper.style.display = 'block';
            arcc.style.display = 'block';
            var post = document.getElementById(competitionName).parentElement;
            if (post != null){
                post.remove();
            }
            var remaining_posts = document.querySelectorAll('.result_container');
            console.log(remaining_posts);
            if (remaining_posts.length <= 0){
                var empty = document.getElementById('empty');
                empty.style.display = 'flex';
            }
        });
        cancel.addEventListener("click", function(){
            cautionpopup_wrapper.style.display = "none";
            bacc.style.display='none';
        });
    }
    /*If the area outside the Ok popup is clicked */
    if (okpopup_wrapper) {
        okpopup_wrapper.addEventListener("click", function(){
            okpopup_wrapper.style.display = "none";
            arcc.style.display = 'none';
        });
        close.addEventListener("click", function(){
            okpopup_wrapper.style.display = "none";
            arcc.style.display = 'none';
        });
    }

  });
});