$(document).ready(function() {
    // BET、クレジット表示
    var initialBet = parseInt($('.js-bet span').text());//初期ベット金額取得

    $('.coin-input').click(function() {
        var coinValue = parseInt($(this).val());//選択コイン額
        var currentBet = parseInt($('.js-bet span').text());//現在のベット金額の取得
        var currentCredit = parseInt($('.js-credit span').text());//現在のクレジット金額の取得

        if ($(this).is(':checked')) {
            if (currentCredit >= coinValue + initialBet) {
                var newBet = currentBet + coinValue;//現在ベット額＋選択コイン額
                var newCredit = currentCredit - coinValue;
                $('.js-bet span').text(newBet);
                $('.js-credit span').text(newCredit);
            } else {
                $('.js-credit').text('クレジットが不足しています');
                $(this).prop('checked', false);
            }
        } else {
            var newBet = currentBet - coinValue;
            var newCredit = currentCredit + coinValue;
            $('.js-bet span').text(newBet);
            $('.js-credit span').text(newCredit);
            $('.js-credit').text('＄' + newCredit);
        }
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
});




