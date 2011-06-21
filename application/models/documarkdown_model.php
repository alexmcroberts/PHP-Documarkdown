<?php
/*
	#PHP Documarkdown Model {#documarkdownmodel}
	*this class handles reading files and directories. it loads the included markdown file, which parses the contents of files*
	**alex mcroberts 2011**
 */	
class Documarkdown_model extends CI_Model
{
	/*
		##constructor
		*default constructor*
		###variables
		* none
		###returns
		* none
		**alex mcroberts 2011**
	 */	
	public function __construct()
	{
		$this->load->helper('markdown_extra');
		parent::__construct();
	}

	/*
		##read_file
		*this method opens and reads a file and returns the contents. Pass in the $parsed as false to receive raw markdown comments*
		###variables
		* bool $parsed (optional)
		###returns
		* string contents
		* false if no contents
		**alex mcroberts 2011**
	 */	
	public function read_file( $path_to_filename, $parsed = true )
	{
		$doc_body = '';
		$contents = file_get_contents($path_to_filename, true);

		//regex here for comments
		$pattern = "/\/\*[\s\S]*?\*\//"; 
		$regex = preg_match_all($pattern, $contents, $comments);
		if($regex) {
			$doc_body = '';
			foreach($comments[0] as $c) {
				if($parsed) {
					//strip comment start & finish
					$c = trim($c, "/");
					$c = trim($c, "*");
					
					$c = preg_replace("/_/", "&#95;", $c); //convert _ to &#95;
					
					$c_a = explode("\n", $c); //explode new lines to array elements
					$block = '';
					foreach($c_a as $c_b) {
						$c_b = trim($c_b);
						$block .= markdown($c_b); //convert to markdown
					}
					
					$doc_body .= "<div>" . $block . "</div><hr />"; //put in a tidy wee div
				}
				else
					$doc_body .= $c; //output the raw stuff
			}
		}

		return $doc_body;
	}

	/*
		##read_directory
		*this method opens a directory and reads all files and returns the contents. Each file is returned as a separate string element in an array. Pass in the $parsed as false to receive raw markdown comments*
		###variables
		* bool $directory_name
		* bool $recursive (optional)
		* bool $parsed (optional)
		###returns
		* array contents
		* false if no contents
		**alex mcroberts 2011**
	 */	
	public function read_directory( $directory )
	{
		$filecount = $this->count_files_in_directory($directory); 
		$obj = new stdClass();
		if( $filecount && is_dir($directory) ) {
			if($dh = opendir($directory) ) {
				while( ($file = readdir($dh)) !== false ) {
					if ( !in_array($file, array('.','..','documarkdown_model.php','documarkdown.php','index.html')) ) {
						$path_parts = pathinfo($file);
						$filelist[] = $path_parts['filename'];
						$documentation[] = $this->read_file($directory.$file);
					}
				}
				closedir($dh);
				$obj->file_count = $filecount;
				$obj->file_list = $filelist;
				$obj->documentation = $documentation;
			}
		}

		return $obj;
	}

	/*
		##read_controllers
		*this method serves as a wrapper for the read_directory method and returns controllers only*
		###variables
		* none
		###returns
		* array contents
		* false if no contents
		**alex mcroberts 2011**
	 */	
	public function read_controllers() {
		return $this->read_directory('application/controllers/');
	}

	/*
		##read_models
		*this method serves as a wrapper for the read_directory method and returns models only*
		###variables
		* none
		###returns
		* array contents
		* false if no contents
		**alex mcroberts 2011**
	 */	
	public function read_models() {
		return $this->read_directory('application/models/');
	}
	
	/*
		##count_files_in_directory
		*this method counts the total number of files in a given directory*
		###variables
		* bool $directory_name
		###returns
		* int number of files
		* false if no name given
		**alex mcroberts 2011**
	 */	
	public function count_files_in_directory( $directory_name = null )
	{
		if($directory_name === null)
			return false;

		if (glob("" . $directory_name . "*.php") != false)
			$filecount = count(glob("" . $directory_name . "*.php"));
		else
			$filecount = 0;	

		return $filecount;
	}
	
	/*
		##save
		*this method saves the temporary file as permanent documentation. pass overwrite to completely overwrite the old documentation*
		###variables
		* bool $overwrite (optional)
		###returns
		* true on success
		* false on failure
		**alex mcroberts 2011**
	 */	
	public function save( $overwrite = false )
	{
		return true;
	}
}