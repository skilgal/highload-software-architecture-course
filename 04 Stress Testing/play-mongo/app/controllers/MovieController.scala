package controllers

import javax.inject._
import play.api.mvc._
import play.api.cache.Cached
import repositories.MovieRepository
import reactivemongo.bson.BSONObjectID
import play.api.libs.json.{Json, __}
import scala.util.{Failure, Success}
import scala.concurrent.{ExecutionContext, Future}

import models.Movie
import play.api.libs.json.JsValue
import play.api.cache.AsyncCacheApi
import com.google.common.cache.CacheBuilder
import scala.concurrent.duration._
import java.util.concurrent.atomic.AtomicInteger
import java.util.Random
import java.util.UUID

@Singleton
class MovieController @Inject() (hCache: Cached, cache: AsyncCacheApi)(implicit
    executionContext: ExecutionContext,
    val movieRepository: MovieRepository,
    val controllerComponents: ControllerComponents
) extends BaseController {

  val ai: AtomicInteger = new AtomicInteger(0)
  val rand = new Random()

  def findAllCachedLimit() = hCache(_ => "key", 20.seconds) {
    Action.async { implicit request: Request[AnyContent] =>
      movieRepository.findAll().map { list =>
        Ok(Json.toJson(list))
      }
    }
  }

  def findAllCached() = hCache("key") {
    Action.async { implicit request: Request[AnyContent] =>
      movieRepository.findAll().map { list =>
        Ok(Json.toJson(list))
      }
    }
  }

  def findAll() = Action.async { implicit request: Request[AnyContent] =>
    movieRepository.findAll().map { list =>
      Ok(Json.toJson(list))
    }
  }

  def findAllProbCached() = Action.async {
    implicit request: Request[AnyContent] =>
      val cachingBefore: Future[Unit] =
        if (ai.incrementAndGet() >= rand.nextInt(60)) {
          movieRepository.findAll().map { list =>
            cache.set("key", list, 60.seconds)
            ai.set(0)
          }
        } else Future.successful(())

      for {
        cacheIfNeeded <- cachingBefore
        cached <- cache
          .getOrElseUpdate("key", 60.seconds)(movieRepository.findAll())
          .map(resp => Ok(Json.toJson(resp)))

      } yield cached
  }

  def findOne(id: String): Action[AnyContent] = Action.async {
    implicit request: Request[AnyContent] =>
      val objectIdTryResult = BSONObjectID.parse(id)
      objectIdTryResult match {
        case Success(objectId) =>
          movieRepository.findOne(objectId).map { movie =>
            Ok(Json.toJson(movie))
          }
        case Failure(_) =>
          Future.successful(BadRequest("Cannot parse the movie id"))
      }
  }

  def create(): Action[JsValue] =
    Action.async(controllerComponents.parsers.json) { implicit request =>
      {
        request.body
          .validate[Movie]
          .fold(
            _ => Future.successful(BadRequest("Cannot parse request body")),
            movie =>
              movieRepository.create(movie).map { _ =>
                Created(Json.toJson(movie))
              }
          )
      }
    }

  def update(id: String): Action[JsValue] =
    Action.async(controllerComponents.parsers.json) { implicit request =>
      {
        request.body
          .validate[Movie]
          .fold(
            _ => Future.successful(BadRequest("Cannot parse request body")),
            movie => {
              val objectIdTryResult = BSONObjectID.parse(id)
              objectIdTryResult match {
                case Success(objectId) =>
                  movieRepository.update(objectId, movie).map { result =>
                    Ok(Json.toJson(result.ok))
                  }
                case Failure(_) =>
                  Future.successful(BadRequest("Cannot parse the movie id"))
              }
            }
          )
      }
    }

  def delete(id: String): Action[AnyContent] = Action.async {
    implicit request =>
      {
        val objectIdTryResult = BSONObjectID.parse(id)
        objectIdTryResult match {
          case Success(objectId) =>
            movieRepository.delete(objectId).map { _ =>
              NoContent
            }
          case Failure(_) =>
            Future.successful(BadRequest("Cannot parse the movie id"))
        }
      }
  }
}
