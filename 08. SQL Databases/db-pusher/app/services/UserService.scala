package services

import com.google.inject.Inject
import models.{User, Users}

import java.util.UUID
import scala.concurrent.Future

class UserService @Inject() (users: Users) {

  def addUser(user: User): Future[String] = {
    users.add(user)
  }

  def deleteUser(id: UUID): Future[Int] = {
    users.delete(id)
  }

  def getUser(id: UUID): Future[Option[User]] = {
    users.get(id)
  }

  def listAllUsers: Future[Seq[User]] = {
    users.listAll
  }
}
