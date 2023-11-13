<?php

#[AllowDynamicProperties]
class Gather
{

	private $conn;
	public function __construct($db)
	{
		$this->conn = $db;

		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}

	}

	function getCountCatId()
	{
		$sqlQuery = "SELECT COUNT(id) as count FROM cat_id_list WHERE DATE(last_modify) != CURDATE()";

		
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_assoc();
	}

	function getAllCatId()
	{
		$sqlQuery = "SELECT cat_id,count_all FROM cat_id_list WHERE DATE(last_modify) != CURDATE()";

		
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}



	function getAllProductNew()
	{
		$sqlQuery = "SELECT cat_id,list_products FROM cat_id_list WHERE DATE(last_modify) = CURDATE()";

		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}

	function getProductNoImage()
	{
		$sqlQuery = "SELECT id FROM product_list WHERE content is null";

		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}

	function getImage($product_id)
	{
		$sqlQuery = "SELECT url FROM images WHERE product_id = $product_id ";

		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}

	function productImageNameUpdate($product_id, $content)
	{

		$content = $this->conn->real_escape_string($content);

		$sqlQuery = "UPDATE product_list 
		SET content = '$content' , last_modify = CURRENT_TIMESTAMP
		WHERE product_id = $product_id";
		$stmt = $this->conn->prepare($sqlQuery);

		if ($stmt->execute()) {
			return true;
		}
	}


	function itemCountUpdate($cat_id, $itemCount,$products)
	{

		$products = $this->conn->real_escape_string($products);

		$sqlQuery = "UPDATE cat_id_list 
		SET count_all = $itemCount , list_products = '$products' , last_modify = CURRENT_TIMESTAMP
		WHERE cat_id = $cat_id";
		$stmt = $this->conn->prepare($sqlQuery);

		if ($stmt->execute()) {
			return true;
		}
	}

	function addProduct($productDetails, $category_id)
	{

		$id = htmlspecialchars(strip_tags($productDetails["id"]));
		$name = htmlspecialchars(strip_tags($productDetails["name"]));
		$category_id = htmlspecialchars(strip_tags($category_id));
		$price_current_value = htmlspecialchars(strip_tags($productDetails["price"]["current"]["value"]));
		$price_current_text = htmlspecialchars(strip_tags($productDetails["price"]["current"]["text"]));
		$price_previous_value = htmlspecialchars(strip_tags($productDetails["price"]["previous"]["value"]));
		$price_previous_text = htmlspecialchars(strip_tags($productDetails["price"]["previous"]["text"]));
		$price_rrp_value = htmlspecialchars(strip_tags($productDetails["price"]["rrp"]["value"]));
		$price_rrp_text = htmlspecialchars(strip_tags($productDetails["price"]["rrp"]["text"]));
		$is_marked_down = htmlspecialchars(strip_tags($productDetails["price"]["isMarkedDown"]));
		$is_outlet_price = htmlspecialchars(strip_tags($productDetails["price"]["isOutletPrice"]));
		$currency = htmlspecialchars(strip_tags($productDetails["price"]["currency"]));
		$colour = htmlspecialchars(strip_tags($productDetails["colour"]));
		$colour_way_id = htmlspecialchars(strip_tags($productDetails["colourWayId"]));
		$brand_name = htmlspecialchars(strip_tags($productDetails["brandName"]));
		$has_variant_colours = htmlspecialchars(strip_tags($productDetails["hasVariantColours"]));
		$has_multiple_prices = htmlspecialchars(strip_tags($productDetails["hasMultiplePrices"]));
		$group_id = htmlspecialchars(strip_tags($productDetails["groupId"]));
		$product_code = htmlspecialchars(strip_tags($productDetails["productCode"]));
		$product_type = htmlspecialchars(strip_tags($productDetails["productType"]));
		$url = htmlspecialchars(strip_tags($productDetails["url"]));
		$image_url = htmlspecialchars(strip_tags($productDetails["imageUrl"]));
		$video_url = htmlspecialchars(strip_tags($productDetails["videoUrl"]));
		$show_video = htmlspecialchars(strip_tags($productDetails["showVideo"]));
		$is_selling_fast = htmlspecialchars(strip_tags($productDetails["isSellingFast"]));
		$sponsored_campaign_id = htmlspecialchars(strip_tags($productDetails["sponsoredCampaignId"]));


		$name = $this->conn->real_escape_string($name);
		$colour = $this->conn->real_escape_string($colour);
		$brand_name = $this->conn->real_escape_string($brand_name);
		$product_type = $this->conn->real_escape_string($product_type);
		$url = $this->conn->real_escape_string($url);




		$sqlQuery = ("INSERT INTO product_list (id, name, category_id, price_current_value, price_current_text, price_previous_value,
		 price_previous_text, price_rrp_value, price_rrp_text, is_marked_down, is_outlet_price, currency, colour, colour_way_id, brand_name, has_variant_colours,
		  has_multiple_prices, group_id, product_code, product_type, url, image_url, video_url, show_video, is_selling_fast, sponsored_campaign_id)
		VALUES
		($id, '$name', $category_id, $price_current_value,
		'$price_current_text','$price_previous_value','$price_previous_text','$price_rrp_value',
		'$price_rrp_text','$is_marked_down','$is_outlet_price','$currency','$colour',
		'$colour_way_id','$brand_name','$has_variant_colours','$has_multiple_prices',
		'$group_id','$product_code','$product_type','$url','$image_url',
		'$video_url' ,'$show_video','$is_selling_fast','$sponsored_campaign_id')
		
		ON DUPLICATE KEY UPDATE
		name = VALUES(name),
		category_id = VALUES(category_id),
		price_current_value = VALUES(price_current_value),
		price_current_text = VALUES(price_current_text),
		price_previous_value = VALUES(price_previous_value),
		price_previous_text = VALUES(price_previous_text),
		price_rrp_value = VALUES(price_rrp_value),
		price_rrp_text = VALUES(price_rrp_text),
		is_marked_down = VALUES(is_marked_down),
		is_outlet_price = VALUES(is_outlet_price),
		currency = VALUES(currency),
		colour = VALUES(colour),
		colour_way_id = VALUES(colour_way_id),
		brand_name = VALUES(brand_name),
		has_variant_colours = VALUES(has_variant_colours),
		has_multiple_prices = VALUES(has_multiple_prices),
		group_id = VALUES(group_id),
		product_code = VALUES(product_code),
		product_type = VALUES(product_type),
		url = VALUES(url),
		image_url = VALUES(image_url),
		video_url = VALUES(video_url),
		show_video = VALUES(show_video),
		is_selling_fast = VALUES(is_selling_fast),
		sponsored_campaign_id = VALUES(sponsored_campaign_id),
		last_modify = CURRENT_TIMESTAMP");


		$stmt = $this->conn->prepare($sqlQuery);
		if ($stmt->execute()) {
			return true;
		}
	}


	function addImage($productDetails)
	{
		
		
		$product_id = htmlspecialchars(strip_tags($productDetails["id"]));
		$imageUrl = htmlspecialchars(strip_tags($productDetails["imageUrl"]));
		$additionalImageUrls = $productDetails["additionalImageUrls"];

	
		$sql = "INSERT INTO images (url, type,  is_primary, product_id) VALUES ";
		

		$sql .= "('{$imageUrl}', 'main',  '1', $product_id), ";
		foreach ($additionalImageUrls as $additionalImageUrl) {
			$sql .= "('{$additionalImageUrl}', 'additional', '0', $product_id), ";
		}

	
		// حذف کاما اضافی
		$sqlQuery = rtrim($sql, ", ");

		$stmt = $this->conn->prepare($sqlQuery);

		if ($stmt->execute()) {
			return true;
		}
	}
}