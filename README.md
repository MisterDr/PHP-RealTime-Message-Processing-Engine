# PHP-Realtime-Message-Processing-Engine
Realtime Message Processing Engine written in PHP

This lightweight framework uses the following parts for the main feature:

 - Use Redis as backend (By default it uses the persistent storage)
 - Use Redis PubSub and WebSocket Client (Receive the message through the Redis PubSub and pass it on to the WebSocket)
 - Use WebSocket server which acts as a message processor and to pass on the message at the client
 - Process manager (Manage the PHP Processes in separate threads)
 - Small REST controller engine


### Sceens
Manager to manage the processes

![alt text](http://i.imgur.com/V8pInkG.png "Manager")

Realtime chart display with sample data
![alt text](http://i.imgur.com/Em2fBli.png "Chart")
