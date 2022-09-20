<?php include('functions.php');
$url_amazon = '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Portfolio</title>

  <!-- mobile responsive meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">

  <!-- ** Plugins Needed for the Project ** -->
  <!-- Slick -->
  <link rel="stylesheet" href="plugins/slick/slick.css">

  <!-- Fontawesome -->
  <link rel="stylesheet" href="plugins/font-awesome/fontawesome.min.css">
  <link rel="stylesheet" href="plugins/font-awesome/brands.css">
  <link rel="stylesheet" href="plugins/font-awesome/solid.css">

  <!-- aos -->
  <link rel="stylesheet" href="plugins/aos/aos.css">

  <!-- Main Stylesheet -->
  <link href="css/style.css" rel="stylesheet">

  <!--Favicon-->
  <!-- <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <link rel="icon" href="images/favicon.ico" type="image/x-icon"> -->

  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">


</head>

<body>

  <div class="preloader">
    <div class="dots dot1">
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
    </div>
  </div>
<!--================== Header Section Start ==================-->
<header class="navigation border-bottom">
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="index.html">
      <i class="fas fa-dollar-sign"></i>Amazon Price History
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.html">Home</a>
          </li>
          
        </ul>
      </div>
    </div>
  </nav>
</header>
<!--================== Header Section End ==================-->


<!--================== Hero Area Section Start ==================-->
<section class="hero-area section">
  <div class="container">
    <div class="row text-center">
      <div class="col-lg-8 mx-auto">
        <div class="hero-img mx-auto mb-1 position-relative">
          <img style="width: 170px; height: 170px;" src="images/banner-img.png" alt="img">
          <span class="shape shape-1"></span>
          <span class="shape shape-2"></span>
          <span class="shape shape-3"></span>
          <span class="shape shape-4"></span>
        </div>
        <p class="mb-1 fw-medium fs-4 text-primary">Welcome to AMAZON Price History Checker</p>
        
        <form action="index.php">
          <div>
            <div class="form-group">
              <label for=""></label>
              <input class="form-control" id="search" type="text" name="ama_url_input" placeholder="What are you looking for? hit with Amazon URL" />
            </div>
            <div class="input-field second-wrap" style="display: none;">
              <div class="input-select">
                <select data-trigger="" name="choices-single-defaul">
                  <option placeholder="">CATEGORY</option>
                  <option>Subject A</option>
                  <option>Subject B</option>
                  <option>Subject C</option>
                </select>
              </div>
            </div>
            <div class="input-field third-wrap">
              <button type="submit" class="btn btn-primary" type="button">Find Product</button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
  <div class="has-circle">
    <span class="circle circle-1"></span>
    <span class="circle circle-2"></span>
    <span class="circle circle-3"></span>
    <span class="circle circle-4"></span>
    <span class="circle circle-5"></span>
    <span class="circle circle-6"></span>
    <span class="circle circle-7"></span>
  </div>
</section>
<!--================== Hero Area Section End ==================-->

