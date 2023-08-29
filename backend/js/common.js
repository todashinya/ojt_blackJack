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
// モーダル内のフォームが送信される際にプレイヤー名も合わせて送信
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
    $.ajax({
      type: 'POST',
      url: '/home/register'
    }).done(function(data){
        // 成功したら以下の処理を行う
        window.location.href = 'http://localhost:8080/game';
      }).fail(function(data){
        alert("Ajax通信が失敗しました。エラー: " + errorThrown);
      });
    // モーダルウィンドウを非表示にする
    $(".js-modal").hide();
    $(".js-overlay").hide();
  });
});





