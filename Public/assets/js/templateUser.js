/**
 *  @title : templateUser.js
 *  @author : Matthis HOULES
 *  @author : Antoine DELAUNAY
 *  @author : Mathieu LEBRUN
 *      
 *  @brief : template js page
 * 
 */

window.addEventListener("DOMContentLoaded", (event) => {
    document.getElementById('body').classList.remove('preload');
    
    var menuTrigger = document.getElementById('menuTrigger');
    var sideBarOverlay = document.getElementById('navbarOverlay');
    var body = document.getElementById('body');
    var closeSideBarB = document.getElementById('closeSideBarB');
    var notificationButton = document.getElementById('notificationButton');


    menuTrigger.addEventListener('click', openSideBar)
    sideBarOverlay.addEventListener('click', closeSideBar);
    closeSideBarB.addEventListener('click', closeSideBar);
    notificationButton.addEventListener('click', openNotification);
    sideBarOverlay.addEventListener('click', closeNotification);



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

        /**
     * @name : openNotification
     * 
     * @author : Matthis HOULES
     *  @author : Antoine DELAUNAY
     *  @author : Mathieu LEBRUN
     * 
     * @brief : Open notification modal popup
     */
    function openNotification() {
        document.getElementById('notificationList').classList.toggle('toggle');
        sideBarOverlay.classList.toggle('toggleNotif');
    }


    /**
     * @name : closeNotification
     * 
     * @author : Matthis HOULES
     *  @author : Antoine DELAUNAY
     *  @author : Mathieu LEBRUN
     * 
     * @brief : Open notification modal popup
     */
    function closeNotification() {
        document.getElementById('notificationList').classList.remove('toggle');
        sideBarOverlay.classList.remove('toggleNotif');
    }
});
