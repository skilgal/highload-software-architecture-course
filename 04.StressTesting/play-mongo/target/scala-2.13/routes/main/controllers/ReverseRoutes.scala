// @GENERATOR:play-routes-compiler
// @SOURCE:/Users/dmytro/Git/highload-software-architecture/4 Stress Testing/play-mongo/conf/routes
// @DATE:Thu Nov 11 20:30:10 EET 2021

import play.api.mvc.Call


import _root_.controllers.Assets.Asset

// @LINE:5
package controllers {

  // @LINE:5
  class ReverseMovieController(_prefix: => String) {
    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:7
    def create(): Call = {
      
      Call("POST", _prefix + { _defaultPrefix } + "movies")
    }
  
    // @LINE:6
    def findOne(id:String): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "movies/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[String]].unbind("id", id)))
    }
  
    // @LINE:5
    def findAll(): Call = {
      
      Call("GET", _prefix + { _defaultPrefix } + "movies")
    }
  
    // @LINE:9
    def delete(id:String): Call = {
      
      Call("DELETE", _prefix + { _defaultPrefix } + "movies/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[String]].unbind("id", id)))
    }
  
    // @LINE:8
    def update(id:String): Call = {
      
      Call("PUT", _prefix + { _defaultPrefix } + "movies/" + play.core.routing.dynamicString(implicitly[play.api.mvc.PathBindable[String]].unbind("id", id)))
    }
  
  }


}
