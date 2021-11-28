// import $file.`global.worksheet`._
import $ivy.`mysql:mysql-connector-java:8.0.27`

import java.sql.Connection
import java.sql.Statement
import java.sql.DriverManager

val update = "UPDATE test_table SET value=value + 1 WHERE id=1;"
val insertRow = "insert into test_table (value) values (0);"

def statement(): (Connection, Statement) = {
  Class.forName("com.mysql.cj.jdbc.Driver")
  val mysqlUrl = "jdbc:mysql://localhost:3306/db"
  val con = DriverManager.getConnection(mysqlUrl, "user", "password")
  val stmt = con.createStatement()
  con.setAutoCommit(false)
  (con, stmt)
}

def inTrx()(st: (Connection, Statement) => Unit) = {

  Class.forName("com.mysql.cj.jdbc.Driver")
  val mysqlUrl = "jdbc:mysql://localhost:3306/db"
  val con = DriverManager.getConnection(mysqlUrl, "user", "password")
  val stmt = con.createStatement()
  con.setAutoCommit(false)

  st(con, stmt)

  stmt.close()
  con.close()
}

inTrx() { (con, stmt) =>
  stmt.execute(update)
  stmt.execute(update)

  con.commit()
}
val check =
  "SELECT IF( (select value from test_table where id = 1) = 2,'true','false') as result;"

inTrx() { (con, st) =>
  val resSet = st.executeQuery(check)
  resSet.next()
  println(resSet.getString("result"))

  con.commit()
}
