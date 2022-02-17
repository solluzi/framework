<?php
declare(strict_types=1);
namespace Solluzi\Database\Traits;

/*
|--------------------------------------------------------------------------
|                                  debug
|--------------------------------------------------------------------------
|
| this class is used when is needed to debug an sql Query
|
*/

trait SqlDebug
{
    
    public function debug()
    {
        $query = $this->query;
        $sql   = $query->base;
        
        if(!empty($query->join)){
            $sql .= implode(' ', $query->join);
        }

        if(!empty($query->leftJoin)){
            $sql .= implode(' ', $query->leftJoin);
        }

        if(!empty($query->rightJoin)){
            $sql .= implode(' ', $query->rightJoin);
        }

        if(!empty($query->union)){
            $sql .= $query->union;
        }

        if(!empty($query->unionAll)){
            $sql .= $query->unionAll;
        }

        if(!empty($query->where)){
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }

        if(!empty($query->orWhere)){
            $sql .= implode(' OR ', $query->orWhere);
        }

        if(!empty($query->having)){
            $sql .= $query->having;
        }

        if(!empty($query->between)){
            $sql .= $query->between;
        }

        if(!empty($query->orderBy)){
            $sql .= $query->orderBy;
        }

        if(!empty($query->groupBy)){
            $sql .= $query->groupBy;
        }

        if(isset($query->limit)){
            $sql .= $query->limit;
        }
        $sql .= ";";

        return $sql;
    }
}
