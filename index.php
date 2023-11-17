<?php

/**
 * Plugin Name: Javis Plugin
 * Plugin URI: 
 * Description: My first plugin
 * Version: 2.0
 * Author: Javis Otieno
 * Author URI: 
 * License: GPL2
 */


//how to get link in terms of id https://www.javytech.co.ke/?p=4242


add_action("admin_menu","addMenu");

function addMenu(){

	add_menu_page("Prices Update","Prices update", 4, "example-options", "exampleMenu");
	
	add_submenu_page("example-options","Products Not on javytech","Products Not on javytech",4,"example-option-2", "option2");
	add_submenu_page("example-options","Products Not on javy","Products Not on Javy",4,"example-option-3", "option3");
	add_submenu_page("example-options","Add Product","Add Product",4,"example-option-1", "option1");
	//prices update- PU DU-Description update
	add_submenu_page("example-options","Description update","Description update",4,"example-option-4", "option4");
		//prices update- PU DU-Description update
	add_submenu_page("example-options","Stock and Price Update","Stock and Price Update",4,"example-option-5", "option5");

	add_submenu_page("example-options","Categories Update","Categories Update",4,"example-option-6", "option6");
}
	function save_prices($post,$price){
    // Get an instance of the WC_Product object
    $product2 = wc_get_product( $post );

    //$price = some_function_to_get_the_price( $post_ID ); 
   

    if($product2->is_type( 'simple' )){
        $product2->set_regular_price($price);
        //product sale price required to prevent sale prices intefering with the regular price
        $product2->set_sale_price($price);
        $product2->set_price($price);
    }
    $product2->save();

    echo '---updated<br/>';

}

function exampleMenu(){


if(isset($_GET['offset'])){
	$offset=$_GET['offset'];
}else
{
	$offset=0;
}

echo "offset:".$offset."--this<br>";


$count=0;
$count2=0;


//interaction with database

$mysqli_host='sql286.your-server.de';
$mysqli_username='javy2021';
$mysqli_password='@Ja20vy20';
$mysqli_database='javy2021';

if($db_link=@mysqli_connect($mysqli_host,$mysqli_username,$mysqli_password,$mysqli_database))
{
	
}
$connect = new mysqli($mysqli_host,$mysqli_username, $mysqli_password, $mysqli_database);

if($connect->connect_error){
	//echo 'Connection failed:'.$connect->connect_error;
}else{
	//echo "succesfully connected.";
}

$query='SELECT * FROM `products` WHERE supplier_id=1 ORDER BY id DESC LIMIT 200 OFFSET '.$offset;
								$query_run=mysqli_query($db_link,$query);
								$count=1;

$offset=$offset+200;

echo '<meta http-equiv="refresh" content="10;URL=\'https://www.javytech.co.ke/wp-admin/admin.php?page=example-options&offset='.$offset.'\'" />'; 
								
								while($row=mysqli_fetch_assoc($query_run)){


								
								if($row['image']==''){
									$image_uri='http://promote.javy.co.ke/assests/images/product-images/picture-coming-soon.jpg';
								}else{
									$image_uri=str_replace("..", "http://promote.javy.co.ke", $row['image']);
								}

									$javy_price=$row['price'];
									$javy_id=$row['id'];
									$javy_name=$row['name'];
									$post_id=$row['javytech_id'];


									





//interaction with database




if($post_id>1){
	
	
	$count++;

		$product = wc_get_product( $post_id );

		if($product){
		
	$product_regular_price=$product->get_regular_price();
	$product_sale_price=$product->get_sale_price();
	$product_price=$product->get_price();

	if($product_regular_price!=$javy_price){
		echo "DIFFERENT";
	}

	echo ' --------------------------'.$javy_price.'----'.$product_regular_price.' '.$javy_id.' '.$javy_name.'  '.$post_id.' ';

	echo  $product_sale_price."  ".$product_price;

save_prices($post_id,$javy_price);

}else{

	echo 'INVALID PRODUCT ID------------'.$javy_price.'  '.$javy_id.' '.$javy_name.'  '.$post_id.' ';
	echo  " <br> ";
}



}else{
	$count2++;
	echo ' NOT UPDATED-----------'.$javy_price.'----'.$product_regular_price.' '.$javy_id.' '.$javy_name.'  '.$post_id.' ---<a target="_blank" href="admin.php?page=example-option-1&id='.$javy_id.'">ADD</a>  -----<a href="http://javis.av.ke/product.php?id='.$javy_id.'" target="_blank">OPEN</a><br/>';
}


}

echo "<br/><br/> Updated count ".$count;
echo "<br/><br/> Not updated count ".$count2;




}

