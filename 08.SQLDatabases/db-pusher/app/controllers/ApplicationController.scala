package controllers

import models.User
import play.api.Logging
import play.api.mvc._
import services.UserService

import java.time.LocalDateTime
import java.util.UUID
import javax.inject._
import scala.concurrent.ExecutionContext.Implicits.global
import scala.util.Random

@Singleton
class ApplicationController @Inject() (
    cc: ControllerComponents,
    userService: UserService
) extends AbstractController(cc)
    with Logging {

  private val r = Random

  def addUser() = Action.async { implicit request: Request[AnyContent] =>
    val newUser = User(
      UUID.randomUUID(),
      r.nextString(5),
      r.nextString(5),
      r.nextString(5),
      LocalDateTime.now()
    )

    userService
      .addUser(newUser)
      .map(_ => Ok("good"))
  }

}
