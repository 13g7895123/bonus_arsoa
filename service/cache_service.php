<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cache_service extends MY_Service
{
    public $cache_type   = ''; # 使用的cache類型
    public $cache_prefix = ''; # cache key前置詞    

    public function __construct()
    {
        parent::__construct();

        $this->cache_type   = $this->config->item('cache_type');
        $this->cache_prefix = $this->config->item('cache_name_prefix');
        $this->do_get = in_array(ENVIRONMENT, array('development')) ? true : false;
    }

    // 清除cache資料 - 無前置詞
    public function _clean_cache_data($cache_name = null)
    {
        $this->cache->{$this->cache_type}->delete($cache_name);
    }

    // 存cache資料 - 無前置詞
    public function _save_cache_data($cache_name, $data = array(), $time = 3600)
    {
        if ($this->cache_type == ''){
            return '';
        }
        if (!$this->do_get) {
            $this->cache->{$this->cache_type}->save($cache_name, json_encode($data), $time);
        }
    }

    // 取cache資料 - 無前置詞
    public function _get_cache_data($cache_name)
    {
        if ($this->cache_type == ''){
            return '';
        }
        if (empty($cache_name)) {
            return array();
        }
        $data[$cache_name] = array();
        $data[$cache_name] = json_decode($this->cache->{$this->cache_type}->get($cache_name), true);

        return $data[$cache_name];
    }

    // 清除cache資料 - 有前置詞
    public function _clean_cache($cache_name = null)
    {
        $this->cache->{$this->cache_type}->delete($this->cache_prefix . $cache_name);
    }

    // 存cache資料 - 有前置詞
    public function _save_cache($cache_name = null, $data = array(), $time = 3600)
    {
        if (!$this->do_get) {
            $this->cache->{$this->cache_type}->save($this->cache_prefix . $cache_name, json_encode($data), $time);
        }
    }

    // 取cache資料 - 有前置詞
    public function _get_cache($cache_name = null, $time = 3600, $var_arr = array())
    {
        if (empty($cache_name)) {
            return array();
        }

        $data[$cache_name]  = array();

        $var = explode('=', $cache_name);
        if (!$this->do_get) {
            $data[$cache_name] = json_decode($this->cache->{$this->cache_type}->get($this->cache_prefix . $cache_name), true);
        }

        $is_null = false;
        if (isset($data[$cache_name]['value']) && $data[$cache_name]['value'] == 'null') {
            $is_null = true;
            $data[$cache_name] = $data[$cache_name]['get'];
        }

        if (((empty($data[$cache_name]) || !is_array($data[$cache_name])) && !$is_null) || $this->do_get) {
            # 取得資料
            switch ($var[0]) {
                case 'www_index':
                    $data[$cache_name] = self::_get_www_index();
                    break;
                case 'www_asite':
                    $data[$cache_name] = self::_get_www_asite();
                    break;
                case 'www_idle':
                    $data[$cache_name] = self::_get_www_idle();
                    break;
                case 'www_article':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_article($var[1]);
                    }
                    break;
                case 'mp3_check':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_mp3_check($var[1]);
                    }
                    break;
                case 'article_num':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_article_num($var[1], $var[2]);
                    }
                    break;
                case 'www_article_author':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_article_author($var[1]);
                    }
                    break;
                case 'www_article_old_id':
                    if (!empty($var[1]) && !empty($var[2])) {
                        $data[$cache_name] = self::_get_article_old_id($var[1], $var[2]);
                    }
                    break;                    
                case 'www_article_relation':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_article_relation($var[1]);
                    }
                    break;
                case 'www_journal':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_journal($var[1]);
                    }
                    break;                       
                case 'www_hashtag':
                    $data[$cache_name] = self::_get_hashtag();                    
                    break;                       
                case 'www_channel_article':
                    if (!empty($var[1]) && !empty($var[2])) {
                        $data[$cache_name] = self::_get_channel_article($var[1], $var[2]);
                    }
                    break;
                case 'www_ad':
                    if (!empty($var[1])) {
                        $var2 = FALSE;
                        if (isset($var[2]) && $var[2] > '') {
                            $var2 = $var[2];
                        }
                        $data[$cache_name] = self::_get_ad($var[1], $var2);
                    }
                    break;
                case 'www_newset':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_newset($var[1]);
                    }
                    break;
                case 'www_newset_new':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_newset_new($var[1]);
                    }
                    break;
                case 'www_newest_ad':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_newset_ad($var[1]);
                    }
                    break;  
                case 'www_cat_list':
                    $data[$cache_name] = self::_get_cat_list();
                    break;
                case 'www_cat':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_cat($var[1]);
                    }
                    break;
                case 'www_cat_all':
                    $data[$cache_name] = self::_get_cat_all();
                    break;
                case 'www_cat_en':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_cat_en($var[1]);
                    }
                    break;
                case 'www_cat_article':
                    if (!empty($var[1]) && !empty($var[2])) {
                        $data[$cache_name] = self::_get_cat_article($var[1], $var[2], $var[3]);
                    }
                    break;
                case 'www_cat_article_new':
                    if (!empty($var[1]) && !empty($var[2])) {
                        $data[$cache_name] = self::_get_cat_article_new($var[1], $var[2], $var[3]);
                    }
                    break;
                case 'www_author':
                    if (!empty($var[1]) && !empty($var[2])) {
                        $data[$cache_name] = self::_get_author($var[1], $var[2]);
                    }
                    break;
                case 'www_author_article':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_author_article($var[1], $var[2]);
                    }
                    break;
                case 'www_topic':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_topic($var[1]);
                    }
                    break;
                case 'www_menu':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_menu($var[1]);
                    }
                    break;
                case 'www_sp_topic':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_sp_topic($var[1]);
                    }
                    break;
                case 'www_sp_topic_get':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_sp_topic_get($var[1]);
                    }
                    break;
                case 'www_sp_topic_list':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_sp_topic_list($var[1]);
                    }
                    break;
                case 'www_topic_index':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_topic_index($var[1]);
                    }
                    break;
                case 'www_tag_article':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_tag_article($var[1], $var[2]);
                    }
                    break;
                case 'www_tag_article_new':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_tag_article_new($var[1], $var[2]);
                    }
                    break;
                case 'www_activity':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_activity($var[1]);
                    }
                    break;
                case 'www_hot_keyword':                    
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_hot_keyword($var[1]);
                    }
                    break;
                case 'www_hot_article':                    
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_hot_article($var[1]);
                    }
                    break;           
                case 'www_magazine_new':                    
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_www_magazine_new($var[1]);
                    }
                    break;           
                             
                case 'www_blog_index':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_blog_index($var[1]);
                    }
                    break;
                case 'member_articles_read_check':
                    if (!empty($var[1]) && !empty($var[2]) && !empty($var[3])) {
                        $data[$cache_name] = self::member_articles_read_check($var[1], $var[2], $var[3]);
                    }
                    break;
                case 'member_favorites':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_member_favorites($var[1]);
                    }
                    break;
                case 'www_magazine_data':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_magazine_data($var[1], $var[2]);
                    }
                    break;
                case 'www_magazine_year':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_magazine_year($var[1]);
                    }
                    break;
                case 'www_magazine_list':
                    if (!empty($var[1]) && !empty($var[2])) {
                        $data[$cache_name] = self::_get_magazine_list($var[1], $var[2]);
                    }
                    break;
                case 'www_magazine_catalog':
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_magazine_catalog($var[1]);
                    }
                    break;
                case 'www_magazine_article':
                    if (!empty($var[1]) && !empty($var[2])) {
                        $data[$cache_name] = self::_get_magazine_article($var[1], $var[2]);
                    }
                    break;
                case 'www_video':
                    //[1]不知道有什麼用[2]影片ID[3]分類ID[4]頁數
                    $data[$cache_name] = self::_get_video($var[1], $var[2], $var[3], $var[4]);
                    break;
                case 'www_video_old':
                    //[1]分類英文名稱[2]分類ID
                    if (!empty($var[1])) {
                        $data[$cache_name] = self::_get_video_catalog_en_name_to_id($var[1]);
                    } else {
                        $data[$cache_name] = self::_get_video_catalog_id_to_en_name($var[2]);
                    }
                    break;
                case 'www_newevent':
                    //[1]event_id[2]limit
                    if (!empty($var[1]) && !empty($var[2])) {
                        $data[$cache_name] = self::_get_newevent_get_event($var[1], $var[2]);
                    }
                    break;
                case 'www_csr':
                    //[1]year[2]key[3]list
                    $var[2] = urlencode($var[2]);
                    $var[3] = urlencode($var[3]);
                    if (!empty($var[3])) {
                        $data[$cache_name] = self::_get_csr_search($var[1], $var[2], $var[3]);
                    } else {
                        $data[$cache_name] = self::_get_csr_history($var[1], $var[2], $var[4]);
                    }
                    break;
                case 'www_gvm_api':
                    //[1]選項[2]頻道名稱[3]文章ID[4]
                    switch ($var[1]) {
                        case 'health_and_gvlf_search_id':
                            $data[$cache_name] = self::_get_health_and_gvlf_search_id($var[2], $var[3]);
                            break;
                        case 'else_search_id':
                            $data[$cache_name] = self::_get_else_search_id($var[4]);
                            break;
                    }
                    break;
                case 'www_fashion':
                    //[1]where_arg_json
                    $data[$cache_name] = self::_get_fashion_old_id($var[1]);
                    break;
                case 'www_fb_api':
                    //[1]offset[2]limit[3]begin_day
                    $data[$cache_name] = self::_get_article_for_rss($var[1] , $var[2], $var[3]);
                    break;
                case 'www_cgno_sitemap':
                    //[1]offset[2]limit[3]begin_day[4]cg_no id[5]大或子分類
                    $data[$cache_name] = self::_get_cgno_sitemap($var[1] , $var[2], $var[3], $var[4], $var[5]);
                    break;
                case 'www_opinion_author_list':
                    //華人菁英作者列表
                    $data[$cache_name] = self::_get_opinion_author_list();
                    break;
                case 'www_opinion_slide':
                    //華人菁英slide [1]slide_num
                    $data[$cache_name] = self::_get_opinion_slide($var[1]);
                    break;
                case 'www_likr':
                    //禾多
                    $data[$cache_name] = self::_get_likr($var[1]);
                    break;
                default:
            }

            // 未取得資料時, 設定5分鐘null
            $is_null = false;
            if (empty($data[$cache_name])) {
                $time = $time > 300 ? 300 : 300;
                $data[$cache_name] = array('get' => $data[$cache_name], 'value' => 'null');
                $is_null = true;
            }

            if (!$this->do_get) {
                //存入cache檔案
                $this->cache->{$this->cache_type}->save($this->cache_prefix . $cache_name, json_encode($data[$cache_name]), $time);
            }

            if ($is_null) {
                $data[$cache_name] = $data[$cache_name]['get'];
            }
        }
        return $data[$cache_name];
    }

    # 取得資料
    private function _get_www_index()
    {
        $this->load->service('rest_service');
        return $this->rest_service->www_index();
    }

    private function _get_www_asite()
    {
        $this->load->service('rest_service');
        return $this->rest_service->www_asite();
    }

    private function _get_www_idle()
    {
        $this->load->service('rest_service');
        return $this->rest_service->www_idle();
    }

    private function _get_mp3_check($key)
    {
        $this->load->service('rest_service');
        return $this->rest_service->mp3_check($key);
    }

    private function _get_article($key1)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_article($key1);
    }

    private function _get_article_num($key1, $key2)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_article_num($key1, $key2);
    }

    private function _get_ad($key1, $key2)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_ad($key1, $key2);
    }

    // 用文章編號抓作者
    private function _get_article_author($key1)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_article_author($key1);
    }

    // 用文章編號抓延伸閱讀
    private function _get_article_relation($key1)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_article_relation($key1);
    }

    // 舊文章編號找出新文章編號
    private function _get_article_old_id($key1, $key2)
    {
        $this->load->service('rest_service');

        return $this->rest_service->get_article_old_id($key1, $key2);
    }

    // 最新文章
    private function _get_newset($key1)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_newset($key1);
    }
    
    // 最新文章
    private function _get_newset_new($key1)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_newset_new($key1);
    }

    // 最新文章+行銷版位
    private function _get_newset_ad($key1)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_newset_ad($key1);
    }
    
    // 英文名稱抓ID
    private function _get_video_catalog_en_name_to_id($en_name)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_video_catalog_en_name_to_id($en_name);
    }
    // ID抓英文名稱
    private function _get_video_catalog_id_to_en_name($catalog)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_video_catalog_id_to_en_name($catalog);
    }
    // 影片頁面
    private function _get_video($video_topic, $video_id, $cg_no, $page)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_video($video_topic, $video_id, $cg_no, $page);
    }

    // 分類編號抓資料
    private function _get_cat($key1)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_cat($key1);
    }

    // 分類編號抓資料
    private function _get_cat_en($key1)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_cat_en($key1);
    }

    private function _get_cat_article($key1, $key2, $key3)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_cat_article($key1, $key2, $key3);
    }

    private function _get_cat_article_new($key1, $key2, $key3)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_cat_article_new($key1, $key2, $key3);
    }

    private function _get_topic_index($key1)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_topic_index($key1);
    }

    private function _get_topic($key1)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_topic($key1);
    }

    private function _get_activity($key1)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_activity($key1);
    }

    private function _get_cat_list()
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_cat_list();
    }

    private function _get_sp_topic($key1)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_sp_topic($key1);
    }

    private function _get_sp_topic_get($key1)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_sp_topic_get($key1);
    }

    private function _get_sp_topic_list($key1)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_sp_topic_list($key1);
    }

    private function _get_blog_index($key1)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_blog_index($key1);
    }

    private function _get_author($key1, $key2)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_author($key1, $key2);
    }

    private function _get_author_article($key1, $key2)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_author_article($key1, $key2);
    }

    private function _get_tag_article($key1, $key2)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_tag_article($key1, $key2);
    }

    private function _get_tag_article_new($key1, $key2)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_tag_article_new($key1, $key2);
    }

    private function member_articles_read_check($key1, $key2, $key3)
    {
        $this->load->service('rest_service');
        return $this->rest_service->member_articles_read_check($key1, $key2, $key3);
    }

    private function _get_member_favorites($key1)
    {
        $this->load->service('rest_service');
        return $this->rest_service->member_favorites($key1);
    }

    private function _get_magazine_data($key1, $key2)
    {
        $this->load->service('rest_service');
        return $this->rest_service->magazine_data($key1, $key2);
    }

    private function _get_magazine_year($key1)
    {
        $this->load->service('rest_service');
        return $this->rest_service->magazine_year($key1);
    }

    private function _get_magazine_list($key1, $key2)
    {
        $this->load->service('rest_service');
        return $this->rest_service->magazine_list($key1, $key2);
    }
   
    // 期刊對應分類
    private function _get_magazine_catalog($key1)
    {
        $this->load->service('rest_service');
        return $this->rest_service->magazine_catalog($key1);
    }
    
    // 期刊分類下文章
    private function _get_magazine_article($key1, $key2)
    {
        $this->load->service('rest_service');
        return $this->rest_service->magazine_article($key1, $key2);
    }
    //抓取活動資訊
    private function _get_newevent_get_event($event_id, $limit)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_newevent_get_event($event_id, $limit);
    }
    //CSR 文章
    private function _get_csr_search($year, $key, $list)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_csr_search($year, $key, $list);
    }
    //CSR 榮譽榜
    private function _get_csr_history($year, $key, $L1)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_csr_history($year, $key, $L1);
    }
    //每日報 健康 華人菁英找文章編號
    private function _get_health_and_gvlf_search_id($cp_from, $article_id)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_health_and_gvlf_search_id($cp_from, $article_id);
    }
    //每日報 其他找文章編號
    private function _get_else_search_id($where_arg_json)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_else_search_id($where_arg_json);
    }
    
    private function _get_fashion_old_id($where_arg_json)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_article_old_from_json($where_arg_json);
    }
    
    //全部分類
    private function _get_cat_all()
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_cat_all();
    }
    
    //熱門關鍵字
    private function _get_hot_keyword($limit)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_hot_keyword($limit);
    }
    
    //熱門關鍵字
    private function _get_hot_article($limit)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_hot_article($limit);
    }
    
    // 最新期刊
    private function _get_www_magazine_new($limit)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_magazine_new($limit);
    }
    
    // 其它頻道文章
    private function _get_channel_article($channel,$limit)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_channel_article($channel,$limit);
    }
    
    // 雜誌文章
    private function _get_journal($limit)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_journal($limit);
    }
    
    // menu 下拉主題標籤
    private function _get_menu($key)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_menu($key);
    }
    
    // 分類標籤
    private function _get_hashtag()
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_hashtag();
    }
    
    // rss 用 拿文章列表
    private function _get_article_for_rss($offset , $limit ,$begin_day)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_article_for_rss($offset , $limit ,$begin_day);
    }

    // 大分類sitemap
    private function _get_cgno_sitemap($offset , $limit ,$begin_day , $cg_no,$ctype)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_cgno_sitemap($offset , $limit ,$begin_day, $cg_no,$ctype);
    }
    // 華人菁英作者列表
    private function _get_opinion_author_list()
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_opinion_author_list();
    }
    
    // 華人菁英slide
    private function _get_opinion_slide($slide_num)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_opinion_slide($slide_num);
    }

    // 禾多
    private function _get_likr($json)
    {
        $this->load->service('rest_service');
        return $this->rest_service->get_likr($json);
    }

}
