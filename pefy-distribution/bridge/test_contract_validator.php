<?php
declare(strict_types=1);
require __DIR__.'/contract_validator.php';
$key = str_repeat('K', 32);
$base = ['action'=>'course.publish','tenant_id'=>'school-a','course_id'=>'course-1','event_id'=>'evt-1'];
function check(array $payload, bool $expected, string $key): void {
    $raw = json_encode($payload, JSON_THROW_ON_ERROR);
    $sig = 'sha256='.hash_hmac('sha256', $raw, $key);
    try {
        $ack = pefy_validate_bridge($raw, $sig, $key);
        if (!$expected || $ack['status'] !== 'accepted') throw new RuntimeException('unexpected acceptance');
    } catch (RuntimeException $e) {
        if ($expected || $e->getMessage() === 'unexpected acceptance') throw $e;
    }
}
check($base, true, $key);
check([...$base,'action'=>'learner.enroll','learner_id'=>'learner-1'], true, $key);
check([...$base,'action'=>'assessment.record','learner_id'=>'learner-1','score'=>85], true, $key);
check([...$base,'email'=>'private@example.org'], false, $key);
check([...$base,'action'=>'assessment.record','learner_id'=>'learner-1','score'=>101], false, $key);
check([...$base,'action'=>'learner.enroll'], false, $key);
$raw = json_encode($base, JSON_THROW_ON_ERROR);
try { pefy_validate_bridge($raw, 'sha256='.str_repeat('0', 64), $key); throw new RuntimeException('unexpected acceptance'); }
catch (RuntimeException $e) { if ($e->getMessage() === 'unexpected acceptance') throw $e; }
echo "7/7 contract assertions passed\n";
