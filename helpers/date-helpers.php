<?php
require_once('common-helpers.php');

/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date) : bool {
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}
/**
 * Возвращает разницу между двумя датами
 *
 * @param string $date Дата в виде строки
 * @param string $timezone Не обязательный параметр, часовой пояс
 *
 * @return DateInterval Объект, представляющий разницу между двумя датами
 */
function get_interval(string $date, string $timezone = 'Asia/Yekaterinburg') {
  date_default_timezone_set($timezone);
  $target = new DateTimeImmutable($date);
  $now = new DateTimeImmutable();

  return $now->diff($target);
}
/**
 * Возвращает оставшиеся время в формате "часы:минуты"
 *
 * @param string $date Дата в виде строки
 *
 * @return string Оставшиеся время в формате "часы:минуты"
 */
function get_remaining_hours_minutes(string $date) {
  $interval = get_interval($date);

  if ($interval->invert === 1) {
    return '00:00';
  }
  $interval_format = $interval->format('%a, %h, %I');
  $intervals = explode(',', $interval_format);
  $hours = str_pad($intervals[0] * 24 + $intervals[1], 2, '0', STR_PAD_LEFT);
  $minutes = $intervals[2];

  return $hours . ':' . $minutes;
}
/**
 * Возвращает отформатированное время в зависимости от давности события в формате "день.месяц.год в часы:минуты"
 *  если прошло больше одного дня, "Вчера, в часы:минуты" если прошло от 24 до 48 часов, "%n часов назад" если прошло до 24 часов,
 *  "Час назад" если прошел час, "%n минут назад" если прошло до 1 часа или "Минуту назад" если прошло до 1 минуты
 * 
 * @param string $date Дата в виде строки
 *
 * @return string Отформатированное время
 */
function get_time_since(string $date) {
	$comparable = new DateTimeImmutable($date);
	$interval = get_interval($date);
	$days = $interval->days;
	$hours = $interval->h;
	$minutes = $interval->i;

  if ($days === 1) {
		return 'Вчера, в ' . $comparable->format('H:i');
	}

  if ($days === 0 && $hours === 0 && $minutes === 1) {
		return 'Минуту назад';
	}

	if ($days === 0 && $hours < 1) {
		return $minutes . ' ' . get_noun_plural_form($minutes, 'минута', 'минуты', 'минут') . ' ' . 'назад';
	}

  if ($days === 0 && $hours === 1) {
		return 'Час назад';
	}

	if ($days === 0 && $hours > 1 && $hours < 24) {
    return $hours . ' ' . get_noun_plural_form($hours, 'час', 'часа', 'часов') . ' ' . 'назад';
	}

	return $comparable->format('d.m.y') . ' ' . 'в' . ' ' . $comparable->format('H:i');
};
/**
 * Возвращает оставшиеся время в формате "дни:часы:минуты"
 *
 * @param string $date Дата в виде строки
 *
 * @return string Оставшиеся время в формате "дни:часы:минуты"
 */
function get_remaining_time(string $date) {
  $interval = get_interval($date);

  if ($interval->invert === 1) {
    return '00:00:00';
  }

  return $interval->format('%D:%H:%I');
};
/**
 * Возвращает истину если осталось менее часа или ложь в противном случаи
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true или false
 */
function is_less_hour(string $date) {
	$interval = get_interval($date);

  if ($interval->invert === 1) {
    return true;
  }
	$days = $interval->days;
	$hours = $interval->h;
	
	return $days === 0 && !$hours >= 1;
};
?>