# SASsy - webSocket App Server

Github: https://github.com/idimensionz/sassy
## Requirements
* PHP 7.4 or higher
* [Composer]

[Composer]: http://getcomposer.org

## Installation Instructions
1. Clone the repository
2. Run `composer install` to install the dependencies

## Starting the websocket server
If you want to see debug output in the server console, set the SASSY_SERVER_DEBUG=1
> export SASSY_SERVER_DEBUG=1

Run 
> php bin/websocket-server.php

## Example client apps
### From the web broweser JS console
You can test the websocket server right from a web browswer JS console by running the code below (i.e. from the dev console)

Note: You'll want to run this from at least 2 browser tabs/windows to be able to see messages flow between the 2 "clients".  
> var conn = new WebSocket('ws://localhost:8080');
> conn.onopen = function(e) {
 console.log("Connection established!");
};
> 
>  let jsonMessage = {messageType: "iDimensionz\\AppServer\\Message\\Base\\TextMessage",uniqId:1,message:"hello"};
> 
> conn.send(JSON.stringify(jsonMessage));

### Use our ReactJS Chat component
**Coming soon!**

## Design approaches
* Messages know how to "process themselves" via process message on server.
* "Service messages" can access functionality provided by a service class
  * i.e. a Topic message allows a connection to call functions on the TopicService like creating a new topic or listing existing topics.
* Topic Manager built in (default "General" topic created when server starts)
* Extensible via events/subscribers to allow developers to easily "hook" into various parts of the server

## Uses
Some ideas for ways this can be used ...
* Chat server 
  * Topics can be "channels".
  * TextMessage can be used for basic text messages.
  * New message types can be created for images, videos, emojis, etc.
* "Presence"
  * Let connections indicate their status (i.e. DND, away, etc)
* Point-to-point communications (audio, video)
* Interactive game server (card games, board games and more)
  * Create new message types for actions within a game
* Distributed processing
  * Create client apps that can process data payloads sent from the server.
* Replace API's clients with websocket clients
  * "Always on" connection could increase performance and enable new features like ...
    * real-time analysis of popular pages/products
    * "assisted shopping" by allowing customer service to interact with customers in real time
    * lots more!
* and whatever interactive applications your imagination can dream up

## Testing
Available via "make" targets in Makefile
* PhpStan - static analysis
* Unit tests

## Why create such a thing (especially in PHP)?
* Wanted to create a basis for implementing some of the uses described above.
* To show PHP is ...
  * a great language and a lot of the "issues" that people had with it in the past have been addressed in latest versions (especially 8+)
  * a language that can be used to create high performance, professional server side applications