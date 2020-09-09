<?php


namespace App\Model\Article;


use EasySwoole\ORM\AbstractModel;

class ArticleMdoel extends AbstractModel
{
    protected $tableName = 'miaosha_goods';

    protected $primaryKey = 'id';

    public function  getListByCage($p = null, $title = null, $category = null, $order = array('field' => 'create_at', 'order' => 'DESC'))
    {
        $limit = 10;
        $where = array();
        if($category) {
            // $this->db->where('category_id', $category);
            $where ['category_id'] = $category; //  = array('category_id' => $category);
        }
        if($title) {
//            $this->db->where('article_title', '%' . $title . '%', 'like');
            $where ['article_title'] = array('%' . $title . '%', 'like');
        }
//        $this->db->where('article_status', 1);
//        $this->db->withTotalCount();
//        $this->db->orderBy($order ['field'], $order ['order']);
//
//        $lists = $this->db->get($this->getTable($this->table) . ' as a', $this->getRow($p), 'a.article_id,a.article_title, a.article_content, a.article_view, a.article_cover as file_id, a.category_id, a.create_at');
//        $totalRow = $this->db->getTotalCount();
//
//        $result = $this->getPage($lists, $totalRow, $p);

        return $this->limit($limit * ($p - 1), $limit)->where(array('article_status' => 1))->where($where)->order($order ['field'], $order ['order'])->get();
    }
}