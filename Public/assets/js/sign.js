/**
 *  @name : sign.js
 * 
 *  @author : Antoine DELAUNAY
 *  @author : Mathieu LEBRUN
 *  @author : Matthis HOULES
 * 
 *  @brief : sign js page
 * 
 */


var passwordButtonList = document.querySelectorAll('.pwdTrigger');

for (var i = 0; i < passwordButtonList.length; ++i) {
    
    passwordButtonList[i].addEventListener('click', changeTypeInput);

}




/**
 *  @name : changeTypeInput
 * 
 *  @param : void
 * 
 *  @return : void
 * 
 *  @brief :  switch password & text input
 * 
 */
function changeTypeInput() {


    if (document.getElementById(this.dataset.toggle).type == 'password') {

        document.getElementById(this.dataset.toggle).type = 'text';
        this.innerHTML = '<i class="far fa-eye-slash"></i>';


    } else {

        document.getElementById(this.dataset.toggle).type = 'password';
        this.innerHTML = '<i class="far fa-eye"></i>';
    }


} // function changeTypeInput()
