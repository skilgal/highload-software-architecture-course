// @GENERATOR:play-routes-compiler
// @SOURCE:/Users/dmytro/Git/highload-software-architecture/4 Stress Testing/play-mongo/conf/routes
// @DATE:Thu Nov 11 20:30:10 EET 2021


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
