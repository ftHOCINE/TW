<?php
/**
class de verification et de recuperation des info de connection et de creation d'evenements
*/
abstract class AbstractArgumentSet {
	private $inputMethod;  			// INPUT_GET, INPUT_POST, ...

	private $errorMessages = [];
  private $arguments = [];   // assoc. array : key : argument name, value : $status
	                           // status is assoc array with keys 'value', 'error', 'rawValue'

	private function addArgument($name, $status){
		if (isset($this->arguments[$name]))
			throw new Exception("argument $name allready defined");
		$this->arguments[$name] = $status;
		if ($status['error']){
			$this->errorMessages[] = "$name : {$status['error']}";
		}
	}
	private function setArgumentValue($name, $value, $rawValue){
 	  if (is_null($value))
 	 		throw new Exception('value can\'t be null');
 	  $this->addArgument($name,['value'=> $value, 'error'=> NULL, 'rawValue'=> $rawValue]);
  }
	private function rejectArgumentValue($name, $rawValue){
		$this->addArgument($name,['value'=>NULL, 'error'=>'rejected', 'rawValue'=> $rawValue]);
	}
	private function missingArgument($name){
		$this->addArgument($name,['value'=>NULL, 'error'=>'missing', 'rawValue'=> NULL]);
	}
	private function addErrors($errorMessages){
		if ($errorMessages && !is_array($errorMessages))
			$errorMessages = [$errorMessages];
		if ($errorMessages && count($errorMessages)>0)
		  array_push($this->errorMessages, ...$errorMessages);
	}

	/**
   *	Validity  of this argument set or validity of some arguments
 	* @param null|string|string[] $scope   scope
 	* @return bool
 	* if $scope is NULL : validity of this entire Argument Set <br/>
 	*	if $scope is a string : validity of argument named $scope.<br/>
 	* if $scope is a string array : validity of every argument whos name is in $scope
 	*/
 	public function isValid($scope = NULL){
 		if (is_null($scope)) // global validity
 			return count($this->errorMessages)==0;

 		if (! is_array($scope))
 			$scope = [$scope];   // scope : list of names
 		foreach ($scope as $name){
 			if ( !isset($this->arguments[$name]) || $this->arguments[$name]['error'] )
 				return FALSE;
 		}
 		return TRUE;
 	}
	/**
  	*	Get argument's elected value.
 	*	@param string $name argument name
 	*	@return mixed argument value. returns null for missing or rejected raw value
 	* @throws Exception when $name is not a defined argument
  	*/
  public final function getValue($name){
 	 if (! isset($this->arguments[$name]))
	 		throw new Exception('Unknown argument');
	 else if ($this->arguments[$name]['error'])
	    return null;
	 else
 		  return $this->arguments[$name]['value'];
  }

  /**
  	*	Argument's elected value.
 	* Allows access to argument values using pseudo property notation :<br/>
 	*  $paramSet->arg1  is an equivalent to $paramSet->getValue('arg1')
 	*	@param string $name argument name
 	*	@return mixed argument value. returns null for missing or rejected raw value
  	*/
  public final function __get($name){
 	 try {
 		 return $this->getValue($name);
 	 } catch (Exception $e){
 			 if (isset($this->{$name})){
 				 $level = E_USER_ERROR;
 				 $message = "Cannot access private or protected property ";
 			 } else {
 				 $level = E_USER_NOTICE;
 				 $message = "Undefined property ";
 			 }
 			 $caller = debug_backtrace()[0];
 			 $message .= "<b>{$caller['class']}::\${$name}</b> in <b>{$caller['file']}</b> on line <b>{$caller['line']}</b><br />\n";
 			 trigger_error($message,$level);
 	 }
 }

 /**
 * Elected values
 * @param bool $fullMode
 * @return array arguments values. Only valid arguments are returned, unless $fullMode is true
 */
	public final function getValues($fullMode = false){
		$res =[];
		foreach ($this->arguments as $name => $status) {
			if ($fullMode || !$status['error'])
					 $res[$name]=$status['value'];
		}
		return $res;
 }

