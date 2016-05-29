<?php

require_once '../lib/main.php';
$method = @$_POST['method'];
header("Content-type:application/json;charset=utf-8");
if (empty($method)) {
    echo jsonError("参数错误");
} else {
    foreach ($_POST as $param) {
        if (!isset($param)) {
            jsonError("参数错误");
            exit();
        }
    }
    main($method, $_POST);
}

function login($param, $conn)
{
    $rs = $conn->query("select * from admin where ad_name = '{$param['name']}' and ad_pass = md5('{$param['pass']}')");
    if ($rs->getRow()) {
        $_SESSION["admin"] = $rs->getRow();
        echo '{"success":"ok"}';
    } else {
        jsonError("用户名或密码错误");
    }
}

function logout()
{
    unset($_SESSION['admin']);
    echo '{"success":"ok"}';
}


function addCourse($param, $conn)
{
    $rs = $conn->execute("insert into course(title,create_time) values( '{$param['title']}',now())");
    if ($rs) {
        echo '{"success":"ok"}';
    } else {
        jsonError("新增失败");
    }
}

function getCourse($param, $conn)
{
    $id = "";
    if(!empty($param['id'])){
        $id = " where id = {$param['id']}";
    }
    $rs = $conn->query("select * from course $id");
    if ($rs) {
        echo json_encode($rs->AllRow());
    } else {
        jsonError("参数错误");
    }
}

function editCourse($param, $conn)
{
    $rs = $conn->execute("update course set title = '{$param['title']}' where id = {$param['id']} ");
    if ($rs) {
        echo '{"success":"ok"}';
    } else {
        jsonError("修改失败");
    }
}

function delCourse($param, $conn)
{
    $rs = $conn->execute("delete from course  where id = {$param['id']}");
    if ($rs) {
        echo '{"success":"ok"}';
    } else {
        jsonError("删除失败");
    }
}

function addSubject($param, $conn)
{
    $rs = $conn->execute("insert into subject(title,course,create_time) values( '{$param['title']}',{$param['course']},now())");
    if ($rs) {
        echo '{"success":"ok"}';
    } else {
        jsonError("新增失败");
    }
}

function getSubject($param, $conn)
{
    $id = "";
    if(isset($param['id'])){
        $id = " and id = {$param['id']}";
    }
    $rs = $conn->query("select * from subject where course = {$param['course']} $id ");
    if ($rs) {
        echo json_encode($rs->AllRow());
    } else {
        jsonError("参数错误");
    }
}

function editSubject($param, $conn)
{
    $rs = $conn->execute("update subject set title = '{$param['title']}' where id = {$param['id']} and course = {$param['course']}");
    if ($rs) {
        echo '{"success":"ok"}';
    } else {
        jsonError("修改失败");
    }
}

function delSubject($param, $conn)
{
    $rs = $conn->execute("delete from subject  where id = {$param['id']} and course = {$param['course']}");
    if ($rs) {
        echo '{"success":"ok"}';
    } else {
        jsonError("删除失败");
    }
}

function addChapter($param, $conn)
{
    $rs0 = $conn->query("select * from chapter where cid = {$param['cid']}  and subject = {$param['subject']}");
    if($rs0->getRow()){
        jsonError("章节号已经存在");
        return;
    }
    $rs = $conn->execute("insert into chapter(title,subject,cid,create_time) values( '{$param['title']}',{$param['subject']},{$param['cid']},now())");
    if ($rs) {
        echo '{"success":"ok"}';
    } else {
        jsonError("新增失败");
    }
}

function getChapter($param, $conn)
{
    $id = "";
    if(isset($param['id'])){
        $id = " and id = {$param['id']}";
    }
    $rs = $conn->query("select * from chapter where subject = {$param['subject']} $id ");
    if ($rs) {
        echo json_encode($rs->AllRow());
    } else {
        jsonError("参数错误");
    }
}

function editChapter($param, $conn)
{
    $rs = $conn->execute("update chapter set title = '{$param['title']}',cid = {$param['cid']} where id = {$param['id']} and subject = {$param['subject']}");
    if ($rs) {
        echo '{"success":"ok"}';
    } else {
        jsonError("修改失败");
    }
}

function delChapter($param, $conn)
{
    $rs = $conn->execute("delete from chapter  where id = {$param['id']} and subject = {$param['subject']}");
    if ($rs) {
        echo '{"success":"ok"}';
    } else {
        jsonError("删除失败");
    }
}


