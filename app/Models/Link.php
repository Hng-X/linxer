<?php
namespace App\Models;

Class Link extends BaseModel {

	protected $valid;

	protected $status_code;

	protected $table = 'links';

    public function __construct($attributes)  {
    	if (is_array(attributes)){
	        parent::__construct($attributes); // Eloquent
        } else {
        	$parsed = $this->parser($attributes)
        	if (!this->verify_url($parsed['url'])){

        	} else {

        	}
        }
        // Your construct code.
    }

    public function validate(){
    	$this->verify_url($this->url);
    	return $this->status_code;
    }

	public function verify_url($url, $followredirects = true){
        // first do some quick sanity checks:
        if(!$url || !is_string($url)){
            $this->valid = false;
            return $this->valid;
        }

        $ch = @curl_init($url);
        if($ch === false){
            return false;
        }
        @curl_setopt($ch, CURLOPT_HEADER         ,true);    // we want headers
        @curl_setopt($ch, CURLOPT_NOBODY         ,true);    // dont need body
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER ,true);    // catch output (do NOT print!)
        if($followredirects){
            @curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,true);
            @curl_setopt($ch, CURLOPT_MAXREDIRS      ,10);  // fairly random number, but could prevent unwanted endless redirects with followlocation=true
        }else{
            @curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,false);
        }
        @curl_exec($ch);
        if(@curl_errno($ch)){   // should be 0
            @curl_close($ch);
            return false;
        }
        $code = @curl_getinfo($ch, CURLINFO_HTTP_CODE); // note: php.net documentation shows this returns a string, but really it returns an int
        @curl_close($ch);

        $this->status_code = $code;


        if (in_array($this->status_code, [403, 404, 500])) {
        	$this->valid = false;
        	return $this->valid;
        }

    	$this->valid = true;
    	return $this->valid
    }

    public function parser(){
    	return [];
    }

    public function tags()
    {
          return $this->belongsToMany(Tag::class);
    }

}
