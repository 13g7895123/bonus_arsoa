<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rest_service extends MY_Service
{
    public function __construct()
    {
        parent::__construct();
    }

    // 首頁
    public function www_index()
    {
        $url = $this->config->item('rest_api_url').'/Index';
        return curl_post($url, array());
    }

    // 右邊區塊
    public function www_asite()
    {
        $url = $this->config->item('rest_api_url').'/Asite';
        return curl_post($url, array());
    }

    // 靜置廣告
    public function www_idle()
    {
        $url = $this->config->item('rest_api_url').'/Ad/idle';
        return curl_post($url, array());
    }

    // 文章資料
    public function get_article($article_id,$preview = FALSE)
    {
        $url = $this->config->item('rest_api_url').'/Article/article/'.$article_id.'/'.$preview;
        return curl_post($url, array());
    }

    // 文章是否播放MP3
    public function mp3_check($article_id)
    {
        $url = $this->config->item('rest_api_url').'/Article/mp3_check/'.$article_id;
        return curl_post($url, array());
    }

    // 文章瀏覽數
    public function get_article_num($article_id, $channel_id)
    {
        $url = $this->config->item('rest_api_url').'/Article/get_click_num/'.$article_id.'/'.$channel_id;
        return curl_post($url, array());
    }

    // 廣告
    public function get_ad($adid, $limit)
    {
        $url = $this->config->item('rest_api_url').'/Ad/ad/'.$adid.'/'.$limit;      
        return curl_post($url, array());
    }

    // 用文章編號抓作者
    public function get_article_author($article_id)
    {
        $url = $this->config->item('rest_api_url').'/Article/get_author/'.$article_id;
        return curl_post($url, array());
    }

    // 用文章編號抓延伸閱讀
    public function get_article_relation($article_id)
    {
        $url = $this->config->item('rest_api_url').'/Article/article_relation/'.$article_id;
        return curl_post($url, array());
    }

    // 用文章編號抓延伸閱讀
    public function get_article_old_id($ori_ser, $cp_from)
    {
        $url = $this->config->item('rest_api_url').'/Article/get_article_old_id/'.$ori_ser.'/'.$cp_from;
        return curl_post($url, array());
    }

    // 最新文章
    public function get_newset($page)
    {
        $url = $this->config->item('rest_api_url').'/Newest/index/'.$page;
        return curl_post($url, array());
    }
    
    // 最新文章
    public function get_newset_new($page)
    {
        $url = $this->config->item('rest_api_url').'/Newest/new_list/'.$page;
        return curl_post($url, array());
    }

    // 最新文章+行銷版位
    public function get_newset_ad($limit)
    {
        $url = $this->config->item('rest_api_url').'/Newest/newest/'.$limit;
        return curl_post($url, array());
    }

    // 英文名稱抓ID
    public function get_video_catalog_en_name_to_id($en_name)
    {
        $url = $this->config->item('rest_api_url').'/Video/get_video_catalog_en_name_to_id/'.$en_name;
        return curl_post($url, array());
    }

    // ID抓英文名稱
    public function get_video_catalog_id_to_en_name($cn_name)
    {
        $url = $this->config->item('rest_api_url').'/Cat/get_cat/'.$cn_name;
        return curl_post($url, array());
    }

    // 影片主頁
    public function get_video($video_topic, $video_id, $cg_no, $page)
    {
        $url = $this->config->item('rest_api_url').'/Video/get_video/' . $video_topic . '/' . $video_id . '/' . $cg_no . '/' . $page;
        return curl_post($url, array());
    }
    
    // 分類編號求分類資料
    public function get_cat($cg_no)
    {        
        $url = $this->config->item('rest_api_url').'/Cat/get_cat/'.$cg_no;
        return curl_post($url, array());
    }
    
    // 分類列表
    public function get_cat_list()
    {        
        $url = $this->config->item('rest_api_url').'/Cat/get_cat_list';
        return curl_post($url, array());
    }    
    
    // 英文名求分類資料
    public function get_cat_en($en_name)
    {        
        $url = $this->config->item('rest_api_url').'/Cat/get_cat_en/' . $en_name;
        return curl_post($url, array());
    }
    
    // 最新文章
    public function get_cat_article($key1,$key2,$key3)
    {
        $url = $this->config->item('rest_api_url').'/Cat/index/'.$key1.'/'.$key2.'/'.$key3;
        return curl_post($url, array());
    }
    
    // 最新文章
    public function get_cat_article_new($key1,$key2,$key3)
    {
        $url = $this->config->item('rest_api_url').'/Cat/new_list/'.$key1.'/'.$key2.'/'.$key3;
        return curl_post($url, array());
    }

    // 數位專題
    public function get_topic_index($key1)
    {
        $url = $this->config->item('rest_api_url').'/Topic/index/'.$key1;
        return curl_post($url, array());
    }
    
    // 數位專題
    public function get_topic($key1)
    {
        $url = $this->config->item('rest_api_url').'/Topic/data/'.$key1;
        return curl_post($url, array());
    }
    
    // 最新活動
    public function get_activity($key1)
    {
        $url = $this->config->item('rest_api_url').'/Activity/index/'.$key1;
        return curl_post($url, array());
    }
    
    // 自定專題資料
    public function get_sp_topic($key1)
    {
        $url = $this->config->item('rest_api_url').'/Topic/sp_topic/'.$key1;
        return curl_post($url, array());
    }
    
    // 自定專題資料
    public function get_sp_topic_get($key1)
    {
        $url = $this->config->item('rest_api_url').'/Topic/sp_topic_get/'.$key1;
        return curl_post($url, array());
    }
    
    // 自定專題資料文章列表
    public function get_sp_topic_list($key1)
    {
        $url = $this->config->item('rest_api_url').'/Topic/sp_topic_list/'.$key1;
        return curl_post($url, array());
    }
    
    // 合作專欄作者列表
    public function get_blog_index($key1)
    {
        $url = $this->config->item('rest_api_url').'/Blog/index/'.$key1;
        return curl_post($url, array());
    }
    
    // 作者資料列表
    public function get_author($key1,$key2)
    {
        $url = $this->config->item('rest_api_url').'/Author/index/'.$key1.'/'.$key2;
        return curl_post($url, array());
    }
    
    // 作者文章列表
    public function get_author_article($key1,$key2)
    {
        $url = $this->config->item('rest_api_url').'/Author/article/'.$key1.'/'.$key2;
        return curl_post($url, array());
    }
    
    // 標籤抓文章
    public function get_tag_article($key1,$key2)
    {
        $url = $this->config->item('rest_api_url').'/Tags/index/'.$key1.'/'.$key2;
        return curl_post($url, array());
    }

    // 標籤抓文章
    public function get_tag_article_new($key1,$key2)
    {
        $url = $this->config->item('rest_api_url').'/Tags/new_list/'.$key1.'/'.$key2;
        return curl_post($url, array());
    }
    
    // 會員抓是否可讀全文的資料
    public function member_articles_read_check($key1,$key2,$key3)
    {
        $url = $this->config->item('rest_api_url').'/Member/articles_read_check/'.$key1.'/'.$key2.'/'.$key3;
        return curl_post($url, array());
    }
    
    // 會員收藏文章
    public function member_favorites($key1)
    {
        $url = $this->config->item('rest_api_url').'/Member/favorites/'.$key1;
        return curl_post($url, array());
    }
    
    // 雜誌
    public function magazine_data($key1,$key2)
    {
        $url = $this->config->item('rest_api_url').'/Magazine/data/'.$key1.'/'.$key2;
        return curl_post($url, array());
    }
    
    public function magazine_year($key1)
    {
        $url = $this->config->item('rest_api_url').'/Magazine/get_year/'.$key1;
        return curl_post($url, array());
    }
    
    public function magazine_list($key1,$key2)
    {
        $url = $this->config->item('rest_api_url').'/Magazine/magazine_list/'.$key1.'/'.$key2;
        return curl_post($url, array());
    }
    
    public function magazine_catalog($key1)
    {
        $url = $this->config->item('rest_api_url').'/Magazine/magazine_catalog/'.$key1;
        return curl_post($url, array());
    }
    
    public function magazine_article($key1,$key2)
    {
        $url = $this->config->item('rest_api_url').'/Magazine/magazine_article/'.$key1.'/'.$key2;
        return curl_post($url, array());
    }
    
    //抓取活動資訊
    public function get_newevent_get_event($event_id, $limit)
    {
        $url = $this->config->item('rest_api_url').'/Newevent/newevent_get_event/'.$event_id.'/'.$limit;
        return curl_post($url, array());
    }

    //抓取活動人數
    public function get_newevent_get_event_users($event_id)
    {
        $url = $this->config->item('rest_api_url').'/Newevent/newevent_get_event_users/'.$event_id;
        return curl_post($url, array());
    }

    //檢查報名是否重複
    public function get_newevent_get_repeat($event_id, $json)
    {      
        return curl_post_json(config_item('rest_api_url') . '/Newevent/newevent_get_repeat/'.$event_id, $json);
    }
    
    //新增資料
    public function idata($itype,$data,$get_id = '')
    {
        $data['itype'] = $itype;

        return curl_post_json(config_item('rest_api_url').'/apis/idata/'.$get_id,json_encode($data));
    }
    
    //新增多筆的資料 
    public function banner_idata($itype,$data,$get_id = '')
    {
        $data['itype'] = $itype;
       
        return curl_post_json(config_item('rest_api_url').'/apis/banner_idata/'.$get_id,json_encode($data));
    }
    

    //新增報名
    public function insert_newevent_insert_event_user($event_id, $ins_content_json)
    {
        return curl_post_json(config_item('rest_api_url') . '/Newevent/newevent_insert_event_user/' . $event_id, $ins_content_json);
    }

    public function get_eventlist($event_id)
    {
        $url = $this->config->item('rest_api_url').'/Newevent/eventlist/'.$event_id;
        return curl_post($url, array());
    }

    //CSR 文章
    public function get_csr_search($year, $key, $list)
    {
        $url = $this->config->item('rest_api_url').'/Csr_ajax/csr_search/'.$year.'/' .$key.'/'. $list;
        return curl_post($url, array());
    }
    
    //CSR 榮譽榜
    public function get_csr_history($year, $key, $L1)
    {
        $url = $this->config->item('rest_api_url').'/Csr_ajax/csr_history/'.$year.'/' .$key.'/'. $L1;
        return curl_post($url, array());
    }
    
    // 分類全部資料
    public function get_cat_all()
    {
        $url = $this->config->item('rest_api_url').'/Cat/get_cat_all';
        return curl_post($url, array());
    }
    
    // 熱門關鍵字
    public function get_hot_keyword($limit = 3)
    {
        $url = $this->config->item('rest_api_url').'/Menu/hot_keyword/'.$limit;
        return curl_post($url, array());
    }
    
    // 熱門文章
    public function get_hot_article($limit = 3)
    {
        $url = $this->config->item('rest_api_url').'/Article/hot_article/'.$limit;
        return curl_post($url, array());
    }
    
    // 最新期刊
    public function get_magazine_new($limit = 3)
    {
        $url = $this->config->item('rest_api_url').'/Magazine/magazine_new/'.$limit;
        return curl_post($url, array());
    }    
    
    // 其它頻道文章
    public function get_channel_article($channel,$limit = 3)
    {
        $url = $this->config->item('rest_api_url').'/Channel/article/'.$channel.'/'.$limit;
        return curl_post($url, array());
    }    
    
    public function get_journal($limit = 3)
    {
        $url = $this->config->item('rest_api_url').'/Article/journal/'.$limit;
        return curl_post($url, array());
    }    
    

    //每日報 健康 華人菁英找文章編號
    public function get_health_and_gvlf_search_id($cp_from, $article_id)
    {
        $url = $this->config->item('rest_api_url').'/Gvm_api/health_and_gvlf_search_id/'.$cp_from.'/' .$article_id;
        return curl_post($url, array());
    }
    
    //每日報 其他找文章編號
    public function get_else_search_id($where_arg_json)
    { 
        $url = $this->config->item('rest_api_url').'/Gvm_api/else_search_id/?where_arg=' . $where_arg_json;
        return curl_post($url, array());
    } 

    public function get_article_old_from_json($where_arg_json)
    { 
        $url = $this->config->item('rest_api_url').'/Article/get_article_old_from_json/?where_arg=' . $where_arg_json;
        return curl_post($url, array());
    } 
    
    // 分類標籤
    public function get_hashtag()
    {         
        $url = $this->config->item('rest_api_url').'/Cat/hashtag';
        return curl_post($url, array());
    } 
    
    // menu 下拉
    public function get_menu($key)
    {
        $url = $this->config->item('rest_api_url').'/Menu/at/'.$key;
        return curl_post($url, array());
    } 
    
    // rss 用 拿文章列表
    public function get_article_for_rss($offset , $limit ,$begin_day)
    { 
        $url = $this->config->item('rest_api_url').'/Fb_report/get_article/'.$offset.'/'.$limit.'/'.$begin_day;
        return curl_post($url, array());
    } 
    
     // 刪除我的最愛
    public function member_removeArticle($mbr_id , $del_article)
    { 
        $url = $this->config->item('rest_api_url').'/Member/remove_favorites/'.$mbr_id.'/'.$del_article;
        return curl_post($url, array());
    } 
    
    // 增加我的最愛
    public function member_add_Article($data)
    { 
        return curl_post_json(config_item('rest_api_url').'/Member/add_favorites',json_encode($data));        
    } 

    // 分類sitemap
    public function get_cgno_sitemap($offset , $limit ,$begin_day, $cg_no,$ctype)
    { 
        $url = $this->config->item('rest_api_url').'/Sitemap/get_cgno_sitemap/'.$offset.'/'.$limit.'/'.$begin_day.'/'.$cg_no.'/'.$ctype;
        return curl_post($url, array());
    }
    
    // gvmevent
    public function get_gvmevent($case , $array)
    { 
        $url = $this->config->item('rest_api_url').'/Gvmevent/get_gvmevent/'.$case;
        return curl_post_array($url, $array);
    }
    // 華人菁英作者列表
    public function get_opinion_author_list()
    { 
        $url = $this->config->item('rest_api_url').'/Blog/slide_author/';
        return curl_post($url, array());
    }

    // 華人菁英slide
    public function get_opinion_slide($slide_num)
    { 
        $url = $this->config->item('rest_api_url').'/Blog/slide_article/'.$slide_num;
        return curl_post($url, array());
    }

    // 禾多rss
    public function get_likr($json)
    { 
        $array = json_decode($json , true);
        $url = $this->config->item('rest_api_url').'/Sitemap/likr/';
        return curl_post_array($url, $array);
    }
}
