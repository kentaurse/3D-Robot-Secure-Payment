<?php
/*
  Template Name: Set Flag
*/
wp_head();

global $seconddb;

$future_records = $seconddb->get_results("SELECT company, listflag_update_on FROM userlist WHERE listflag = 'off' ORDER BY listflag_update_on ASC LIMIT 10");
echo '<script>console.log("次に更新される10件"); console.log(' . json_encode($future_records) . ')</script>';

$next_cron_job_on = wp_get_scheduled_event('set_listflag_on')->timestamp;
echo '<script>console.log("次回の更新日時");';
if ($next_cron_job_on) {
  echo 'console.log("' . date('Y-m-d H:i:s', $next_cron_job_on + 9 * 60 * 60) . '")</script>';
} else {
  echo 'console.log("No cron job scheduled")</script>';
}

$has_id = isset($_GET['compid']) && $_GET['compid'] != '';
$confirmed = isset($_GET['confirmed']) && $_GET['confirmed'] == 'true';
if ($has_id) {
  $this_id = $_GET['compid'];
  $company = $seconddb->get_var("SELECT company FROM userlist WHERE userid = $this_id");
  $listflag = $seconddb->get_var("SELECT listflag FROM userlist WHERE userid = $this_id");
  $listflag_update_on = $seconddb->get_var("SELECT listflag_update_on FROM userlist WHERE userid = $this_id");
  $listflag_update_on_formatted = date('Y-m-d', strtotime($listflag_update_on));

  if ($listflag == "on" && $confirmed) {
    $timestamp = date('Y-m-d', strtotime('+30 days'));
    $timestamp_formatted = date('Y-m-d', strtotime($timestamp));
    $seconddb->query("UPDATE userlist SET listflag = 'off', listflag_update_on = '$timestamp' WHERE userid = $this_id");
  }
}

?>
<style>
  *,
  *::before,
  *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  html {
    height: 100vh;
  }

  body {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 2rem;
  }

  h1 {
    font-size: 1.2em;
    font-weight: bold;
    margin-bottom: 0.5em;
  }

  form {
    display: flex;
    flex-direction: column;
    max-width: 100%;
    width: 400px;
    text-align: center;
    justify-content: center;
  }

  input {
    padding: 1rem;
    width: 100%;
    margin-bottom: 1rem;
  }

  .buttons {
    display: flex;
    justify-content: space-between;
  }

  .buttons a {
    padding: .5rem 2rem;
    width: 100%;
    text-align: center;
    margin: 1rem 1rem 0;
    text-decoration: none;
    color: white;
    background: gray;
  }
</style>
<?php
if ($has_id && $confirmed) {
?>
  <h1>完了</h1>
  <p>listflagを<?php echo $timestamp_formatted ?>までoffにしました</p>
  <div class="buttons">
    <a href="<?php echo get_permalink(); ?>">戻る</a>
  </div>
<?php
} else if ($has_id) {
?>
  <?php if ($company == '') : ?>
    <h1>該当する会社が見つかりませんでした</h1>
    <div class="buttons">
      <a href="<?php echo get_permalink(); ?>">戻る</a>
    </div>

  <?php else : ?>
    <h1><?php echo $company; ?></h1>
    <?php if ($listflag == "off") : ?>
      <p>listflagが<?php echo $listflag_update_on_formatted ?>までoffになっています</p>
      <div class="buttons">
        <a href="<?php echo get_permalink(); ?>">戻る</a>
      </div>
    <?php else : ?>
      <div class="buttons">
        <a href="<?php echo get_permalink(); ?>">戻る</a>
        <a href="<?php echo get_permalink(); ?>?compid=<?php echo $this_id ?>&confirmed=true">送信</a>
      </div>
    <?php endif; ?>
  <?php endif; ?>
<?php
} else {
?>
  <form method="get">
    <input type="number" name="compid" id="compid" placeholder="ID">
    <input type="submit" value="送信" disabled>
  </form>
  <script>
    const id = document.getElementById('compid');
    const submit = document.querySelector('input[type="submit"]');

    id.addEventListener('input', () => {
      if (id.value.length > 0) {
        submit.disabled = false;
      } else {
        submit.disabled = true;
      }
    })
  </script>
<?php
}
wp_footer();
