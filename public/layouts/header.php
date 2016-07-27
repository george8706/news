<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo $page_title?></title>
  <link href="/css/jquery-ui.css" rel="stylesheet" />
  <link href="/css/jquery-ui.theme.min.css" rel="stylesheet" />
  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <link href="/css/bootstrapValidator.css" rel="stylesheet">
  <link href="/css/my.css" rel="stylesheet">
</head>

<body>
<div  id="wrap" class="container">

  <!-- Static navbar -->
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"></a>
      </div>
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li <?php if ($current_page == "home") echo 'class="active"';?>><a href="index.php">Home</a></li>
          <li <?php if ($current_page == "add_news") echo 'class="active"';?>><a href="add.php">Add news</a></li>

        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav>