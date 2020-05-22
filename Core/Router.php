<?php
/**
 *  @title : Router.php
 *  @author : Guillaume RISCH
 *  @author : Matthis HOULES
 * 
 *  @brief : Router class (initialize controller)
 */


class Router {

    /**
     *  @name : $routes
     * 
     *  @type : array
     *          key : string : route value (ex : /travel/create ) 
     *          value : array : route param (controller)
     * 
     *  @brief : routing table
     */
    protected $routes = [];



    /**
     *  @name   : initialize
     * 
     *  @param  : void
     * 
     *  @return : void
     * 
     *  @brief  : initialize the routing table
     * 
     */
    public function initialize() {

        // Check if URL is in routing table keys
        if (!array_key_exists($this->getURL(), $this->routes)) {

            var_dump('TODO : REDIRECT TO 404 PAGE');
            die();

        }

        // Loading Controllers classes
        spl_autoload_register(function($class){
            require_once(__DIR__.'/../App/Controller/'.$class.'.php');
        });



        $class = new $this->routes[$this->getUrl()]['controller'];



    } // public function initialize()



    /**
     *  @name  : add
     * 
     *  @param : string : route : route name
     *  @param : array : route params
     *  
     *  @return : void
     */
    public function add($route, $routeParam) {

        $this->routes[$route] = $routeParam;
    
    }


    /**
     *  @name : getUrl
     * 
     *  @param : void
     * 
     *  @return : URL without get parameters
     * 
     *  @brief : get page URL
     */
    public function getUrl() {

        // removing GET parameters from URL.

        
        return strtolower(rtrim(explode('?', $_SERVER['REQUEST_URI'], 2)[0], '/'));
        
    }







}



?>