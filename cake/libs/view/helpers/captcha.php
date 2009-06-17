<?php
  /******************************************************************

   Projectname:   CAPTCHA Helper class
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
   This helper is used to generate CAPTCHAs.

  ******************************************************************/
class CaptchaHelper extends AppHelper {

	var $helpers = array('html', 'form');

	function input($controller = null) {

		if(is_null($controller)) {
			$controller = $this->params['controller'];
		}

		$output = array();
		$output[] = $this->html->image('/' . $controller . '/captcha/image.png', array('id' => 'captcha_image'));
		$output[] = $this->form->input('Captcha/captcha', array('div' => 'captcha_input', 'label' => __('case_sensitive', true)));

		return implode("\r\n", $output);

	}

}
?>