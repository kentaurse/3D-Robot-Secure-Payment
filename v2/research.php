<?php
/*
Template Name: Research
*/
get_header();

$userid = $_GET['userid'];

if (!isset($_SESSION['apo_log_tkn'])) {
  header("Location: /login/?action=must_login&return_to=research&userid=$userid");
}

if (isset($_GET['status']) && $_GET['status'] == 'success') { ?>
  <div class="container" style="margin-top: 40px; display: flex; flex-direction: column; align-items: center; line-height: 1.4em; text-align: center">
    <p>調査を承りました。<br>
      3営業日以内に調査結果をメールにて<br>
      お知らせいたします。</p><br>
    <p>迷惑メールフォルダも<br>
      併せてご確認くださいませ。</p>
  </div>
<?php
} else {
  if (isset($_GET['userid']) && !empty($_GET['userid'])) {
    global $seconddb;
    $_email = $_SESSION['apo_log_mail'];
    $userid = $_GET['userid'];

    $company = $seconddb->get_var("SELECT company FROM userlist WHERE userid = '$userid'");
    $pref = $seconddb->get_var("SELECT pref FROM userlist WHERE userid = '$userid'");
    $city = $seconddb->get_var("SELECT city FROM userlist WHERE userid = '$userid'");
    $addr = $seconddb->get_var("SELECT addr FROM userlist WHERE userid = '$userid'");
    $address = $pref . $city . $addr;

    $company_name = $seconddb->get_var("SELECT company_name FROM vendor WHERE email='$_email'");
    $company_address = $seconddb->get_var("SELECT company_address FROM vendor WHERE email='$_email'");

    $price = 3300;
  } else {
    header("Location: /");
  }
?>
  <div class="container" style="margin-top: 40px; display: flex; flex-direction: column; align-items: center;">
    <p style="text-align: center; line-height: 1.2em">本日から30日以内に下記会社が商談をしている商材を調べることができます。</p>
    <div style="padding: 20px; background: #ebebeb; margin-top: 40px; width: 500px; max-width: 80%;">
      <p style="line-height:1.3em"><strong style="font-size:1.05em; margin-bottom: .5em; display: block;">調査対象</strong>
        <?php echo $company; ?>
        <br>
        <?php echo $address; ?>
      </p>
    </div>

    <div style="padding: 20px; background: #e8f0ff; margin-top: 20px; width: 500px; max-width: 80%;">
      <p style="line-height:1.3em"><strong style="font-size:1.05em; margin-bottom: .5em; display: block;">調査結果の通知先</strong>
        <?php echo $company_name; ?>
        <br>
        <?php echo $company_address; ?>
        <br>
        <?php echo $_email; ?>
      </p>
    </div>

    <form id="mainform" style="margin-top: 30px">
      <div>
        <label for="target"><strong style="font-size: 1.1em; line-height: 1.6em">調べたい商材をお1つご入力ください。※2つ以上入力した場合は1つめを採用</strong></label>
        <input style="width: 100%; border-radius: 8px; padding: 0.5em; height: 3em; border: 2px solid black;" type="text" id="target" name="target" value="" maxlength="30">
      </div>
      <div style="margin-top: 20px; line-height: 1.4em;">
        <div>
          <input type="checkbox" id="agree_1" name="agree_1">
          <label for="agree_1">調査していることは、先方の会社には知らされません。</label>
        </div>

        <div>
          <input type="checkbox" id="agree_2" name="agree_2">
          <label for="agree_2">調査対象期間は下記「調査する」ボタンを押してから遡って30日以内です。</label>
        </div>

        <div>
          <input type="checkbox" id="agree_3" name="agree_3">
          <label for="agree_3">調査対象は上記にご入力いただいた商材の営業を受けているかどうかです。(商談日が決まったか否か)</label>
        </div>

        <div>
          <input type="checkbox" id="agree_4" name="agree_4">
          <label for="agree_4">調査結果は3営業日以内にメールで通知いたします。</label>
        </div>

        <div>
          <input type="checkbox" id="agree_5" name="agree_5">
          <label for="agree_5">調査費用は1社あたり3,300円となります。</label>
        </div>
      </div>

      <div class="row" style="padding: 10px; background-color: aliceblue; width: 350px;  margin: 35px auto 0; max-width: 80%;">
        <div class="col-6">合計</div>
        <div class="col-6" style="text-align: end; color: red">¥
          <strong>
            <?php echo number_format($price); ?>
          </strong>
        </div>
      </div>

      <input id="tkn" name="tkn" type="hidden" value="">
      <input type="hidden" name="userid" value="<?php echo $userid; ?>">
      <input type="hidden" name="price" value="<?php echo $price; ?>">
      <div id="CARD_INPUT_FORM"></div>

      <input type="button" value="調査する" id="button_buy" style="display: block; color: white; background: rgb(56, 58, 255); width: 300px; padding: 1rem; font-weight: bold; border-radius: 10px; opacity: .5; margin: 50px auto 0px; max-width: 80%; border-color: rgb(56, 58, 255);" onclick="doPurchase()" disabled>

      <p style="text-align: center; padding-top: 20px; line-height: 19px; width: 100%; color: #ff0009c9; font-weight: 600;" id="caution">上記のチェックボックスにチェックを入れてください</p>
    </form>
  </div>
  <script src="https://credit.j-payment.co.jp/gateway/js/jquery.js"></script>
  <script src="https://credit.j-payment.co.jp/gateway/js/CPToken.js"></script>
  <script>
    var checkboxes = document.querySelectorAll('#mainform input[type="checkbox"]');
    var button = document.querySelector('#mainform #button_buy');
    var caution = document.querySelector('#caution');

    function enableButton() {
      var checkedCount = 0;
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
          checkedCount++;
        }
      }
      if (checkedCount === checkboxes.length) {
        button.disabled = false;
        button.style.opacity = 1;
        caution.style.display = 'none';
      } else {
        button.disabled = true;
        button.style.opacity = .5;
        caution.style.display = 'block';
      }
    }

    for (var i = 0; i < checkboxes.length; i++) {
      checkboxes[i].addEventListener('change', enableButton);
    }

    // 3Dセキュア認証処理を行う関数
    function perform3DSecureAuth(token, callback) {
      // 3Dセキュア認証用のフォームを作成
      var form = document.createElement('form');
      form.setAttribute('method', 'post');
      form.setAttribute('action', 'https://credit.j-payment.co.jp/gateway/3dsecure/auth.aspx');
      form.setAttribute('target', '3dsecure_iframe');
      
      // 必要なパラメータを追加
      var aidInput = document.createElement('input');
      aidInput.setAttribute('type', 'hidden');
      aidInput.setAttribute('name', 'aid');
      aidInput.setAttribute('value', '123747'); // 加盟店ID
      form.appendChild(aidInput);
      
      var tknInput = document.createElement('input');
      tknInput.setAttribute('type', 'hidden');
      tknInput.setAttribute('name', 'tkn');
      tknInput.setAttribute('value', token);
      form.appendChild(tknInput);
      
      var rtInput = document.createElement('input');
      rtInput.setAttribute('type', 'hidden');
      rtInput.setAttribute('name', 'rt');
      rtInput.setAttribute('value', '1'); // 戻り値タイプ
      form.appendChild(rtInput);
      
      // 3Dセキュア認証用のiframeを作成
      var iframe = document.createElement('iframe');
      iframe.setAttribute('name', '3dsecure_iframe');
      iframe.setAttribute('id', '3dsecure_iframe');
      iframe.style.width = '100%';
      iframe.style.height = '400px';
      iframe.style.border = 'none';
      
      // 3Dセキュア認証用のモーダルを作成
      var modal = document.createElement('div');
      modal.setAttribute('id', '3dsecure_modal');
      modal.style.position = 'fixed';
      modal.style.top = '0';
      modal.style.left = '0';
      modal.style.width = '100%';
      modal.style.height = '100%';
      modal.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
      modal.style.zIndex = '9999';
      modal.style.display = 'flex';
      modal.style.justifyContent = 'center';
      modal.style.alignItems = 'center';
      
      var modalContent = document.createElement('div');
      modalContent.style.backgroundColor = '#fff';
      modalContent.style.padding = '20px';
      modalContent.style.borderRadius = '5px';
      modalContent.style.width = '80%';
      modalContent.style.maxWidth = '600px';
      
      var modalTitle = document.createElement('h3');
      modalTitle.textContent = '3Dセキュア認証';
      modalContent.appendChild(modalTitle);
      
      var modalDescription = document.createElement('p');
      modalDescription.textContent = 'カード発行会社の認証画面が表示されます。認証を完了してください。';
      modalContent.appendChild(modalDescription);
      
      modalContent.appendChild(iframe);
      modal.appendChild(modalContent);
      document.body.appendChild(modal);
      
      // フォームをbodyに追加して送信
      document.body.appendChild(form);
      form.submit();
      
      // メッセージイベントリスナーを追加
      window.addEventListener('message', function(event) {
        if (event.origin === 'https://credit.j-payment.co.jp') {
          var result = event.data;
          // モーダルを閉じる
          document.body.removeChild(modal);
          // フォームを削除
          document.body.removeChild(form);
          // コールバックを呼び出す
          callback(result);
        }
      }, false);
    }

    function execPurchase(resultCode, errMsg) {
      if (resultCode != "Success") {
        console.log(errMsg);
        window.alert('決済に失敗しました。最初からやり直してください。');
      } else {
        // トークンを取得
        var token = document.getElementById('tkn').value;
        
        // 3Dセキュア認証を実行
        perform3DSecureAuth(token, function(result) {
          if (result.status === 'success') {
            // 3Dセキュア認証成功時の処理
            var formData = new FormData(document.getElementById('mainform'));
            formData.append('threeDSecureResult', JSON.stringify(result));
            
            return fetch('/research-payment', {
              method: 'post',
              credentials: 'same-origin',
              headers: {
                'content-type': 'application/json'
              },
              body: JSON.stringify(Object.fromEntries(formData))
            }).then(function(response) {
              if (response.status == 200) {
                window.location = '/research/?status=success';
              } else {
                window.alert('決済に失敗しました。最初からやり直してください。');
              }
            });
          } else {
            // 3Dセキュア認証失敗時の処理
            window.alert('3Dセキュア認証に失敗しました。最初からやり直してください。');
          }
        });
      }
    };

    function doPurchase() {
      const aid = '123747';
      CPToken.CardInfo({
        aid,
        // 3Dセキュア必須フラグを追加
        secure3d: '1'
      }, execPurchase);
    }
  </script>
<?php } ?>