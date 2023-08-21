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
$("#modal-form").submit(function(event) {
  var playerName = $("#textbox").val();
  $("#player-name").val(playerName);
});

// モーダルウィンドウ
    $('.js-open').on('click', function() {
        $('.js-modal').addClass('open');
        $('.js-overlay').addClass('open');
        return false; // フォームのサブミットを防止
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
      // 成功したら以下の処理を行う

    // アニメーション対象の画像要素を選択
    const targetImage1 = $(".player-item .img").eq(0); 
    const targetImage2 = $(".player-item .img").eq(1); 
    const targetImage3 = $(".player-item .img").eq(2); 
    const targetImage4 = $(".player-item .img").eq(3); 
      
    // 画像を少しずつずらして表示させるアニメーション
    targetImage4.animate({ left: '-=30px' }, 500); 
    targetImage3.animate({ left: '-=25px' }, 500); 
    targetImage2.animate({ left: '-=80px' }, 500); 
    targetImage1.animate({ left: '-=0px' }, 500); 

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
    $(".player li .img").empty();
    $(".dealer li .img").empty().removeClass("card-back");
  
    // プレイヤーのli要素に対して2枚のカードを追加する
  $(".player li").each(function(index) {
    for (let i = 0; i < 2; i++) {
      const selectedCard = cards[index * 2 + i];
      const cardImage = `<img src="../../img/img_${selectedCard.rank}-${selectedCard.suit}.png" alt="card">`;
      const playerHand = $(this).find(".img");
      if (i > 0) {
        const marginRight = 10 * i; // ずらし量を計算
        playerHand.css("margin-right", `${marginRight}px`); // ずらし量を適用
      }
      playerHand.append(cardImage);
    }
  });
  
  // ディーラーのli要素に対して2枚のカードを追加する
    $(".dealer li").each(function(index) {
      for (let i = 0; i < 2; i++) {
        const selectedCard = cards[index * 2 + i];
        const cardImage = `<img src="../../img/img_${selectedCard.rank}-${selectedCard.suit}.png" alt="card">`;

        const dealerHand = $(this).find(".img");
        if (i > 0) {
          const marginRight = 10 * i; // ずらし量を計算
          dealerHand.css("margin-right", `${marginRight}px`); // ずらし量を適用
        }
        dealerHand.append(cardImage);
      }
    });

    // モーダルウィンドウを非表示にする
    $(".js-modal").hide();
    $(".js-overlay").hide();
  });

});