 /**
 * Arguments status
 * @return array arguments status : list of associative arrays (keys : 'value', 'error', 'rawValue')
 */
	public final function getStatus(){
		return $this->arguments;
  }

 	/**
 	 *	Gets erroneous arguments list
 	 *	@return  array  associative array (map) of errors.
 	 *	 key : arg name (string), value : "rejected" or "missing"
 	 */
 	public final function getArgErrors(){
		$res =[];
		foreach ($this->arguments as $name => $status) {
			if ($status['error'])
					 $res[$name]=$status['error'];
		}
		return $res;
 	}

	/**
	 * Error messages list
	 * @return string[]
	 */
	 public final function getErrorMessages(){
		 return $this->errorMessages;
	 }

 private function prepareFilterOptions($filter, $options, $flags){
	 // add default options
	 $options = array_merge(['dimension'=>'scalar'],$options);

	 // ignore given dimension flags and replace by dimension option
	 if ($options['dimension'] =='array')
		 $result['flags'] = $flags & ~FILTER_REQUIRE_SCALAR & ~FILTER_FORCE_ARRAY | FILTER_REQUIRE_ARRAY;
	 else  // scalar
		 $result['flags'] = $flags & ~FILTER_REQUIRE_ARRAY & ~FILTER_FORCE_ARRAY | FILTER_REQUIRE_SCALAR;

	 // set filter options
	 if ($filter === FILTER_CALLBACK){  // for this filter, options must contain only callback
		 if (!isset($options['callback']))
			 throw new Exception("FILTER_CALLBACK needs a callback");
		 $result['options'] = $options['callback'];
	 }
	 else { // don't use buit-in default mechanism
		 $result['options'] = array_diff_key($options,['default'=>1]);
	 }
	 return $result;
 }

 private function filterValue($v, $filter, $filterOptions){
	 $res = filter_var($v, $filter, $filterOptions);
	 if ($filterOptions['flags'] & FILTER_REQUIRE_ARRAY){
		 return (is_array($res) && !in_array(false, $res ,true)) ?	$res : false;
	 } else {
		 return (!is_array($res) && $res !== false) ?	$res : false;
	 }

 }

/**
 * Defines a new argument, using PHP filter.
 * @param string $name Argument name
 * @param int $filter Filter {@see http://php.net/manual/fr/filter.filters.php}
 * @param string[] $options Associative array : optionName=>optionValue.
 * @param int $flags
 *
 * @return mixed|null
 */
 protected final function registerFiltered($name, $filter, $options=[], $flags=0){
	 $filterOptions = $this->prepareFilterOptions($filter, $options, $flags);
	 $default = @$options['default'];
	 if ($default !== NULL){ 	// verify default value	validity
		 $default = $this->filterValue($default, $filter, $filterOptions);
		 if ($default === FALSE)
			 throw new Exception("Incorrect default value : " . json_encode($options['default']));
	 }
	 $rawValue = filter_input($this->inputMethod, $name, FILTER_UNSAFE_RAW, $filterOptions);
	 $v = is_null($rawValue) ? $default : $rawValue; 	 // apply default value

	 $case=@$options['case'];
	 if ($case == 'to_upper')
	 		$v = mb_strtoupper($v);
	 else if ($case == 'to_lower')
	 		$v = mb_strtolower($v);

	 if (is_null($v)){
		 $this->missingArgument($name);
	 }
	 else {
		 $v = $this->filterValue($v, $filter, $filterOptions);
		 if ($v === FALSE)
		 	$this->rejectArgumentValue($name, $rawValue);
		 else
		 	$this->setArgumentValue($name, $v, $rawValue);
	 }
	 return $v;
 }



	/**
	 * Defines a new argument. Argument value can be any string and will be sanitized.
	 * for scalar argument, default value is '', unless user specifies an other default value in $options['default'].
	 * @param string $name Argument name
	 * @param string[] $options Options : 'default', 'dimension'.
	 * @return string|null Elected value (sanitized), if accepted; false if value is rejected; null if value is missing and there is no default value
	 */
	protected final function defineString($name, $options=[]){  // defaults to ''
		if (! isset($options['dimension']) || $options['dimension']=='scalar')
				$options = array_merge(['default'=>''],$options);
		return $this->registerFiltered($name,FILTER_SANITIZE_STRING,$options);
	}

