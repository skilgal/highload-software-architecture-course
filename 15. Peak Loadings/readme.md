---
author: Dmytro Altsyvanovych
title: "15. Peak Load on the [GOAL](https://goal.com) Page"
---

# Task

GOAL!!!

Describe solution that solves peak load problem for biggest european
football website <https://goal.com>

1.  Analyze all types of pages on the site
2.  Analyze and list possible sources of peak load
3.  Describe possible solution for each type

# Page types

## Static content

All of described below are static pages with content, which shouldn\'t
make load on the back-end side

-   News page
-   Players information
-   Last clubs\' news and information
-   Match history results
-   

## Shop Page

It\'s possible place of the load but we can\'t expect peak load here
according to the site specialization mostly provide information about
sport translations and sport news

## Live scores

Page contains live results of current matches. It\'s possible due to the
permanent polling process, which triggers back-end each period of time
(currently seen - 30 seconds) ![Live polling Chrome
screen](resources/live-polling.png)
