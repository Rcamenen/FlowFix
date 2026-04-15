const tabButtons = document.querySelectorAll(".subnav li");
const tabContents = document.querySelectorAll(".main__content section");
const teamId = document.querySelector("main").dataset.teamId;
frictionLoaded = false;

tabButtons.forEach(tabButton => {

    // ECOUTE AU CLICK DES TAB BUTTONS
    tabButton.addEventListener("click",function(){

        tabName = this.dataset.tabButton;
        
        // CSS TAB BUTTONS
        tabButtons.forEach(tabButton=>{
            if(tabButton.dataset.tabButton != tabName) tabButton.classList.remove("btn-tab--active");
            else tabButton.classList.add("btn-tab--active")
        })

        tabContents.forEach(tabContent => {
            if(tabContent.dataset.tabContent != tabName) tabContent.classList.add("dn");
            else tabContent.classList.remove("dn");
        });

        if(tabName == "frictions" && !frictionLoaded){
            console.log("frictions");
            loadFrictions(teamId,1);
            frictionLoaded = true;
        }
        
    })

});


function loadFrictions(teamId, page){

    fetch(`/team/${teamId}/frictions?page=${page}`)
    .then(response=>response.text())
    .then(html => {

        document.querySelector("[data-tab-content=frictions] .section__content").innerHTML=html

        const prevBtn = document.querySelector(".pagination__prev");
        const nextBtn = document.querySelector(".pagination__next");

        if(prevBtn){
            prevBtn.addEventListener("click", function(){
                loadFrictions(this.dataset.team, this.dataset.page);
            },{ once: true });
        }

        if(nextBtn){
            nextBtn.addEventListener("click", function(){
                loadFrictions(this.dataset.team, this.dataset.page);
            },{ once: true });
        }

    })
    .catch(() => {
        document.querySelector("[data-tab-content=frictions] .section__content").innerHTML = '<p>Erreur de chargement.</p>'
    })

}
