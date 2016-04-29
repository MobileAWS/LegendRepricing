<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tweet_model extends CI_Model {	

		public function __construct(){

			parent::__construct();

		}
		
		public function newTweet($data){

			return $this->db->insert("retweets",$data);	
		}
		
		public function getTweets($userid){
		
		    $this->db->order_by('tweet_id','desc');
			$qry = $this->db->get_where('retweets',array('userid' => $userid));
			return $qry->result();
		}
		
		public function getSpecificTweet($tweet_id){
		    
			$qry = $this->db->get_where('retweets',array('tweet_id' => $tweet_id));
			return $qry->result();
		}
		
		public function getSpecificBlog($blog_id){
		    
			$qry = $this->db->get_where('blog',array('blog_id' => $blog_id));
			return $qry->result();
		}
		
		public function getSpecificUserFollower($userid){
		    
			$this->db->select('follower');
			$qry = $this->db->get_where('accounts',array('userid' => $userid))->result();
			return $qry[0]->follower;
		}
		
		public function getSpecificSite($website_id){
		    
			$qry = $this->db->get_where('websites',array('website_id' => $website_id));
			return $qry->result();
		}
		
		public function getSpecificTube($stream_id){
		    
			$qry = $this->db->get_where('youtube_video',array('stream_id' => $stream_id));
			return $qry->result();
		}
		
		public function getSpecificBanner($banner_id){
		    
			$qry = $this->db->get_where('banner',array('banner_id' => $banner_id));
			return $qry->result();
		}
		
		public function getSites($userid){
		
		    $this->db->order_by('website_id','desc');
			$qry = $this->db->get_where('websites',array('userid' => $userid));
			
			return $qry->result();
		}
		
		
		public function getTubes($userid){
		
		    $this->db->order_by('stream_id','desc');
			$qry = $this->db->get_where('youtube_video',array('userid' => $userid));
			
			return $qry->result();
		}
		
		public function getBlogs($userid){
		
		    $this->db->order_by('blog_id','desc');
			$qry = $this->db->get_where('blog',array('userid' => $userid));
			
			return $qry->result();
		}
		
		public function getAllRss(){
		
		    //$this->db->order_by('blog_id','desc');
			$qry = $this->db->get_where('blog',array('status' => '1'));
			
			return $qry->result();
		}
		
		public function getAllRssFeeds($blog_id){
		
		    //$this->db->order_by('blog_id','desc');
			$qry = $this->db->get_where('blog_feed',array('blog_id' => $blog_id));
			
			return $qry->result();
		}
		
		
		public function searchForFeeds($blog_id,$feed_title){
		
		    //$this->db->order_by('blog_id','desc');
			$qry = $this->db->get_where('blog_feed',array('blog_id' => $blog_id,'feed_title' => $feed_title));
			
			return $qry->result();
		}
		
		public function upateRssFeed($data,$feed_id){
					
			return $this->db->update("blog_feed",$data,array("feed_id" => $feed_id));	  

		}
		
		public function insertRssFeed($arrFeeds){			
			
			foreach($arrFeeds as $list){
			
			$blog_feed['blog_id'] = $list['blog_id'];
			$blog_feed['feed_url'] = $list['link'];
			$blog_feed['feed_title'] = $list['title'];
			$blog_feed['feed_description'] = $list['desc'];
			$blog_feed['userid'] = $list['userid'];
			
			$this->db->insert("blog_feed",$blog_feed);
			
			}

		}
		
		
		public function getFeeds($blog_id){
		
		    $this->db->order_by('feed_id','desc');
			$qry = $this->db->get_where('blog_feed',array('blog_id' => $blog_id));
			
			return $qry->result();
		}
		
		public function deleteFeed($feed_id){
						
			$this->db->delete("blog_feed",array("feed_id" => $feed_id));

		}
		
		
		public function deleteTweet($tweet_id){
			
			$data = $this->db->get_where("retweets",array("tweet_id" => $tweet_id))->row_array();
			
			$this->db->query("update users SET credit_points = credit_points + ".$data['total_offered_credit']." where userid='".$data['userid']."'");
									
			$this->db->delete("retweets",array("tweet_id" => $tweet_id));
			$this->db->delete("skip_retweet",array("retweet_id" => $tweet_id));
			$this->db->delete("retweet_history",array("retweet_id" => $tweet_id));			   

		}
		
		public function deleteWebsite($website_id){
			
			$data = $this->db->get_where("websites",array("website_id" => $website_id))->row_array();
			
			$this->db->query("update users SET credit_points = credit_points + ".$data['total_credit']." where userid='".$data['userid']."'");
									
			$this->db->delete("websites",array("website_id" => $website_id));
			$this->db->delete("skip_wesite",array("website_id" => $website_id));
			$this->db->delete("websites_activity",array("website_id" => $website_id));			   

		}
		
				
		public function deleteTube($stream_id){

			$data = $this->db->get_where("youtube_video",array("stream_id" => $stream_id))->row_array();
			
			$this->db->query("update users SET credit_points = credit_points + ".$data['total_credit']." where userid='".$data['userid']."'");
						
			$this->db->delete("youtube_video",array("stream_id" => $stream_id));
			$this->db->delete("skip_youtube",array("video_id" => $stream_id));
			$this->db->delete("youtube_video_activity",array("video_id" => $stream_id));			   

		}
		
		public function deleteBlog($blog_id){

			$data = $this->db->get_where("blog",array("blog_id" => $blog_id))->row_array();
			
			$this->db->query("update users SET credit_points = credit_points + ".$data['total_credit']." where userid='".$data['userid']."'");
			
			$this->db->delete("blog",array("blog_id" => $blog_id));
			$this->db->delete("blog_feed",array("blog_id" => $blog_id));
			$this->db->delete("feed_history",array("blog_id" => $blog_id));
			$this->db->delete("skip_blog_feed",array("blog_id" => $blog_id));			   

		}
		
		public function deleteBanner($banner_id){
			
			$data = $this->db->get_where("banner",array("banner_id" => $banner_id))->row_array();
			unlink("asset/images/upload/img_".$banner_id.'_'.$data['banner_img']);
			$this->db->delete("banner",array("banner_id" => $banner_id));			   

		}
		
		public function updateTweet($data,$tweet_id){

			return $this->db->update("retweets",$data,array("tweet_id" => $tweet_id));	  

		}
		
		public function insertWebsites($data){

			return $this->db->insert("websites",$data);	

		}
		
		public function newTube($data){

			return $this->db->insert("youtube_video",$data);	

		}
		
		public function insertBlogs($data,$arrFeeds){

			$this->db->insert("blog",$data);	
			
			$blog_id = mysql_insert_id();
			
			foreach($arrFeeds as $list){
			
			$blog_feed['blog_id'] = $blog_id;
			$blog_feed['feed_url'] = $list['link'];
			$blog_feed['feed_title'] = $list['title'];
			$blog_feed['feed_description'] = $list['desc'];
			$blog_feed['userid'] = $this->session->userdata('userid');
			
			$this->db->insert("blog_feed",$blog_feed);
			
			}

		}
		
		public function updateBlog($data,$blog_id){

			return $this->db->update("blog",$data,array("blog_id" => $blog_id));	  

		}
		
		public function updateSites($data,$website_id){

			return $this->db->update("websites",$data,array("website_id" => $website_id));	  

		}
		
		public function duplicateVideo($video_id,$userid){

			$query = $this->db->get_where('youtube_video',array('video_id' => $video_id,'userid' => $userid));

		    return $query->num_rows();

		}
		
		public function updateTubes($data,$stream_id){

			return $this->db->update("youtube_video",$data,array("stream_id" => $stream_id));	  

		}
		
		public function getCountrySites($country,$userid){
						
			$res = $this->db->query("SELECT website_id, title, detail, url, credit_per_view FROM websites WHERE status='1' AND userid in (SELECT userid FROM users where status='Active' AND userid != '$userid'  AND country = '$country') AND website_id NOT IN (SELECT website_id FROM websites_activity WHERE userid = '$userid') AND website_id NOT IN (SELECT website_id FROM skip_wesite WHERE userid = '$userid') AND total_credit >= credit_per_view ORDER BY credit_per_view desc,website_id desc LIMIT 28");
			
			return $res->result();   

		}
		
		public function getInterestSites($like,$userid){
		
			$res = $this->db->query("SELECT website_id, title, detail, url, credit_per_view FROM websites WHERE status='1' AND userid in (SELECT userid FROM users where status='Active' AND userid != '$userid' AND (".$like.")) AND website_id NOT IN (SELECT website_id FROM websites_activity WHERE userid = '$userid') AND website_id NOT IN (SELECT website_id FROM skip_wesite WHERE userid = '$userid') AND total_credit >= credit_per_view ORDER BY credit_per_view desc,website_id desc LIMIT 28");
			
			return $res->result();   

		}
		
		public function getTopSites(){
		
			$res = $this->db->query("SELECT website_id, title, detail, url, credit_per_view FROM websites WHERE status='1' ORDER BY credit_per_view desc LIMIT 6");
			
			return $res->result();	   

		}
		
		
		public function getAllSites($userid){
		
			$res = $this->db->query("SELECT website_id, title, detail, url, credit_per_view FROM websites WHERE status='1' AND userid in (SELECT userid FROM users where status='Active' AND userid != '$userid') AND website_id NOT IN (SELECT website_id FROM websites_activity WHERE userid = '$userid') AND website_id NOT IN (SELECT website_id FROM skip_wesite WHERE userid = '$userid') AND total_credit >= credit_per_view ORDER BY credit_per_view desc,website_id desc LIMIT 28");
			
			return $res->result();	   

		}
		
		
		
		public function getAllRetweets($userid){
		
			$res = $this->db->query("SELECT userid,(SELECT account FROM accounts WHERE userid = retweets.userid) as account,(SELECT profile_image FROM accounts WHERE userid = retweets.userid) as profile_image, tweet_id, tweet, total_member_required, credit_per_tweet, total_offered_credit FROM retweets WHERE status='1' AND total_offered_credit >= credit_per_tweet AND userid in (SELECT userid FROM users where status='Active' AND userid != '$userid') AND tweet_id NOT IN (SELECT retweet_id FROM retweet_history WHERE userid = '$userid') AND tweet_id NOT IN (SELECT retweet_id FROM skip_retweet WHERE userid = '$userid')  ORDER BY credit_per_tweet desc,tweet_id desc LIMIT 28");
			
			return $res->result();	   

		}
		
		
		public function getAllRetweets2($userid){
		
			$res = $this->db->query("SELECT userid,(SELECT account FROM accounts WHERE userid = retweets.userid) as account,(SELECT profile_image FROM accounts WHERE userid = retweets.userid) as profile_image, tweet_id, tweet, total_member_required, credit_per_tweet, total_offered_credit FROM retweets WHERE status='1' AND total_offered_credit >= credit_per_tweet AND userid in (SELECT userid FROM users where status='Active' AND userid != '$userid') AND tweet_id NOT IN (SELECT retweet_id FROM retweet_history WHERE userid = '$userid') AND tweet_id NOT IN (SELECT retweet_id FROM skip_retweet WHERE userid = '$userid')  ORDER BY tweet_id desc");
									
			return $res->result();	   

		}
		
		public function getRecenttweets($userid){
		
			$res = $this->db->query("SELECT userid,(SELECT account FROM accounts WHERE userid = retweets.userid) as account,(SELECT profile_image FROM accounts WHERE userid = retweets.userid) as profile_image, tweet_id, tweet, total_member_required, credit_per_tweet, total_offered_credit FROM retweets WHERE status='1' AND total_offered_credit >= credit_per_tweet AND userid in (SELECT userid FROM users where status='Active' AND userid != '$userid') AND tweet_id NOT IN (SELECT retweet_id FROM retweet_history WHERE userid = '$userid') AND tweet_id NOT IN (SELECT retweet_id FROM skip_retweet WHERE userid = '$userid')  ORDER BY tweet_id desc");
									
			return $res->result();	   

		}
		public function getCreditTweets($userid){
		
			$res = $this->db->query("SELECT userid,(SELECT account FROM accounts WHERE userid = retweets.userid) as account,(SELECT profile_image FROM accounts WHERE userid = retweets.userid) as profile_image, tweet_id, tweet, total_member_required, credit_per_tweet, total_offered_credit FROM retweets WHERE status='1' AND total_offered_credit >= credit_per_tweet AND userid in (SELECT userid FROM users where status='Active' AND userid != '$userid') AND tweet_id NOT IN (SELECT retweet_id FROM retweet_history WHERE userid = '$userid') AND tweet_id NOT IN (SELECT retweet_id FROM skip_retweet WHERE userid = '$userid')  ORDER BY credit_per_tweet desc");
									
			return $res->result();	   

		}
		public function getCategoryTweets($userid,$cid){
		
			$res = $this->db->query("SELECT userid,(SELECT account FROM accounts WHERE userid = retweets.userid) as account,(SELECT profile_image FROM accounts WHERE userid = retweets.userid) as profile_image, tweet_id, tweet, total_member_required, credit_per_tweet, total_offered_credit FROM retweets WHERE status='1' AND category_id=$cid AND total_offered_credit >= credit_per_tweet AND userid in (SELECT userid FROM users where status='Active' AND userid != '$userid') AND tweet_id NOT IN (SELECT retweet_id FROM retweet_history WHERE userid = '$userid') AND tweet_id NOT IN (SELECT retweet_id FROM skip_retweet WHERE userid = '$userid')  ORDER BY credit_per_tweet desc");
									
			return $res->result();	   

		}
		public function getKeyWordTweets($userid,$tweetkey){
		
			$res = $this->db->query("SELECT userid,(SELECT account FROM accounts WHERE userid = retweets.userid) as account,(SELECT profile_image FROM accounts WHERE userid = retweets.userid) as profile_image, tweet_id, tweet, total_member_required, credit_per_tweet, total_offered_credit FROM retweets WHERE status='1' AND  tweet LIKE '%".$tweetkey."%' AND total_offered_credit >= credit_per_tweet AND userid in (SELECT userid FROM users where status='Active' AND userid != '$userid') AND tweet_id NOT IN (SELECT retweet_id FROM retweet_history WHERE userid = '$userid') AND tweet_id NOT IN (SELECT retweet_id FROM skip_retweet WHERE userid = '$userid')  ORDER BY credit_per_tweet desc");
									
			return $res->result();	   

		}

		public function getAllFeeds($userid){
			
			$res = $this->db->query("SELECT blog_feed.userid,(SELECT account FROM accounts WHERE userid = blog_feed.userid) as account,(SELECT profile_image FROM accounts WHERE userid = blog_feed.userid) as profile_image, blog_feed.blog_id,blog_feed.feed_id,blog.minimum_follower,blog.credit_per_tweet,blog.feed_type,blog_feed.feed_url,     blog_feed.feed_title,blog_feed.feed_description FROM blog_feed join blog on blog_feed.blog_id= blog.blog_id where blog.total_credit >= blog.credit_per_tweet AND blog_feed.userid in (SELECT userid FROM users where status='Active' AND userid != '$userid') AND blog_feed.feed_id NOT IN (SELECT feed_id FROM feed_history WHERE userid = '$userid') AND blog_feed.feed_id NOT IN (SELECT feed_id FROM skip_blog_feed WHERE userid = '$userid') order by blog.credit_per_tweet desc,blog_feed.feed_id desc LIMIT 28");
			
			return $res->result();
			

		}
		
		public function insertSiteSkip($data){

			return $this->db->insert("skip_wesite",$data);	

		}
		
		public function insertRetweetSkip($data){

			return $this->db->insert("skip_retweet",$data);	

		}
		
		public function insertFeedSkip($data){

			return $this->db->insert("skip_blog_feed",$data);	

		}
		
		public function getWhoseTweet($tweet_id){

			$this->db->select('*');
			$this->db->from('retweets');
			$this->db->join('users', 'retweets.userid = users.userid');
			$this->db->join('accounts', 'retweets.userid = accounts.userid');
			$this->db->where('retweets.tweet_id',$tweet_id);
			$query = $this->db->get();
			
			return $query->result();

		}
		
		public function getWhoseFeed($feed_id){

			$this->db->select('*');
			$this->db->from('blog_feed');
			$this->db->join('blog', 'blog_feed.blog_id = blog.blog_id');
			$this->db->join('users', 'blog_feed.userid = users.userid');
			$this->db->join('accounts', 'blog_feed.userid = accounts.userid');
			$this->db->where('blog_feed.feed_id',$feed_id);
			$query = $this->db->get();
			
			return $query->result();

		}
		
		public function insertRetweetHistory($data){

			return $this->db->insert("retweet_history",$data);	

		}
		
		public function insertFeedHistory($data){

			return $this->db->insert("feed_history",$data);	

		}
		
		public function checkIfAlreadyViewed($website_id){
			$query   = $this->db->query("select * from websites_activity where website_id = '$website_id' AND userid = '".$this->session->userdata('userid')."'");
			$results = $query->row();
			return !empty($results)? $results : false;
		}
		
		public function getWebsiteSeedByStreamId($id){
			$query   = $this->db->query("select *from websites where website_id ='".$id."'");
			$results = $query->row();
			return !empty($results)? $results : false;
		}
		
		public function updateWebsite($website_id){
			return $this->db->query($sql="update websites SET total_viewer = total_viewer + 1, total_credit = total_credit - credit_per_view where website_id=$website_id");
		}
		
		public function insertWebsiteSeedActivity($data){
			$this->db->insert("websites_activity",$data);
		}
		
		public function updateWebsiteViewerSeed($userid,$no_of_seed){
			return $this->db->query($sql="update users SET credit_points = credit_points + $no_of_seed where userid=$userid");
		}
		
		public function updateRetweet($data,$tweet_id){

			return $this->db->update("retweets",$data,array("tweet_id" => $tweet_id));	  

		}
		
		public function updateFeed($data,$blog_id){

			return $this->db->update("blog",$data,array("blog_id" => $blog_id));	  

		}
		
		
		public function updateBanner($data,$banner_id){

			return $this->db->update("banner",$data,array("banner_id" => $banner_id));	  

		}
		
		public function getAllRetweetsForAdmin($limit,$offset,$status){

			$this->db->select('retweets.tweet_id,retweets.userid,retweets.tweet,retweets.status,retweets.timestamp,accounts.account,accounts.profile_image');
			$this->db->from('retweets');
			$this->db->join('accounts', 'retweets.userid = accounts.userid');
			$this->db->where('accounts.status','Active');
			if($status=='Active')
			$this->db->where('retweets.status','1');
			else if($status=='Inactive')
			$this->db->where('retweets.status','0');
			$this->db->order_by('retweets.tweet_id','desc');
			if($limit!=1000)
			$this->db->limit($limit,$offset-1);
			$query = $this->db->get();
			
			return $query;

		}
		
		
		public function getAllWebsitesForAdmin($limit,$offset,$status){

			$this->db->select('websites.website_id,websites.userid,websites.url,websites.status,websites.isFeatured,websites.timestamp,accounts.account,accounts.profile_image');
			$this->db->from('websites');
			$this->db->join('accounts', 'websites.userid = accounts.userid');
			$this->db->where('accounts.status','Active');
			if($status=='Active')
			$this->db->where('websites.status','1');
			else if($status=='Inactive')
			$this->db->where('websites.status','0');
			$this->db->order_by('websites.website_id','desc');
			if($limit!=1000)
			$this->db->limit($limit,$offset-1);
			$query = $this->db->get();
			
			return $query;

		}
		
		public function getAllBlogsForAdmin($limit,$offset,$status){

			$this->db->select('blog.blog_id,blog.userid,blog.blog_url,blog.status,blog.timestamp,accounts.account,accounts.profile_image');
			$this->db->from('blog');
			$this->db->join('accounts', 'blog.userid = accounts.userid');
			$this->db->where('accounts.status','Active');
			if($status=='Active')
			$this->db->where('blog.status','1');
			else if($status=='Inactive')
			$this->db->where('blog.status','0');
			$this->db->order_by('blog.blog_id','desc');
			if($limit!=1000)
			$this->db->limit($limit,$offset-1);
			$query = $this->db->get();
			
			return $query;

		}
		
		public function getFeedsForAdmin($blog_id,$limit,$offset,$status){

			$this->db->select('blog_feed.feed_id,blog_feed.blog_id,blog_feed.userid,blog_feed.feed_title,blog_feed.status,blog.timestamp,accounts.account,accounts.profile_image');
			$this->db->from('blog_feed');
			$this->db->join('accounts', 'blog_feed.userid = accounts.userid');
			$this->db->join('blog', 'blog_feed.blog_id = blog.blog_id');
			$this->db->where('accounts.status','Active');
			if($status=='Active')
			$this->db->where('blog_feed.status','1');
			else if($status=='Inactive')
			$this->db->where('blog_feed.status','0');
			$this->db->where('blog_feed.blog_id',$blog_id);
			$this->db->order_by('blog_feed.feed_id','desc');
			if($limit!=1000)
			$this->db->limit($limit,$offset-1);
			$query = $this->db->get();
			
			return $query;

		}
		
		
		public function getAllVideosForAdmin($limit,$offset,$status){

	        $this->db->select(       'youtube_video.stream_id,youtube_video.video_id,youtube_video.userid,youtube_video.video_thumbnail,youtube_video.status,accounts.account,accounts.profile_image');
			$this->db->from('youtube_video');
			$this->db->join('accounts', 'youtube_video.userid = accounts.userid');
			$this->db->where('accounts.status','Active');
			if($status=='Active')
			$this->db->where('youtube_video.status','ON');
			else if($status=='Inactive')
			$this->db->where('youtube_video.status','OFF');
			$this->db->order_by('youtube_video.stream_id','desc');
			if($limit!=1000)
			$this->db->limit($limit,$offset-1);
			$query = $this->db->get();
			
			return $query;

		}
		
		public function changeTweetStatus($tweet_id){

			$res = $this->db->get_where("retweets",array("tweet_id" => $tweet_id))->result();
			
			if($res[0]->status=='1') $status='0';
			else $status='1';
			
			$data['status'] = $status;
			
			return $this->db->update("retweets",$data,array("tweet_id" => $tweet_id));	  

		}
		
		public function changeWebsiteStatus($website_id){

			$res = $this->db->get_where("websites",array("website_id" => $website_id))->result();
			
			if($res[0]->status=='1') $status='0';
			else $status='1';
			
			$data['status'] = $status;
			
			return $this->db->update("websites",$data,array("website_id" => $website_id));	  

		}
		
		public function setFeaturedWebsite($website_id){
			
			$this->db->query("update websites set isFeatured='0'");
			
			$data['isFeatured'] = '1';
			
			return $this->db->update("websites",$data,array("website_id" => $website_id));	  

		}
		
		public function getFeaturedWebsite(){
			
			$res = $this->db->get_where("websites",array("isFeatured" => '1'))->result();
			return $res;

		}
		
		public function changeBlogStatus($blog_id){

			$res = $this->db->get_where("blog",array("blog_id" => $blog_id))->result();
			
			if($res[0]->status=='1') $status='0';
			else $status='1';
			
			$data['status'] = $status;
			
			return $this->db->update("blog",$data,array("blog_id" => $blog_id));	  

		}
		
		public function changeFeedStatus($feed_id){

			$res = $this->db->get_where("blog_feed",array("feed_id" => $feed_id))->result();
			
			if($res[0]->status=='1') $status='0';
			else $status='1';
			
			$data['status'] = $status;
			
			return $this->db->update("blog_feed",$data,array("feed_id" => $feed_id));	  

		}
		
		public function changeYoutubeStatus($stream_id){

			$res = $this->db->get_where("youtube_video",array("stream_id" => $stream_id))->result();
			
			if($res[0]->status=='ON') $status='OFF';
			else $status='ON';
			
			$data['status'] = $status;
			
			return $this->db->update("youtube_video",$data,array("stream_id" => $stream_id));	  

		}
		
		public function changeBannerStatus($banner_id){

			$res = $this->db->get_where("banner",array("banner_id" => $banner_id))->result();
			
			if($res[0]->status=='1') $status='0';
			else $status='1';
			
			$data['status'] = $status;
			
			return $this->db->update("banner",$data,array("banner_id" => $banner_id));	  

		}
		
		public function getFollowerList($account){
		
            $this->db->distinct();
			$this->db->select('accounts.acc_id');
			$this->db->from('credit_history');
			$this->db->join('accounts', 'credit_history.acc_name = accounts.account');
			$this->db->where('credit_history.mimic',$account);
			$query = $this->db->get();
			
			return $query->result();

		}
		
	
		
		public function wannaFollow($userid){
          
			$this->db->select('accounts.acc_id,accounts.userid,accounts.account,accounts.profile_image,accounts.offered_credit,users.credit_points');
			$this->db->from('accounts');
			$this->db->join('follow_list', 'accounts.acc_id = follow_list.acc_id');
			$this->db->join('users', 'accounts.userid = users.userid');
			$this->db->where('follow_list.userid',$userid);
			$this->db->order_by('follow_list.follow_list_id','desc');
			$this->db->limit(9);
			$query = $this->db->get();
			
			return $query->result();
			

		}
		
		public function wannaUnfollow($userid){
          
			$this->db->select('accounts.acc_id,accounts.userid,accounts.account,accounts.profile_image,accounts.offered_credit,users.credit_points');
			$this->db->from('accounts');
			$this->db->join('unfollow_list', 'accounts.acc_id = unfollow_list.acc_id');
			$this->db->join('users', 'accounts.userid = users.userid');
			$this->db->where('unfollow_list.userid',$userid);
			$this->db->order_by('unfollow_list.unfollow_list_id','desc');
			$this->db->limit(9);
			$query = $this->db->get();
			
			return $query->result();

		}
		
		
		public function getAllBanners($limit,$offset,$status){

	        $this->db->select('*');
			$this->db->from('banner');
			if($status=='Active')
			$this->db->where('status','1');
			else if($status=='Inactive')
			$this->db->where('status','0');
			$this->db->order_by('banner_id','desc');
			if($limit!=1000)
			$this->db->limit($limit,$offset-1);
			$query = $this->db->get();
			
			return $query;

		}
		
		public function getSmallAdds(){

			$this->db->select('*');
			$this->db->from('banner');
			$this->db->where('banner_type','small');
			$this->db->where('status','1');
			$this->db->limit(6);
			$query = $this->db->get();
			
			return $query->result();

		}
		
		public function getMediumAdds(){

			$this->db->select('*');
			$this->db->from('banner');
			$this->db->where('banner_type','medium');
			$this->db->where('status','1');
			$this->db->limit(1);
			$query = $this->db->get();
			
			return $query->result();

		}
		
		public function getLargeAdds(){

			$this->db->select('*');
			$this->db->from('banner');
			$this->db->where('banner_type','large');
			$this->db->where('status','1');
			$this->db->limit(1);
			$query = $this->db->get();
			
			return $query->result();

		}
		
		public function getXlargeAdds(){

			$this->db->select('*');
			$this->db->from('banner');
			$this->db->where('banner_type','xlarge');
			$this->db->where('status','1');
			$this->db->limit(1);
			$query = $this->db->get();
			
			return $query->result();

		}
		
		public function getAllAccounts(){		 
 		
		    $this->db->select('*');
			$this->db->from('accounts');
			$this->db->where('status','Active');
			$query = $this->db->get();
			
			return $query->result();
		}
		
		
		public function get100Accounts(){		 
 		
		    $this->db->select('*');
			$this->db->from('accounts');
			$this->db->where('status','Active');
			$this->db->where('(last_update2+12*3600) <= now()');
			$this->db->limit(100);
			$query = $this->db->get();
			
			return $query->result();
		}
		
		
		public function deleteFollowList($userid){

         $this->db->delete("follow_list",array("userid" => $userid));
		
		}
		
		public function deleteUnfollowList($userid){

         $this->db->delete("unfollow_list",array("userid" => $userid));
		
		}
		
		public function insertFollowList($data){
		 
			$this->db->insert("follow_list",$data);
			

		}
		
		public function deleteFromFollowList($userid,$acc_id){
		 
			$this->db->delete("follow_list",array("userid" => $userid,"acc_id" => $acc_id));
			

		}
		
		
		public function insertUnfollowList($data){
		
			$this->db->insert("unfollow_list",$data);

		}
		
		public function deleteFromUnfollowList($userid,$acc_id){
		 
			$this->db->delete("unfollow_list ",array("userid" => $userid,"acc_id" => $acc_id));
			

		}
		
		
		public function fetchFollower($userid){

			$qry = $this->db->get_where('follower_list',array('userid' => $userid));
			return $qry->result();

		}
				
		
		public function fetchFriends($data){

			$qry = $this->db->get_where('friend_list',array('userid' => $userid));
			return $qry;

		}
		
		public function updateAccount($data,$userid){

			return $this->db->update("accounts",$data,array("userid" => $userid));

		}
		
		
		public function getLatestUsers(){
          
			$this->db->select('*');
			$this->db->from('accounts');
			$this->db->where('status','Active');
			$this->db->order_by('last_update','desc');
			$this->db->limit(14);
			$query = $this->db->get();
			
			return $query->result();

		}
		
		public function getAdds(){

			$this->db->select('*');
			$this->db->from('banner');
			$this->db->where('status','1');
			$this->db->limit(6);
			$query = $this->db->get();
			
			return $query->result();

		}
				
}