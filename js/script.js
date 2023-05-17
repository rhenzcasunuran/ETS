const sidebar = document.querySelector(".sidebar");
const closeBtn = document.querySelector("#btn");

window.onload = function(){

    closeBtn.addEventListener("click",function(){
        sidebar.classList.toggle("open")
        menuBtnChange()
    })

    function menuBtnChange(){
        if(sidebar.classList.contains("open")){
            closeBtn.classList.replace("bx-arrow-to-right","bx-arrow-to-left")
        }else{
            closeBtn.classList.replace("bx-arrow-to-left","bx-arrow-to-right")
        }
    }
}

