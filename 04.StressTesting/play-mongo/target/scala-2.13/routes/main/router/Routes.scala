// @GENERATOR:play-routes-compiler
// @SOURCE:/Users/dmytro/Git/highload-software-architecture/4 Stress Testing/play-mongo/conf/routes
// @DATE:Thu Nov 11 20:30:10 EET 2021

package router

import play.core.routing._
import play.core.routing.HandlerInvokerFactory._

import play.api.mvc._

import _root_.controllers.Assets.Asset

class Routes(
  override val errorHandler: play.api.http.HttpErrorHandler, 
  // @LINE:5
  MovieController_0: controllers.MovieController,
  val prefix: String
) extends GeneratedRouter {

   @javax.inject.Inject()
   def this(errorHandler: play.api.http.HttpErrorHandler,
    // @LINE:5
    MovieController_0: controllers.MovieController
  ) = this(errorHandler, MovieController_0, "/")

  def withPrefix(addPrefix: String): Routes = {
    val prefix = play.api.routing.Router.concatPrefix(addPrefix, this.prefix)
    router.RoutesPrefix.setPrefix(prefix)
    new Routes(errorHandler, MovieController_0, prefix)
  }

  private[this] val defaultPrefix: String = {
    if (this.prefix.endsWith("/")) "" else "/"
  }

  def documentation = List(
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """movies""", """controllers.MovieController.findAll()"""),
    ("""GET""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """movies/""" + "$" + """id<[^/]+>""", """controllers.MovieController.findOne(id:String)"""),
    ("""POST""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """movies""", """controllers.MovieController.create()"""),
    ("""PUT""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """movies/""" + "$" + """id<[^/]+>""", """controllers.MovieController.update(id:String)"""),
    ("""DELETE""", this.prefix + (if(this.prefix.endsWith("/")) "" else "/") + """movies/""" + "$" + """id<[^/]+>""", """controllers.MovieController.delete(id:String)"""),
    Nil
  ).foldLeft(List.empty[(String,String,String)]) { (s,e) => e.asInstanceOf[Any] match {
    case r @ (_,_,_) => s :+ r.asInstanceOf[(String,String,String)]
    case l => s ++ l.asInstanceOf[List[(String,String,String)]]
  }}


  // @LINE:5
  private[this] lazy val controllers_MovieController_findAll0_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("movies")))
  )
  private[this] lazy val controllers_MovieController_findAll0_invoker = createInvoker(
    MovieController_0.findAll(),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.MovieController",
      "findAll",
      Nil,
      "GET",
      this.prefix + """movies""",
      """ Routes
 GET     /movies                controllers.MovieController.findAllProbCached()
 GET     /movies                controllers.MovieController.findAllCachedLimit()
 GET     /movies                controllers.MovieController.findAllCached()""",
      Seq()
    )
  )

  // @LINE:6
  private[this] lazy val controllers_MovieController_findOne1_route = Route("GET",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("movies/"), DynamicPart("id", """[^/]+""",true)))
  )
  private[this] lazy val controllers_MovieController_findOne1_invoker = createInvoker(
    MovieController_0.findOne(fakeValue[String]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.MovieController",
      "findOne",
      Seq(classOf[String]),
      "GET",
      this.prefix + """movies/""" + "$" + """id<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:7
  private[this] lazy val controllers_MovieController_create2_route = Route("POST",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("movies")))
  )
  private[this] lazy val controllers_MovieController_create2_invoker = createInvoker(
    MovieController_0.create(),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.MovieController",
      "create",
      Nil,
      "POST",
      this.prefix + """movies""",
      """""",
      Seq()
    )
  )

  // @LINE:8
  private[this] lazy val controllers_MovieController_update3_route = Route("PUT",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("movies/"), DynamicPart("id", """[^/]+""",true)))
  )
  private[this] lazy val controllers_MovieController_update3_invoker = createInvoker(
    MovieController_0.update(fakeValue[String]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.MovieController",
      "update",
      Seq(classOf[String]),
      "PUT",
      this.prefix + """movies/""" + "$" + """id<[^/]+>""",
      """""",
      Seq()
    )
  )

  // @LINE:9
  private[this] lazy val controllers_MovieController_delete4_route = Route("DELETE",
    PathPattern(List(StaticPart(this.prefix), StaticPart(this.defaultPrefix), StaticPart("movies/"), DynamicPart("id", """[^/]+""",true)))
  )
  private[this] lazy val controllers_MovieController_delete4_invoker = createInvoker(
    MovieController_0.delete(fakeValue[String]),
    play.api.routing.HandlerDef(this.getClass.getClassLoader,
      "router",
      "controllers.MovieController",
      "delete",
      Seq(classOf[String]),
      "DELETE",
      this.prefix + """movies/""" + "$" + """id<[^/]+>""",
      """""",
      Seq()
    )
  )


  def routes: PartialFunction[RequestHeader, Handler] = {
  
    // @LINE:5
    case controllers_MovieController_findAll0_route(params@_) =>
      call { 
        controllers_MovieController_findAll0_invoker.call(MovieController_0.findAll())
      }
  
    // @LINE:6
    case controllers_MovieController_findOne1_route(params@_) =>
      call(params.fromPath[String]("id", None)) { (id) =>
        controllers_MovieController_findOne1_invoker.call(MovieController_0.findOne(id))
      }
  
    // @LINE:7
    case controllers_MovieController_create2_route(params@_) =>
      call { 
        controllers_MovieController_create2_invoker.call(MovieController_0.create())
      }
  
    // @LINE:8
    case controllers_MovieController_update3_route(params@_) =>
      call(params.fromPath[String]("id", None)) { (id) =>
        controllers_MovieController_update3_invoker.call(MovieController_0.update(id))
      }
  
    // @LINE:9
    case controllers_MovieController_delete4_route(params@_) =>
      call(params.fromPath[String]("id", None)) { (id) =>
        controllers_MovieController_delete4_invoker.call(MovieController_0.delete(id))
      }
  }
}
