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
});