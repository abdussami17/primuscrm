<?php
require __DIR__ . '/../../vendor/autoload.php';
$app = require __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\SequenceExecutionLog;

$rows = SequenceExecutionLog::latest()->take(12)->get();
foreach ($rows as $r) {
    echo sprintf("#%d seq:%s act:%s lead:%s status:%s scheduled:%s executed:%s\n",
        $r->id,
        $r->smart_sequence_id,
        $r->sequence_action_id,
        $r->lead_id,
        $r->status,
        $r->scheduled_at,
        $r->executed_at
    );
}