function option4(){


$count=0;
$count2=0;


//interaction with database

$mysqli_host='sql286.your-server.de';
$mysqli_username='javy2021';
$mysqli_password='@Ja20vy20';
$mysqli_database='javy2021';

if($db_link=@mysqli_connect($mysqli_host,$mysqli_username,$mysqli_password,$mysqli_database))
{
	
}
$connect = new mysqli($mysqli_host,$mysqli_username, $mysqli_password, $mysqli_database);

if($connect->connect_error){
	//echo 'Connection failed:'.$connect->connect_error;
}else{
	//echo "succesfully connected.";
}

$query='SELECT * FROM `products` WHERE supplier_id=1 AND status=1';
								$query_run=mysqli_query($db_link,$query);
								$count=1;
								
								while($row=mysqli_fetch_assoc($query_run)){

									$javy_description=$row['description'];
									$javy_description = str_replace('our online store', 'Javy Technologies', $javy_description);
									$javy_description = str_replace('our online shop', 'Javy Technologies', $javy_description);
									$javy_description = str_replace('woocommerce-Tabs-panel woocommerce-Tabs-panel--description panel entry-content wc-tab', '', $javy_description);
									$javy_id=$row['id'];
									$javy_name=$row['name'];
									$post_id=$row['javytech_id'];


//interaction with database

if($post_id>1){
	
	
	$count++;

		$product = wc_get_product( $post_id );

	
		
	$product_description=$product->get_description();

	if($product_description!=html_entity_decode($javy_description)&&!empty($javy_description)&&!empty($post_id)){
		echo "DIFFERENT";
	// Get the WC_Product Object instance (optional if needed)
	// Set the description
	$product->set_description(html_entity_decode($javy_description));
	$product->save(); // Save product data

	}

	echo ' --------------------------'.$javy_id.' '.$javy_name.'  <a href="https://www.javytech.co.ke/product/?p='.$post_id.'" "target=_blank">'.$post_id.'</a> <br>';
	





}else{
	$count2++;
	echo ' NOT UPDATED-----------'.$javy_id.' '.$javy_name.'  '.$post_id.' ---<a target="_blank" href="admin.php?page=example-option-1&id='.$javy_id.'">ADD</a>  -----<a href="http://javis.av.ke/product.php?id='.$javy_id.'" target="_blank">OPEN</a><br/>';
}


}

echo "<br/><br/> Updated count ".$count;
echo "<br/><br/> Not updated count ".$count2;




}



function option5(){

if(isset($_GET['offset'])){
	$offset=$_GET['offset'];
}else
{
	$offset=0;
}

echo "offset:".$offset."--this<br>";



$count=0;
$count2=0;


//interaction with database

$mysqli_host='sql286.your-server.de';
$mysqli_username='javy2021';
$mysqli_password='@Ja20vy20';
$mysqli_database='javy2021';

if($db_link=@mysqli_connect($mysqli_host,$mysqli_username,$mysqli_password,$mysqli_database))
{
	
}
$connect = new mysqli($mysqli_host,$mysqli_username, $mysqli_password, $mysqli_database);

if($connect->connect_error){
	//echo 'Connection failed:'.$connect->connect_error;
}else{
	//echo "succesfully connected.";
}

$query='SELECT * FROM `products` WHERE supplier_id=1 ORDER BY id DESC LIMIT 200 OFFSET '.$offset;
								$query_run=mysqli_query($db_link,$query);
								$count=1;
//done with offset on sql
$offset=$offset+200;

echo '<meta http-equiv="refresh" content="10;URL=\'https://www.javytech.co.ke/wp-admin/admin.php?page=example-option-5&offset='.$offset.'\'" />'; 
								
								while($row=mysqli_fetch_assoc($query_run)){

									$javy_status=$row['status'];
									$javy_name=$row['name'];
									$post_id=$row['javytech_id'];
									$javy_price=$row['price'];








//interaction with database

if($post_id>1){
	
	$count++;
	$product = wc_get_product( $post_id );

//available 
	save_prices($post_id,$javy_price);

	if($javy_status==1&&!empty($product)){
		
	$product->set_stock_status('instock');
	$product->save(); // Save product data
	echo 'IN STOCK';
	}
	//not available
	else if($javy_status==0&&!empty($product)){
	$product->set_stock_status('outofstock');
	$product->save(); // Save product data
	echo 'OUT OF STOCK';
	}
	echo ' --------------------------'.$javy_id.' '.$javy_name.' <a href="https://www.javytech.co.ke/product/?p='.$post_id.'" target="_blank"> '.$post_id.'</a> <br>';
	

}else{
	$count2++;
	echo ' NOT UPDATED-----------'.$javy_id.' '.$javy_name.'  '.$post_id.' ---<a target="_blank" href="admin.php?page=example-option-1&id='.$javy_id.'">ADD</a>  -----<a href="http://javis.av.ke/product.php?id='.$javy_id.'" target="_blank">OPEN</a><br/>';
}


}

echo "<br/><br/> Updated count ".$count;
echo "<br/><br/> Not updated count ".$count2;




}


