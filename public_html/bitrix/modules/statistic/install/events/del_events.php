<?
global $DB;
$DB->Query("DELETE FROM b_event_type WHERE EVENT_NAME in ('STATISTIC_DAILY_REPORT', 'STATISTIC_ACTIVITY_EXCEEDING')");
$DB->Query("DELETE FROM b_event_message WHERE EVENT_NAME in ('STATISTIC_DAILY_REPORT', 'STATISTIC_ACTIVITY_EXCEEDING')");
?>
