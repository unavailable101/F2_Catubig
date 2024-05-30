document.addEventListener("DOMContentLoaded", function() {
    const overviewTab = document.getElementById("overview-tab");
    const eventsTab = document.getElementById("events-tab");
    
    const overview = document.querySelector(".overview");
    const adminevents = document.querySelector(".admin-events");

    overviewTab.addEventListener("click", function(){
        overviewTab.classList.add("active");
        eventsTab.classList.remove("active");
        
        overview.style.display = "block";
        adminevents.style.display = "none";
    });
    
    eventsTab.addEventListener("click", function(){
        eventsTab.classList.add("active");
        overviewTab.classList.remove("active");
        
        adminevents.style.display = "block";
        overview.style.display = "none";
    });

    const archiveBtn = document.getElementById("archive");
    const backBtn = document.getElementById("back");
    const archiveOverview = document.querySelector(".archive-events");
    const adminOverview = document.querySelector(".all-admin-events");

    archiveBtn.addEventListener("click", function(){
        adminOverview.style.display = 'none';
        archiveOverview.style.display = 'block';
    });

    backBtn.addEventListener("click", function(){
        archiveOverview.style.display = 'none';
        adminOverview.style.display = 'block';
    });
});