function option6(){

if(isset($_GET['offset'])){
	$offset=$_GET['offset'];
}else
{
	$offset=0;
}

echo "offset:".$offset."--this<br>";



$count=0;
$count2=0;


//interaction with database

$mysqli_host='sql286.your-server.de';
$mysqli_username='javy2021';
$mysqli_password='@Ja20vy20';
$mysqli_database='javy2021';

if($db_link=@mysqli_connect($mysqli_host,$mysqli_username,$mysqli_password,$mysqli_database))
{
	
}
$connect = new mysqli($mysqli_host,$mysqli_username, $mysqli_password, $mysqli_database);

if($connect->connect_error){
	//echo 'Connection failed:'.$connect->connect_error;
}else{
	//echo "succesfully connected.";
}

$query='SELECT * FROM `products` WHERE category="home-theatres" and brand="lg" ORDER BY id DESC LIMIT 200 OFFSET '.$offset;
//test purposes
//$query='SELECT * FROM `products` WHERE id=10870';
								$query_run=mysqli_query($db_link,$query);
								$count=1;
//done with offset on sql
$offset=$offset+200;

//echo '<meta http-equiv="refresh" content="10;URL=\'https://www.javytech.co.ke/wp-admin/admin.php?page=example-option-5&offset='.$offset.'\'" />'; 
								
								while($row=mysqli_fetch_assoc($query_run)){

									$javy_status=$row['status'];
									$javy_name=$row['name'];
									$post_id=$row['javytech_id'];
									$javy_price=$row['price'];








//interaction with database

if($post_id>1){
	
	$count++;
	$product = wc_get_product( $post_id );

//available 
	save_prices($post_id,$javy_price);

	if(!empty($product)){
	echo "Working on categories";
	$cat_ids = array( 159 );	
	wp_set_object_terms( $post_id, $cat_ids, 'product_cat', true );
	$cat_ids = array( 157 );	
	wp_remove_object_terms( $post_id, $cat_ids, 'product_cat' );
	}
	//not available

	echo ' --------------------------'.$javy_id.' '.$javy_name.' <a href="https://www.javytech.co.ke/product/?p='.$post_id.'" target="_blank"> '.$post_id.'</a> <br>';
	

}else{
	$count2++;
	echo ' NOT UPDATED-----------'.$javy_id.' '.$javy_name.'  '.$post_id.' ---<a target="_blank" href="admin.php?page=example-option-1&id='.$javy_id.'">ADD</a>  -----<a href="http://javis.av.ke/product.php?id='.$javy_id.'" target="_blank">OPEN</a><br/>';
}


}

echo "<br/><br/> Updated count ".$count;
echo "<br/><br/> Not updated count ".$count2;




}


