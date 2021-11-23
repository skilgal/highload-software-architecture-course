package models

import com.google.inject.Inject
import play.api.data.Form
import play.api.data.Forms.mapping
import play.api.data.Forms._
import play.api.db.slick.{DatabaseConfigProvider, HasDatabaseConfigProvider}
import slick.jdbc.JdbcProfile

import scala.concurrent.{ExecutionContext, Future}
import java.time.LocalDateTime
import java.util.UUID

case class User(
    id: UUID,
    userName: String,
    password: String,
    realName: String,
    birthDate: LocalDateTime
)

import slick.jdbc.MySQLProfile.api._

class UserTableDef(tag: Tag) extends Table[User](tag, "users") {

  def id = column[UUID]("id", O.PrimaryKey, O.AutoInc)
  def userName = column[String]("userName")
  def password = column[String]("password")
  def realName = column[String]("realName")
  def birthDate = column[LocalDateTime]("birthDate")

  override def * =
    (id, userName, password, realName, birthDate) <> (User.tupled, User.unapply)
}

class Users @Inject() (protected val dbConfigProvider: DatabaseConfigProvider)(
    implicit executionContext: ExecutionContext
) extends HasDatabaseConfigProvider[JdbcProfile] {

  val users = TableQuery[UserTableDef]

  def add(user: User): Future[String] = {
    dbConfig.db
      .run(users += user)
      .map(res => "User successfully added")
      .recover { case ex: Exception =>
        ex.getCause.getMessage
      }
  }

  def delete(id: UUID): Future[Int] = {
    dbConfig.db.run(users.filter(_.id === id).delete)
  }

  def get(id: UUID): Future[Option[User]] = {
    dbConfig.db.run(users.filter(_.id === id).result.headOption)
  }

  def listAll: Future[Seq[User]] = {
    dbConfig.db.run(users.result)
  }

}
