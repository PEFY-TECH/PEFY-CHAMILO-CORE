<?php
declare(strict_types=1);
/** Contract validation only. NOT a Chamilo controller or persistent integration. */
function pefy_validate_bridge(string $raw, string $signature, string $key): array {
    if (strlen($key) < 32 || strlen($raw) > 65536) throw new RuntimeException('invalid input');
    if (!hash_equals('sha256='.hash_hmac('sha256', $raw, $key), $signature)) throw new RuntimeException('unauthorized');
    $event = json_decode($raw, true, 16, JSON_THROW_ON_ERROR);
    if (!is_array($event) || array_is_list($event)) throw new RuntimeException('invalid object');
    foreach ($event as $field => $_) if (!in_array($field, ['action','tenant_id','course_id','event_id','learner_id','score'], true)) throw new RuntimeException('unexpected field');
    foreach (['action','tenant_id','course_id','event_id'] as $field) if (!isset($event[$field]) || !is_string($event[$field]) || trim($event[$field]) === '') throw new RuntimeException('required field');
    if (!in_array($event['action'], ['course.publish','learner.enroll','assessment.record'], true)) throw new RuntimeException('invalid action');
    if ($event['action'] !== 'course.publish' && (!isset($event['learner_id']) || !is_string($event['learner_id']) || trim($event['learner_id']) === '')) throw new RuntimeException('learner required');
    if ($event['action'] === 'assessment.record' && (!isset($event['score']) || !(is_int($event['score']) || is_float($event['score'])) || $event['score'] < 0 || $event['score'] > 100)) throw new RuntimeException('invalid score');
    return ['event_id'=>$event['event_id'],'tenant_id'=>$event['tenant_id'],'status'=>'accepted'];
}