function option2(){


$count2=0;


//interaction with database

$mysqli_host='sql286.your-server.de';
$mysqli_username='javy2021';
$mysqli_password='@Ja20vy20';
$mysqli_database='javy2021';

if($db_link=@mysqli_connect($mysqli_host,$mysqli_username,$mysqli_password,$mysqli_database))
{
	
}
$connect = new mysqli($mysqli_host,$mysqli_username, $mysqli_password, $mysqli_database);

if($connect->connect_error){
	//echo 'Connection failed:'.$connect->connect_error;
}else{
	//echo "succesfully connected.";
}

$query='SELECT * FROM `products` WHERE supplier_id=1';
								$query_run=mysqli_query($db_link,$query);
								
								
								while($row=mysqli_fetch_assoc($query_run)){


								
								if($row['image']==''){
									$image_uri='http://promote.javy.co.ke/assests/images/product-images/picture-coming-soon.jpg';
								}else{
									$image_uri=str_replace("..", "http://promote.javy.co.ke", $row['image']);
								}

									$javy_price=$row['price'];
									$javy_id=$row['id'];
									$javy_name=$row['name'];
									$post_id=$row['javytech_id'];

									$javy_status=$row['status'];


									





//interaction with database




if($post_id>1){


}else{
	if($javy_status==1){
		$stock_status="IN STOCK";
	}else if ($javy_status==0){
		$stock_status="OUT OF STOCK";
	}
	$count2++;
	echo ' NOT UPDATED-----------'.$javy_price.'----'.$product_regular_price.' '.$javy_id.' '.$javy_name.'  '.$post_id.' ---'.$stock_status.'---<a target="_blank" href="admin.php?page=example-option-1&id='.$javy_id.'">ADD</a>  -----<a href="http://javis.av.ke/product.php?id='.$javy_id.'" target="_blank">OPEN</a><br/>';
}


}

echo "<br/><br/> Not updated count ".$count2;




}





function option3(){


$count2=0;
$count=0;


//interaction with database

$mysqli_host='15.235.51.182';
$mysqli_username='javy2021';
$mysqli_password='@Ja20vy20';
$mysqli_database='javy2021';

if($db_link=@mysqli_connect($mysqli_host,$mysqli_username,$mysqli_password,$mysqli_database))
{
	
}
$connect = new mysqli($mysqli_host,$mysqli_username, $mysqli_password, $mysqli_database);

if($connect->connect_error){
	//echo 'Connection failed:'.$connect->connect_error;
}else{
	//echo "succesfully connected.";
}




$ids = wc_get_products( array( 'return' => 'ids', 'limit' => -1 ) );


foreach ($ids as $post_id) {
	$count++;

	$query='SELECT * FROM `products` WHERE javytech_id='.$post_id;
								$query_run=mysqli_query($db_link,$query);
								$rows=mysqli_num_rows($query_run);
								
								
								if($rows==0){
		$count2++;

$product = wc_get_product( $post_id );


		
	$product_regular_price=$product->get_regular_price();
	$product_sale_price=$product->get_sale_price();
	$product_price=$product->get_price();
	$product_title=$product->get_title();



	echo ' -----------'.$product_title.' --- '.$product_regular_price.' '.$post_id.' ';

	echo  $product_sale_price."  ".$product_price.'  <a href="https://www.javytech.co.ke?p='.$post_id.'" target="_blank">OPEN</a> --- <a href="http://control.javy.av.ke/scrape/wordpress/add-product.php?link=https://www.javytech.co.ke?p='.$post_id.'" target="_blank">ADD</a>--- <a href="post.php?post='.$post_id.'&action=edit" target="_blank">EDIT-DELETE</a><br/>';

}


}
	# code...



echo "<br/><br/> Total count on javytech ".$count;
echo "<br/><br/> Not on .av.ke ".$count2;




}