	/**
	 * Defines a new argument. Argument value can be any non empty string and will be sanitized.
	 * @param string $name Argument name
	 * @param string[] $options Options : 'default', 'dimension'.
	 * @return string|null Elected value (sanitized) if accepted; false if value is rejected; null if argument is missing and there is no default value
	 */
	protected final function defineNonEmptyString($name, $options=[]){
		$options['callback']=
					function($v) {$v=filter_var($v,FILTER_SANITIZE_STRING); return ($v!='')?$v:false;} ;
		return $this->registerFiltered($name, FILTER_CALLBACK, $options);
	}
	/**
	 * Defines a new argument. Accepted values are listed in <var>$values</var>
	 * @param string $name Argument name
	 * @param string[] $values Allowed values
	 * @param string[] $options Options : 'default', 'dimension'.
	 * @return string|null Elected value if accepted; false if value is rejected; null if argument is missing and there is no default value
	 */
	protected final function defineEnum($name, array $values, $options=[]){
		$options['callback']=
							function($v) use ($values){return in_array($v,$values)?$v:false;} ;
		return $this->registerFiltered($name, FILTER_CALLBACK, $options);
	}

	/**
	 * Define a new argument. Accepted values are specified by a regular expression.
	 * @param string $name Argument name
	 * @param string $regExp Regular expression
	 * @param string[] $options Options : 'default', 'dimension'.
	 * @return string|null Elected value if accepted; false if value is rejected; null if argument is missing and there is no default value
	 */
	protected final function defineRegExp($name, $regExp, $options=[]){
		$options['regexp']= $regExp;
		return $this->registerFiltered($name, FILTER_VALIDATE_REGEXP, $options);
	}

	/**
	 * Define a new argument. Argument value must be an integer
	 * @param string $name Argument name
	 * @param string[] $options Options : 'default', 'dimension', 'min_range' (min value), 'max_range' (max value)
	 * @return integer|null Elected value if accepted; false if value is rejected; null if argument is missing and there is no default value
	 */
	protected final function defineInt($name, $options=[]){
		return $this->registerFiltered( $name, FILTER_VALIDATE_INT, $options );
	}

	/**
	 * Define a new argument. Argument value must be a number
	 * @param string $name Argument name
	 * @param string[] $options Options : 'default', 'dimension', 'decimal' (decimal separator)
	 * @return float|null Elected value if accepted; false if value is rejected; null if argument is missing and there is no default value
	 */
	protected final function defineFloat($name, $options=[]){
		return $this->registerFiltered( $name, FILTER_VALIDATE_FLOAT, $options );
	}


	/**
	* Constructor
	*	@param string|int $inputMethod : method used, given as string "get", "post", "auto" or as constant : INPUT_GET, INPUT_POST
	*/
	public final function __construct($inputMethod = "auto"){
		if (is_string($inputMethod)){ // translate string to constant value
			$method = strtoupper($inputMethod);
			if ($method=="AUTO"){ // detect method from server infos
				$method = $_SERVER['REQUEST_METHOD'];
			}
			$method = "INPUT_".$method;
			if (!defined($method)) // constant undefined
			   throw new Exception("unknown input method : $method");
			$inputMethod = constant($method); // constant value
		}
  	$this->inputMethod = $inputMethod;

		$this->definitions();

		if ($this->isValid()){ // arguments OK
      $this->addErrors($this->checkings());
		}
	}
	/**
	 *	extended classes can implement this method in order to process additionnal checkings.
	 *
	 *	@return null|false|string|string[] error message (non empty string) or error message list.
	 *  NULL or FALSE if checking is OK
	 *
	 *  checkings() is invoked by constructor when definitions() is completed, only if every declared argument is valid.
	 *  This arguments set will be tagged as invalid if result of checkings() is a non empty string or a non empty strings array.
	 */
	protected function checkings(){
		return NULL;
	}
  /**
	*	extended classes must implement this function, in order to define arguments, using defineXXX() methods
	*	@return void
	*/
	protected abstract function definitions();


}
?>
