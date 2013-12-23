<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package CodeIgniter
 * @author  ExpressionEngine Dev Team
 * @copyright  Copyright (c) 2006, EllisLab, Inc.
 * @license http://codeigniter.com/user_guide/license.html
 * @link http://codeigniter.com
 * @since   Version 1.0
 * @filesource
 */

// --------------------------------------------------------------------

/**
 * CodeIgniter Fonts Class
 *
 * This class add CSS @font-face style in order to integrate custom fonts in your application
 * adding classes .fontname automatically
 *
 * Use tools like http://www.fontsquirrel.com/tools/webfont-generator to get your converted fonts
 *
 * @package		CodeIgniter
 * @author		César González
 * @subpackage	Libraries
 * @category	Libraries
 * @link		
 * @copyright  Copyright (c) 2013, César González.
 * @version 0.0.5
 * 
 */
class CI_Fonts {
	var $CI;
	var $fonts;
	var $debug;
	var $folder;
	var $minify;
	function CI_Fonts()
	{
		$this->CI =& get_instance();
		
		if(file_exists(APPPATH.'config/fonts'.EXT)){
			include(APPPATH.'config/fonts'.EXT);
			$this->debug = $fonts['debug'];
			$this->folder = $fonts['folder'];
			$this->minify = $fonts['minify'];
		} else {
			show_error('config/fonts'.EXT.' doesn\'t exists :(');
		}
		if (isset($fonts))
		{
			foreach($fonts as $fontname=>$font){
				if(is_array($font)){
					$this->fonts[$fontname] = $font;
				}
			}
			if($this->debug){
				$this->check_folder();
				$this->check_fonts();
			}
		} else {
			show_error('No fonts defined in config/fonts'.EXT.' ._.');
		}
	}
	
	function draw($add_html_tags = TRUE){
		$o = '';
		if($add_html_tags) $o.="<style>\n";
		foreach($this->fonts as $fontname=>$font){
			$o.="@font-face {\n";
			$o.="	font-family: '".$fontname."';\n";
			$otemp = array();
			$src_temp = array();
			foreach($font as $param=>$value){
				if(strstr($param,'font-')){
					$otemp[] = "	".$param.": ".$value.";";
				} else if($param=='eot'){
					$otemp[] = "	src: url('".site_url($this->folder."/".$value)."');";
				} else {
					$format = false;
					switch($param){
						case 'eotie':
							$format = 'embedded-opentype';
						break;
						case 'woff':
							$format = 'woff';
						break;
						case 'ttf':
							$format = 'truetype';
						break;
						case 'svg':
							$format = 'svg';
						break;
					}
					if($format){
						$src_temp[] = "		url('".site_url($this->folder."/".$value)."') format('".$format."')";
					}
				}
			}
			if(count($src_temp)>0){
				$otemp[] = "	src: ".implode("\n",$src_temp);
			}
			$o.=implode("\n",$otemp)."\n";
			$o.="}\n";
			$o.=".".$fontname."{\n";
			$o.="	font-family:'".$fontname."'\n";
			$o.="}\n";
		}
		// add custom class
		
		if($add_html_tags) $o.="</style>\n";
		if($this->minify) $o = str_replace(array("	","\n"),array(""," "),$o);
		return $o;
	}
	
	function check_folder(){
		if(!is_dir($this->folder)){
			show_error('O_o WTF?! '.$this->folder.' doesn\'t exists!');
		}
		
	}
	
	function check_fonts(){
		foreach($this->fonts as $fontname =>$font){
			foreach($font as $param=>$value){
				if(!strstr($param,'font-')){
					if(!file_exists($this->folder.'/'.$this->clean_params($value))){
						show_error('The font file you\'ve defined in config as '.$param.' for \''.$fontname.'\' font doesn\'t appear to exist in '.$this->folder.'/'.$value.' - EPIC FAIL');
					}
				}
			}
		}
	}
	function clean_params($filename){
		while(strstr($filename,'#') || strstr($filename,'?')){
			$filename = substr($filename,0,strpos($filename,'#'));
			$filename = substr($filename,0,strpos($filename,'?'));
		}
		return $filename;
	}
}