<?php

class _DROP_MAIN_LIST {
    public $monsterName;
    public $monsterID;
    public $monsterOpenDrop;
    public $monsterMoney;
    public $listType = [];
    public $itemTypeID = [];
    public $itemCount = [];
}

class _DROP_GROUP_ITEM_LIST {
    public $listID;
    public $itemID = [];
}

class _DROP_GROUP_ITEM_PROCESS {
    public $groupID;
    public $listID;
    public $type;
}

class _DROP_GROUP_RANDOM_LIST {
    public $randomNumber;
    public $nGroupNo = [];
}

class _MOB_TBL {
    public $mob_name;
}

function readFileEx($handle, $size): int
{
    $ret = 0;
    $i = 0;
    $vl = 8 * ($size - 1);
    $arr = unpack("C*",fread($handle, $size));
    while($vl >= 0)
    {
        $ret += $arr[$size - $i++] << $vl;
        $vl -= 8;
    }
    return $ret;
}

function readFileString($handle) : ?string
{
    $size = readFileEx($handle, 2);
    if($size)
    {
        return fread($handle, $size);
    }
    return null;
}

class XCodeDropList
{
    public $drop_main_arr = [];
    public $drop_group_item_arr = [];
    public $drop_group_item_process_arr = [];
    public $drop_group_random_arr = [];
    public $mob_arr = [];

    private $drop_main_list = "_DROP_MAIN_LIST.xcode";
    private $drop_group_item_list = "_DROP_GROUP_ITEM_LIST.xcode";
    private $drop_group_item_process = "_DROP_GROUP_ITEM_PROCESS.xcode";
    private $drop_group_random_list = "_DROP_GROUP_RANDOM_LIST.xcode";
    private $mob_tbl = "_MOB_TBL.xcode";

    private function addItemTypes($itemID, $type, &$list)
    {
        array_push($list, ["itemID" => $itemID, "itemCount" => 1]);
        for($i = 1; $i < $type; $i++)
        {
            array_push($list, ["itemID" => ++$itemID, "itemCount" => 1]);
        }
    }

    public function getMonsterName($monster_id)
    {
        if(!array_key_exists($monster_id, $this->mob_arr)) return null;
        return $this->mob_arr[$monster_id];
    }

    public function getMonsterInfo($monster_id)
    {
        if(!array_key_exists($monster_id, $this->drop_main_arr)) return null;
        $drop = $this->drop_main_arr[$monster_id];
        if(!$drop) return null;
        return $drop;
    }

    public function getMonsterDrops($monster_id): ?array
    {
        if(!array_key_exists($monster_id, $this->drop_main_arr)) return null;
       $drop = $this->drop_main_arr[$monster_id];
       if(!$drop) return null;
       $list = [];

       if($drop->monsterMoney > 0) array_push($list, ["itemID" => 900000000, "itemCount" => $drop->monsterMoney]);

       for($i = 0; $i < 7; $i++)
       {
           $listType = $drop->listType[$i];
           if($listType == 0)
           {
               if($drop->itemTypeID[$i] > 0) array_push($list, ["itemID" => $drop->itemTypeID[$i], "itemCount" => $drop->itemCount[$i]]);
           } else if($listType == 1)
           {
               if(!array_key_exists($drop->itemTypeID[$i], $this->drop_group_item_process_arr)) continue;
               $process = $this->drop_group_item_process_arr[$drop->itemTypeID[$i]];
               if($process)
               {
                   if(!array_key_exists($process->listID, $this->drop_group_item_arr)) continue;
                   $group = $this->drop_group_item_arr[$process->listID];
                   if($group)
                   {
                       for($j = 0; $j < count($group->itemID); $j++)
                       {
                           if($process->type >= 2 && $process->type <= 8)
                           {
                                $this->addItemTypes($group->itemID[$j], $process->type, $list);
                           } else {
                                if($group->itemID[$j] > 0) array_push($list, ["itemID" => $group->itemID[$i], "itemCount" => 1]);
                           }
                       }
                   }
               }
           } else if($listType == 2)
           {
               if(!array_key_exists($drop->itemTypeID[$i], $this->drop_group_random_arr)) continue;
               $random = $this->drop_group_random_arr[$drop->itemTypeID[$i]];
               if($random)
               {
                   $nGroup = [];
                   for($j = 0; $j < 20; $j++) {
                       if ($random->nGroupNo[$j] > 0) array_push($nGroup, $random->nGroupNo[$j]);
                   }
                   if(empty($nGroup)) continue;

                   for($j = 0; $j < count($nGroup); $j++)
                   {
                       if(!array_key_exists($nGroup[$j], $this->drop_group_item_process_arr)) continue;
                       $process = $this->drop_group_item_process_arr[$nGroup[$j]];
                       if($process) {
                           if(!array_key_exists($process->listID, $this->drop_group_item_arr)) continue;
                           $group = $this->drop_group_item_arr[$process->listID];
                           if($group)
                           {
                               for($j = 0; $j < count($group->itemID); $j++)
                               {
                                   if($process->type >= 2 && $process->type <= 8)
                                   {
                                       $this->addItemTypes($group->itemID[$j], $process->type, $list);
                                   } else {
                                       if($group->itemID[$j] > 0) array_push($list, ["itemID" => $group->itemID[$i], "itemCount" => 1]);
                                   }
                               }
                           }
                       }
                   }

               }
           }
       }

       return $list;
    }

