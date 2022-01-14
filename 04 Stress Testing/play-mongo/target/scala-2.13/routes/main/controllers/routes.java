// @GENERATOR:play-routes-compiler
// @SOURCE:/Users/dmytro/Git/highload-software-architecture/4 Stress Testing/play-mongo/conf/routes
// @DATE:Thu Nov 11 20:30:10 EET 2021

package controllers;

import router.RoutesPrefix;

public class routes {
  
  public static final controllers.ReverseMovieController MovieController = new controllers.ReverseMovieController(RoutesPrefix.byNamePrefix());

  public static class javascript {
    
    public static final controllers.javascript.ReverseMovieController MovieController = new controllers.javascript.ReverseMovieController(RoutesPrefix.byNamePrefix());
  }

}
