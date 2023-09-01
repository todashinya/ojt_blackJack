$(document).ready(function() {
  // BET、クレジット表示
  $('.coin').click(function(){
    const coinValue = parseInt($(this).find('input').val());
    const currentBet = parseInt($('.js-bet span').text());
    const currentCredit = parseInt($('.js-credit span').text());
    var newBet = currentBet + coinValue;
    var newCredit = currentCredit - coinValue;
    $('.js-bet span').text(newBet);
    $('.js-credit span').text(newCredit);

    // 隠しフィールドにnewBetとnewCreditの値を設定
    $('#new-bet').val(newBet);
    $('#new-credit').val(newCredit);
  });

  // プレイヤー名取得
$("#start-btn").on("click", function() {
  var playerName = $("#textbox").val();
  $("#player-name").val(playerName);
});

  // モーダルウィンドウ
  $('.js-open').on('click', function() {
      $('.js-modal').addClass('open');
      $('.js-overlay').addClass('open');
      return false; 
  });
  $('.js-close').on('click', function() {
      $('.js-modal').removeClass('open');
      $('.js-overlay').removeClass('open');
  });
    

  // HITボタンがクリックされたとき
  $(".hit").on("click", function() {
    $.ajax({
      type: 'POST',
      url: '/game/hit'
    }).done(function(data){
      //   // 成功したら以下の処理を行う
    }).fail(function(data){
      alert("Ajax通信が失敗しました。エラー: " + errorThrown);
    });

  });

  // STANDボタンがクリックされたとき
  $(".stand").on("click", function() {
    $.ajax({
      type: 'POST',
      url: '/game/stand'
    }).done(function(data){
        // 成功したら以下の処理を行う

    }).fail(function(data){
      alert("Ajax通信が失敗しました。エラー: " + errorThrown);
    });
  });


  // SURRENDERボタンがクリックされたとき
  $(".surrender").on("click", function() {
    $.ajax({
      type: 'POST',
      url: '/game/surrender'
    }).done(function(data){
        // 成功したら以下の処理を行う
    }).fail(function(data){
      alert("Ajax通信が失敗しました。エラー: " + errorThrown);
    });
  });

  // STARTボタンがクリックされたときの処理
  $(".start").on("click", function() {

    // 現在の日付と時刻を取得
    var currentDate = new Date();

    // 年、月、日、時、分、秒を取得
    var year = currentDate.getFullYear();
    var month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
    var day = currentDate.getDate().toString().padStart(2, '0');
    var hours = currentDate.getHours().toString().padStart(2, '0');
    var minutes = currentDate.getMinutes().toString().padStart(2, '0');
    var seconds = currentDate.getSeconds().toString().padStart(2, '0');

    // 形式に合わせて日付を組み立て
    var formattedDate = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;

    var playerName = $("#textbox").val();
    var bet = $('#new-bet').val();
    var credit = $('#new-credit').val();

    var requestData = {
      name: playerName,
      bet: bet,
      credit: credit,
      startDate: formattedDate
    };

    console.log(requestData);

    $.ajax({
      type: 'POST',
      url: '/home/register',
      data: requestData
    }).done(function(data){
      // 成功したら以下の処理を行う
      window.location.href = "http://localhost:8080/game";

    }).fail(function(data){
      alert("Ajax通信が失敗しました。エラー: " + errorThrown);
    });
    // モーダルウィンドウを非表示にする
    $(".js-modal").hide();
    $(".js-overlay").hide();
  });
});
