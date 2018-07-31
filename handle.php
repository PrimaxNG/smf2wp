  <!-- REQUIRE HANDLEBARS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.0/handlebars.min.js"></script>
<head>
  <meta charset="UTF-8">
  <title>Handlebars.js Tutorial</title>
</head>
<body>
 
  <h1>List of Animals and Sounds</h1>
  <div id="animalList">
  </div>
 
  <!-- HANDLEBARS TEMPLATE -->
  <script id="animalTemplate" type="text/x-handlebars-template">
    <ul>
      {{#animals}}
        <li class="animal">{{type}} says {{sound}}</li>
      {{/animals}}
    </ul>
  </script>
 

 
  <!-- RENDER TEMPLATE AFTER EVERYTHING ELSE LOADED -->

  <!-- HANDLEBARS TEMPLATE -->
  <script id="animalTemplate" type="text/x-handlebars-template">
    <ul>
      {{#animals}}
        <li class="animal">{{type}} says {{sound}}</li>
      {{/animals}}
    </ul>
  </script>
 
</body>
</html>