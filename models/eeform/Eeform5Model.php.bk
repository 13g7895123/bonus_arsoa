<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eeform5Model extends MY_Model {

    protected $table_submissions = 'eeform5_submissions';
    protected $table_occupations = 'eeform5_occupations';
    protected $table_health_issues = 'eeform5_health_issues';
    protected $table_product_recommendations = 'eeform5_product_recommendations';
    protected $table_consultation_records = 'eeform5_consultation_records';

    public function __construct() {
        parent::__construct();
        
        // Enable error reporting for debugging
        error_reporting(-1);
        ini_set('display_errors', 1);
        
        $this->load->database();
    }

    /**
     * 建立表單提交記錄
     * @param array $data 表單資料
     * @return int|bool 提交記錄ID或false
     */
    public function create_submission($data) {
        try {
            $this->db->trans_start();
            
            // 插入主表數據
            $this->db->insert($this->table_submissions, $data);
            $submission_id = $this->db->insert_id();
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE || !$submission_id) {
                throw new Exception('插入提交記錄失敗');
            }
            
            return $submission_id;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            throw new Exception('建立提交記錄失敗: ' . $e->getMessage());
        }
    }

    /**
     * 取得會員的所有提交記錄
     * @param string $member_name 會員姓名
     * @return array
     */
    public function get_submissions_by_member($member_name) {
        try {
            $this->db->select('*');
            $this->db->from($this->table_submissions);
            $this->db->where('member_name', $member_name);
            $this->db->order_by('created_at', 'DESC');
            
            $query = $this->db->get();
            $submissions = $query->result_array();
            
            return $submissions;
            
        } catch (Exception $e) {
            throw new Exception('取得提交記錄失敗: ' . $e->getMessage());
        }
    }

    /**
     * 根據ID取得單一提交記錄
     * @param int $id 提交記錄ID
     * @return array|null
     */
    public function get_submission_by_id($id) {
        try {
            $this->db->select('*');
            $this->db->from($this->table_submissions);
            $this->db->where('id', $id);
            
            $query = $this->db->get();
            $submission = $query->row_array();
            
            return $submission;
            
        } catch (Exception $e) {
            throw new Exception('取得提交記錄失敗: ' . $e->getMessage());
        }
    }

    /**
     * 更新提交記錄
     * @param int $id 提交記錄ID
     * @param array $data 更新資料
     * @return bool
     */
    public function update_submission($id, $data) {
        try {
            $data['updated_at'] = date('Y-m-d H:i:s');
            
            $this->db->where('id', $id);
            $result = $this->db->update($this->table_submissions, $data);
            
            return $result;
            
        } catch (Exception $e) {
            throw new Exception('更新提交記錄失敗: ' . $e->getMessage());
        }
    }

    /**
     * 刪除提交記錄
     * @param int $id 提交記錄ID
     * @return bool
     */
    public function delete_submission($id) {
        try {
            $this->db->trans_start();
            
            // 刪除主記錄
            $this->db->where('id', $id);
            $this->db->delete($this->table_submissions);
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('刪除提交記錄失敗');
            }
            
            return true;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            throw new Exception('刪除提交記錄失敗: ' . $e->getMessage());
        }
    }

    /**
     * 保存職業資料
     * @param int $submission_id 提交記錄ID
     * @param array $occupations 職業資料
     * @return bool
     */
    public function save_occupations($submission_id, $occupations) {
        try {
            $this->db->trans_start();
            
            // 刪除現有記錄
            $this->db->where('submission_id', $submission_id);
            $this->db->delete($this->table_occupations);
            
            // 插入新記錄
            foreach ($occupations as $occupation) {
                $data = [
                    'submission_id' => $submission_id,
                    'occupation_type' => $occupation['type'],
                    'occupation_name' => $occupation['name']
                ];
                $this->db->insert($this->table_occupations, $data);
            }
            
            $this->db->trans_complete();
            
            return $this->db->trans_status() !== FALSE;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            throw new Exception('保存職業資料失敗: ' . $e->getMessage());
        }
    }

    /**
     * 保存健康困擾資料
     * @param int $submission_id 提交記錄ID
     * @param array $health_issues 健康困擾資料
     * @return bool
     */
    public function save_health_issues($submission_id, $health_issues) {
        try {
            $this->db->trans_start();
            
            // 刪除現有記錄
            $this->db->where('submission_id', $submission_id);
            $this->db->delete($this->table_health_issues);
            
            // 插入新記錄
            foreach ($health_issues as $issue) {
                $data = [
                    'submission_id' => $submission_id,
                    'issue_code' => $issue['code'],
                    'issue_name' => $issue['name'],
                    'other_description' => isset($issue['other_description']) ? $issue['other_description'] : null,
                    'severity' => isset($issue['severity']) ? $issue['severity'] : null
                ];
                $this->db->insert($this->table_health_issues, $data);
            }
            
            $this->db->trans_complete();
            
            return $this->db->trans_status() !== FALSE;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            throw new Exception('保存健康困擾資料失敗: ' . $e->getMessage());
        }
    }

    /**
     * 保存產品推薦資料
     * @param int $submission_id 提交記錄ID
     * @param array $product_recommendations 產品推薦資料
     * @return bool
     */
    public function save_product_recommendations($submission_id, $product_recommendations) {
        try {
            $this->db->trans_start();
            
            // 刪除現有記錄
            $this->db->where('submission_id', $submission_id);
            $this->db->delete($this->table_product_recommendations);
            
            // 插入新記錄
            foreach ($product_recommendations as $recommendation) {
                $data = [
                    'submission_id' => $submission_id,
                    'product_code' => $recommendation['product_code'],
                    'product_name' => $recommendation['product_name'],
                    'recommended_dosage' => $recommendation['dosage']
                ];
                $this->db->insert($this->table_product_recommendations, $data);
            }
            
            $this->db->trans_complete();
            
            return $this->db->trans_status() !== FALSE;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            throw new Exception('保存產品推薦資料失敗: ' . $e->getMessage());
        }
    }

    /**
     * 取得所有提交記錄(分頁) - 管理後台用
     * @param int $page 頁碼
     * @param int $limit 每頁筆數  
     * @param string $search 搜尋關鍵字
     * @param string $start_date 開始日期
     * @param string $end_date 結束日期
     * @return array
     */
    public function get_all_submissions_paginated($page = 1, $limit = 20, $search = null, $start_date = null, $end_date = null) {
        try {
            $offset = ($page - 1) * $limit;
            
            // 建立查詢
            $this->db->select('
                s.id,
                s.member_name,
                s.birth_year,
                s.birth_month,
                s.height,
                s.has_medication_habit,
                s.medication_name,
                s.has_family_disease_history,
                s.disease_name,
                s.microcirculation_test,
                s.dietary_advice,
                s.submission_date,
                s.created_at,
                s.status
            ');
            $this->db->from($this->table_submissions . ' s');
            
            // 搜尋條件
            if ($search) {
                $this->db->group_start();
                $this->db->like('s.member_name', $search);
                $this->db->or_like('s.medication_name', $search);  
                $this->db->or_like('s.disease_name', $search);
                $this->db->group_end();
            }
            
            // 日期條件
            if ($start_date) {
                $this->db->where('s.submission_date >=', $start_date);
            }
            if ($end_date) {
                $this->db->where('s.submission_date <=', $end_date);
            }
            
            // 複製查詢來計算總數
            $total_query = $this->db->get_compiled_select();
            $total_result = $this->db->query("SELECT COUNT(*) as total FROM ($total_query) as subquery");
            $total = $total_result->row()->total;
            
            // 重新建立查詢以獲取資料
            $this->db->select('
                s.id,
                s.member_name,
                s.birth_year,
                s.birth_month,
                s.height,
                s.has_medication_habit,
                s.medication_name,
                s.has_family_disease_history,
                s.disease_name,
                s.microcirculation_test,
                s.dietary_advice,
                s.submission_date,
                s.created_at,
                s.status
            ');
            $this->db->from($this->table_submissions . ' s');
            
            if ($search) {
                $this->db->group_start();
                $this->db->like('s.member_name', $search);
                $this->db->or_like('s.medication_name', $search);
                $this->db->or_like('s.disease_name', $search);
                $this->db->group_end();
            }
            
            if ($start_date) {
                $this->db->where('s.submission_date >=', $start_date);
            }
            if ($end_date) {
                $this->db->where('s.submission_date <=', $end_date);
            }
            
            $this->db->order_by('s.created_at', 'DESC');
            $this->db->limit($limit, $offset);
            
            $query = $this->db->get();
            $submissions = $query->result_array();
            
            // 計算分頁資訊
            $total_pages = ceil($total / $limit);
            
            return [
                'data' => $submissions,
                'pagination' => [
                    'current_page' => $page,
                    'per_page' => $limit,
                    'total' => $total,
                    'total_pages' => $total_pages,
                    'has_next' => $page < $total_pages,
                    'has_prev' => $page > 1
                ]
            ];
            
        } catch (Exception $e) {
            throw new Exception('取得提交記錄失敗: ' . $e->getMessage());
        }
    }

    /**
     * 取得提交記錄詳細資料(包含關聯資料) - 管理後台用
     * @param int $id 提交記錄ID
     * @return array|null
     */
    public function get_submission_with_details($id) {
        try {
            // 取得主記錄
            $submission = $this->get_submission_by_id($id);
            if (!$submission) {
                return null;
            }
            
            // 取得職業資料
            $this->db->select('occupation_type, occupation_name');
            $this->db->from($this->table_occupations);
            $this->db->where('submission_id', $id);
            $occupations_query = $this->db->get();
            $submission['occupations'] = $occupations_query ? $occupations_query->result_array() : [];
            
            // 取得健康困擾資料  
            $this->db->select('issue_code, issue_name, other_description, severity');
            $this->db->from($this->table_health_issues);
            $this->db->where('submission_id', $id);
            $health_issues_query = $this->db->get();
            $submission['health_issues'] = $health_issues_query ? $health_issues_query->result_array() : [];
            
            // 取得產品推薦資料
            $this->db->select('product_code, product_name, recommended_dosage as dosage');
            $this->db->from($this->table_product_recommendations);
            $this->db->where('submission_id', $id);  
            $products_query = $this->db->get();
            $submission['product_recommendations'] = $products_query ? $products_query->result_array() : [];
            
            return $submission;
            
        } catch (Exception $e) {
            throw new Exception('取得提交記錄詳細資料失敗: ' . $e->getMessage());
        }
    }

    /**
     * 匯出單一提交記錄為Excel - 管理後台用
     * @param array $submission 提交記錄資料
     */
    public function export_single_submission($submission) {
        try {
            // 載入PhpSpreadsheet
            $this->load->library('PhpSpreadsheet');
            
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // 設置標題
            $sheet->setTitle('健康諮詢表');
            
            // 表頭
            $row = 1;
            $sheet->setCellValue('A' . $row, '健康諮詢表 - 提交記錄');
            $sheet->mergeCells('A' . $row . ':B' . $row);
            $row += 2;
            
            // 基本資訊
            $sheet->setCellValue('A' . $row, '記錄ID'); 
            $sheet->setCellValue('B' . $row, $submission['id']);
            $row++;
            
            $sheet->setCellValue('A' . $row, '會員姓名');
            $sheet->setCellValue('B' . $row, $submission['member_name']);  
            $row++;
            
            $sheet->setCellValue('A' . $row, '出生年月');
            $sheet->setCellValue('B' . $row, $submission['birth_year'] . '年' . $submission['birth_month'] . '月');
            $row++;
            
            $sheet->setCellValue('A' . $row, '身高(公分)');
            $sheet->setCellValue('B' . $row, $submission['height']);
            $row++;
            
            $sheet->setCellValue('A' . $row, '長期用藥習慣');
            $sheet->setCellValue('B' . $row, $submission['has_medication_habit'] ? '有' : '無');
            $row++;
            
            if ($submission['medication_name']) {
                $sheet->setCellValue('A' . $row, '使用藥物');
                $sheet->setCellValue('B' . $row, $submission['medication_name']);
                $row++;
            }
            
            $sheet->setCellValue('A' . $row, '家族慢性病史');
            $sheet->setCellValue('B' . $row, $submission['has_family_disease_history'] ? '有' : '無');
            $row++;
            
            if ($submission['disease_name']) {
                $sheet->setCellValue('A' . $row, '疾病名稱');
                $sheet->setCellValue('B' . $row, $submission['disease_name']);
                $row++;
            }
            
            // 職業資料
            if (!empty($submission['occupations'])) {
                $row++;
                $sheet->setCellValue('A' . $row, '職業');
                $occupations_str = '';
                foreach ($submission['occupations'] as $occupation) {
                    $occupations_str .= $occupation['occupation_name'] . ', ';
                }
                $sheet->setCellValue('B' . $row, rtrim($occupations_str, ', '));
                $row++;
            }
            
            // 健康困擾
            if (!empty($submission['health_issues'])) {
                $row++;
                $sheet->setCellValue('A' . $row, '健康困擾');
                $issues_str = '';
                foreach ($submission['health_issues'] as $issue) {
                    $issues_str .= $issue['issue_name'];
                    if ($issue['other_description']) {
                        $issues_str .= '(' . $issue['other_description'] . ')';
                    }
                    $issues_str .= ', ';
                }
                $sheet->setCellValue('B' . $row, rtrim($issues_str, ', '));
                $row++;
            }
            
            // 檢測與建議
            if ($submission['microcirculation_test']) {
                $row++;
                $sheet->setCellValue('A' . $row, '微循環檢測');
                $sheet->setCellValue('B' . $row, $submission['microcirculation_test']);
                $row++;
            }
            
            if ($submission['dietary_advice']) {
                $row++;
                $sheet->setCellValue('A' . $row, '日常飲食建議');
                $sheet->setCellValue('B' . $row, $submission['dietary_advice']);
                $row++;
            }
            
            // 產品推薦
            if (!empty($submission['product_recommendations'])) {
                $row++;
                $sheet->setCellValue('A' . $row, '產品推薦');
                $row++;
                foreach ($submission['product_recommendations'] as $product) {
                    $sheet->setCellValue('A' . $row, $product['product_name']);
                    $sheet->setCellValue('B' . $row, $product['dosage']);
                    $row++;
                }
            }
            
            $row++;
            $sheet->setCellValue('A' . $row, '提交日期');
            $sheet->setCellValue('B' . $row, $submission['submission_date']);
            $row++;
            
            $sheet->setCellValue('A' . $row, '建立時間');
            $sheet->setCellValue('B' . $row, $submission['created_at']);
            
            // 設置列寬
            $sheet->getColumnDimension('A')->setWidth(20);
            $sheet->getColumnDimension('B')->setWidth(50);
            
            // 輸出Excel文件
            $filename = '健康諮詢表_' . $submission['member_name'] . '_' . date('YmdHis') . '.xlsx';
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
            
        } catch (Exception $e) {
            throw new Exception('匯出Excel失敗: ' . $e->getMessage());
        }
    }
}