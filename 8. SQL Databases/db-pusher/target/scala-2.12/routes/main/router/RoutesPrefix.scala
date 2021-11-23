// @GENERATOR:play-routes-compiler
// @SOURCE:/Users/dmytro/Git/highload-software-architecture/8. SQL Databases/db-pusher/conf/routes
// @DATE:Mon Nov 22 22:17:13 EET 2021


package router {
  object RoutesPrefix {
    private var _prefix: String = "/"
    def setPrefix(p: String): Unit = {
      _prefix = p
    }
    def prefix: String = _prefix
    val byNamePrefix: Function0[String] = { () => prefix }
  }
}
