<?php 

namespace Canvas;

class CanvasModel
{
	/**
	 * @var CanvasClient
	 */
	protected static $_client;
	
	/**
	 * Get a Canvas API client
	 * 
	 * @return CanvasClient
	 */
	protected static function _getClient()
	{
		if(self::$_client === null)
		{
			self::$_client = new CanvasClient();
		}
		return self::$_client;
	}
	
	public static function getClient()
	{
		return self::_getClient();
	}
	
	/**
	 * Parse pagination headers, return array with links to other pages
	 * @param array $response
	 */
	protected function _parsePagination($response)
	{
		$headers = $response->getHeaders();
		$links = explode(',', $headers['Link']);
		$parsedLinks = array();
		foreach($links as $link)
		{
			//</api/v1/accounts/1/courses?page=2&per_page=50>; rel="next"
			preg_match('~^<https?://(.)*/api/v1/([^>]+)[^"]+"([^"]+)~', $link, $matches);
			$rel = $matches[3];
			$url = $matches[2];
			$parsedLinks[$rel] = $url;
		}
		return $parsedLinks;
	}
}