function addQuestion($param, $conn)
{
    $rs0 = $conn->query("select * from question where cid = {$param['cid']}  and subject = {$param['subject']} and number = {$param['number']}");
    if($rs0->getRow()){
        jsonError("题号已经存在");
        return;
    }
    $rs = $conn->execute("insert into question(number,content,type,subject,cid,answer1,answer2,answer3,answer4,`right`,`explain`) "
            . " values( '{$param['number']}', '{$param['content']}',{$param['type']},{$param['subject']},{$param['cid']},'{$param['answer1']}',"
            . " '{$param['answer2']}','{$param['answer3']}','{$param['answer4']}','{$param['right']}','{$param['explain']}')");
    if ($rs) {
        echo '{"success":"ok"}';
    } else {
        jsonError("新增失败");
    }
}

function getQuestion($param, $conn)
{
    $id = "";
    if(isset($param['id'])){
        $id = " and id = {$param['id']}";
    }
    $rs = $conn->query("select *,case type when 0 then '单选' when 1 then '多选' when 2 then '判断' end as typeTitle  from question where subject = {$param['subject']} and cid = {$param['cid']} $id order by number");
    if ($rs) {
        $rows = $rs->AllRow();
        foreach ($rows as &$row){
            if(empty($row['answer1'])) $row['answer1'] = "-";
            if(empty($row['answer2'])) $row['answer2'] = "-";
            if(empty($row['answer3'])) $row['answer3'] = "-";
            if(empty($row['answer4'])) $row['answer4'] = "-";
        }
        echo json_encode($rows);
    } else {
        jsonError("参数错误");
    }
}

function editQuestion($param, $conn)
{
    $rs = $conn->execute("update question set number = '{$param['number']}',content = '{$param['content']}',"
    . " type={$param['type']},answer1='{$param['answer1']}',answer2='{$param['answer2']}',answer3='{$param['answer3']}',"
    . "answer4='{$param['answer4']}',`right`='{$param['right']}',`explain`='{$param['explain']}' where id = {$param['id']} and subject = {$param['subject']} and cid = {$param['cid']}");
    if ($rs) {
        echo '{"success":"ok"}';
    } else {
        jsonError("修改失败");
    }
}

function delQuestion($param, $conn)
{
    $rs = $conn->execute("delete from question  where id = {$param['id']} and subject = {$param['subject']} and cid = {$param['cid']}");
    if ($rs) {
        echo '{"success":"ok"}';
    } else {
        jsonError("删除失败");
    }
}


function addUser($param, $conn)
{
    if(empty($param['account'])){
        jsonError("账号不能为空");
        return;
    }else{
        $param['account'] = str_replace(array('\t','\n','\r','\0',' '),"",trim($param['account']));
    }
    $rs0 = $conn->query("select * from `user` where `name` = '{$param['account']}'");
    if($rs0->getRow()){
        jsonError("用户名已经存在");
        return;
    }
    if(!empty($param['name'])||!empty($param['mobile'])){
        $info = $param['name'].','.$param['mobile'];
    }else{
        $info = "";
    }
    $rs = $conn->execute("insert into `user`(`name`,remark,`status`,create_time) values( '{$param['account']}','$info',1,now())");
    if ($rs) {
        echo '{"success":"ok"}';
    } else {
        jsonError("新增失败");
    }
}

function getUser($param, $conn)
{
    $id = "";
    $page = isset($param['page']) ? $param['page'] : 1;
    $size = 20;
    $page = $page - 1;
    $start = $page * $size;
    $key = '';
    if(!empty($param['key'])){
        $key = " and remark like '%{$param['key']}%' or `name` like '%{$param['key']}%' ";
    }
    if(isset($param['id'])){
        $id = " and id = {$param['id']}";
    }
    $rs = $conn->query("select *,case `status` when 0 then '待审核' when 1 then '审核通过' end as statusText from `user` where 1=1 $id $key order by id desc limit $start,$size");
    if ($rs) {
        echo json_encode($rs->AllRow());
    } else {
        jsonError("参数错误");
    }
}

function editUser($param, $conn)
{
    if(!empty($param['name'])||!empty($param['mobile'])){
        $info = $param['name'].','.$param['mobile'];
    }else{
        $info = "";
    }
    $rs = $conn->execute("update `user` set `name` = '{$param['account']}',remark = '$info' where id = {$param['id']}");
    if ($rs) {
        echo '{"success":"ok"}';
    } else {
        jsonError("修改失败");
    }
}

function delUser($param, $conn)
{
    $rs = $conn->execute("delete from `user`  where id = {$param['id']}");
    if ($rs) {
        echo '{"success":"ok"}';
    } else {
        jsonError("删除失败");
    }
}

