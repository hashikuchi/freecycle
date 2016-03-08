<?php
    require_once('wp-load.php');
?>
<?php get_header('top'); ?>

<div class="BlackBoard" style='position:relative;'>
    <div class="title">
        <span>TexChangeからのお知らせ</span>
    </div>
    <div class="re-box" style='position: absolute;top: 26%; padding-left: 12%;'>
        <span>ただいまWebサイトはリニューアル中です</span><br>
        <span>情報はこちらから↓</span><br>
    </div>
    <div class="re-box2" style='position: absolute; top: 47%; padding-left: 17%;'>
        <span class="tw-botton" style='background-color: #00acee;padding: 7px;border-radius: 5px;box-shadow: 2px 2px 1px #444444;'><a href="https://twitter.com/texchg2" style="color' white;">Twitter公式アカウント</a></span>
    </div>
    <div class="bird-comment" style='position: absolute; bottom: 13%; padding-left: 19%;'>
        <span>少々お待ちくださいっぴ</span>
    </div>
    <img class="texban" style='width: 100%; height: auto;' src="<?php echo get_stylesheet_directory_uri() . '/images/texban.png'; ?>" />
</div>

<div class="ad-bookfair" style="width: 100%;background-color: #FDF5E6;padding: 10px 0;">
    <div class="card" style='width:80%;margin: 20px auto;background-color: white;border-radius: 2px;text-align: center;box-shadow: 2px 2px  1px #444444;'>
        <div class="card-title" style='padding: 15px 0 7px 0;'>
            <span style='font-size: 16px;font-weight: bolder;'>【南山大学にて古本市開催中】</span>
        </div>
        <div class="card-content" style='width: 90%;padding: 5px;margin: 0 auto;'>
            <span style='font-size:13px;'>教科書や小説等を無料で配付中！！</span><br>
            <span style='font-size:13px;'>読み終わった本の回収も行っています</span><br>
        </div>
        <div class="card-images">
            <img class="portrait" src="<?php echo get_stylesheet_directory_uri() .'/images/bookfair.jpg-large'; ?>" alt="" style='margin:10px 3px; width: 100px;
        	height: 120px;'/>
            <img class="landscape" src="<?php echo get_stylesheet_directory_uri() .'/images/bookfair2.jpg'; ?>" alt="" style='margin:10px 3px; width: 120px;
        	height: 100px;'/>
        </div>
        <div class="card-content" style='width: 90%;padding: 5px;margin: 0 auto;'>
            <table style='width: 100%; border: 1px black solid;'>
                <tr style='border: 1px black solid;'>
                    <th style='border: 1px black solid;'>開催日</th>
                    <th style='border: 1px black solid;'>毎週木曜日<br>(※会場の都合により、開催できない場合もございます)</th>
                </tr>
                <tr style='border: 1px black solid;'>
                    <th style='border: 1px black solid;'>時間</th>
                    <th style='border: 1px black solid;'>12:35 ~ 13:30</th>
                </tr>
                <tr>
                    <th style='border: 1px black solid;'>場所</th>
                    <th style='border: 1px black solid;'>南山大学G30</th>
                </tr>
            </table>
        </div>
        <div class="card-content">
            <span>ご来場お待ちしております！！</span>
        </div>
    </div>

    <div class="card"  style="width:80%;margin: 20px auto;background-color: white;border-radius: 2px;text-align: center;box-shadow: 2px 2px  1px #444444;padding-top: 5px;">
        <div class="card-title" style="padding: 15px 0 7px 0;">
            <span style="font-size: 16px;font-weight: bolder;">お問合わせはこちらへ</span>
        </div>
        <div class="card-content" style="width: 90%;padding: 5px;margin: 0 auto;">
            <span style="font-size: 13px;">texchange.ag@gmail.com</span>
        </div>
    </div>

</div>

<?php get_footer("top"); ?>
