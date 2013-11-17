<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TryHistories
 *
 * @author john
 */
class ParametersController extends AppController {
    public function beforeFilter() {
        parent::beforeFilter();
        parent::requireManager();
    }

    //put your code here
    public function question(){
        $data = $this->Parameter->find('list', 
                array('conditions' => array('type'=>'question'),
                    'fields' => 'name,value'
                    ));
        $this->set('para', $data);
    }
    public function setQuestionPercent($q_type = null, $percent = null){
        $this->autoRender = false;
        $this->loadModel('Question');
        $this->Question->updateAll(array('usage_scope' => 1),array('q_type' => $q_type));
        
        $ques = $this->Question->find('all', array(
            'fields' => 'id',
            'conditions' => "q_type=$q_type"
        ));
        if (count($ques) == 0) return "错误:题库中题目数为0";
        $keys = array_rand($ques, intval(count($ques) * $percent /100));
        
        $data = array();
        foreach($keys as $key){
            $row = array('id'=>$ques[$key]['Question']['id'],
                'usage_scope' => 0
                );
            $data[] = $row;
        }
        $this->Question->saveMany($data);
        switch($q_type){
            case 0: 
                $this->Parameter->updateAll(array('value' => $percent), array('name' => 'sel_percent'));
                break;
            case 1: 
                $this->Parameter->updateAll(array('value' => $percent), array('name' => 'jud_percent'));
                break;
            case 2: 
                $this->Parameter->updateAll(array('value' => $percent), array('name' => 'ans_percent'));
                break;
        }
        return "修改成功";
    }
    public function examPassScore(){
        $data = $this->Parameter->find('list', 
                array('conditions' => array('name'=>'exam_pass_score'),
                    'fields' => 'name,value'
                    ));
        $this->set('para', $data);
    }
    public function setExamPassScore($score){
        $this->autoRender = false;
        $this->Parameter->updateAll(array('value' => $score), array('name' => 'exam_pass_score'));
        $this->loadModel('Student');
        $this->Student->updateAll(array('times' => "(select count(*) from try_histories as T where Student.id=T.student_id and (sel_score+jud_score+ans_score)>= $score)"));
        $this->json_success();
    }
    
}

?>
