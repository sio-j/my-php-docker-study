<?php
// フォームからデータがPOST送信された場合に実行される
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8");
    $comment = htmlspecialchars($_POST["comment"], ENT_QUOTES, "UTF-8");
    $time = date("Y-m-d H:i:s");

    // 2. 名前無しなら「名無し」にする
    if ($name === "") {
        $name = "名無し";
    } else {
        $name = htmlspecialchars($name, ENT_QUOTES, "UTF-8");
    }

    $line = $time.",".$name.",".$comment."\n";
    file_put_contents("data.txt", $line, FILE_APPEND);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>たぬき速報</title>
    <style>
        /* 全体の基本デザイン */
        *{
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background-color: #F5F5DC;
        }
        /* 見出し（タイトル）の装飾 */
        .komoku{
           background-color: #d15f1d;
           padding: 20px;
           margin: 0 auto;
           text-align: center;
           border: 0.5rem solid;
           border-radius: 20px;
        }
        /* 投稿欄見出しの左寄せ調整 */
        .reft-align{
            text-align: left;
            margin-left: 0;
            padding: 15px;

        }
        
    </style>
</head>

<body>
    <h1 class="komoku">たぬき掲示板</h1>

    <form method="POST">
        <p>名前 &emsp;: <input type="text" name="name" ></p>
        <p>コメント : <input type="text" name="comment" required></p>
        <button type="submit">送信する</button>
    </form>

    <hr>

    <h2 class="komoku reft-align">投稿欄</h2>

    <?php
    // 保存ファイルが存在する場合のみ読み込み処理を行う
    if (file_exists("data.txt")) {
        $lines = file("data.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $count = count($lines); // 全体の件数を数える

        foreach (array_reverse($lines) as $line) {
            $data = explode(",", $line);
            if (count($data) === 3) {
                list($t, $n, $c) = $data;
                // $count を使って番号を表示
                echo "<p>{$count}. <strong>$n</strong> [$t] <br> $c</p><hr>";
                $count--; // 1つずつ減らしていく
            }
        }
    }
    ?>
</body>

</html>