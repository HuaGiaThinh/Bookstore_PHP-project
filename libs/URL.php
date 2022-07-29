<?php
class URL
{
	public static function redirect($module = 'default', $controller = 'index', $action = 'index', $options = null, $router = null){
		$link	= self::createLink($module, $controller, $action, $options, $router);
		header('location: ' . $link);
		exit();
	}

    public static function createLink($module, $controller, $action, $params = null, $router = null){

		if(URL_FRIENDLY && !empty($router)) return ROOT_URL . $router;

		$queryParams = '';
		if (!empty($params)) {
			foreach ($params as $key => $value) {
				$queryParams .= "&$key=$value";
			}
		}

		return sprintf("%sindex.php?module=%s&controller=%s&action=%s%s", ROOT_URL, $module, $controller, $action, $queryParams);
	}

	public static function checkRefreshPage($value, $module, $controller, $action, $params = null){
		if(Session::get('token') == $value){
			Session::delete('token');
			URL::redirect($module, $controller, $action, $params);
		}else{
			Session::set('token', $value);
		}
	}
	
	private function removeSpace($value){
		$value = trim($value);
		$value = preg_replace('#(\s)+#', ' ', $value);
		return $value;
	}
	
	public static function replaceSpace($value){
		$value = trim($value);
		$value = str_replace(' ', '-', $value);
		$value = preg_replace('#(-)+#', '-', $value);
		return $value;
	}
	
	public static function removeCircumflex($value){
		/*a à ả ã á ạ ă ằ ẳ ẵ ắ ặ â ầ ẩ ẫ ấ ậ b c d đ e è ẻ ẽ é ẹ ê ề ể ễ ế ệ
		 f g h i ì ỉ ĩ í ị j k l m n o ò ỏ õ ó ọ ô ồ ổ ỗ ố ộ ơ ờ ở ỡ ớ ợ
		p q r s t u ù ủ ũ ú ụ ư ừ ử ữ ứ ự v w x y ỳ ỷ ỹ ý ỵ z*/
		$value		= strtolower($value);
		
		$characterA	= '#(a|à|ả|ã|á|ạ|ă|ằ|ẳ|ẵ|ắ|ặ|â|ầ|ẩ|ẫ|ấ|ậ)#imsU';
		$replaceA	= 'a';
		$value = preg_replace($characterA, $replaceA, $value);
		
		$characterD	= '#(đ|Đ)#imsU';
		$replaceD	= 'd';
		$value = preg_replace($characterD, $replaceD, $value);
		
		$characterE	= '#(è|ẻ|ẽ|é|ẹ|ê|ề|ể|ễ|ế|ệ)#imsU';
		$replaceE	= 'e';
		$value = preg_replace($characterE, $replaceE, $value);
		
		$characterI	= '#(ì|ỉ|ĩ|í|ị)#imsU';
		$replaceI	= 'i';
		$value = preg_replace($characterI, $replaceI, $value);
		
		$charaterO = '#(ò|ỏ|õ|ó|ọ|ô|ồ|ổ|ỗ|ố|ộ|ơ|ờ|ở|ỡ|ớ|ợ)#imsU';
		$replaceCharaterO = 'o';
		$value = preg_replace($charaterO,$replaceCharaterO,$value);
		
		$charaterU = '#(ù|ủ|ũ|ú|ụ|ư|ừ|ử|ữ|ứ|ự)#imsU';
		$replaceCharaterU = 'u';
		$value = preg_replace($charaterU,$replaceCharaterU,$value);
		
		$charaterY = '#(ỳ|ỷ|ỹ|ý|Ý)#imsU';
		$replaceCharaterY = 'y';
		$value = preg_replace($charaterY,$replaceCharaterY,$value);
		
		$charaterSpecial = '#(,|$|:|;|!|@)#imsU';
		$replaceSpecial = '';
		$value = preg_replace($charaterSpecial,$replaceSpecial,$value);
		
		
		return $value;
		
	}
	
	
	public static function filterURL($value){
		$value = self::replaceSpace($value);
		$value = self::removeCircumflex($value);
		
		return $value;
	}

	public static function createLinkBookForUser($data, $params)
    {
        $bookID             = $data['id'];
        $categoryID         = $data['category_id'];
        $categoryNameURL    = self::filterURL($data['category_name']);
        $bookNameURL        = self::filterURL($data['name']);

        $link = self::createLink($params['module'], 'book', 'detail', ['book_id' => $bookID], "$categoryNameURL/$bookNameURL-$categoryID-$bookID.html");
        return $link;
    }
	
}
