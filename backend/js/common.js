$(document).ready(function () {
  // BET、クレジット表示
  $('.coin').click(function () {
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
  $("#start-btn").on("click", function () {
    var playerName = $("#textbox").val();
    $("#player-name").val(playerName);
  });

  // モーダルウィンドウ
  $('.js-open').on('click', function () {
    $('.js-modal').addClass('open');
    $('.js-overlay').addClass('open');
    return false;
  });
  $('.js-close').on('click', function () {
    $('.js-modal').removeClass('open');
    $('.js-overlay').removeClass('open');
  });


  // HITボタンがクリックされたとき
  $(".hit").on("click", function () {
    $.ajax({
      type: 'POST',
      url: '/game/hit'
      // data: postData
    }).done(function (data) {
      //   // 成功したらカードのDOMを作成し、要素を追加する
      // alert("event called")
    }).fail(function (data) {
      alert("Ajax通信が失敗しました。エラー: " + errorThrown);
    });

  });


  // STANDボタンがクリックされたとき
  $(".stand").on("click", function () {
    $.ajax({
      type: 'POST',
      url: '/game/stand',
    }).done(function (data) {
      // 成功したら以下の処理を行う

    }).fail(function (data) {
      alert("Ajax通信が失敗しました。エラー: " + errorThrown);
    });
  });


  // SURRENDERボタンがクリックされたとき
  $(".surrender").on("click", function () {
    $.ajax({
      type: 'POST',
      url: '/game/surrender'
    }).done(function (data) {
      // 成功したら以下の処理を行う

    }).fail(function (data) {
      alert("Ajax通信が失敗しました。エラー: " + errorThrown);
    });
  });

  // STARTボタンがクリックされたときの処理
  $(".start").on("click", function() {

    // 現在の日付と時刻を取得
    const currentDate = new Date();

    // 年、月、日、時、分、秒を取得
    const year = currentDate.getFullYear();
    const month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
    const day = currentDate.getDate().toString().padStart(2, '0');
    const hours = currentDate.getHours().toString().padStart(2, '0');
    const minutes = currentDate.getMinutes().toString().padStart(2, '0');
    const seconds = currentDate.getSeconds().toString().padStart(2, '0');

    // 形式に合わせて日付を組み立て
    const formattedDate = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;

    const playerName = $("#textbox").val();
    const bet = $('#new-bet').val();
    const credit = $('#new-credit').val();

    const requestData = {
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

  // 退出ボタンがクリックされたとき
  $(".button").on("click", function() {
    $.ajax({
      type: 'POST',
      url: '/game/exit'
    }).done(function(data){
        // 成功したら以下の処理を行う
        window.location.href = "http://localhost:8080/";
    }).fail(function(data){
      alert("Ajax通信が失敗しました。エラー: " + errorThrown);
    });
  });
});
