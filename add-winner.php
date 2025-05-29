<?php
require_once('init.php');
require_once('models.php');
require_once('helpers/sql-helpers.php');
require_once('mail.php');

$query_lot = $get_query_lots_by_no_winner();
$lots = get_mysqli_result($link, $query_lot);

foreach($lots as $lot) {
  $query_bet = $get_query_max_bet_by_user_id();
  $bet = get_mysqli_select_stmt_result($link, $query_bet, [$lot['id']]);
  
  if(!empty($bet)) {
    $user_id = $bet[0]['user_id'];
    $winning_bet = $bet[0]['bet'];
    $query_winner = $get_query_create_winner();
    get_mysqli_insert_stmt_result($link, $query_winner, [$user_id, $lot['id']]);
    $message_content = include_template('mail.template.php',
      [
        'user_name' => $lot['user_name'],
        'lot' => $lot,
        'winning_bet' => $winning_bet
      ]
  );
    $message->subject("Вы победили!");
    $message->html($message_content);
    $mailer->send($message);
  }
}
?>