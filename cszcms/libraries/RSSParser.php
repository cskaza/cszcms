<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * This class is written based entirely on the work found below
 * www.techbytes.co.in/blogs/2006/01/15/consuming-rss-with-php-the-simple-way/
 * All credit should be given to the original author
 * 
 * Fixed for support by CSKAZA (Founder of CSZ CMS)
 *
 * Example:

	$this->load->library('rssparser');
	$this->rssparser->set_feed_url('http://example.com/feed');
	$this->rssparser->set_cache_life(30);
	$rss = $this->rssparser->getFeed(6);  // Get six items from the feed

	// Using a callback function to parse addictional XML fields

	$this->load->library('rssparser', array($this, 'parseFile')); // parseFile method of current class

	function parseFile($data, $item)
	{
		$data['summary'] = (string)$item->summary;
		return $data;
	}
*/


class RSSParser {

	public $feed_uri 			= NULL; 					// Feed URI
	public $data 				= FALSE; 					// Associative array containing all the feed items
	public $channel_data 		= array(); 					// Store RSS Channel Data in an array
	public $feed_unavailable	= NULL; 					// Boolean variable which indicates whether an RSS feed was unavailable
	public $cache_life 		= 0; 						// Cache lifetime
	public $cache_dir 		= './cszcms/cache/'; 	// Cache directory
	public $write_cache_flag 	= FALSE; 					// Flag to write to cache
	public $callback 			= FALSE; 					// Callback to read custom data
	

	function __construct($callback = FALSE)
	{
		if ($callback)
		{
			$this->callback = $callback;
		}
                $CI =& get_instance();
                if (CACHE_TYPE == 'file') {
                    $CI->load->driver('cache', array('adapter' => 'file', 'key_prefix' => EMAIL_DOMAIN . '_'));
                } else {
                    $CI->load->driver('cache', array('adapter' => CACHE_TYPE, 'backup' => 'file', 'key_prefix' => EMAIL_DOMAIN . '_'));
                }
	}

	// --------------------------------------------------------------------

