/* /////////////////////////////////////////////////////////
    contact.js
///////////////////////////////////////////////////////// */
(function($){
  $(function(){

      // 数値キーボードを変更させるための設定
      $('#phone').attr('type', 'tel');


      // 確認ボタンの初期状態設定
      checkPrivacyCheckbox();

      // 「同意する」チェックボックスの状態変化を監視
      $('input[name="privacy[]"]').change(function() {
          checkPrivacyCheckbox();
      });


  });
})(jQuery);

// 「同意する」チェックボックスの状態に応じて確認ボタンの有効/無効を切り替える関数
function checkPrivacyCheckbox() {
  if ($('input[name="privacy[]"]').is(':checked')) {
    // チェックされたら確認ボタンを有効化
    $('#submit input[type=submit]').prop('disabled', false);
  } else {
    // チェックされていなければ確認ボタンを無効化
    $('#submit input[type=submit]').prop('disabled', true);
  }
}
