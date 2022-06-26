<?php
class Validate
{

	// Error array
	private $errors	= array();

	// Source array
	private $source	= array();

	// Rules array
	private $rules	= array();

	// Result array
	private $result	= array();

	// Contrucst
	public function __construct($source)
	{
		$this->source = $source;
	}

	// Add rules
	public function addRules($rules)
	{
		$this->rules = array_merge($rules, $this->rules);
	}

	// Get error
	public function getError()
	{
		return $this->errors;
	}

	// Set error
	public function setError($element, $message)
	{

		if (array_key_exists($element, $this->errors)) {
			$this->errors[$element] .= ' - ' . $message;
		} else {
			$this->errors[$element] = '<b>' . ucfirst($element) . ':</b> ' . $message;
		}
	}

	// Get result
	public function getResult()
	{
		return $this->result;
	}

	// Add rule
	public function addRule($element, $type, $options = null, $required = true)
	{
		$this->rules[$element] = array('type' => $type, 'options' => $options, 'required' => $required);
		return $this;
	}

	// Run
	public function run()
	{
		foreach ($this->rules as $element => $value) {
			if ($value['required'] == true && trim($this->source[$element]) == null) {
				$this->setError($element, 'dữ liệu không được rỗng!');
			} else {
				switch ($value['type']) {
					case 'int':
						$this->validateInt($element, $value['options']['min'], $value['options']['max']);
						break;
					case 'string':
						$this->validateString($element, $value['options']['min'], $value['options']['max']);
						break;
					case 'url':
						$this->validateUrl($element);
						break;
					case 'email':
						$this->validateEmail($element);
						break;
					case 'status':
						$this->validateStatus($element);
						break;
					case 'select':
						$this->validateSelectBox($element);
						break;
					case 'groupACP':
						$this->validateGroupACP($element);
						break;
					case 'group':
						$this->validateGroupID($element);
						break;
					case 'password':
						$this->validatePassword($element, $value['options']);
						break;
					case 'confirm':
						$this->validateConfirm($element, $value['options']);
						break;
					case 'date':
						$this->validateDate($element, $value['options']['start'], $value['options']['end']);
						break;
					case 'existRecord':
						$this->validateExistRecord($element, $value['options']);
						break;
					case 'notExistRecord':
						$this->validateNotExistRecord($element, $value['options']);
						break;
					case 'string-notExistRecord':
						$this->validateString($element, $value['options']['min'], $value['options']['max']);
						$this->validateNotExistRecord($element, $value['options']);
						break;
					case 'email-notExistRecord':
						$this->validateEmail($element);
						$this->validateNotExistRecord($element, $value['options']);
						break;
					case 'password-notExistRecord':
						$this->validatePassword($element, $value['options']);
						$this->validateNotExistRecord($element, $value['options']);
						break;
					case 'file':
						$this->validateFile($element, $value['options']);
						break;
				}
			}
			if (!array_key_exists($element, $this->errors)) {
				$this->result[$element] = $this->source[$element];
			}
		}
		$eleNotValidate = array_diff_key($this->source, $this->errors);
		$this->result	= array_merge($this->result, $eleNotValidate);
	}

	// Validate Integer
	private function validateInt($element, $min = 0, $max = 0)
	{
		if (!filter_var($this->source[$element], FILTER_VALIDATE_INT, array("options" => array("min_range" => $min, "max_range" => $max)))) {
			$this->setError($element, 'is an invalid number');
		}
	}

	// Validate String
	private function validateString($element, $min = 0, $max = 0)
	{
		$length = strlen($this->source[$element]);
		if ($length < $min) {
			$this->setError($element, 'is too short');
		} elseif ($length > $max) {
			$this->setError($element, 'is too long');
		} elseif (!is_string($this->source[$element])) {
			$this->setError($element, 'is an invalid string');
		}
	}

	// Validate URL
	private function validateURL($element)
	{
		if (!filter_var($this->source[$element], FILTER_VALIDATE_URL)) {
			$this->setError($element, 'is an invalid url');
		}
	}

	// Validate Email
	private function validateEmail($element)
	{
		if (!filter_var($this->source[$element], FILTER_VALIDATE_EMAIL)) {
			$this->setError($element, 'is an invalid email');
		}
	}

	public function showErrors()
	{
		$xhtml = '<div class="alert alert-danger alert-dismissible">';
		$xhtml .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
		$xhtml .= '<h5><i class="icon fas fa-exclamation-triangle"></i> Lỗi!</h5>';
		if (!empty($this->errors)) {
			$xhtml .= '<ul class="list-unstyled mb-0">';
			foreach ($this->errors as $key => $value) {
				$xhtml .= '<li class="text-white">' . $value . ' </li>';
			}
			$xhtml .=  '</ul>';
		}
		$xhtml .= '</div>';
		return $xhtml;
	}

