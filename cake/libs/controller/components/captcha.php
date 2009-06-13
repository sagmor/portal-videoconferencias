<?php
  /******************************************************************

   Projectname:   CAPTCHA Component class
   Version:       1.0
   Author:        Michael James (mikeyjsa@gmail.com)
   Website:       http://www.getkeywords.co.za
   Last modified: 11. June 2008

   * GNU General Public License (Version 2, June 1991)
   *
   * This program is free software; you can redistribute
   * it and/or modify it under the terms of the GNU
   * General Public License as published by the Free
   * Software Foundation; either version 2 of the License,
   * or (at your option) any later version.
   *
   * This program is distributed in the hope that it will
   * be useful, but WITHOUT ANY WARRANTY; without even the
   * implied warranty of MERCHANTABILITY or FITNESS FOR A
   * PARTICULAR PURPOSE. See the GNU General Public License
   * for more details.

   Description:
   This component is used to generate CAPTCHAs.

  ******************************************************************/

uses('security');

class CaptchaComponent extends Object {

	var $length = 6;

	var $fontpath;

	var $fonts;

	var $components = array('Session');

	var $controller = array();

	var $sessionKey = 'Captcha';

	var $case = false;

	var $filters = array();

	var $imgFormat = "png";

	var $bgColor = array(255, 255, 255);

	var $stringColor = array(0, 0, 0);


	function startup(&$controller) {

		if (strtolower($controller->name) == 'app' || (strtolower($controller->name) == 'tests' && Configure::read() > 0)) {
			return;
		}

		$this->controller = $controller;

		if (!method_exists($controller, 'captcha')) {

			trigger_error(__('Could not find function captcha. Please create a captcha function in Controller::$controller.', true), E_USER_WARNING);
			die();

		}

		$this->fontpath = $this->__getFontPath();

		if(is_null($this->__getFonts())) {

			trigger_error(__('Could not find any fonts in webroot/files/fonts/ please confirm you have created directory and have uploaded only true type fonts!', true), E_USER_WARNING);
			die();

		}

	}


	// Add this to controller action which you want to use captcha
	// for and the model that has the capchta variable in.
	function protect($model = 'Captcha') {
		if(isset($this->controller->data[$model]['Captcha/captcha']) && !empty($this->controller->data[$model]['Captcha/captcha'])) {
//			debug('Entre al if');
//			debug($this->Session->read($this->sessionKey));
//			debug($this->controller->data[$model]['Captcha/captcha']);
			if($this->__check($this->controller->data[$model]['Captcha/captcha'])) {
//				debug('esta bien el captcha');
				$this->Session->del($this->sessionKey);
				unset($this->controller->data[$model]['Captcha/captcha']);

				return true;

			} else {
//				debug('fallo captcha');
				$this->__generate();
				$this->Session->setFlash(__('Incorrect image verification please retry!',true));
				unset($this->controller->data[$model]['Captcha/captcha']);

				return false;

			}

		} else {

			$this->__generate();
			return false;

		}
	}

	// Create a function called captcha in a controller and reference
	// the captcha image src in the view to it.
	function show() {

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: no-store, no-cache");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");

		$this->fontpath = $this->__getFontPath();

		$this->fonts    = $this->__getFonts();

		$this->__makeCaptcha();

