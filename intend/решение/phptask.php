<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 27.05.2015
 * Time: 23:10
 */

// 1. task

    class PhpTask{

        protected function doLevels($arr, $levels = [], $count = 0){
            foreach ($arr as $k => $v) {
                if($count == 0){
                    if($v[1] == $count){
                        $levels[$count][$v[0]]['text'] = $v[2];
                        $levels[$count][$v[0]]['parent_id'] = $v[1];
                        unset($arr[$k]);
                    }
                }
                else{
                    if(array_key_exists($v[1], $levels[$count - 1])){
                        $levels[$count][$v[0]]['text'] = $v[2];
                        $levels[$count][$v[0]]['parent_id'] = $v[1];
                        unset($arr[$k]);
                    }
                }
            }

            if(count($arr) != 0){
                $count++;
                $levels = $this -> doLevels($arr, $levels, $count);
            }
            return $levels;
        }


        protected function doString($rootArr, $string = ''){
            foreach($rootArr as $k => $v){
                $tmp = '';
                if(array_key_exists('children', $v)){
                    $tmp = $this -> doString($v['children']);
                }
                $string .= '<div>' . $v['text'] . $tmp .'</div>';
            }
            return $string;
        }


        public function doTree($arr){
            $levels = array_reverse($this -> doLevels($arr), true);
            foreach($levels as $k => $v) {
                if ($k - 1 >= 0) {
                    foreach ($v as $k2 => $v2) {
                        $levels[$k - 1][$v2['parent_id']]['children'][$k2] = $levels[$k][$k2];
                    }
                }
            }
            return $this -> doString($levels[0]);
        }

    }


    $arr = array(
        //		    id	   parent_id	text
        array(1,	   0,		       'text_1'),
        array(4,	   2,		       'text_4'),
        array(8,	   0,		       'text_8'),
        array(3,	   1,		       'text_3'),
        array(10,  3,		       'text_10'),
        array(5,	   4,		       'text_5'),
        array(7,	   3,		       'text_7'),
        array(2,	   1,		       'text_2'),
        array(9,	   0,		       'text_9'),
        array(11,  0,		       'text_11'),
        array(6,	   4,		       'text_6'),
        array(12,  11,	           'text_12')
    );

    echo htmlentities((new PhpTask) -> doTree($arr));

?>