function option1(){


//interaction with database
	$product_id=$_GET['id'];

$mysqli_host='sql286.your-server.de';
$mysqli_username='javy2021';
$mysqli_password='@Ja20vy20';
$mysqli_database='javy2021';

if($db_link=@mysqli_connect($mysqli_host,$mysqli_username,$mysqli_password,$mysqli_database))
{
	
}
$connect = new mysqli($mysqli_host,$mysqli_username, $mysqli_password, $mysqli_database);

if($connect->connect_error){
	//echo 'Connection failed:'.$connect->connect_error;
}else{
	//echo "succesfully connected.";
}

$query='SELECT * FROM `products` WHERE id='.$product_id;
								$query_run=mysqli_query($db_link,$query);
								
		if($row=mysqli_fetch_assoc($query_run)){



			$javy_price=$row['price'];
			$javy_id=$row['id'];
			$javy_name=$row['name'];
			$javy_status=$row['status'];
			$javy_highlights=$row['highlights'];
			$javy_description=html_entity_decode($row['description']);
			$javy_description=str_replace('our online shop.com', 'javytech,co.ke', $javy_description);
			$javy_description=str_replace('our online store.com', 'javytech.co.ke', $javy_description);
			$javy_description=str_replace('our online shop', 'Javy Technologies', $javy_description);
			$javy_description=str_replace('our online store', 'Javy Technologies', $javy_description);
			$javy_description=str_replace('woocommerce-Tabs-panel woocommerce-Tabs-panel--description panel entry-content wc-tab', '', $javy_description);
			
			$javy_description=str_replace('from Kenya.', 'from Javy Technologies in Kenya.', $javy_description);

			if(empty($javy_description)){
				$javy_description=$javy_highlights;
				$javy_highlights='';
			}

			$javy_category=$row['category'];
			$javy_brand=$row['brand'];

			$query2='SELECT * FROM `categories` WHERE categories_slug="'.$javy_category.'"';
			$query_run2=mysqli_query($db_link,$query2);				
			if($row2=mysqli_fetch_assoc($query_run2)){
				$category_id=$row2['javytech_id'];
				$javy_category_id=$row2['categories_id'];
			}

			$query3='SELECT * FROM `brands` WHERE brand_slug="'.$javy_brand.'" AND brand_category="'.$javy_category_id.'"';
			$query_run3=mysqli_query($db_link,$query3);				
			if($row3=mysqli_fetch_assoc($query_run3)){
				$brand_id=$row3['javytech_id'];
			}

			echo 'category='.$category_id.'  brand='.$brand_id.'  ';

			$javy_image=str_replace( '..', 'http://promote.javy.co.ke' , $row['image']);

	echo '<br/>-'.$javy_id.' '.$javy_name.'  <br/>'.$javy_price.'  <br/>'.$row_image.'<br/>'.$javy_highlights.'<br/>';

	$objProduct = new WC_Product();

$objProduct->set_name($javy_name);
$objProduct->set_status("publish");  // can be publish,draft or any wordpress post status
$objProduct->set_catalog_visibility('visible'); // add the product visibility status
$objProduct->set_description(addslashes($javy_description));
$objProduct->set_short_description($javy_highlights);
$objProduct->set_sku(""); //can be blank in case you don't have sku, but You can't add duplicate sku's
$objProduct->set_price($javy_price); // set product price
$objProduct->set_regular_price($javy_price); // set product regular price
$objProduct->set_manage_stock(false); // true or false
//$objProduct->set_manage_stock(true);
//$objProduct->set_stock_quantity(10);
 // in stock or out of stock value
if($javy_status==1){
	$objProduct->set_stock_status('instock');
}else if($javy_status==0){
	$objProduct->set_stock_status('outofstock');
}
$objProduct->set_backorders('no');
$objProduct->set_reviews_allowed(true);
$objProduct->set_sold_individually(false);
//set to iphone
//manually set

$objProduct->set_category_ids(array($category_id,$brand_id));



function uploadMedia($image_url){

    require_once(plugin_dir_path( __FILE__ ).'../../../wp-admin//includes/image.php');
	require_once(plugin_dir_path( __FILE__ ).'../../../wp-admin//includes/file.php');
	require_once(plugin_dir_path( __FILE__ ).'../../../wp-admin//includes/image.php');
	$media = media_sideload_image($image_url,0);
	$attachments = get_posts(array(
		'post_type' => 'attachment',
		'post_status' => null,
		'post_parent' => 0,
		'orderby' => 'post_date',
		'order' => 'DESC'
	));
	return $attachments[0]->ID;
}
// above function uploadMedia, I have written which takes an image url as an argument and upload image to wordpress and returns the media id, later we will use this id to assign the image to product.
$productImagesIDs = array(); // define an array to store the media ids.
//$images = array("image1","image2","image3");
$images = array($javy_image); // images url array of product

foreach($images as $image){
	$mediaID = uploadMedia($image); // calling the uploadMedia function and passing image url to get the uploaded media id
	if($mediaID) $productImagesIDs[] = $mediaID; // storing media ids in a array.
}
if($productImagesIDs){
	$objProduct->set_image_id($productImagesIDs[0]); // set the first image as primary image of the product

        //in case we have more than 1 image, then add them to product gallery. 
	if(count($productImagesIDs) > 1){
		$objProduct->set_gallery_image_ids($productImagesIDs);
	}
}




$product_id = $objProduct->save();


$query_javytech_id='UPDATE `products` SET javytech_id='.$product_id.' WHERE id='.$javy_id;


if(mysqli_query($db_link,$query_javytech_id)){
    echo "Javytech ID ".$product_id." Succesfully Updated";        
}


echo ' ---<a href="https://www.javytech.co.ke/?p='.$product_id.'" target="_blank">OPEN UP</a>';





}
else{
	echo "ENTER ID OF THE PRODUCT ON JAVY";
}






}


?>