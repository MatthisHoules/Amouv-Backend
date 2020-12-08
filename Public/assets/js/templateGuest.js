/**
 *  @title : template.js
 *  @author : Matthis HOULES
 *  @author : Antoine DELAUNAY
 *  @author : Mathieu LEBRUN
 *      
 *  @brief : template js page
 * 
 */

window.addEventListener("DOMContentLoaded", (event) => {
    document.getElementById('body').classList.remove('preload');
    

    var sideBar = document.getElementById('sideBar');
    var menuTrigger = document.getElementById('menuTrigger');
    var sideBarOverlay = document.getElementById('navbarOverlay');
    var body = document.getElementById('body');
    var closeSideBarB = document.getElementById('closeSideBarB');
    var notificationButton = document.getElementById('notificationButton');


    menuTrigger.addEventListener('click', openSideBar)
    sideBarOverlay.addEventListener('click', closeSideBar);
    closeSideBarB.addEventListener('click', closeSideBar);



    /**
     * @name : openSideBar
     * 
     * @author : Matthis HOULES
     *  @author : Antoine DELAUNAY
     *  @author : Mathieu LEBRUN
     * 
     * @brief : Open sidebar function
     */
    function openSideBar() {
        sideBarOverlay.classList.add('toggle');
        body.classList.add('toggle');
    }


    /**
     * @name : closeSideBar
     * 
     * @author : Matthis HOULES
     *  @author : Antoine DELAUNAY
     *  @author : Mathieu LEBRUN
     * 
     * @brief : Open sidebar function
     */
    function closeSideBar() {
        sideBarOverlay.classList.remove('toggle');
        body.classList.remove('toggle');
    }

});
