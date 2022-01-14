// @GENERATOR:play-routes-compiler
// @SOURCE:/Users/dmytro/Git/highload-software-architecture/8. SQL Databases/db-pusher/conf/routes
// @DATE:Mon Nov 22 22:17:13 EET 2021

import play.api.mvc.Call


import _root_.controllers.Assets.Asset

// @LINE:7
package controllers {

  // @LINE:7
  class ReverseApplicationController(_prefix: => String) {
    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:7
    def addUser(): Call = {
      
      Call("POST", _prefix + { _defaultPrefix } + "add")
    }
  
  }

  // @LINE:10
  class ReverseAssets(_prefix: => String) {
    def _defaultPrefix: String = {
      if (_prefix.endsWith("/")) "" else "/"
    }

  
    // @LINE:10
    def versioned(file:Asset): Call = {
      implicit lazy val _rrc = new play.core.routing.ReverseRouteContext(Map(("path", "/public"))); _rrc
      Call("GET", _prefix + { _defaultPrefix } + "assets/" + implicitly[play.api.mvc.PathBindable[Asset]].unbind("file", file))
    }
  
  }


}