	function parse()
	{
            $CI =& get_instance();
            $CI->load->model('Csz_model');
            if($CI->Csz_model->is_url_exist($this->feed_uri) !== FALSE){
		// Are we caching?
		if ($this->cache_life != 0)
		{
			$filename = $this->cache_dir.'rss_Parse_'.md5($this->feed_uri);
			// Is there a cache file ?
			if (file_exists($filename))
			{
				// Has it expired?
				$timedif = (time() - filemtime($filename));

				if ($timedif < ( $this->cache_life * 60))
				{
					$rawFeed = @file_get_contents($filename);
                                        $rawFeed = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $rawFeed);
                                        $rawFeed = preg_replace('#&(?=[a-z_0-9]+=)#', '&amp;', $rawFeed);
                                        $rawFeed = preg_replace('#<content:encoded>(.*?)</content:encoded>#is', '', $rawFeed);
				}
				else
				{
					// So raise the falg
					$this->write_cache_flag = true;
				}
			}
			else
			{
				// Raise the flag to write the cache
				$this->write_cache_flag = true;
			}
		}
		// Reset
		$this->data = array();
		$this->channel_data = array();
		// Parse the document
		if (!isset($rawFeed))
		{
			$rawFeed = @$CI->Csz_model->get_contents_url($this->feed_uri);
                        $rawFeed = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $rawFeed);
                        $rawFeed = preg_replace('#&(?=[a-z_0-9]+=)#', '&amp;', $rawFeed);
                        $rawFeed = preg_replace('#<content:encoded>(.*?)</content:encoded>#is', '', $rawFeed);
		}
                if($rawFeed !== FALSE){
                    $xml = new SimpleXmlElement($rawFeed);
                    if ($xml->channel)
                    {
                            // Assign the channel data
                            $this->channel_data['title'] = $xml->channel->title;
                            $this->channel_data['description'] = $xml->channel->description;

                            // Build the item array
                            foreach ($xml->channel->item as $item)
                            {
                                    $data = array();
                                    $data['title'] = (string)$item->title;
                                    $data['description'] = (string)$item->description;
                                    $data['pubDate'] = (string)$item->pubDate;
                                    $data['link'] = (string)$item->link;
                                    $dc = $item->children('http://purl.org/dc/elements/1.1/');
                                    $data['author'] = (string)$dc->creator;

                                    if ($this->callback)
                                    {
                                            $data = call_user_func($this->callback, $data, $item);
                                    }

                                    $this->data[] = $data;
                            }
                    }
                    else
                    {
                            // Assign the channel data
                            $this->channel_data['title'] = $xml->title;
                            $this->channel_data['description'] = $xml->subtitle;

                            // Build the item array
                            foreach ($xml->entry as $item)
                            {
                                    $data = array();
                                    $data['id'] = (string)$item->id;
                                    $data['title'] = (string)$item->title;
                                    $data['description'] = (string)$item->content;
                                    $data['pubDate'] = (string)$item->published;
                                    $data['link'] = (string)$item->link['href'];
                                    $dc = $item->children('http://purl.org/dc/elements/1.1/');
                                    $data['author'] = (string)$dc->creator;

                                    if ($this->callback)
                                    {
                                            $data = call_user_func($this->callback, $data, $item);
                                    }

                                    $this->data[] = $data;
                            }
                    }
                    // Do we need to write the cache file?
                    if ($this->write_cache_flag)
                    {
                            if (!$fp = @fopen($filename, 'wb'))
                            {
                                    echo "RSSParser error";
                                    log_message('error', "Unable to write cache file: ".$filename);
                                    return;
                            }

                            flock($fp, LOCK_EX);
                            fwrite($fp, $rawFeed);
                            flock($fp, LOCK_UN);
                            fclose($fp);
                    }
                    return TRUE;
                }else{
                    return FALSE;
                }
            }else{
                return FALSE;
            }
	}

	// --------------------------------------------------------------------

	function set_cache_life($period = NULL)
	{
		$this->cache_life = $period;
		return $this;
	}

	// --------------------------------------------------------------------

	function set_feed_url($url = NULL)
	{
		$this->feed_uri = $url;
		return $this;
	}

	// --------------------------------------------------------------------

	/* Return the feeds one at a time: when there are no more feeds return false
	 * @param No of items to return from the feed
	 * @return Associative array of items
	*/
	function getFeed($num)
	{
            $return = array();
            $feed = $this->parse();
            if($feed !== FALSE){		
		$c = 0;
		foreach ($this->data AS $item)
		{
			$return[] = $item;
			$c++;
			if ($c == $num)
			{
				break;
			}
		}		
            }
            return $return;
	}
        
        // --------------------------------------------------------------------

	function runFeedBackend($num)
	{
            $CI =& get_instance();
            if (!$CI->cache->get('backend_rssfeed_news')) {
                $return = '';
                $rss = $this->getFeed($num);
                if(!empty($rss)){
                    foreach ($rss as $item) {
                        $return.= '<div class="list-group"><div class="list-group-item">';
                        $return.= '<a href="'.$item['link'].'" target="_blank"><b>'.$item['title'].'</b></a>'; 
                        $return.= '<p>'.$item['description'].'</p>';
                        $return.= '<span class="badge">'.$item['pubDate'].'</span>';
                        $return.= '</div></div>';
                    }   
                }
                ($CI->Csz_model->load_config()->pagecache_time == 0) ? $cache_time = 1440 : $cache_time = $CI->Csz_model->load_config()->pagecache_time;
                $CI->cache->save('backend_rssfeed_news', $return, ($cache_time * 60));
            }
            return $CI->cache->get('backend_rssfeed_news');
	}

	// --------------------------------------------------------------------

	/* Return channel data for the feed */
	function & getChannelData()
	{
		$flag = false;

		if (!empty($this->channel_data))
		{
			return $this->channel_data;
		}
		else
		{
			return $flag;
		}
	}

	// --------------------------------------------------------------------

	/* Were we unable to retreive the feeds ?  */
	function errorInResponse()
	{
		return $this->feed_unavailable;
	}

	// --------------------------------------------------------------------
	
	/* Initialize the feed data */ 
	function clear()
	{
		$this->feed_uri		= NULL;
		$this->data			= FALSE;
		$this->channel_data	= array();
		$this->cache_life	= 0;
		$this->callback		= FALSE;
		
		return $this;
	}
}

/* End of file RSSParser.php */
/* Location: ./application/libraries/RSSParser.php */