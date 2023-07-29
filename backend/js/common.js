$(document).ready(function() {
// BET、クレジット表示
  var initialBet = parseInt($('.js-bet span').text()); // 初期ベット金額取得

  $('.coin-value').click(function() {
    var coinValue = parseInt($(this).attr('data-value')); // 選択コイン額
    var currentBet = parseInt($('.js-bet span').text()); // 現在のベット金額の取得
    var currentCredit = parseInt($('.js-credit span').text()); // 現在のクレジット金額の取得

    if (currentCredit >= coinValue + initialBet) {
      var newBet = currentBet + coinValue; // 現在ベット額＋選択コイン額
      var newCredit = currentCredit - coinValue;
      $('.js-bet span').text(newBet);
      $('.js-credit span').text(newCredit);
    } else {
      $('.js-credit').text('クレジットが不足しています');
      $(this).prop('checked', false);
    }
    
    var newBet = currentBet - coinValue; // 現在のベット金額から選択コイン額を引く
    var newCredit = currentCredit + coinValue; // クレジットに選択コイン額を戻す
    $('.js-bet span').text(newBet);
    $('.js-credit span').text(newCredit);
    $('.js-credit').text('＄' + newCredit);


    // if ($(this).is(':checked')) {
    //     if (currentCredit >= coinValue + initialBet) {
    //       var newBet = currentBet + coinValue; // 現在ベット額＋選択コイン額
    //       var newCredit = currentCredit - coinValue;
    //       $('.js-bet span').text(newBet);
    //       $('.js-credit span').text(newCredit);
    //     } else {
    //       $('.js-credit').text('クレジットが不足しています');
    //       $(this).prop('checked', false);
    //     }
    //     } else {
    //     var newBet = currentBet - coinValue; // 現在のベット金額から選択コイン額を引く
    //     var newCredit = currentCredit + coinValue; // クレジットに選択コイン額を戻す
    //     $('.js-bet span').text(newBet);
    //     $('.js-credit span').text(newCredit);
    //     $('.js-credit').text('＄' + newCredit);
    // }
  });


    // $(".reset").on("click", function () {
    //     clearForm(this.form);
    //         function clearForm (form) {
    //             $(form)
    //                 .find("input")
    //                 .val("")
    //                 .prop("checked", false)
    //         }
    // });

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

//アクションボタン 
    // ヒットボタンがクリックされたときの処理
    $(".hit").on("click", function() {

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
});