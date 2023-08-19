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
  });
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
function reset() {
  document.modal-form.reset();
}

// ヒットボタンがクリックされたとき
$(".hit").on("click", function() {
  $.ajax({
    type: 'POST',
    url: '/game'
  }).done(function(data){
      // 成功したら以下の処理を行う
      console.log(data);

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
    
    // let cardCount = 0 ;
    // // ヒットボタンがクリックされたときの処理
    // $(".hit").on("click", function() {
    //   $.ajax({
    //     type: 'POST',
    //     url: '/game/drowCard'
    //   }).done(function(data){
    //       alert('ajax成功!');
    //   }).fail(function(data){
    //       alert('ajax失敗');
    //   });      if (cardCount < cards.length) {
    //     // ランダムなカードを選択
    //     const selectedCard = cards[cardCount];
  
    //     // カードの画像を表示
    //     // const cardImage = `<img src="../../img/img_${selectedCard.rank}-${selectedCard.suit}.png" alt="card">`;
  
    //     // プレイヤーの手札にカードを追加して表示
    //     const playerHand = $(".player li:last-child .img");
    //     if (cardCount > 0) {
    //       const marginRight = 10 * cardCount; // ずらし量を計算
    //       playerHand.css("margin-right", `${marginRight}px`); // ずらし量を適用
    //     }
    //     playerHand.append(cardImage);
  
    //     // 表示したカードの数をインクリメント
    //     cardCount++;
    //   }
    // });

    //   // スタンドボタンがクリックされたときの処理
    // $(".stand").on("click", function() {
      
    // });

    //   // サレンダーボタンがクリックされたときの処理
    // $(".surrender").on("click", function() {

    // });

    //   // 退出するボタンがクリックされたときの処理
    // $(".leaving").on("click", function() {
    //     // ゲーム画面を隠す処理を実装する
    //     $("#game").hide();
    // });





