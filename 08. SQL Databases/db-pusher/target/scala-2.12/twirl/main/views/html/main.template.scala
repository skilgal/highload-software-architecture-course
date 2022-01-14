
package views.html

import _root_.play.twirl.api.TwirlFeatureImports._
import _root_.play.twirl.api.TwirlHelperImports._
import _root_.play.twirl.api.Html
import _root_.play.twirl.api.JavaScript
import _root_.play.twirl.api.Txt
import _root_.play.twirl.api.Xml
import models._
import controllers._
import play.api.i18n._
import views.html._
import play.api.templates.PlayMagic._
import play.api.mvc._
import play.api.data._

object main extends _root_.play.twirl.api.BaseScalaTemplate[play.twirl.api.HtmlFormat.Appendable,_root_.play.twirl.api.Format[play.twirl.api.HtmlFormat.Appendable]](play.twirl.api.HtmlFormat) with _root_.play.twirl.api.Template1[Html,play.twirl.api.HtmlFormat.Appendable] {

  /**/
  def apply/*1.2*/()(content: Html):play.twirl.api.HtmlFormat.Appendable = {
    _display_ {
      {


Seq[Any](format.raw/*2.1*/("""
"""),format.raw/*3.1*/("""<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Play 2.7 + Slick 4.0.0 example</title>
        <link rel="stylesheet" media="screen" href=""""),_display_(/*7.54*/routes/*7.60*/.Assets.versioned("stylesheets/main.css")),format.raw/*7.101*/("""">
        <link rel="shortcut icon" type="image/png" href=""""),_display_(/*8.59*/routes/*8.65*/.Assets.versioned("images/favicon.png")),format.raw/*8.104*/("""">

    </head>
    <body>
        """),_display_(/*12.10*/content),format.raw/*12.17*/("""

      """),format.raw/*14.7*/("""<script src=""""),_display_(/*14.21*/routes/*14.27*/.Assets.versioned("javascripts/main.js")),format.raw/*14.67*/("""" type="text/javascript"></script>
    </body>
</html>"""))
      }
    }
  }

  def render(content:Html): play.twirl.api.HtmlFormat.Appendable = apply()(content)

  def f:(() => (Html) => play.twirl.api.HtmlFormat.Appendable) = () => (content) => apply()(content)

  def ref: this.type = this

}


              /*
                  -- GENERATED --
                  DATE: Mon Nov 22 20:00:07 EET 2021
                  SOURCE: /Users/dmytro/Git/highload-software-architecture/8. SQL Databases/db-pusher/app/views/main.scala.html
                  HASH: d89ab5d8c1cd35008d0c3449e7258dc970df8339
                  MATRIX: 726->1|837->19|864->20|1041->171|1055->177|1117->218|1204->279|1218->285|1278->324|1341->360|1369->367|1404->375|1445->389|1460->395|1521->435
                  LINES: 21->1|26->2|27->3|31->7|31->7|31->7|32->8|32->8|32->8|36->12|36->12|38->14|38->14|38->14|38->14
                  -- GENERATED --
              */
          