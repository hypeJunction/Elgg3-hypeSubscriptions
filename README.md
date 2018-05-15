hypeSubscriptions
=================
![Elgg 3.0](https://img.shields.io/badge/Elgg-3.0-orange.svg?style=flat-square)

API for implementing paid subscriptions

## Features

 * Agnostic API that can be extended with any payment provider
 * Implement site subscriptions and optionally restrict access to paying subscribers only
 * API to implement entity/group specific subscriptions
 * API to restrict access to posts and downloads
 
 ## Developer Notes
 
 ### Events
 
 To implement custom logic when the subscription is created, listen to ``create, subscription`` event.
 
 To implement custom logic when the subscription cancelled, listing to ``cancel, subscription``. Note that the sbuscription can be cancelled at period end, so check ``current_period_end`` metadata, before terminating access to features.
 