
    <div id="insert_bookfair_info_area">
        <h3>古本市の予定入力欄</h3>
        <span class="bookfair_label" style="font-size:15px;color:darkorange;">１．開催日、開始時間、終了時間を指定する</span></br>
        <input type="text" placeholder="クリックして開催日を選択" id="bookfair_date" class="bookfair_day"/></br>
        <input type="text" placeholder="クリックして開始時間を選択" id="start_bookfair_time" class="bookfair_day"/>
        <input type="text" placeholder="クリックして終了時間を選択" id="end_bookfair_time" class="bookfair_day"/></br>
        <span class="bookfair_label" style="font-size:15px;color:darkorange;">２．古本市開催場所を指定する</span></br>
        <select id="bookfair_place">
            <option>南山大学G30</option>
        </select>
        <input type="text" placeholder="選択肢にない場合に入力" id="other_place"/>
        </br>
        <div class="button_position">
            <input type="submit" value="入力完了" id="insert_bookfair_info"/>
        </div>
    </div>

    <div id="bookfair_table">
        <h3>古本市予定一覧</h3>
        <!-- ↓古本市の予定表 -->
        <?php show_bookfair_info_of_all_after_today(); ?>
    </div>
</body>



 

 


