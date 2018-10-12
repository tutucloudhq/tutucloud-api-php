<?php
/**
 * 
 * 涂图API异常类
 * @author Tusdk
 *
 */
class ApiException extends Exception {
	public function errorMessage()
	{
		return $this->getMessage();
	}
}
