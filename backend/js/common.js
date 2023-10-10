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

    // console.log('newBet:', newBet);
    // console.log('newCredit:', newCredit);
  });

  $("#start-btn").on("click", function () {
    // プレイヤー名取得
    var playerName = $("#textbox").val();
    $("#player-name").val(playerName);    
  });

  // BET/credit選択モーダルウィンドウ
  $('.js-open').on('click', function () {
    betOpenModal ();
    return false;
  });
  $('.js-close').on('click', function () {
    betCloseModal ()
  });

  // 勝敗後モーダルウィンドウ
  $('.js-issue-close').on('click', function () {
    $('.js-issue-modal').removeClass('open');
    $('.js-issue-overlay').removeClass('open');
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

    console.log(response);

    $.each([response.playerHands], function(i, playerHands) {
      $.each(playerHands, function(j, playerHand) {
        var imgElement = $("<img>");
        imgElement.attr("src", playerHand.image_path);
        $(".img.hand-area").append(imgElement);
      });
    });

    $.each([response.dealerHands], function(i, dealerHands) {
      $.each(dealerHands, function(j, dealerHand) {
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

      $.each([response.playerHands], function(i, playerHands) {
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

    // 現時点での手札をajaxでPOST
    var requestData = {
      playerHands : g_playerHands,
      dealerHands : g_dealerHands,
    };
    
    $.ajax({
      type: 'POST',
      url: '/game/stand',
      data: requestData,
      dataType: 'json',
    }).done(function (response) {

      $(".img.dealer-hand-area").empty();

      // ディーラーは17までドローした結果を表示
      g_dealerHands = response.resultHands.dealerHands;

      console.log(g_dealerHands);
      
      $.each([g_dealerHands], function(i, dealerHands) {
        $.each(dealerHands, function(j, dealerHand) {
          var imgElement = $("<img>");
          imgElement.attr("src", dealerHand.image_path);
          $(".img.dealer-hand-area").append(imgElement);
        });
      });
      

      // resultCodeに応じてmodalを表示
      if (response.resultCode === 1) {
        openModal(response.message);
      } else if (response.resultCode === 2 ){
        openModal(response.message);
      } else if (response.resultCode === 3) {
        openModal(response.message);
      } else {
        openModal("エラーです");
      }

      const yesBtn = document.getElementById('yes-btn');
      const noBtn = document.getElementById('no-btn');

      // YESボタンがクリックされたらBET/Credit選択画面に移動
      yesBtn.addEventListener('click' , function(){
        $.ajax({
          url: '/', 
          type: 'GET', 
          dataType: 'html',
          success: function(data) {
            // 現ページbody要素に取得したhtmlデータを追加
            $('body').append(data);
            // モーダルを表示する処理をここに追加
            betOpenModal();
          },
          error: function() {
            console.error('HTMLの読み込みに失敗しました。');
          }
        });
      });

      //NOボタンをクリックしたらゲーム終了
      noBtn.addEventListener('click' , function(){
        $.ajax({
          type: 'POST',
          url: '/game/exit'
        }).done(function(data){
            // 成功したら以下の処理を行う
            window.location.href = "/";
        }).fail(function(data){
          alert("Ajax通信が失敗しました。エラー: " + errorThrown);
        });
      });
    
    }).fail(function (response, errorThrown) {
      alert("Ajax通信が失敗しました。エラー: " + errorThrown);
    });

  });

  // SURRENDERボタンがクリックされたとき
  // g_playerHandsの配列の数とnumberの合計値をPOSTする
  $(".surrender").on("click", function () {
    $.ajax({
      type: 'POST',
      url: '/game/surrender'
    }).done(function (response) {
      // 成功したら以下の処理を行う
      // checkWinOrLoseメソッドから結果メッセージを取得する
      // console.log(response);
      var resultCode = response.resultCode;
      var message = response.message;
      // resultCodeに応じてmodalを表示する
      // モーダル処理を関数にまとめる
      if (resultCode === 4) {
        openModal(message);
      } 

      const yesBtn = document.getElementById('yes-btn');
      const noBtn = document.getElementById('no-btn');
      // YESボタンがクリックされたらBET/Credit選択画面に移動
      yesBtn.addEventListener('click' , function(){
        $.ajax({
          url: '/', 
          type: 'GET', 
          dataType: 'html',
          success: function(data) {
            // 現ページbody要素に取得したhtmlデータを追加
            $('body').append(data);
            // モーダルを表示する処理をここに追加
            betOpenModal();
          },
          error: function() {
            console.error('HTMLの読み込みに失敗しました。');
          }
        });
      });
      //NOボタンをクリックしたらゲーム終了
      noBtn.addEventListener('click' , function(){
        $.ajax({
          type: 'POST',
          url: '/game/exit'
        }).done(function(data){
            // 成功したら以下の処理を行う
            window.location.href = "/";
        }).fail(function(data){
          alert("Ajax通信が失敗しました。エラー: " + errorThrown);
        });
      });
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
  
      // // 形式に合わせて日付を組み立て
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
      window.location.href = "/game";

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
        window.location.href = "/";
    }).fail(function(data){
      alert("Ajax通信が失敗しました。エラー: " + errorThrown);
    });
  });
});


////////////////////////////////////////////////
//関数処理
////////////////////////////////////////////////

function openModal(message) {
//モーダルの表示
const issueOverlay = document.getElementById('issue-overlay');
const issueModal = document.getElementById('issue-modal');
  issueOverlay.classList.add("open");
  issueModal.classList.add("open");

//勝敗メッセージの表示
const issueContent = document.getElementById('issue-content');
const issueContent_p = document.getElementById('p1');
const issueMessage = document.createElement('p');
  issueMessage.textContent = message;
  issueContent.insertBefore(issueMessage,issueContent_p);
}


function betOpenModal () {
    $('.js-modal').addClass('open');
    $('.js-overlay').addClass('open');
  }

function betCloseModal () {
  $('.js-modal').removeClass('open');
  $('.js-overlay').removeClass('open');
}