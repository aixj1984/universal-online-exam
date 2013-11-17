<?php
require_once '../../../../../class/autoload.inc';

$test_type = new test_type();
$test_type_panel = $test_type->getTestTypePanel();

if (isset($_POST["quetext"])) {
    $question = new question();
    $result = $question->addMulSel($_POST["quetext"], $_POST["deg"]);
} elseif (isset($_POST["sinque"])) {
    $question = new question();
    $result = $question->addOneSel($_POST["sinque"], 
            $_POST["sela"], $_POST["selb"], $_POST["selc"], $_POST["seld"], 
            $_POST["chos"], $_POST["deg"]);
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="../../../../js/jquery-1.9.0.js" type='text/javascript'></script>
        <script src="../../../../jquery-ui/js/jquery-ui-1.10.1.custom.js" type='text/javascript'></script>
        <script src="../../../../js/common.js" type='text/javascript'></script>
        <script src="index.js" type='text/javascript'></script>
        <link rel="stylesheet" href="../../../../jquery-ui/development-bundle/themes/sunny/jquery-ui.css" />
        <link rel="stylesheet" href="common.css" />
        <title>添加选择题</title>
    </head>
    <body>
        <script language="javascript">
            <?php
            if (isset($result)){
                echo "
                    $(function(){
                        $('#dialog').html('$result').dialog('open');
                    });";
            }
            ?>
            function alert(error){
                $('#dialog').html(error).dialog('open');
            }
            function trim(str) {
                posL = 0;
                posR = str.length - 1;
                while (str.charAt(posL) == ' ' && posL <= posR)
                    posL++;
                while (str.charAt(posR) == ' ' && posL <= posR)
                    posR--;
                if (posL > posR)
                    return "";
                return str.substring(posL, posR + 1);
            }
            function checkOne() {
                if (trim(document.getElementById("sinque").value) == "")
                {
                    alert("上传题目不能为空!");
                    document.getElementById("sinque").focus();
                    return false;
                }
                if (trim(document.getElementById("sela").value) == "" || trim(document.getElementById("selb").value) == "" ||
                        trim(document.getElementById("selc").value) == "" || trim(document.getElementById("seld").value) == "") {
                    alert("上传选项不能为空!");
                    return false;
                }
                if (trim(document.getElementById("chos").value) == "")
                {
                    alert("上传题目答案未选择!");
                    document.getElementById("chos").focus();
                    return false;
                }
                return true;
            }
            function check() {
                text = document.getElementById("quetext").value;
                if (trim(text) == "" || text.indexOf("#Q", 0) == -1)
                {
                    alert("上传题目不能为空!");
                    document.getElementById("quetext").focus();
                    return false;
                }

                pos1 = 0;
                pos = text.indexOf("#Q", 0);
                while (pos != -1) {
                    pos1 = text.indexOf("#", pos + 2);
                    if (pos1 == -1) {
                        alert("格式错误: #Q与#标志不匹配!");
                        return false;
                    }
                    if (pos1 == pos + 2) {
                        alert("格式错误: #Q与 #之间没有题目!");
                        return false;
                    }
                    pos = pos1;
                    for (i = 1; i <= 4; i++) {
                        pos = text.indexOf("#", pos + 1);
                        if (pos == -1) {
                            alert("格式错误：题目选项不足！");
                            return false;
                        }
                    }
                    if (pos == text.length - 1) {
                        alert("格式错误：#后面没有答案！");
                        return false;
                    }

                    if (text.charAt(pos + 1) != 'A' && text.charAt(pos + 1) != 'B' && text.charAt(pos + 1) != 'C' && text.charAt(pos + 1) != 'D') {
                        alert("格式错误: #后面后面答案错误,应为ABC或D!");
                        return false;
                    }
                    pos = text.indexOf("#Q", pos + 1);
                }
            }
        </script>
        <div id="bod">
            <div id="bodin">
                <div id="header">
                </div>
                <div>
                    <div>
                        <br />
                        <fieldset>
                            <legend class="m"> 添加单个选择题 </legend>
                            <form action="addSelQue.php" method="post"
                                  onsubmit="return checkOne();">
                                    <?= $test_type_panel ?>
                                <br />
                                <span>题目:</span>
                                <br />
                                <textarea cols="80" name="sinque"  rows="3" id="sinque"></textarea>
                                <br />
                                <span>A:</span>
                                <input type="text" id="sela" name="sela" value="" />
                                <br />
                                <span>B:</span>
                                <input type="text" id="selb" name="selb" value="" />
                                <br />
                                <span>C:</span>
                                <input type="text" id="selc" name="selc" value="" />
                                <br />
                                <span>D:</span>
                                <input type="text" id="seld" name="seld" value="" />
                                <br />
                                <div class="d">
                                    <input type="radio" name="chos" id="chos" value="A" checked />
                                    A
                                    <input type="radio" name="chos" id="chos" value="B" />
                                    B
                                    <input type="radio" name="chos" id="chos" value="C" />
                                    C
                                    <input type="radio" name="chos" id="chos" value="D" />
                                    D
                                </div>
                                <input type="submit" id="conf1" value="确定单个上传" />
                            </form>
                        </fieldset>

                    </div>

                    <br />
                    <hr/>

                    <br />

                    <div>
                        <fieldset>
                            <legend class="m"> 批量添加选择题 </legend>
                            <form action="addSelQue.php" method="post"
                                  onsubmit="return check();">
                                    <?= $test_type_panel ?>
                                <br />
                                <span>上传文本:</span>
                                <br />
                                <div>
                                    <div>
                                        <textarea tabindex="1" accesskey="1" name="quetext" cols="80"
                                                  rows="25" id="quetext" title=""></textarea>
                                    </div>
                                    <div>
                                        <input type="submit" id="conf2" value="确认批量上传" />
                                    </div>
                                </div>
                            </form>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
        <div id="dialog" title="message"> </div>
    </body>
</html>
