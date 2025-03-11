const sidebar_toggle = document.getElementById("sidebar-toggle");
const sidebar = document.getElementById("sidebar");

sidebar_toggle.addEventListener('click', function(event){
    console.log("clicked");
    sidebar.classList.toggle('collapsed');
});
function sidebarToggle(){
    
}
