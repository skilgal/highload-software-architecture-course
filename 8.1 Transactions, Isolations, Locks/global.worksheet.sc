import java.sql.DriverManager
import java.sql.Statement
import java.sql.Connection
import $ivy.`mysql:mysql-connector-java:8.0.27`

def statement(): (Connection, Statement) = {
  Class.forName("com.mysql.cj.jdbc.Driver")
  val mysqlUrl = "jdbc:mysql://localhost:3306/db"
  val con = DriverManager.getConnection(mysqlUrl, "user", "password")
  val stmt = con.createStatement()
  con.setAutoCommit(false)
  (con, stmt)
}

def execute(query: String, col: Option[String] = None) = {
  Class.forName("com.mysql.cj.jdbc.Driver")
  val mysqlUrl = "jdbc:mysql://localhost:3306/db"
  val con = DriverManager.getConnection(mysqlUrl, "user", "password")
  val stmt = con.createStatement()
  col
    .map { name =>
      val res = stmt.executeQuery(query)
      res.next()
      res.getString(name)
    }
    .getOrElse {
      stmt.execute(query)
    }
}
