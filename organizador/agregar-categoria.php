<?php require_once('../Connections/HotSecrets.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO categorias (nom_cate, urlseo, desc_cate, img_cate, estado_categoria) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nom_cate'], "text"),
                       GetSQLValueString($_POST['urlseo'], "text"),
                       GetSQLValueString($_POST['desc_cate'], "text"),
                       GetSQLValueString($_POST['img_cate'], "text"),
                       GetSQLValueString($_POST['estado_categoria'], "int"));

  mysql_select_db($database_HotSecrets, $HotSecrets);
  $Result1 = mysql_query($insertSQL, $HotSecrets) or die(mysql_error());

  $insertGoTo = "lista-categorias.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Agregar Producto</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="css/font-awesome.css" rel="stylesheet" />


    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

<!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
<script src="js/jquery.js"></script>
  </head>

  <body>

  <section id="container" class="">
      <!--header start-->
     <?php include("xtructura/1-header.php"); ?>
      </header>
      <!--header end-->
      <!--sidebar start-->
      <?php include("xtructura/2-menu-agregar-producto.php"); ?>
      <!--sidebar end-->
      <!--main content start-->
<section id="main-content">
<section class="wrapper">
<!-- page start-->
<div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
Inline form
</header>
</section>
</div>
</div>

<div class="row">
<div class="col-lg-12">
<section class="panel">
<div class="panel-body">
<form class="form-horizontal tasi-form" method="post" name="form2" action="<?php echo $editFormAction; ?>">

<script type="text/javascript" src="js/jquery.stringToSlug.js"></script>
<div class="form-group">
<label class="col-sm-2 control-label col-lg-2" for="nom_cate">Nombre De Categoria</label>
<div class="col-lg-4">
<input type="text" class="form-control" name="nom_cate" id="categoria" placeholder="Nombre del Categoria">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label col-lg-2" for="urlseo">Url SEO</label>
<div class="col-lg-4">
<input type="text" class="form-control" name="urlseo" id="url" placeholder="Url SEO">
</div>
</div>

<script>
$(document).ready( function() {
$("#categoria").stringToSlug({
setEvents: 'keyup keydown blur',
getPut: '#url',
space: '-'
});
});
</script>

<script> 
function subirpeque()
{
self.name = 'opener';
remote = open('subir-imagen-categoria.php', 'remote', 'width=400,height=162,location=no,scrollbars=yes,menubars=no,toolbars=no,resizable=yes,fullscreen=no, status=yes');
remote.focus();
}
</script>
<div class="form-group">
<label class="col-sm-2 control-label col-lg-2" for="img_cate">Imagen</label>
<div class="col-md-4 input-group">
<input type="text" class="form-control" name="img_cate" placeholder="Imagen">
<div class="input-group-btn">
<button type="button" class="btn btn-info date-set" onClick="javascript:subirpeque();">Subir Imagen</button>
</div>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label col-lg-2" for="desc_cate">Descripcion de la Categoria</label>
<div class="col-lg-4">
<textarea class="form-control" cols="55" rows="4" name="desc_cate" placeholder="Descripcion de la Categoria"></textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label col-lg-2" for="estado_categoria">¿El producto Está Activo?</label>
<div class="col-lg-4">
<select class="form-control m-bot15" name="estado_categoria">
<option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>Activo</option>
<option value="0" <?php if (!(strcmp(0, ""))) {echo "SELECTED";} ?>>Inactivo</option>
</select>
</div>
</div>

<div class="col-lg-4">
<button type="submit" class="btn btn-success">Insertar Categoria</button>
<input type="hidden" name="MM_insert" value="form2">
</div>
</form>
</div>

</div>
</div>
<!-- page end-->
</section>
</section>
<!--main content end-->
<!--footer start-->
<?php include("xtructura/7-footer.php"); ?> 
<!--footer end-->
</section>
 <!-- js placed at the end of the document so the pages load faster -->    
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jquery.nicescroll.js" type="text/javascript"></script>

<script src="js/jquery-ui-1.9.2.custom.min.js"></script>
<script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
<!--custom switch-->
<script src="js/bootstrap-switch.js"></script>
<!--custom tagsinput-->
<script src="js/jquery.tagsinput.js"></script>
<!--custom checkbox & radio--> 

<script type="text/javascript" src="js/bootstrap-inputmask.min.js"></script>
<script src="js/respond.min.js" ></script>
<!--common script for all pages-->
<script src="js/common-scripts.js"></script>
<!--script for this page-->
<script src="js/form-component.js"></script>
</body>
</html>