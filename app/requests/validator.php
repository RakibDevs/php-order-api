<?php
    
     
class Validator 
{

    /**
     * @var array $errors
     */

    public $input = array();

    public $errors = array();

    
    /**
     * @var array $patterns
     */
    public $patterns = [
        'int'           => '[0-9]+',
        'float'         => '[0-9\.,]+',
        'tel'           => '[0-9+\s()-]+',
        'text'          => '[\p{L}0-9\s-.,;:!"%&()?+\'°#\/@]+',
        'file'          => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+\.[A-Za-z0-9]{2,4}',
        'email'         => '[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+'
    ];



    public function validate($input, $rules)
    {
        $this->input = $input;

        foreach ($rules as $field => $rule) {
            
        }

    } 
    

    public function pattern($name)
    {
        
        if($name == 'array'){         
            if(!is_array($this->value)){
                $this->errors[] = 'Field format '.$this->name.' is not valid.';
            }
        
        }else{
        
            $regex = '/^('.$this->patterns[$name].')$/u';
            if($this->value != '' && !preg_match($regex, $this->value)){
                $this->errors[] = 'Field format '.$this->name.' is not valid.';
            }
            
        }
        return $this;
        
    }
    
    
    
    /**
     * Check required
     * 
     * @return this
     */
    public function required()
    {
        
        if((isset($this->file) && $this->file['error'] == 4) || ($this->value == '' || $this->value == null)){
            $this->errors[] = 'Field '.$this->name.' is required.';
        }            
        return $this;
        
    }
    
    /**
     * Min length validation
     * 
     * @param int $min
     * @return this
     */
    public function min($length){
        
        if(is_string($this->value)){
            
            if(strlen($this->value) < $length){
                $this->errors[] = 'Field value '.$this->name.' less than the minimum value';
            }
       
        }else{
            
            if($this->value < $length){
                $this->errors[] = 'Field value '.$this->name.' less than the minimum value';
            }
            
        }
        return $this;
        
    }
        
    /**
     * Max length validation
     * 
     * @param int $max
     * @return this
     */
    public function max($length){
        
        if(is_string($this->value)){
            
            if(strlen($this->value) > $length){
                $this->errors[] = 'Field value '.$this->name.' is higher than the maximum value';
            }
       
        }else{
            
            if($this->value > $length){
                $this->errors[] = 'Field value '.$this->name.' is higher than the maximum value';
            }
            
        }
        return $this;
        
    }
    
    
    /**
     * Maximum file size validation 
     *
     * @param int $size
     * @return this 
     */
    public function maxSize($size){
        
        if($this->file['error'] != 4 && $this->file['size'] > $size){
            $this->errors[] = 'The file '.$this->name.' exceeds the maximum size of '.number_format($size / 1048576, 2).' MB.';
        }
        return $this;
        
    }
    
    /**
     * File extension validation
     *
     * @param string $extension
     * @return this 
     */
    public function ext($extension){

        if($this->file['error'] != 4 && pathinfo($this->file['name'], PATHINFO_EXTENSION) != $extension && strtoupper(pathinfo($this->file['name'], PATHINFO_EXTENSION)) != $extension){
            $this->errors[] = 'The file '.$this->name.' is not a '.$extension.'.';
        }
        return $this;
        
    }
    
    
    /**
     * check is success
     * 
     * @return boolean
     */
    public function isSuccess(){
        if(empty($this->errors)) return true;
    }
    
    /**
     * return errors
     * 
     * @return array $this->errors
     */
    public function getErrors(){
        if(!$this->isSuccess()) return $this->errors;
    }
    
    
    /**
     * return validation result
     *
     * @return booelan|string
     */
    public function result(){
        
        if(!$this->isSuccess()){
           
            foreach($this->getErrors() as $error){
                echo "$error\n";
            }
            exit;
            
        }else{
            return true;
        }
    
    }
    
    /**
     * php default integer validator
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_int($value){
        return filter_var($value, FILTER_VALIDATE_INT);
    }
    
    /**
     * php default floating point number validator
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_float($value){
        return filter_var($value, FILTER_VALIDATE_FLOAT);
    }
    
    /**
     * php default email validator
     *
     * @param mixed $value
     * @return boolean
     */
    public static function is_email($value){
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }


    /**
     * php default purifier
     *
     * @param string $string
     * @return $string
     */
    public function purify($string){
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
    
}