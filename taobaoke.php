<?php 
    $id = $_GET['id'];
    $app_key = ""; 
    $secret = "";
    $timestamp = time() . "000";
    $message = $secret . 'app_key' . $app_key . 'timestamp' . $timestamp . $secret;
    $mysign = strtoupper(hash_hmac("md5", $message, $secret));
    setcookie("timestamp", $timestamp);
    setcookie("sign", $mysign);
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="http://l.tbcdn.cn/apps/top/x/sdk.js?appkey=<?php echo $app_key;?>"></script>
    <style>
        #div {display:none;}
        #span {margin-left:20px;}
	#p {display:none;}
    </style>
</head>
<body>
    <div id="div">
        <label>commission</label><span id="span"></span><br/>
        <a id="link" href="javascript:void(0);">open</a>
    </div>
    <p id="p"></p>
    <script>
        TOP.api('rest', 'post',{
            method:'taobao.taobaoke.widget.items.convert',
            fields:'num_iid,title,nick,pic_url,price,click_url,commission,commission_rate,commission_num,commission_volume,shop_click_url,seller_credit_score,item_location,volume ',
            num_iids:'<?php echo $id;?>' 
        },function(res){                 
            if(res.total_results == 0){
                document.getElementById("p").style.display = "block";
                document.getElementById("p").innerHTML = "This one has no commision";
                return ;
            }

            if( res.error_response){
                document.getElementById("p").style.display = "block";
                document.getElementById("p").innerHTML = "There's something wrong with it";
                console.log(res.error_response.code, res.error_response.sub_msg);
            }
            else{
                var item=res.taobaoke_items.taobaoke_item[0];
                document.getElementById("span").innerHTML = item.commission;
                document.getElementById("link").onclick = function(){window.open(item.click_url);};
                document.getElementById("div").style.display = "block";
            }
        });
    </script>
</body>
</html>