	public function showErrorsFrontend()
	{
		$xhtml = '<div class="alert alert-danger" role="alert">';
		$xhtml .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
		$xhtml .= '<h5><i class="icon fa fa-exclamation-triangle"></i> Lỗi!</h5>';
		if (!empty($this->errors)) {
			$xhtml .= '<ul class="list-unstyled mb-0">';
			foreach ($this->errors as $value) {
				$xhtml .= '<li class="input-group">' . $value . ' </li>';
			}
			$xhtml .=  '</ul>';
		}
		$xhtml .= '</div>';
		return $xhtml;
	}

	public function showErrorLogin()
	{
		$xhtml = '<div class="alert alert-danger error">';
		$xhtml .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
		$xhtml .= 'Thông tin đăng nhập không chính xác!</div>';
		return $xhtml;
	}

	public function isValid()
	{
		if (count($this->errors) > 0) return false;
		return true;
	}

	// // Validate Status 
	// private function validateStatus($element){
	// 	if($this->source[$element] < 0 || $this->source[$element] > 1){
	// 		$this->setError($element, 'Select status');
	// 	}
	// }

	// Validate Status EDIT
	private function validateStatus($element)
	{
		if ($this->source[$element] != 'active' && $this->source[$element] != 'inactive') {
			$this->setError($element, 'Select status');
		}
	}

	// Validate groupACP 
	private function validateGroupACP($element)
	{
		if ($this->source[$element] == '- Select Group ACP -') {
			$this->setError($element, 'Select groupACP');
		}
	}

	private function validateSelectBox($element)
	{
		if ($this->source[$element] == 'default') {
			$this->setError($element, 'Invalid value');
		}
	}

	// Validate GroupID
	private function validateGroupID($element)
	{
		if ($this->source[$element] == 0) {
			$this->setError($element, 'Select group');
		}
	}

	// Validate Password
	// private function validatePassword($element, $options)
	// {
	// 	if ($options['action'] == 'add' || ($options['action'] == 'edit' && $this->source[$element])) {
	// 		$pattern = '#^(?=.*\d)(?=.*[A-Z])(?=.*\W).{8,8}$#';	// Php4567!
	// 		if (!preg_match($pattern, $this->source[$element])) {
	// 			$this->setError($element, 'is an invalid password');
	// 		};
	// 	}
	// }

	// Validate Password
	private function validatePassword($element, $options)
	{
		if ($options['action'] == 'add' || ($options['action'] == 'edit' && $this->source[$element])) {
			$length = strlen($this->source[$element]);
			if ($length < 6 || $length > 50) {
				$this->setError($element, 'password không hợp lệ');
			}
		}
	}

	// Validate Password
	private function validateConfirm($element, $options)
	{
		if ($this->source[$element] != $options['confirm-element']) {
			$this->setError($element, 'mật khẩu không khớp');
		}
	}

	// Validate Date
	private function validateDate($element, $start, $end)
	{
		// Start
		$arrDateStart 	= date_parse_from_format('d/m/Y', $start);
		$tsStart		= mktime(0, 0, 0, $arrDateStart['month'], $arrDateStart['day'], $arrDateStart['year']);

		// End
		$arrDateEnd 	= date_parse_from_format('d/m/Y', $end);
		$tsEnd			= mktime(0, 0, 0, $arrDateEnd['month'], $arrDateEnd['day'], $arrDateEnd['year']);

		// Current
		$arrDateCurrent	= date_parse_from_format('d/m/Y', $this->source[$element]);
		$tsCurrent		= mktime(0, 0, 0, $arrDateCurrent['month'], $arrDateCurrent['day'], $arrDateCurrent['year']);

		if ($tsCurrent < $tsStart || $tsCurrent > $tsEnd) {
			$this->setError($element, 'is an invalid date');
		}
	}

	// Validate Exist record
	private function validateExistRecord($element, $options)
	{
		$database = $options['database'];

		$query	  = $options['query'];
		if ($database->isExist($query) == false) {
			$this->setError($element, 'record is not exist');
		}
	}

	// Validate Not Exist record
	private function validateNotExistRecord($element, $options)
	{
		$database = $options['database'];

		$query	  = $options['query'];	// SELECT id FROM user where username = 'admin'
		if ($database->isExist($query) == true) {
			$this->setError($element, 'giá trị này đã tồn tại');
		}
	}

	// Validate File
	private function validateFile($element, $options)
	{

		if (!filter_var($this->source[$element]['size'], FILTER_VALIDATE_INT, array("options" => array("min_range" => $options['min'], "max_range" => $options['max'])))) {
			$this->setError($element, 'kích thước không phù hợp');
		}

		$ext = pathinfo($this->source[$element]['name'], PATHINFO_EXTENSION);
		if (in_array($ext, $options['extension']) == false) {
			$this->setError($element, 'phần mở rộng không phù hợp');
		}
	}
}
