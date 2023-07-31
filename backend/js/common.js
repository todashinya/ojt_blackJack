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

//アクションボタン 
  //カードのデータを用意
    const cards = [
      // ハート
      { suit : 'heart' , rank : '2'},
      { suit : 'heart' , rank : '3'},
      { suit : 'heart' , rank : '4'},
      { suit : 'heart' , rank : '5'},
      { suit : 'heart' , rank : '6'},
      { suit : 'heart' , rank : '7'},
      { suit : 'heart' , rank : '8'},
      { suit : 'heart' , rank : '9'},
      { suit : 'heart' , rank : '10'},
      { suit : 'heart' , rank : 'J'},
      { suit : 'heart' , rank : 'Q'},
      { suit : 'heart' , rank : 'K'},
      { suit : 'heart' , rank : 'A'},
      // スペード
      { suit : 'spade' , rank : '2'},
      { suit : 'spade' , rank : '3'},
      { suit : 'spade' , rank : '4'},
      { suit : 'spade' , rank : '5'},
      { suit : 'spade' , rank : '6'},
      { suit : 'spade' , rank : '7'},
      { suit : 'spade' , rank : '8'},
      { suit : 'spade' , rank : '9'},
      { suit : 'spade' , rank : '10'},
      { suit : 'spade' , rank : 'J'},
      { suit : 'spade' , rank : 'Q'},
      { suit : 'spade' , rank : 'K'},
      { suit : 'spade' , rank : 'A'},
      // ダイヤ
      { suit : 'diamond' , rank : '2'},
      { suit : 'diamond' , rank : '3'},
      { suit : 'diamond' , rank : '4'},
      { suit : 'diamond' , rank : '5'},
      { suit : 'diamond' , rank : '6'},
      { suit : 'diamond' , rank : '7'},
      { suit : 'diamond' , rank : '8'},
      { suit : 'diamond' , rank : '9'},
      { suit : 'diamond' , rank : '10'},
      { suit : 'diamond' , rank : 'J'},
      { suit : 'diamond' , rank : 'Q'},
      { suit : 'diamond' , rank : 'K'},
      { suit : 'diamond' , rank : 'A'},
      // クローバー
      { suit : 'club' , rank : '2'},
      { suit : 'club' , rank : '3'},
      { suit : 'club' , rank : '4'},
      { suit : 'club' , rank : '5'},
      { suit : 'club' , rank : '6'},
      { suit : 'club' , rank : '7'},
      { suit : 'club' , rank : '8'},
      { suit : 'club' , rank : '9'},
      { suit : 'club' , rank : '10'},
      { suit : 'club' , rank : 'J'},
      { suit : 'club' , rank : 'Q'},
      { suit : 'club' , rank : 'K'},
      { suit : 'club' , rank : 'A'},
      // ジョーカー
      { suit : 'joker' , rank : 'joker'},
    ]
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
    
    let cardCount = 0 ;
    // ヒットボタンがクリックされたときの処理
    $(".hit").on("click", function() {
      if (cardCount < cards.length) {
        // ランダムなカードを選択
        const selectedCard = cards[cardCount];
  
        // カードの画像を表示
        // const cardImage = `<img src="../../img/img_${selectedCard.rank}-${selectedCard.suit}.png" alt="card">`;
  
        // プレイヤーの手札にカードを追加して表示
        const playerHand = $(".player li:last-child .img");
        if (cardCount > 0) {
          const marginRight = 10 * cardCount; // ずらし量を計算
          playerHand.css("margin-right", `${marginRight}px`); // ずらし量を適用
        }
        playerHand.append(cardImage);
  
        // 表示したカードの数をインクリメント
        cardCount++;
      }
    });

      // スタンドボタンがクリックされたときの処理
    $(".stand").on("click", function() {
      
    });

      // サレンダーボタンがクリックされたときの処理
    $(".surrender").on("click", function() {

    });

      // 退出するボタンがクリックされたときの処理
    $(".leaving").on("click", function() {
        // ゲーム画面を隠す処理を実装する
        $("#game").hide();
    });





