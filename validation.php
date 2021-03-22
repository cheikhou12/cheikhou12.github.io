	<?php
  session_start();
  $bdd = new PDO('mysql:host=localhost;dbname=immobilier', 'root', '');
  if(isset($_GET['id']) AND $_GET['id'] >0)
  {
     $getid = intval($_GET['id']);
     $requser = $bdd->prepare('SELECT * FROM user WHERE id=?');
     $requser->execute(array($getid));
     $userinfo = $requser->fetch();
}
     ?>
      <?php 

   $conn = new mysqli("localhost","root","","memoire");
   if($conn->connect_error){
    die("connection Failed!".$conn->connect_error);
   }

       if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    // $products = $_POST['products'];
    $total = $_POST['total'];
    $address = $_POST['address'];
    // $pmode = $_POST['pmode'];

    
        $stmt = $conn->prepare("INSERT INTO commande(name,email,phone,total,address) VALUES(?,?,?,?,?)");
    $stmt->bind_param("sssss",$name,$email,$phone,$total,$address);
    $stmt->execute();

   echo '<div class="text-center"><h1 class="display-4 mt-2 text-danger">SounougaBatimat vous remercie!</h1>
    <h2 class="text-success" style="background-color: yellow;">commande effectuer avec succes</h2>
    <h4 class"bg-danger text-light rounded p-2">produits commandees : '.$products.'</h4>
    
    <h4>votre nom : '.$name.'</h4>
    <h4>votre email : '.$email.'</h4>
    <h4>votre telephone : '.$phone.'</h4>
    <h4>net a payer : '.number_format($total,2).'</h4>

    
    </div>';
    
   }
   ?>

  <?php

session_start();
   $connect = mysqli_connect("localhost", "root", "", "immobilier");
   if(isset($_POST["add_to_cart"]))
   {
     if(isset($_SESSION["shopping_cart"]))
     {
         $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
         if(!in_array($_GET["id"], $item_array_id))
         {
          $count = count($_SESSION["shopping_cart"]);
          $item_array = array(
        'item_id'     => $_GET['id'],
        'item_name'     => $_POST['hidden_name'],
        'item_price'     => $_POST['hidden_price'],
        'item_quantity'     => $_POST['quantity']
      );
          $_SESSION["shopping_cart"][$count] = $item_array;
         }
         else
         {
          echo '<script>alert("item already added")</script>';
          echo '<script>window.location="index2.php"</script>';
         }
     }
     else
     {
      $item_array = array(
        'item_id'     => $_GET['id'],
        'item_name'     => $_POST['hidden_name'],
        'item_price'     => $_POST['hidden_price'],
        'item_quantity'     => $_POST['quantity']
      );
      $_SESSION["shopping_cart"][0] = $item_array;
     }
   }
   if(isset($_GET["action"]))
   {
      if($_GET["action"] == "delete")
      {
         foreach($_SESSION["shopping_cart"] as $keys => $values)
         {
           if($values["item_id"] == $_GET["id"])
           {
            unset($_SESSION["shopping_cart"][$keys]);
            echo'<script>alert("item supprimer")</script>';
           header("location:index.php");
           }
         }
      }
   }


?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <script src="js/jquery.min.css"></script>
  <link rel="stylesheet" type="text/css" href="../panier/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" type="text/css" href="css/h.css"> -->
  
  <style>
    .popover
    {
      width: 100%;
      max-width: 800px;
    }
  </style>
</head>
<header>
  <?php  include("../panier/entete.php");?>
</header></br>
<body>
</br></br></br></br></br></br>
<!-- <h2 align="right">bienvenue! <?php //echo$userinfo['username']; ?></h2> -->
  <div class="container">
    
    <h3 align="center"><a href="#" style="color: blue;">finalisation de commande</a></h3>
    </br>
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="row" style="background-color: rgb(100,200,300);">
          <div class="col-md-6">Details panier</div>
          <div class="col-md-6" align="right">
            <button type="button" name="clear_cart" id="clear_cart" class="btn btn-warning btn-xs">Clear</button>
          </div>
          
        </div>
        
      </div>
      
    
    <div class="panel-body" id="shopping_cart" class="row" style="background-color: rgb(100,100,100);">

  <h3>votre details</h3>
    <div class="table-responsive" class="row" style="background-color: rgb(100,100,100);">
      <table class="table table-bordered" style="background-color: rgb(100,200,300);">
        <tr>
          <th width="40%">item name</th>
          <th width="10%">quantity</th>
          <th width="20%">price</th>
          <th width="15%">total</th>
          <th width="5%">action</th>
        </tr>
        <?php
                   if(!empty($_SESSION["shopping_cart"]))
                   {
                      $total = 0;
                      foreach($_SESSION["shopping_cart"] as $keys =>$values)
                      {
                        ?>
                        <tr>
                          <td><?php echo $values["item_name"]; ?></td>
                          <td><?php echo $values["item_quantity"]; ?></td>
                          <td><?php echo $values["item_price"]; ?></td>
                          <td><?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
                          <td><a href="validation.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="texte-title" style="background-color: red;" onclick="return">Supprimer</span></a></td>
                        </tr>

                        <?php
                        $total = $total + ($values["item_quantity"] * $values["item_price"]);
                      }
                      ?>
                      
                      <tr>
                        <td colspan="3" align="right">Total</td>
                        <td align="right">f <?php echo number_format($total, 2); ?></td>
                      </tr>
                 <?php
                   }
                   ?>
        
      </table>