function changeUserStatus($param, $conn){
    $sql = " update `user` set `status`=(`status`+1)%2 where id = {$param['id']} ";
    $rs = $conn->execute($sql);
    if($rs){
        echo '{"success":"ok"}';
    }else{
        jsonError("更新失败");
    }
}

function getSuit($param, $conn){
    $rs = $conn->query(" select * from exam_suit ");
    if ($rs) {
        echo json_encode($rs->AllRow());
    }else{
        jsonError("暂无数据");
    }
}

function editSuit($param, $conn){
    $rs = $conn->execute("update exam_suit set title = '{$param['title']}' where id = {$param['id']}");
    if ($rs) {
        echo '{"success":"ok"}';
    } else {
        jsonError("删除失败");
    }
}
function delSuit($param, $conn){
    $rs = $conn->execute("delete from exam_suit where id = {$param['id']}");
    if ($rs) {
        echo '{"success":"ok"}';
    } else {
        jsonError("删除失败");
    }
}
function addSuit($param, $conn){
    $rs = $conn->execute("insert into exam_suit(title) values('{$param['title']}')");
    if ($rs) {
        echo '{"success":"ok"}';
    } else {
        jsonError("删除失败");
    }
}
function getExam($param, $conn){
    $id = "";
    if(isset($param['id'])){
        $id = " and id = {$param['id']}";
    }
    if(isset($param['num'])&&!empty($param['num'])){
        $sql = " select *,case type when 0 then '单选' when 1 then '多选' when 2 then '判断' when 3 then '案例' when 4 then '计算' end as typeTitle from question_exam where subjectId = {$param['subject']} and suitId = {$param['suit']} and parentNumber= {$param['num']} $id ";
    }else{
        $sql = "select *,case type when 0 then '单选' when 1 then '多选' when 2 then '判断' when 3 then '案例' when 4 then '计算' end as typeTitle "
            . " from question_exam where subjectId = {$param['subject']} and suitId = {$param['suit']} and parentNumber=0 $id order by type,number ";
    }
    $rs = $conn->query($sql);
    $fl = false;
    $opts = array();
    if(isset($param['qt'])&&$param['qt']=='0'){
        $fl = true;
        $sql4 = "select * from exam_slist order by parentId,id";
        $rs4 = $conn->query($sql4);
        if($rs4->getRow()){
            $opts = $rs4->allRow();
        }
    }
    if ($rs&&$rs->getRow()) {
        $rows = $rs->AllRow();
        foreach ($rows as &$row){
            if($row['answer1']==null||$row['answer1']=='') $row['answer1'] = "-";
            if($row['answer2']==null||$row['answer2']=='') $row['answer2'] = "-";
            if($row['answer3']==null||$row['answer3']=='') $row['answer3'] = "-";
            if($row['answer4']==null||$row['answer4']=='') $row['answer4'] = "-";
            if(empty($row['right'])&&$row['type']=='4') {
                if(!empty($id)){
                    $row['right'] = '-';
                }else{
                    $row['right'] = "<a href = 'exam_p1.php?subject={$param['subject']}&suit={$param['suit']}&num={$row['number']}'>分录选项</a>";
                }
            }
            if(empty($row['right'])&&$row['type']=='3'){
                if(!empty($id)){
                    $row['right'] = '-';
                    $row['explain'] = '-';
                }else{
                    $row['right'] = "<a href = 'exam_p2.php?subject={$param['subject']}&suit={$param['suit']}&num={$row['number']}'>小题管理</a>";
                }
            }
            if($fl){
                /*
                $shtml = '';
                foreach($opts as $k => $opt){
                    if($opt['parentId']=='0'){
                        if($k==0){
                            $ops[$opt['id']][] = "<optgroup label='{$opt['title']}' >";
                        }else{
                            $ops[$opt['id']][] = "</optgroup><optgroup label='{$opt['title']}' >";
                        }
                    }else{
                        if($row['answer2']==$opt['title']){
                            $ops[$opt['parentId']][] = "<option value='{$opt['title']}' selected='selected'>{$opt['title']}</option>";
                        }else{
                            $ops[$opt['parentId']][] = "<option value='{$opt['title']}'>{$opt['title']}</option>";
                        }
                    }
                }
                foreach ($ops as $sss){
                    $shtml .= implode($sss);
                }
                 */
                $row['opts'] = $opts;
            }
            if(!isset($row['typeTitle'])){
                $row['typeTitle'] = "多选";
            }
        }
        echo json_encode($rows);
    } else {
        echo json_encode(array("error"=>"暂无数据","opts"=>$opts));
    }
}
function examp1($param, $conn){
    if(isset($param['type'])&&$param['type']=='del'){
        $sql = " delete from question_exam where id = {$param['id']} and suitId = {$param['suit']} and subjectId = {$param['subject']} and parentNumber = {$param['parent']} ";
    }else{
        if(isset($param['id'])){
            $sql = " update question_exam set number = {$param['number']},answer1 ='{$param['answer1']}',answer2 ='{$param['answer2']}',`right` ={$param['right']} "
            . " where id = {$param['id']} and suitId = {$param['suit']} and subjectId = {$param['subject']} and parentNumber = {$param['parent']}";
        }else{
            $sql = "insert into question_exam(suitId,subjectId,parentNumber,number,type,answer1,answer2,`right`) "
                    . " values({$param['suit']}, {$param['subject']},{$param['parent']},{$param['number']},1,'{$param['answer1']}','{$param['answer2']}',{$param['right']})";
        }
    }
    $rs = $conn->execute($sql);
    if ($rs) {
        echo '{"success":"ok"}';
    }else{
        jsonError("请求错误");
    }
}
function exam($param, $conn){
    if(empty($param['number'])||empty($param['subject'])||empty($param['suit'])||!is_numeric($param['number'])||!is_numeric($param['subject'])||!is_numeric($param['suit'])){
        jsonError("参数错误");
        return;
    }
    $exam = array("number"=>$param['number'],
        "subjectId"=>$param['subject'],
        "suitId"=>$param['suit'],
        "type"=>$param['type'],"content"=>$param['content'],
        "answer1"=>$param['answer1'],"answer2"=>$param['answer2'],"answer3"=>$param['answer3'],"answer4"=>$param['answer4'],
        "`right`"=>$param['right'],"`explain`"=>$param['explain']);
    
    if(isset($param['parent'])&&is_numeric($param['parent'])){
        $exam['parentNumber'] = $param['parent'];
    }else{
        $exam['parentNumber'] = "0";
    }
    if(empty($param['id'])){
        $rs0 = $conn->query("select * from question_exam where suitId = {$param['suit']}  and subjectId = {$param['subject']} and number = {$param['number']} and type= {$param['type']} and parentNumber = {$exam['parentNumber']} ");
        if($rs0->getRow()){
            jsonError("题号已经存在");
            return;
        }
    }
    
    if(isset($param['p1'])&&$param['p1']=='1'){//分录题
        $exam['`right`'] = null;
    }
    
    if(!empty($param['id'])&&is_numeric($param['id'])){
        $sql = parseSql($exam,$param['id']);
    }else{
        $sql = parseSql($exam,null);
    }
    $rs = $conn->execute($sql);
    if ($rs) {
        echo '{"success":"ok"}';
    } else {
        jsonError("保存失败");
    }
}

