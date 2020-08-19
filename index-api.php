<?php
   $keyword ='';
   $response = null;

   $url='https://app.rakuten.co.jp/services/api/IchibaItem/Search/20170706';

   $params = [
        'format' => 'json',
        'applicationId' => '1001694101497813118',
        'hits' => 15,
        'imageFlag' => 1
    ];

    if(array_key_exsists('keyword' , $_post)){
     $keyword = $_POST['keyword'];
     $response_json=execute_api($url , $keyword , $params);
     $response= execute_json($response_json);
    }

    function execute_api($url , $keyword , $params){
        $query= http_build_query($params , "" , "&" );
        $search_url = $url . '?' . $query . '&keyword=' . $keyword;

        return file_get_contents($search_url);
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <title>Test-API</title>
</head>
<body>
    <div class="wrapper">
        <div class="main">
            <div class="main-body">
                <form action="index-api.php" method="post">
                    <label for="keyword">検索</label>
                    <input type="text" name="keyword" class="form-control"/>
                </form>
                <?php if($response->hits>0){?>
                    <h2 class="col-sm-10">
                        検索ワード：<?php print htmlspecialchars("keyword" , ENT_QUOTES , "UTF-8")?>
                    </h2>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">商品名</th>
                            <th scope="col">画像</th>
                            <th scope="col">価格</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($response->Item as $item) {?>
                            <tr>
                            <th scope="row">1</th>
                            <td><?php print htmlspecialchars($item->Item->itemName , ENT_QUOTES , 'UTF-8') ?></td>
                            <td>
                                <img src="<?php print htmlspecialchars($item->Item->smallImageUrls[0]->imageUrl , ENT_QUOTES , 'UTF-8') ?>">
                            </td>
                            <td>@mdo</td>
                            </tr>
                <?php } ?>
                        </tbody>
                </table>
            </div>
            <?php } else { ?>
                <p>お探しの商品は見当たりませんでした。</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>