</div>
</div>
</div>


<h3 style="background-color: rgb(100,300,567);" align="center">sunugal-batimat vous remercie de votre participation et vous informe que vous serez alerte dans un courte delais pour la poursuite de votre commande </h3>
<div>

</div>
</br></br></br>
       <h4 class="text-center text-info p-2">informations complementaire</h4>
      <form action="" method="post" id="placeOrder">
      <input type="hidden" name="products" value="<?= $allItems; ?>">
      <input type="hidden" name="total" value="<?= $total; ?>">
      <div class="form-groupe">
        <input type="text" name="name" class="form-control" placeholder="votre nom">

      </div>
      <div class="form-groupe">
        <input type="email" name="email" class="form-control" placeholder="votre email">
        
      </div>
      <div class="form-groupe">
        <input type="tel" name="phone" class="form-control" placeholder="votre numero">
         
      </div>
      <div class="form-groupe">
        <textarea name="address" class="form-control" rows="3" cols="10" placeholder="entrez votre adresse ici..."></textarea>
        
      </div>
      <h6 class="text-center lead">Selectionnez un methode de payement</h6>
      <div class="form-groupe">
          <select name="pmode" class="form-control">
            <option value="" selected disabled>Selectionnez un methode de payement</option>
            <option value="cod">Cash Cash</option>
            <option value="netbanking">Wav</option>
            <option value="money">Orange Money</option>
            <option value="cards">Debit/Credit Card</option>
          </select>
      </div>
      <div class="form-groupe">
        <input type="submit" name="submit" value="Place Order" class="btn btn-danger btn-block">
        <a href="action.php?clear=all" class="badge-danger badge p-1" onclick="return confirm('etes vous sure de supprimer le panier')">effacer votre panier</a>
      </div>
      </form>
        
            <footer class="page-footer bg-dark" style="background-color: black;">
            <h1 style="background-color: green;" align="center">a propos </h1>
                <div class="bg-success" style="background-color: rgb(568,900,800);">
                    <div class="container">
                        <div class="row py-4 d-flex align-item-center" style="background-color: rgb(568,900,800);">
                            
                            <div class="col-md-12 text-center" style="background-color: rgb(568,900,800);">
                                <a href="#"><i class="fab fa-facebook text-white mr-4"></i></a>
                                <a href="#"><i class="fab fa-twitter text-white mr-4"></i></a>
                                <a href="#"><i class="fab fa-google-plus-g text-white mr-4"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in text-white mr-4"></i></a>
                                <a href="#"><i class="fab fa-instagram text-white mr-4"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container text-center text-md-left mt-5">
                   <div class="row">
                       <div class="col-md-3 mx-auto mb-4">
                       <h6 class="text-uppercase font-wight-bold">nos partenaire</h6>
                       <hr class="bg-success mb-4 mt-0 d-inline-block mx-auto" style="width: 125px; height: 2px">
                           <p class="mt-2">bonsoir il fait 23 je suis planque sur mon pc entrain de coder parfois sa marche parfois non</p>
                       </div>
                       <div class="col-md-3 mx-auto mb-4">
                       <h6 class="text-uppercase font-wight-bold">nos produits</h6>
                       <hr class="bg-success mb-4 mt-0 d-inline-block mx-auto" style="width: 125px; height: 2px">
                       <ul class="list-unstyled">
                           <li class="my-2"><a href="#">appartement a louer</a></li>
                           <li class="my-2"><a href="#">appartement a vendre</a></li>
                           <li class="my-2"><a href="#">apppartement a yoff</a></li>
                           <li class="my-2"><a href="#">ordinateur</a></li>
                       </ul>
                       </div>
                       <div class="col-md-3 mx-auto mb-4">
                       <h6 class="text-uppercase font-wight-bold">nos liens</h6>
                       <hr class="bg-success mb-4 mt-0 d-inline-block mx-auto" style="width: 125px; height: 2px">
                       <ul class="list-unstyled">
                           <li class="my-2"><a href="#">Acceuil</a></li>
                           <li class="my-2"><a href="#">Poduits</a></li>
                           <li class="my-2"><a href="#">Partenaires</a></li>
                           <li class="my-2"><a href="#">Se connecter</a></li>
                       </ul>
                       </div>
                   </div>
                    
                </div>
            </footer>
<!-- javascript -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@v3.3.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="js/cart.js"></script>
</body>
</html>