		$this->controller->autoRender=false;

	} //captcha

	function __check($string)	{

  	return ($string === $this->Session->read($this->sessionKey));

  }

	function __generate($protect = false) {

		if(!$protect) {

			$protect = !$this->Session->check($this->sessionKey);

		}

		if ($protect) {

			$this->Session->write($this->sessionKey, $this->__stringGen());

		}

	}

	function __getFontPath() {

		return WWW_ROOT . 'files' . DS . 'fonts' . DS;

	}

	function __getFonts() {

		$fonts = array();

		if ($handle = @opendir($this->fontpath)) {

			while (($file = readdir($handle)) !== FALSE) {

				$extension = strtolower(substr($file, strlen($file) - 3, 3));

				if ($extension == 'ttf') {

					$fonts[] = $file;

				}

			}

			closedir($handle);

			} else {

			return null;

		}

		if (count($fonts) == 0) {

			return null;

		} else {

			return $fonts;

		}

	} //getFonts

	function __getRandFont() {

		return $this->fontpath . $this->fonts[mt_rand(0, count($this->fonts) - 1)];

	} //getRandFont


	function __stringGen() {

		$results = null;
		$uppercase  = range('A', 'Z');
		$numeric    = range(0, 9);

		$CharPool   = array_merge($uppercase, $numeric);

		if($this->case) {

			$lowercase  = range('a', 'z');
			$CharPool   = array_merge($CharPool, $lowercase);

		}

		$PoolLength = count($CharPool) - 1;

		for ($i = 0; $i < $this->length; $i++) {

		$results .= $CharPool[mt_rand(0, $PoolLength)];

		}

		return	$results;

	} //StringGen

	function __makeCaptcha() {

		$this->__generate(true);
		$captchaString = $this->Session->read($this->sessionKey);

		$imagelength = $this->length * 25 + 16;
		$imageheight = 75;

		$image       = imagecreate($imagelength, $imageheight);

		$bgcolor     = imagecolorallocate($image, $this->bgColor[0], $this->bgColor[1], $this->bgColor[2]);

		$stringcolor = imagecolorallocate($image, $this->stringColor[0], $this->stringColor[1], $this->stringColor[2]);

		$this->__signs($image, $this->__getRandFont());

		for ($i = 0; $i < strlen($captchaString); $i++) {

			imagettftext($image, 25, mt_rand(-15, 15), $i * 25 + 10,
			mt_rand(30, 70),
			$stringcolor,
			$this->__getRandFont(),
			$captchaString{$i});

		}

		if(isset($this->filters['noise']) && is_numeric($this->filters['noise'])) {

			$this->__noise($image, $this->filters['noise']);

		}

		if(isset($this->filters['blur']) && is_numeric($this->filters['blur'])) {

			$this->__blur($image, $this->filters['blur']);

		}

 		switch($this->imgFormat) {

			case "png" 	: header('Content-type: image/png');
										imagepng($image);
			break;

			case "jpg" 	: header('Content-type: image/jpg');
										imagejpeg($image);
			break;

			case "jpeg" : header('Content-type: image/jpg');
										imagejpeg($image);
			break;

			case "gif" 	: header('Content-type: image/gif');
										imagegif($image);
			break;

			default 		: header('Content-type: image/png');
										imagejpeg($image);
			break;

		}

		imagedestroy($image);

	} //MakeCaptcha


/*-----------------------------
* FILTER FOR CAPTCHA
*
*
*------------------------------*/

	function __noise(&$image, $runs = 30) {

	$w = imagesx($image);
	$h = imagesy($image);

		for ($n = 0; $n < $runs; $n++) {

			for ($i = 1; $i <= $h; $i++) {

			$randcolor = imagecolorallocate($image,
													mt_rand(0, 255),
													mt_rand(0, 255),
													mt_rand(0, 255));

			imagesetpixel($image,
				mt_rand(1, $w),
				mt_rand(1, $h),
				$randcolor);

			}

		}

	} //noise

	function __signs(&$image, $font, $cells = 3) {

		$w = imagesx($image);
		$h = imagesy($image);

		for ($i = 0; $i < $cells; $i++) {

			$centerX     = mt_rand(1, $w);
			$centerY     = mt_rand(1, $h);
			$amount      = mt_rand(1, 15);
			$stringcolor = imagecolorallocate($image, 175, 175, 175);

			for ($n = 0; $n < $amount; $n++) {

				$signs = range('A', 'Z');
				$sign  = $signs[mt_rand(0, count($signs) - 1)];

				imagettftext($image, 25,
				 mt_rand(-15, 15),
				 $centerX + mt_rand(-50, 50),
				 $centerY + mt_rand(-50, 50),
				 $stringcolor, $font, $sign);

			}

		}

	} //signs

	function __blur(&$image, $radius = 3) {

		$radius  = round(max(0, min($radius, 50)) * 2);

		$w       = imagesx($image);
		$h       = imagesy($image);

		$imgBlur = imagecreate($w, $h);

		for ($i = 0; $i < $radius; $i++) {

			imagecopy     ($imgBlur, $image,   0, 0, 1, 1, $w - 1, $h - 1);
			imagecopymerge($imgBlur, $image,   1, 1, 0, 0, $w,     $h,     50.0000);
			imagecopymerge($imgBlur, $image,   0, 1, 1, 0, $w - 1, $h,     33.3333);
			imagecopymerge($imgBlur, $image,   1, 0, 0, 1, $w,     $h - 1, 25.0000);
			imagecopymerge($imgBlur, $image,   0, 0, 1, 0, $w - 1, $h,     33.3333);
			imagecopymerge($imgBlur, $image,   1, 0, 0, 0, $w,     $h,     25.0000);
			imagecopymerge($imgBlur, $image,   0, 0, 0, 1, $w,     $h - 1, 20.0000);
			imagecopymerge($imgBlur, $image,   0, 1, 0, 0, $w,     $h,     16.6667);
			imagecopymerge($imgBlur, $image,   0, 0, 0, 0, $w,     $h,     50.0000);
			imagecopy     ($image  , $imgBlur, 0, 0, 0, 0, $w,     $h);

		}

		imagedestroy($imgBlur);

	} //blur

} //class: captcha

?>