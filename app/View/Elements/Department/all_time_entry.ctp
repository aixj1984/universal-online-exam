<?php
$department_id = $_SESSION['Manager']['Manager']['department_id'];
?>
<table>
    <tr>
        <th style="width:100px;">院系</th>
        <th style="width:80px;">考试类型</th>
        <th>开始时间</th> 
        <th>时长(分钟)</th>
        <th>有效时间(小时)</th>
        <th>补考开始时间</th>
        <th>说明</th>
        <?php if ($department_id == 0): ?>
        <th style='width:100px'>操作</th>
        <?php endif ?>
    </tr>

    <?php
    $department_id = $_SESSION['Manager']['Manager']['department_id'];
    
    echo $this->Form->label($name, $label, array('class' => 'larger_label'));
    foreach ($$name as $test):
        $test_type_name = $test['TestType']['name'];
        $dept_name = $test['Department']['dept_name'];
        $test = $test['Test'];
        if ($department_id != 0 && $department_id != $test['department_id']) //判断是否是本院
            continue;
        ?>
        <tr>
            <td><?=$dept_name?></td>
            <td>
                <?php echo $this->Form->hidden('id', array('value' => $test['id'], 'id' => 'TestId')); ?>
                <?php echo $this->Form->hidden('test_type_id', array('value' => $test['test_type_id'], 'id' => 'test_type_id')); ?>
                <?php echo $this->Form->hidden('department_id', array('value' => $test['department_id'], 'id' => 'department_id')); ?>

                <?php echo $this->Form->label($test_type_name) ?> 
            </td>
            <td>
                <?php echo $this->Form->input('begin_time', array('value' => $test['begin_time'], 'label' => '')) ?> 
            </td>

            <td>
                <?php echo $this->Form->input('duration', array('value' => $test['duration'], 'label' => '')) ?> 
            </td>

            <td>
                <?php echo $this->Form->input('available', array('value' => $test['available'], 'label' => '')) ?> 
            </td>

            <td>
                <?php echo $this->Form->input('second_begin_time', array('value' => $test['second_begin_time'], 'label' => '')) ?> 
            </td>

            <td>
                <?php echo $this->Form->input('comment', array('value' => $test['comment'], 'label' => '')) ?> 
            </td>
            <td >
                <?php
                if ($department_id == 0){
                    echo $this->Form->button('保存', array(
                        'controller' => 'tests',
                        'action' => 'saveTest',
                        'class' => 'saveTestButton',
                    ));
                    echo $this->Form->button('删除', array(
                        'action' => 'delete',
                        'class' => 'deleteTime',
                    ));
                }
                if (isset($addToHistory))
                echo $this->Form->button('添加至历史', array(
                    'class' => 'addToHistory',
                ));
                
                ?>
            </td>
        </tr>   

<?php endforeach ?> 
</table>
<br/> <br/> <br/> 
