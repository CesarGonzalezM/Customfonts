Customfonts
===========

Custom Fonts Class for Codeigniter
----------------------------------

This library makes easier to manage webfonts.
Just add font paths in config/fonts.php and call fonts->draw()
You'll get css style with all @font-face references and a css class (.font-name) wich you can add anywhere.

Config
------
```
$fonts['debug']		= FALSE;	  		// set TRUE to go to strict mode
$fonts['folder']	= 'css/fonts';	// fonts folder
$fonts['minify']	= FALSE;		  	// set TRUE if you want minified CSS

$fonts['font-name']['eot']			= 'font-name-light-webfont.eot';
$fonts['font-name']['eotie']		= 'font-name-light-webfont.eot?#iefix';
$fonts['font-name']['woff']			= 'font-name-light-webfont.woff';
$fonts['font-name']['ttf']			= 'font-name-light-webfont.ttf';
$fonts['font-name']['svg']			= 'font-name-light-webfont.svg#bbva_web_lightregular';

$fonts['font-name']['font-weight']	= 'normal';
$fonts['font-name']['font-style']	= 'normal';
```

Usage
-----
* Load library (or add it in your autoload.php).
  ```
  $this->load->library('fonts');
  ```

* Add fonts wherever you want. If needed, there are several online tools to convert ttf to webfonts such as http://www.fontsquirrel.com/tools/webfont-generator
* Set filenames path and custom styles in config/fonts.php
* In controller, do the magic
  ```
  $style = $this->fonts->draw();
  ```
* There you go! Print it, render it, add it to your template or the **** you always do
