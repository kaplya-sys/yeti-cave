<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Ваша ставка победила!</title>
  <style>
    body {
      font-family: Arial, sans-serif; line-height: 1.6; color: #333;
    }
    .container {
      max-width: 600px; margin: 0 auto; padding: 20px;
    }
    .header {
      background-color: #f8f1e9; padding: 20px; text-align: center;
      }
    .content {
      padding: 20px;
      }
    .lot-image {
      max-width: 100%; height: auto; margin-bottom: 20px;
    }
    .button { 
      display: inline-block; 
      padding: 12px 24px; 
      background-color: #4CAF50; 
      color: white; 
      text-decoration: none; 
      border-radius: 4px; 
      margin-top: 20px;
    }
    .footer { 
      margin-top: 30px; 
      padding-top: 20px; 
      border-top: 1px solid #eee; 
      font-size: 12px; 
      color: #777;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Поздравляем, ваша ставка победила!</h1>
    </div>
    <div class="content">
      <p>Здравствуйте, <?= htmlspecialchars($user_name) ?>,</p>
      <p>Ваша ставка на лот <strong>"<?= htmlspecialchars($lot['title']); ?>"</strong> оказалась выигрышной!</p>
      <img src="https://yeticave/uploads/<?= htmlspecialchars($lot['img_path']); ?>" alt="<?= htmlspecialchars($lot['title']); ?>" class="lot-image">
      <h3>Детали вашей победы:</h3>
      <ul>
        <li>Лот: <?= htmlspecialchars($lot['title']); ?></li>
        <li>Дата завершения аукциона: <?= date('d.m.Y', strtotime($lot['expiration_date'])); ?></li>
      </ul>
      <a href="https://yeticave/lot.php?id=<?= $lot['id']; ?>" class="button">Перейти к лоту</a>
    </div>
  </div>
</body>
</html>