function delExam($param, $conn){
    $parent = "0";
    if(isset($param['parent'])){
        $parent = $param['parent'];
    }
    $rs = $conn->execute("delete from question_exam  where id = {$param['id']} and subjectId = {$param['subject']} and suitId = {$param['suit']} and parentNumber = $parent ");
    if ($rs) {
        echo '{"success":"ok"}';
    } else {
        jsonError("删除失败");
    }
}

function parseSql($param,$id){
    if(empty($id)){//新增
        $sql = "insert into question_exam(";
        $value = " values(";
        $i = 0;
        foreach ($param as $k=>$v){
            if($i>0) {
                $sql="$sql,";
                $value = "$value,";
            }
            $sql .= $k;
            $tv = trim($v);
            if($tv==''||$tv=='-'){
                $value .= 'null';
            }else if(is_numeric($tv)){
                $value .= "$tv";
            }else{
                $value .= "'$tv'";
            }
            $i++;
        }
        $sql .= ")";
        $value .= ")";
        return $sql.$value;
    }else{
        $sql = "update question_exam set ";
        $i = 0;
        $subject = $param['subjectId'];
        $suit = $param['suitId'];
        $parent = "0";
        if(isset($param['parentNumber'])){
            $parent = "{$param['parentNumber']} ";
            unset($param['parentNumber']);
        }
        unset($param['subjectId']);
        unset($param['suitId']);
        foreach ($param as $k=>$v){
            if($i>0) {
                $sql="$sql,";
            }
            $tv = trim($v);
            if($tv==''||$tv=='-'){
                $sql .= " $k = null ";
            }else if(is_numeric($tv)){
                $sql .=  " $k = $tv ";
            }else{
                $sql .= " $k = '$tv'";
            }
            $i++;
        }
        $sql .= "  where subjectId = $subject and suitId = $suit and id = $id and parentNumber = $parent";
        return $sql;
    }
}