<!--================== PHP FUNCTION CALL ==================-->
<?php
//Variable to load ASIN
$asin = '';
if(isset($_GET['ama_url_input'])){
  if($_GET['ama_url_input'] != ''){
    $url = $_GET['ama_url_input'];
    $url_amazon = $_GET['ama_url_input'];
    $asin = ama_url($url);
    //$info = ama_load_info("https://camelcamelcamel.com/product/$asin");
    $html = file_get_contents("https://camelcamelcamel.com/product/$asin");
    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML($html);
    $finder = new DomXPath($doc);
?>

<!--================== Product Info Section ==================-->
<div class="container-fluid">
  <div class="row">
    <?php
      $node = $finder->query("//*[contains(@class, 'row column hide-for-medium')]/following-sibling::*[1]");
      //print_r($doc->saveHTML($node->item(0)));
      $data = $doc->saveHTML($node->item(0));
      $data = rep_class($data, '<h2>', '<h2 class="h5">', '1');
      $data = rep_class($data, 'style="height: 160px;"', 'style="float:right;"', '1');
      $data = rep_class($data, '<span class="green">', '<span class="text-success h1">', '1');
      $data = rep_class($data, 'product page at Amazon">', 'product page at Amazon"><button class="btn btn-success"> View at Amazon</button><span style="display:none">', '1');
      $data = rep_class($data, '</a> ', '</span></a>', '1');
      $data = rep_class($data, 'button expanded buy', 'button expanded referalLink', '1');
      $data = rep_class($data, '<a href="https://camelcamelcamel.com/', '<a id="photoURL" href="https://camelcamelcamel.com/', '1');
      $data = rep_class($data, 'style="overflow-wrap: break-word;"', 'style="overflow-wrap: break-word;" class="titleTag"', '1');
      $data = rep_class($data, 'breadcrumbs ', 'breadcrumb', '1');
      $data = rep_class($data, 'row column show-for-medium', 'col-sm-', '12');
      $data = rep_class($data, 'class="row column"', 'style="display:none;"', '1');
      $data = rep_class($data, 'column column-block small-12 medium-2 text-center', 'col-sm-2', '1');
      $data = rep_class($data, 'column small-12 medium-7', 'col-sm-8', '1');
      $data = rep_class($data, 'column column-block small-12 medium-3 medium-text-right', 'col-sm-2', '1');
      echo $data;
    ?>
    
  </div>
</div>
<hr>
<!--================== Product Info Section END ==================-->

<!--================== Product Price Graph ==================-->
<div class="container-fluid">
  <div class="row">
    <?php
    $homepage = "https://charts.camelcamelcamel.com/us/".$asin."/amazon.png?force=1&zero=0&w=1500&h=800&desired=false&legend=1&ilt=1&tp=all&fo=0&lang=en";
    echo "<img src='$homepage'>";
    ?>
  </div>
</div>
<hr style="border-top: 1px dashed black !important;">
<!--================== Product Price Graph End ==================-->

<!--================== Product Price Table ==================-->
<div class="container-fluid">
  <div class="row">
      <?php
        $node = $finder->query("//*[contains(@id, 'histories')]");
        //print_r($doc->saveHTML($node->item(0)));
        $data = $doc->saveHTML($node->item(0));
        $data = rep_class($data, 'row column', 'col-sm-4', '1');
        $data = rep_class($data, '<div class="col-sm-4 ">', '<div class="">', '1');
        $data = rep_class($data, 'class="row"', 'class', '1');
        echo $data;
      ?>
  </div>
</div>
<!--================== Product Price Table End ==================-->

<?php
    }//End GET_URL
  }//End isset(GET)
?>
<!--================== PHP FUNCTION CALL END ==================-->

<div class="backtotop">
  <i class="fas fa-angle-up"></i>
</div>
<!--================== Footer Section Start ==================-->
<footer>
  <div class="footer-top section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 mx-auto text-center">
          <h2 class="text-primary h4 fw-bold mb-md-5 mb-3">[Company Name]</h2>
          <p class="mb-2">[Address]</p>
          <a href="#" class="mb-3 h6 text-tertiary d-block">[EMAIL]</a>
          <a class="mb-lg-4 mb-3 d-inline-block text-dark" href="#">[PHONE]</a>
          <ul class="list-inline">
            <li class="list-inline-item"><a href="#">Whtatsapp</a></li>
            <li class="list-inline-item"><a href="#">Facebook</a></li>
            <li class="list-inline-item"><a href="#">Instagram</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom text-center py-md-5 py-4 mb-0 border-top">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <p class="mb-0">Designed And Developed by <a rel="nofollow" href="https://www.esystematics.com " target="blank">Esystematic Technologies | +92 334 5266444
          </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>
<!--================== Footer Section End ==================-->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="plugins/bootstrap/bootstrap.bundle.min.js"></script>
<!-- slick-slider-->
<script src="plugins/slick/slick.min.js"></script>
<!-- aos -->
<script src="plugins/aos/aos.js"></script>
<!-- isotope -->
<script src="plugins/shuffle/shuffle.js"></script>
<!-- Main Script -->
<script src="js/script.js"></script>
<!-- Custom Script -->
<script>
  var tag = 'microattire-20';
  var cart_ama = 'https://www.amazon.com/gp/aws/cart/add.html?ASIN.1=<?=$asin?>&Quantity.1=1';
  var url_ama = '<?= $url_amazon;?>';
  $("#photoURL").attr("href", cart_ama+"&tag="+tag);
  $(".titleTag").attr("href", cart_ama+"&tag="+tag);
  $(".referalLink").attr("href", cart_ama+"&tag="+tag);
  $('.column.small-12.large-4').toggleClass('col-sm-4');
  $('.highest_price').addClass('text-danger');
  $('.lowest_price').addClass('text-success');
  //$('.product_pane').css('width', '400px !important');
  $('#pimg').addClass('img-fluid float-right');
  $('.c-15').toggleClass('row');
  $('.product_pane').toggleClass('table table-responsive table-hover table-dark');
</script>
</body>

</html>