    function __construct()
    {
        // _MOB_TBL

        $handle = fopen($this->mob_tbl, "r");
        $row_size = readFileEx($handle, 4);

        for($i = 0; $i < $row_size; $i++) {
            $mob_id = readFileEx($handle, 2);
            $this->mob_arr[$mob_id] = readFileString($handle);
        }

        $handle = fopen($this->drop_main_list, "r");
        $row_size = readFileEx($handle, 4);

        // _DROP_MAIN_LIST

        for($i = 0; $i < $row_size; $i++)
        {
            $list = new _DROP_MAIN_LIST;
            $list->monsterID = readFileEx($handle, 2);
            $list->monsterOpenDrop = readFileEx($handle, 1);
            $list->monsterMoney = readFileEx($handle, 4);
            for($j = 0; $j < 7; $j++)
                $list->listType[$j] = readFileEx($handle, 1);
            for($j = 0; $j < 7; $j++)
                $list->itemTypeID[$j] = readFileEx($handle, 4);
            for($j = 0; $j < 7; $j++)
                $list->itemCount[$j] = readFileEx($handle, 4);

            if(array_key_exists($list->monsterID, $this->mob_arr)) $list->monsterName = $this->mob_arr[$list->monsterID];

            $this->drop_main_arr[$list->monsterID] = $list;
        }

        // _DROP_GROUP_ITEM_LIST

        $handle = fopen($this->drop_group_item_list, "r");
        $row_size = readFileEx($handle, 4);

        for($i = 0; $i < $row_size; $i++) {
            $list = new _DROP_GROUP_ITEM_LIST;
            $list->listID = readFileEx($handle, 4);
            $vSize = readFileEx($handle, 4);
            for($j = 0; $j < $vSize; $j++)
                array_push($list->itemID, readFileEx($handle, 4));

            $this->drop_group_item_arr[$list->listID] = $list;
        }

        // _DROP_GROUP_ITEM_PROCESS

        $handle = fopen($this->drop_group_item_process, "r");
        $row_size = readFileEx($handle, 4);

        for($i = 0; $i < $row_size; $i++) {
            $list = new _DROP_GROUP_ITEM_PROCESS;
            $list->groupID = readFileEx($handle, 4);
            $list->listID = readFileEx($handle, 2);
            $list->type = readFileEx($handle, 1);

            $this->drop_group_item_process_arr[$list->groupID] = $list;
        }

        // _DROP_GROUP_RANDOM_LIST

        $handle = fopen($this->drop_group_random_list, "r");
        $row_size = readFileEx($handle, 4);

        for($i = 0; $i < $row_size; $i++) {
            $list = new _DROP_GROUP_RANDOM_LIST;
            $list->randomNumber = readFileEx($handle, 4);
            for($j = 0; $j < 20; $j++)
                $list->nGroupNo[$j] = readFileEx($handle, 2);

            $this->drop_group_random_arr[$list->randomNumber] = $list;
        }
    }
}

$dropList = new XCodeDropList;

echo json_encode($dropList->getMonsterName(250));
