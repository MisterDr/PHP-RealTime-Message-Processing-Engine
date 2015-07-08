# Asynchronio - PHP Realtime Message Processing Engine / Framework
Realtime Message Processing Engine/Framework written in PHP

This lightweight framework uses the following parts for the example features:

 - Use Redis as backend (By default it uses the persistent storage)
 - Use Redis PubSub and WebSocket Client (Receive the message through the Redis PubSub and pass it on to the WebSocket)
 - Use WebSocket server which acts as a message processor and to pass on the message at the client
 - Process manager (Manage the PHP Processes in separate threads)
 - Small REST controller engine

## Screens
Manager to manage the processes

![alt text](http://i.imgur.com/V8pInkG.png "Manager")

Realtime chart display with sample data
![alt text](http://i.imgur.com/Em2fBli.png "Chart")

Process flowchart
![alt text](http://i.imgur.com/T90Xwhd.png "Process")

## More features

### Ultra Light Scalable PHP Framework

   - Fully Redis backboned
   - Package agnostic (You can use regular composer packages, or make your own)
   - Variable / Class name agnostic (Name it, use it)
   - Asynchronous processing
   - WebSockets rendering engine (You can render whole pages through WebSockets)
   - Plates templating engine (Fully replaceable by your own)
   - RedBean ORM (Again fully replaceable, used mainly for rapid prototyping)
   - Cross Domain/Platform caching with Redis
   - PHPUnit testing

### Planned features
  
   - BootSnip Components with backend support
   - Docker support
   - Grid computing support
   - High performance computing using the CUDA PHP / OpenCV
   
#### Hot smokin' planned features
 
   - Advanced code generator based on NLP
   - Evolving code engine / Asynchronio Reasoning Engine (Generating code through NLP, context reasoning, self modifying and self learning)
   - Sample to generate Contact list program with search capability

## Folder structure

   + app
     - base             : Asynchronio Base files
     - common           : Asynchronio Common files
     - controllers      : Controllers
     - services         : Standalone services
     - tests            : PHPUnit tests
     - views            : Various views
   + ui
     - bower_components : Bower installation folder
     - css              : CSS files
     - fonts            : Fonts
     - js               : JS
     
# TODO

    + Install pthreads