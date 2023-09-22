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

  $("#start-btn").on("click", function () {
    // プレイヤー名取得
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


  // プレイヤーとディーラーの手札を管理するグローバル変数
  var g_playerHands = [];
  var g_dealerHands = [];


  // game画面に遷移後、プレイヤーとディーラーは手札を2枚引く
  $.ajax({
    type: 'GET',
    url: '/game/dealcard',
    dataType: 'json'

  }).done(function (response) {

    g_playerHands = response.playerHands;
    g_dealerHands = response.dealerHands;

    $.each(response.playerHands, function(i, playerHands) {
      $.each(playerHands, function(i, playerHand) {
        var imgElement = $("<img>");
        imgElement.attr("src", playerHand.image_path);
        $(".img.hand-area").append(imgElement);
      });
    });

    $.each(response.dealerHands, function(i, dealerHands) {
      $.each(dealerHands, function(i, dealerHand) {
        var imgElement = $("<img>");
            imgElement.attr("src", dealerHand.image_path);
            $(".img.dealer-hand-area").append(imgElement);
      });
    });
    
    console.log(g_playerHands);
    console.log(g_dealerHands);

    //ディーラー手札の1枚目に裏トランプカードを被せる
    var uraCard =  $(".img.dealer-hand-area img").eq(0);
    uraCard.data('custom-src' , uraCard.attr('src'));
    uraCard.attr('src' , '../img/img_ura.png');

  }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
    alert("Ajax通信が失敗しました。エラー: " + errorThrown);
  });



  // HITボタンがクリックされたとき
  // g_playerHandsに手札を1枚追加する
  $(".hit").on("click", function () {

    const hitFlag = $('input[name="hit"]').val();
    const hitFlagData = {
      hit: hitFlag
    };

    $.ajax({
      type: 'POST',
      url: '/game/hit',
      data: hitFlagData,
      dataType: 'json',
    }).done(function (response) {

      g_playerHands = g_playerHands.concat(response.playerHands);

      $.each(response.playerHands, function(i, playerHands) {
        $.each(playerHands, function(i, playerHand) {
          var imgElement = $("<img>");
          imgElement.attr("src", playerHand.image_path);
          $(".img.hand-area").append(imgElement);
        });
      });
      console.log(g_playerHands);

    }).fail(function (response, errorThrown) {
      alert("Ajax通信が失敗しました。エラー: " + errorThrown);
    });

  });



  // STANDボタンがクリックされたとき
  // g_playerHandsとg_dealerHandsをPOSTする
  $(".stand").on("click", function () {

    // ディーラーの手札オープン
    var uraCard =  $(".img.dealer-hand-area img").eq(0);
    var customSrc = uraCard.data('custom-src');
    uraCard.attr('src' , customSrc);

    
    console.log(g_dealerHands);


    // 合計値が17以上になるまでカードを引く
    var total = 0;
    while (total <= 17) {
      total = calculateTotal();
      if (total <= 17) {
        drawDealer();
      }
    }

    stand();

    // 手札オープン後のディーラーの手札合計値を求める
    function calculateTotal() {
     
      for (var i = 0; i < g_dealerHands.length; i++) {
        var number = g_dealerHands[i][0].number;
        if(number >= 11 && number <= 13) {
          number = 10;
        }
        total += number;
      }
      console.log("合計値: " + total);
      return total;
    }


    function drawDealer() {
      $.ajax({
        type: 'POST',
        url: '/game/hit',
        dataType: 'json',
      }).done(function (response) {
  
        g_dealerHands = g_dealerHands.concat(response.dealerHands);
  
        $.each(response.dealerHands, function(i, dealerHands) {
          $.each(dealerHands, function(i, dealerHand) {
            var imgElement = $("<img>");
                imgElement.attr("src", dealerHand.image_path);
                $(".img.dealer-hand-area").append(imgElement);
          });
        });
        console.log(g_dealerHands);
    
      }).fail(function (response, errorThrown) {
        alert("Ajax通信が失敗しました。エラー: " + errorThrown);
      });
    
    }

    
    function stand() {

      var requestData = {
        playerHands : g_playerHands,
        dealerHands : g_dealerHands
      };
  
      console.log(requestData);

      $.ajax({
        type: 'POST',
        url: '/game/stand',
        data: requestData
      }).done(function (response) {
  
      }).fail(function (response, errorThrown) {
        alert("Ajax通信が失敗しました。エラー: " + errorThrown);
      });
    }
    
  });



  // SURRENDERボタンがクリックされたとき
  // g_playerHandsの配列の数とnumberの合計値をPOSTする
  $(".surrender").on("click", function () {
    $.ajax({
      type: 'POST',
      url: '/game/surrender'
    }).done(function (data) {

    }).fail(function (data) {
      alert("Ajax通信が失敗しました。エラー: " + errorThrown);
    });
  });


  // STARTボタンがクリックされたときの処理
  $(".start").on("click", function() {

    // 現在の日付と時刻を取得
    const currentDate = new Date();
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