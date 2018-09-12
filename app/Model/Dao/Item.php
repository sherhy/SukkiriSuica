<?php

namespace Model\Dao;

class Item extends Dao
{

    /**
     * itemのidでin句で全部取る。
     *
     * @param string $item_ids
     * @return array
     */
    public function getItems(string $item_ids):array
    {
        $sql = "
            select
            	*
            from
            	item
            where
            	id in ($item_ids)
        ";
        return $this->db->fetchAll($sql);
    }

}